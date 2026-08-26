(function () {
  "use strict";

  function safeParseJson(raw, fallback) {
    try {
      var data = JSON.parse(raw || "");
      return data == null ? fallback : data;
    } catch (e) {
      return fallback;
    }
  }

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
    var fields = (form.getAttribute("data-fields") || "").split(",").map(function (f) { return f.trim(); }).filter(Boolean);
    var wrap = form.querySelector(".repeater-wrap");
    if (!wrap) return;
    var jsonFieldName = wrap.getAttribute("data-json-field");
    var jsonInput = form.querySelector('[name="' + jsonFieldName + '"]');
    var addBtn = form.querySelector(".btn-add");
    if (!jsonInput) return;

    function getData() {
      var data = safeParseJson(jsonInput.value || "[]", []);
      return Array.isArray(data) ? data : [];
    }

    function setData(data) {
      jsonInput.value = JSON.stringify(data);
    }

    function fieldValue(value) {
      if (Array.isArray(value)) return value.join(", ");
      if (value == null) return "";
      return String(value);
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
          input.value = fieldValue(item[field]);
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
            if (!d[index]) d[index] = {};
            d[index][field] = this.value;
            setData(d);
          });
        });
        wrap.appendChild(block);
      });
    }

    if (addBtn) {
      addBtn.addEventListener("click", function () {
        var d = getData();
        var empty = {};
        fields.forEach(function (f) { empty[f] = ""; });
        d.push(empty);
        setData(d);
        render();
      });
    }

    form.addEventListener("submit", function () {
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

  /* Pricing page editor */
  (function () {
    var form = document.getElementById("pricing-form");
    var editor = document.getElementById("pricing-categories-editor");
    var jsonInput = document.getElementById("pricing-categories-json");
    var addCatBtn = document.getElementById("pricing-add-category");
    if (!form || !editor || !jsonInput || !addCatBtn) return;

    function getCategories() {
      var data = safeParseJson(jsonInput.value || "[]", []);
      return Array.isArray(data) ? data : [];
    }

    function setCategories(data) {
      jsonInput.value = JSON.stringify(data);
    }

    function featuresToText(features) {
      if (!Array.isArray(features)) return "";
      return features.join("\n");
    }

    function textToFeatures(text) {
      return String(text || "")
        .split(/\r?\n/)
        .map(function (line) { return line.trim(); })
        .filter(Boolean);
    }

    function emptyPlan() {
      return {
        name: "New Plan",
        description: "",
        price: "",
        old_price: "",
        period: "",
        badge: "",
        featured: false,
        features: [],
        button_text: "Order Now",
        button_url: "index.php#contact"
      };
    }

    function emptyCategory() {
      return {
        id: "category-" + Date.now(),
        title: "New Category",
        subtitle: "",
        plans: [emptyPlan()]
      };
    }

    function readField(root, name, isCheckbox) {
      var el = root.querySelector('[data-field="' + name + '"]');
      if (!el) return isCheckbox ? false : "";
      return isCheckbox ? !!el.checked : (el.value || "");
    }

    function syncFromDom() {
      var cats = [];
      editor.querySelectorAll(".pricing-cat").forEach(function (catEl) {
        var plans = [];
        catEl.querySelectorAll(".pricing-plan").forEach(function (planEl) {
          plans.push({
            name: readField(planEl, "name"),
            description: readField(planEl, "description"),
            price: readField(planEl, "price"),
            old_price: readField(planEl, "old_price"),
            period: readField(planEl, "period"),
            badge: readField(planEl, "badge"),
            featured: readField(planEl, "featured", true),
            features: textToFeatures(readField(planEl, "features")),
            button_text: readField(planEl, "button_text") || "Order Now",
            button_url: readField(planEl, "button_url") || "index.php#contact"
          });
        });
        cats.push({
          id: readField(catEl, "id"),
          title: readField(catEl, "title"),
          subtitle: readField(catEl, "subtitle"),
          plans: plans
        });
      });
      setCategories(cats);
      return cats;
    }

    function render() {
      var cats = getCategories();
      editor.innerHTML = "";

      cats.forEach(function (cat, catIndex) {
        var catEl = document.createElement("div");
        catEl.className = "pricing-cat";
        catEl.dataset.catIndex = String(catIndex);
        catEl.innerHTML =
          '<div class="item-head">' +
            '<strong>Category ' + (catIndex + 1) + '</strong>' +
            '<button type="button" class="btn-remove" data-action="remove-cat">Remove Category</button>' +
          '</div>' +
          '<div class="grid-2">' +
            '<label>Category Title<input type="text" data-field="title"></label>' +
            '<label>Category ID (slug)<input type="text" data-field="id" placeholder="e.g. 3in1"></label>' +
          '</div>' +
          '<label>Category Subtitle<input type="text" data-field="subtitle"></label>' +
          '<div class="pricing-plans"></div>' +
          '<button type="button" class="btn-add" data-action="add-plan">+ Add Plan</button>';

        catEl.querySelector('[data-field="title"]').value = cat.title || "";
        catEl.querySelector('[data-field="id"]').value = cat.id || "";
        catEl.querySelector('[data-field="subtitle"]').value = cat.subtitle || "";

        var plansWrap = catEl.querySelector(".pricing-plans");
        (cat.plans || []).forEach(function (plan, planIndex) {
          var planEl = document.createElement("div");
          planEl.className = "pricing-plan repeater-item";
          planEl.dataset.planIndex = String(planIndex);
          planEl.innerHTML =
            '<div class="item-head">' +
              '<strong>Plan ' + (planIndex + 1) + '</strong>' +
              '<button type="button" class="btn-remove" data-action="remove-plan">Remove Plan</button>' +
            '</div>' +
            '<div class="grid-2">' +
              '<label>Plan Name<input type="text" data-field="name"></label>' +
              '<label>Short Description<input type="text" data-field="description"></label>' +
              '<label>Price<input type="text" data-field="price" placeholder="499"></label>' +
              '<label>Old Price<input type="text" data-field="old_price" placeholder="557"></label>' +
              '<label>Period<input type="text" data-field="period" placeholder="/mo"></label>' +
              '<label>Badge<input type="text" data-field="badge" placeholder="Popular"></label>' +
              '<label>Button Text<input type="text" data-field="button_text"></label>' +
              '<label>Button URL<input type="text" data-field="button_url"></label>' +
            '</div>' +
            '<label class="pricing-featured-check"><input type="checkbox" data-field="featured"> Featured plan</label>' +
            '<label>Features (one per line)<textarea data-field="features" rows="4"></textarea></label>';

          planEl.querySelector('[data-field="name"]').value = plan.name || "";
          planEl.querySelector('[data-field="description"]').value = plan.description || "";
          planEl.querySelector('[data-field="price"]').value = plan.price || "";
          planEl.querySelector('[data-field="old_price"]').value = plan.old_price || "";
          planEl.querySelector('[data-field="period"]').value = plan.period || "";
          planEl.querySelector('[data-field="badge"]').value = plan.badge || "";
          planEl.querySelector('[data-field="button_text"]').value = plan.button_text || "Order Now";
          planEl.querySelector('[data-field="button_url"]').value = plan.button_url || "index.php#contact";
          planEl.querySelector('[data-field="featured"]').checked = !!plan.featured;
          planEl.querySelector('[data-field="features"]').value = featuresToText(plan.features);
          plansWrap.appendChild(planEl);
        });

        editor.appendChild(catEl);
      });
    }

    addCatBtn.addEventListener("click", function (event) {
      event.preventDefault();
      syncFromDom();
      var data = getCategories();
      data.push(emptyCategory());
      setCategories(data);
      render();
      var last = editor.querySelector(".pricing-cat:last-child");
      if (last) last.scrollIntoView({ behavior: "smooth", block: "start" });
    });

    editor.addEventListener("click", function (event) {
      var btn = event.target.closest("[data-action]");
      if (!btn) return;
      event.preventDefault();

      var action = btn.getAttribute("data-action");
      var catEl = btn.closest(".pricing-cat");
      if (!catEl) return;
      var catIndex = Number(catEl.dataset.catIndex || -1);

      syncFromDom();
      var data = getCategories();
      if (catIndex < 0 || !data[catIndex]) return;

      if (action === "remove-cat") {
        data.splice(catIndex, 1);
        setCategories(data);
        render();
        return;
      }

      if (action === "add-plan") {
        if (!data[catIndex].plans) data[catIndex].plans = [];
        data[catIndex].plans.push(emptyPlan());
        setCategories(data);
        render();
        return;
      }

      if (action === "remove-plan") {
        var planEl = btn.closest(".pricing-plan");
        var planIndex = planEl ? Number(planEl.dataset.planIndex || -1) : -1;
        if (planIndex < 0 || !data[catIndex].plans) return;
        data[catIndex].plans.splice(planIndex, 1);
        setCategories(data);
        render();
      }
    });

    form.addEventListener("submit", function () {
      syncFromDom();
    });

    editor.addEventListener("input", function () {
      syncFromDom();
    });
    editor.addEventListener("change", function () {
      syncFromDom();
    });

    render();
  })();

  /* Highlight active sidebar link on scroll */
  var panels = document.querySelectorAll(".admin-panel");
  var links = document.querySelectorAll(".sidebar-nav a[href^='#']");
  if (panels.length && links.length) {
    window.addEventListener("scroll", function () {
      var current = "";
      panels.forEach(function (panel) {
        if (window.scrollY >= panel.offsetTop - 100) current = panel.id;
      });
      links.forEach(function (link) {
        var active = link.getAttribute("href") === "#" + current;
        link.classList.toggle("is-active", active);
      });
    });
  }
})();
