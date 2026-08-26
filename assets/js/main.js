(function () {
  "use strict";

  /* Mobile nav */
  var toggle = document.querySelector(".nav-toggle");
  var nav = document.querySelector(".nav");
  if (toggle && nav) {
    toggle.addEventListener("click", function () {
      var open = nav.classList.toggle("is-open");
      toggle.setAttribute("aria-expanded", open ? "true" : "false");
    });
  }

  /* Dropdown menus */
  document.querySelectorAll(".nav-item.has-dropdown").forEach(function (item) {
    var trigger = item.querySelector(".nav-trigger");
    if (!trigger) return;

    trigger.addEventListener("click", function (e) {
      e.stopPropagation();
      var isOpen = item.classList.contains("is-open");
      document.querySelectorAll(".nav-item.is-open").forEach(function (el) {
        el.classList.remove("is-open");
        var t = el.querySelector(".nav-trigger");
        if (t) t.setAttribute("aria-expanded", "false");
      });
      if (!isOpen) {
        item.classList.add("is-open");
        trigger.setAttribute("aria-expanded", "true");
      }
    });
  });

  document.addEventListener("click", function () {
    document.querySelectorAll(".nav-item.is-open").forEach(function (el) {
      el.classList.remove("is-open");
      var t = el.querySelector(".nav-trigger");
      if (t) t.setAttribute("aria-expanded", "false");
    });
  });

  /* Tabs */
  document.querySelectorAll(".tab-btn").forEach(function (btn) {
    btn.addEventListener("click", function () {
      var tab = btn.getAttribute("data-tab");
      var panel = btn.closest(".tab-panel");
      if (!panel) return;

      panel.querySelectorAll(".tab-btn").forEach(function (b) {
        b.classList.remove("is-active");
        b.setAttribute("aria-selected", "false");
      });
      panel.querySelectorAll(".tab-content").forEach(function (c) {
        c.classList.remove("is-active");
      });

      btn.classList.add("is-active");
      btn.setAttribute("aria-selected", "true");
      var target = panel.querySelector('[data-panel="' + tab + '"]');
      if (target) target.classList.add("is-active");
    });
  });

  /* Animated counters */
  function formatNumber(n) {
    return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }

  function animateCounter(el) {
    if (el.dataset.animated) return;
    el.dataset.animated = "1";

    var target = parseInt(el.getAttribute("data-target"), 10);
    var suffix = el.getAttribute("data-suffix") || "";
    var duration = 2000;
    var start = 0;
    var startTime = null;

    function step(ts) {
      if (!startTime) startTime = ts;
      var progress = Math.min((ts - startTime) / duration, 1);
      var eased = 1 - Math.pow(1 - progress, 3);
      var current = Math.floor(start + (target - start) * eased);
      el.textContent = formatNumber(current) + (progress >= 1 ? suffix : "");
      if (progress < 1) requestAnimationFrame(step);
    }

    requestAnimationFrame(step);
  }

  if ("IntersectionObserver" in window) {
    var counterObs = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          counterObs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.3 });

    document.querySelectorAll(".counter").forEach(function (el) {
      counterObs.observe(el);
    });
  } else {
    document.querySelectorAll(".counter").forEach(animateCounter);
  }

  /* Success stories slider */
  var track = document.querySelector(".stories-track");
  var dots = document.querySelectorAll(".slider-dots .dot");
  if (track && dots.length) {
    dots.forEach(function (dot, i) {
      dot.addEventListener("click", function () {
        dots.forEach(function (d) { d.classList.remove("is-active"); });
        dot.classList.add("is-active");
        var card = track.children[i];
        if (card) {
          track.scrollTo({ left: card.offsetLeft - track.offsetLeft, behavior: "smooth" });
        }
      });
    });
  }

  /* Testimonial slider — read name/role from active quote data attributes */
  var quotes = document.querySelectorAll(".quote");
  var qIndex = 0;

  function showQuote(idx) {
    quotes.forEach(function (q, i) {
      q.classList.toggle("is-active", i === idx);
    });
    var active = quotes[idx];
    var nameEl = document.querySelector(".author-name");
    var roleEl = document.querySelector(".author-role");
    if (active && nameEl && roleEl) {
      nameEl.textContent = active.getAttribute("data-name") || "";
      roleEl.textContent = active.getAttribute("data-role") || "";
    }
  }

  var prevBtn = document.querySelector(".t-nav.prev");
  var nextBtn = document.querySelector(".t-nav.next");
  if (quotes.length && prevBtn && nextBtn) {
    prevBtn.addEventListener("click", function () {
      qIndex = (qIndex - 1 + quotes.length) % quotes.length;
      showQuote(qIndex);
    });
    nextBtn.addEventListener("click", function () {
      qIndex = (qIndex + 1) % quotes.length;
      showQuote(qIndex);
    });
  }

  /* Portfolio tabs */
  var portfolioTabs = document.querySelectorAll("[data-portfolio-tab]");
  if (portfolioTabs.length) {
    portfolioTabs.forEach(function (tab) {
      tab.addEventListener("click", function () {
        var id = tab.getAttribute("data-portfolio-tab");
        portfolioTabs.forEach(function (t) {
          var on = t === tab;
          t.classList.toggle("is-active", on);
          t.setAttribute("aria-selected", on ? "true" : "false");
        });
        document.querySelectorAll("[data-portfolio-panel]").forEach(function (panel) {
          panel.classList.toggle("is-active", panel.getAttribute("data-portfolio-panel") === id);
        });
        if (window.history && window.history.replaceState) {
          var url = new URL(window.location.href);
          url.searchParams.set("tab", id);
          window.history.replaceState({}, "", url.toString());
        }
      });
    });
  }
})();
