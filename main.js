/**
 * Worknoon Theme — main.js
 *
 * Handles:
 *  - Mobile navigation toggle
 *  - Contact form AJAX submission
 *  - Smooth scroll for anchor links
 *  - Scroll-triggered animations
 */

(function () {
  "use strict";

  /* =========================================================
     DOM READY
     ========================================================= */
  document.addEventListener("DOMContentLoaded", function () {
    initMobileNav();
    initContactForm();
    initSmoothScroll();
    initScrollAnimations();
  });

  /* =========================================================
     MOBILE NAVIGATION
     ========================================================= */
  function initMobileNav() {
    const hamburger = document.querySelector(".nav-hamburger");
    const navLinks = document.querySelector(".nav-links");

    if (!hamburger || !navLinks) return;

    hamburger.setAttribute("aria-expanded", "false");
    hamburger.setAttribute("aria-controls", "primary-nav");
    navLinks.id = "primary-nav";

    hamburger.addEventListener("click", function () {
      const isOpen = navLinks.classList.toggle("is-open");
      hamburger.setAttribute("aria-expanded", isOpen ? "true" : "false");
      hamburger.innerHTML = isOpen
        ? '<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>'
        : '<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>';
    });

    // Close nav on link click (mobile)
    navLinks.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", function () {
        navLinks.classList.remove("is-open");
        hamburger.setAttribute("aria-expanded", "false");
      });
    });

    // Close nav on outside click
    document.addEventListener("click", function (e) {
      if (!hamburger.contains(e.target) && !navLinks.contains(e.target)) {
        navLinks.classList.remove("is-open");
        hamburger.setAttribute("aria-expanded", "false");
      }
    });
  }

  /* =========================================================
     CONTACT FORM — AJAX SUBMISSION
     ========================================================= */
  function initContactForm() {
    const submitBtn = document.getElementById("worknoon-submit");
    const statusDiv = document.getElementById("worknoon-form-status");

    if (!submitBtn || !statusDiv) return;

    // Set initial hamburger icon
    const hamburger = document.querySelector(".nav-hamburger");
    if (hamburger) {
      hamburger.innerHTML =
        '<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>';
    }

    submitBtn.addEventListener("click", function () {
      const name = document.getElementById("wn-name");
      const email = document.getElementById("wn-email");
      const subject = document.getElementById("wn-subject");
      const message = document.getElementById("wn-message");

      // Client-side validation
      if (!name.value.trim()) {
        showStatus("error", "Please enter your full name.");
        name.focus();
        return;
      }
      if (!isValidEmail(email.value.trim())) {
        showStatus("error", "Please enter a valid email address.");
        email.focus();
        return;
      }
      if (!message.value.trim()) {
        showStatus("error", "Please describe your project.");
        message.focus();
        return;
      }

      // Disable button and show loading
      submitBtn.disabled = true;
      submitBtn.textContent = "Sending…";

      const formData = new FormData();
      formData.append("action", "worknoon_contact");
      formData.append("nonce", worknoonData.nonce);
      formData.append("name", name.value.trim());
      formData.append("email", email.value.trim());
      formData.append("subject", subject ? subject.value : "General Inquiry");
      formData.append("message", message.value.trim());

      fetch(worknoonData.ajaxUrl, {
        method: "POST",
        body: formData,
        credentials: "same-origin",
      })
        .then(function (response) {
          if (!response.ok) throw new Error("Network error");
          return response.json();
        })
        .then(function (data) {
          if (data.success) {
            showStatus(
              "success",
              data.data.message || "Message sent! We'll be in touch within 24 hours."
            );
            // Reset form fields
            [name, email, message].forEach(function (el) {
              el.value = "";
            });
            if (subject) subject.selectedIndex = 0;
          } else {
            showStatus(
              "error",
              data.data.message || "Something went wrong. Please try again."
            );
          }
        })
        .catch(function () {
          showStatus("error", "A network error occurred. Please try again.");
        })
        .finally(function () {
          submitBtn.disabled = false;
          submitBtn.textContent = "Send Message →";
        });
    });

    function showStatus(type, msg) {
      statusDiv.style.display = "block";
      statusDiv.style.padding = "1rem";
      statusDiv.style.borderRadius = "8px";
      statusDiv.style.marginBottom = "1.25rem";
      statusDiv.style.fontWeight = "500";

      if (type === "success") {
        statusDiv.style.background = "#d1fae5";
        statusDiv.style.color = "#065f46";
        statusDiv.style.border = "1px solid #6ee7b7";
      } else {
        statusDiv.style.background = "#fee2e2";
        statusDiv.style.color = "#991b1b";
        statusDiv.style.border = "1px solid #fca5a5";
      }
      statusDiv.textContent = msg;

      // Auto-hide success message after 5s
      if (type === "success") {
        setTimeout(function () {
          statusDiv.style.display = "none";
        }, 5000);
      }
    }

    function isValidEmail(email) {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
  }

  /* =========================================================
     SMOOTH SCROLL
     ========================================================= */
  function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
      anchor.addEventListener("click", function (e) {
        const target = document.querySelector(this.getAttribute("href"));
        if (!target) return;
        e.preventDefault();
        const offset = 80; // sticky header height
        const top =
          target.getBoundingClientRect().top + window.pageYOffset - offset;
        window.scrollTo({ top: top, behavior: "smooth" });
      });
    });
  }

  /* =========================================================
     SCROLL-TRIGGERED FADE-IN ANIMATIONS
     ========================================================= */
  function initScrollAnimations() {
    const targets = document.querySelectorAll(
      ".service-card, .testimonial-card, .contact__form, .hero__card"
    );

    if (!targets.length || !("IntersectionObserver" in window)) return;

    targets.forEach(function (el) {
      el.style.opacity = "0";
      el.style.transform = "translateY(24px)";
      el.style.transition = "opacity 0.55s ease, transform 0.55s ease";
    });

    const observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.style.opacity = "1";
            entry.target.style.transform = "translateY(0)";
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.12 }
    );

    targets.forEach(function (el) {
      observer.observe(el);
    });
  }
})();
