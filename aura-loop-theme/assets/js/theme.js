/**
 * Aura Loop Theme JavaScript
 * Author: colorgraphicz
 */

(function($) {
  'use strict';

  // STICKY NAVIGATION
  var navEl = document.getElementById('mainNav');
  if (navEl) {
    window.addEventListener('scroll', function() {
      if (window.scrollY > 70) {
        navEl.classList.add('stuck');
      } else {
        navEl.classList.remove('stuck');
      }
    }, { passive: true });
  }

  // SCROLL REVEAL OBSERVER
  var revealItems = document.querySelectorAll('.reveal');
  if (revealItems.length) {
    var revealObserver = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('in');
          revealObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12 });
    revealItems.forEach(function(el) { revealObserver.observe(el); });
  }

  // BACK TO TOP BUTTON
  var backBtn = document.getElementById('backToTopBtn');
  if (backBtn) {
    window.addEventListener('scroll', function() {
      if (window.scrollY > 500) {
        backBtn.classList.add('visible');
      } else {
        backBtn.classList.remove('visible');
      }
    });
    backBtn.addEventListener('click', function() {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // PLAN SELECTION VIA CLICK HANDLERS + HASH ON LOAD
  (function initPlanSelection() {
    var planSelect = document.getElementById('planSelect');
    var hash = window.location.hash;
    var planMatch = hash.match(/[?&]plan=(\w+)/);
    var planParam = planMatch ? planMatch[1] : null;
    if (planParam && planSelect) {
      var option = planSelect.querySelector('option[value="' + planParam + '"]');
      if (option) option.selected = true;
    }
    document.querySelectorAll('[href*="plan="]').forEach(function(link) {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        var match = this.getAttribute('href').match(/plan=(\w+)/);
        if (match && planSelect) {
          var option = planSelect.querySelector('option[value="' + match[1] + '"]');
          if (option) option.selected = true;
        }
        var formSection = document.getElementById('connect');
        if (formSection) formSection.scrollIntoView({ behavior: 'smooth' });
      });
    });
  })();

  // MODAL POPUP
  function openModal(type, message) {
    var existing = document.querySelector('.modal-overlay');
    if (existing) existing.remove();

    var overlay = document.createElement('div');
    overlay.className = 'modal-overlay active';

    var isSuccess = type === 'success';
    var checkMark = '<path d="M20 6 L9 17 L4 12" stroke-linecap="round" stroke-linejoin="round"/>';
    var xMark = '<path d="M18 6 L6 18 M6 6 L18 18" stroke-linecap="round"/>';
    var title = isSuccess ? 'Welcome to the Loop' : 'Something went wrong';

    overlay.innerHTML =
      '<div class="modal-box' + (isSuccess ? '' : ' error') + '">' +
        '<button class="modal-close" aria-label="Close">&times;</button>' +
        '<div class="modal-icon">' +
          '<svg viewBox="0 0 24 24">' + (isSuccess ? checkMark : xMark) + '</svg>' +
        '</div>' +
        '<h3>' + title + '</h3>' +
        '<p>' + message + '</p>' +
        '<button class="modal-btn">' + (isSuccess ? 'Continue' : 'Try Again') + '</button>' +
      '</div>';

    document.body.appendChild(overlay);

    function closeModal() {
      overlay.classList.remove('active');
      setTimeout(function() { overlay.remove(); }, 300);
    }

    overlay.querySelector('.modal-close').addEventListener('click', closeModal);
    overlay.querySelector('.modal-btn').addEventListener('click', closeModal);
    overlay.addEventListener('click', function(e) {
      if (e.target === overlay) closeModal();
    });
  }

  // AJAX FORM SUBMISSION
  var form = document.getElementById('insightForm');
  if (form) {
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      var data = new FormData(form);
      data.append('action', 'aura_loop_contact');
      data.append('_wpnonce', auraml_ajax.nonce);

      var submitBtn = form.querySelector('.submit-btn');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Sending...';
      }

      fetch(auraml_ajax.ajax_url, {
        method: 'POST',
        body: data,
      })
      .then(function(r) { return r.json(); })
      .then(function(res) {
        if (res.success) {
          openModal('success', res.data.msg);
          form.reset();
        } else {
          openModal('error', res.data.msg);
        }
      })
      .catch(function() {
        openModal('error', 'Connection error. Please try again.');
      })
      .finally(function() {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.textContent = 'Request Invitation \u2192';
        }
      });
    });
  }

  // SHOW MODAL FROM URL PARAMS (fallback if redirected)
  (function checkUrlMessage() {
    var params = new URLSearchParams(window.location.search);
    if (params.get('success') === '1') {
      openModal('success', 'Thank you! Your request has been received. Welcome to the Loop.');
      // Clean URL
      if (window.history.replaceState) {
        var clean = window.location.pathname + window.location.hash;
        window.history.replaceState({}, document.title, clean);
      }
    } else if (params.get('error')) {
      var msgs = {
        captcha: 'Incorrect captcha answer. Please try again.',
        fields: 'Please fill in all required fields.',
        email: 'Please provide a valid email address.',
        server: 'A server error occurred. Please try again later.'
      };
      openModal('error', msgs[params.get('error')] || 'An error occurred.');
      if (window.history.replaceState) {
        var clean = window.location.pathname + window.location.hash;
        window.history.replaceState({}, document.title, clean);
      }
    }
  })();

  // FIX TICKER: DUPLICATE CONTENT FOR SEAMLESS INFINITE SCROLL
  var tickerTrack = document.getElementById('tickerTrack');
  if (tickerTrack) {
    var originalHTML = tickerTrack.innerHTML;
    tickerTrack.innerHTML = originalHTML + originalHTML;
  }

  // RESPECT PREFERS-REDUCED-MOTION
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    var animatedElements = document.querySelectorAll('.ring, .v-ring, .ticker-track, .scroll-track::after, .dot-marker');
    animatedElements.forEach(function(el) {
      if (el) el.style.animation = 'none';
    });
  }

})(jQuery);
