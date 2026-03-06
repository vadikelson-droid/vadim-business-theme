/**
 * Vadim Business Theme — Main JS
 * Features: Reveal animations, AJAX portfolio filter, Live search, Smooth scroll
 */

(function() {
  'use strict';

  // === REVEAL ON SCROLL ===
  const ro = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('vis');
        ro.unobserve(e.target);
      }
    });
  }, { threshold: 0.08, rootMargin: '0px 0px -20px 0px' });

  document.querySelectorAll('.rv').forEach(el => ro.observe(el));

  // === SMOOTH SCROLL ===
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const target = document.querySelector(a.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  // === HEADER SHADOW ===
  window.addEventListener('scroll', () => {
    const header = document.getElementById('site-header');
    if (header) header.classList.toggle('scrolled', scrollY > 10);
  });

  // === AJAX PORTFOLIO FILTER ===
  const filterBtns = document.querySelectorAll('.portfolio-filter-btn');
  const portfolioGrid = document.getElementById('portfolio-grid');

  if (filterBtns.length && portfolioGrid) {
    filterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        // Update active state
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const category = btn.dataset.category;
        portfolioGrid.style.opacity = '0.5';
        portfolioGrid.style.pointerEvents = 'none';

        const formData = new FormData();
        formData.append('action', 'vadim_portfolio_filter');
        formData.append('nonce', vadimAjax.nonce);
        formData.append('category', category);

        fetch(vadimAjax.url, {
          method: 'POST',
          body: formData,
        })
        .then(r => r.json())
        .then(data => {
          if (data.success) {
            portfolioGrid.innerHTML = data.data.html;
            // Update count
            const counter = document.getElementById('portfolio-count');
            if (counter) counter.textContent = data.data.count;
          }
          portfolioGrid.style.opacity = '1';
          portfolioGrid.style.pointerEvents = '';
        })
        .catch(() => {
          portfolioGrid.style.opacity = '1';
          portfolioGrid.style.pointerEvents = '';
        });
      });
    });
  }

  // === LIVE SEARCH ===
  const searchInput = document.getElementById('live-search-input');
  const searchResults = document.getElementById('live-search-results');
  let searchTimeout;

  if (searchInput && searchResults) {
    searchInput.addEventListener('input', () => {
      clearTimeout(searchTimeout);
      const query = searchInput.value.trim();

      if (query.length < 2) {
        searchResults.innerHTML = '';
        searchResults.classList.remove('open');
        return;
      }

      searchTimeout = setTimeout(() => {
        const formData = new FormData();
        formData.append('action', 'vadim_live_search');
        formData.append('nonce', vadimAjax.nonce);
        formData.append('query', query);

        fetch(vadimAjax.url, {
          method: 'POST',
          body: formData,
        })
        .then(r => r.json())
        .then(data => {
          if (data.success && data.data.results.length) {
            const html = data.data.results.map(item => `
              <a href="${item.url}" class="search-result-item">
                ${item.thumbnail ? `<img src="${item.thumbnail}" alt="">` : '<div class="search-thumb-placeholder"></div>'}
                <div>
                  <strong>${item.title}</strong>
                  <span class="search-type">${item.type}</span>
                  <p>${item.excerpt}</p>
                </div>
              </a>
            `).join('');
            searchResults.innerHTML = html;
            searchResults.classList.add('open');
          } else {
            searchResults.innerHTML = '<div class="search-no-results">No results found</div>';
            searchResults.classList.add('open');
          }
        });
      }, 300);
    });

    // Close search results on click outside
    document.addEventListener('click', e => {
      if (!e.target.closest('.live-search-wrap')) {
        searchResults.classList.remove('open');
      }
    });
  }

  // === BOOKING FORM (for plugin) ===
  const bookingForm = document.getElementById('vd-booking-form');
  if (bookingForm) {
    bookingForm.addEventListener('submit', e => {
      e.preventDefault();
      const btn = bookingForm.querySelector('button[type="submit"]');
      const originalText = btn.textContent;
      btn.textContent = 'Sending...';
      btn.disabled = true;

      const formData = new FormData(bookingForm);
      formData.append('action', 'vd_submit_booking');
      formData.append('nonce', vadimAjax.nonce);

      fetch(vadimAjax.url, {
        method: 'POST',
        body: formData,
      })
      .then(r => r.json())
      .then(data => {
        const msg = bookingForm.querySelector('.booking-message');
        if (data.success) {
          msg.textContent = data.data.message;
          msg.className = 'booking-message success';
          bookingForm.reset();
        } else {
          msg.textContent = data.data?.message || 'Error sending. Try again.';
          msg.className = 'booking-message error';
        }
        msg.style.display = 'block';
        btn.textContent = originalText;
        btn.disabled = false;
      })
      .catch(() => {
        btn.textContent = originalText;
        btn.disabled = false;
      });
    });
  }

})();
