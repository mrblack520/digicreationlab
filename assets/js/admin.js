(function () {
  "use strict";

  /* Sync JSON textarea fields before submit */
  document.querySelectorAll("[data-sync]").forEach(function (ta) {
    var targetId = ta.getAttribute("data-sync");
    var form = ta.closest("form");
    if (!form) return;
    form.addEventListener("submit", function () {
      var hidden = form.querySelector('[name="' + targetId + '"]');
      if (hidden) hidden.value = ta.value;
    });
  });

  /* Repeater forms */
  document.querySelectorAll("form[data-repeater]").forEach(function (form) {
    var repeaterKey = form.getAttribute("data-repeater");
    var fields = (form.getAttribute("data-fields") || "").split(",").map(function (f) { return f.trim(); }).filter(Boolean);
    var wrap = form.querySelector(".repeater-wrap");
    var jsonFieldName = wrap.getAttribute("data-json-field");
    var jsonInput = form.querySelector('[name="' + jsonFieldName + '"]');
    if (!wrap || !jsonInput) return;

    function getData() {
      try { return JSON.parse(jsonInput.value || "[]"); } catch (e) { return []; }
    }

    function setData(data) {
      jsonInput.value = JSON.stringify(data);
    }

    function render() {
      var data = getData();
      wrap.innerHTML = "";
      data.forEach(function (item, index) {
        var block = document.createElement("div");
        block.className = "repeater-item";
        block.innerHTML = '<div class="item-head"><strong>Item ' + (index + 1) + '</strong><button type="button" class="btn-remove">Remove</button></div>';
        fields.forEach(function (field) {
          var label = document.createElement("label");
          label.textContent = field.charAt(0).toUpperCase() + field.slice(1);
          var input = document.createElement("input");
          input.type = "text";
          input.dataset.field = field;
          input.value = item[field] || "";
          label.appendChild(input);
          block.appendChild(label);
        });
        block.querySelector(".btn-remove").addEventListener("click", function () {
          var d = getData();
          d.splice(index, 1);
          setData(d);
          render();
        });
        fields.forEach(function (field) {
          block.querySelector('[data-field="' + field + '"]').addEventListener("input", function () {
            var d = getData();
            d[index][field] = this.value;
            setData(d);
          });
        });
        wrap.appendChild(block);
      });
    }

    form.querySelector(".btn-add").addEventListener("click", function () {
      var d = getData();
      var empty = {};
      fields.forEach(function (f) { empty[f] = ""; });
      d.push(empty);
      setData(d);
      render();
    });

    form.addEventListener("submit", function () {
      /* ensure latest values */
      var blocks = wrap.querySelectorAll(".repeater-item");
      var d = getData();
      blocks.forEach(function (block, index) {
        fields.forEach(function (field) {
          var input = block.querySelector('[data-field="' + field + '"]');
          if (input && d[index]) d[index][field] = input.value;
        });
      });
      setData(d);
    });

    render();
  });

  /* Portfolio admin add rows */
  document.querySelectorAll("[data-add-portfolio]").forEach(function (btn) {
    btn.addEventListener("click", function () {
      var type = btn.getAttribute("data-add-portfolio");
      var list = document.getElementById(type + "-list");
      if (!list) return;

      var row = document.createElement("div");
      row.className = "portfolio-admin-row grid-2";

      if (type === "logo") {
        row.innerHTML =
          '<label>Title<input type="text" name="logo_title[]" value=""></label>' +
          '<label>Image URL<input type="text" name="logo_image[]" value=""></label>' +
          '<label>Upload Image<input type="file" name="logo_image_file[]" accept="image/*"></label>';
      } else {
        row.innerHTML =
          '<label>Title<input type="text" name="website_title[]" value=""></label>' +
          '<label>Project URL<input type="text" name="website_url[]" value="#"></label>' +
          '<label>Image URL<input type="text" name="website_image[]" value=""></label>' +
          '<label>Upload Image<input type="file" name="website_image_file[]" accept="image/*"></label>';
      }

      list.appendChild(row);
    });
  });

  /* Highlight active sidebar link on scroll */
  var panels = document.querySelectorAll(".admin-panel");
  var links = document.querySelectorAll(".sidebar-nav a");
  if (panels.length && links.length) {
    window.addEventListener("scroll", function () {
      var current = "";
      panels.forEach(function (panel) {
        if (window.scrollY >= panel.offsetTop - 100) current = panel.id;
      });
      links.forEach(function (link) {
        link.style.color = link.getAttribute("href") === "#" + current ? "#fff" : "";
        link.style.background = link.getAttribute("href") === "#" + current ? "#1c2030" : "";
      });
    });
  }
})();
