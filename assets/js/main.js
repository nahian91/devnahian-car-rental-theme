/**
 * Veloce Prestige Fleet - Theme & Plugin Core Scripts
 * WordPress-friendly bundle
 * 
 * Dependencies: jQuery
 * Text Domain / Namespace: dev-nahian-car-
 */

(function($) {
  'use strict';

  $(document).ready(function() {

    /* ==========================================================================
       1. NAVIGATION & OFFCANVAS MOBILE DRAWER
       ========================================================================== */
    const $mobileMenuBtn   = $('#dev-nahian-car-mobileMenuBtn');
    const $mobileDrawer    = $('#dev-nahian-car-mobileDrawer');
    const $drawerOverlay   = $('#dev-nahian-car-drawerOverlay');
    const $closeDrawerLinks= $('.dev-nahian-car-close-drawer');
    const $submenuToggles  = $('.dev-nahian-car-mobile-submenu-toggle');

    function toggleMobileDrawer(open) {
      if (!$mobileDrawer.length || !$drawerOverlay.length || !$mobileMenuBtn.length) return;

      $mobileDrawer.toggleClass('dev-nahian-car-open', open);
      $drawerOverlay.toggleClass('dev-nahian-car-open', open);
      $mobileMenuBtn.toggleClass('dev-nahian-car-active', open);
      $mobileMenuBtn.attr('aria-expanded', open ? 'true' : 'false');
      $('body').css('overflow', open ? 'hidden' : '');
    }

    if ($mobileMenuBtn.length) {
      $mobileMenuBtn.off('click').on('click', function(e) {
        e.preventDefault();
        const isOpen = $mobileDrawer.hasClass('dev-nahian-car-open');
        toggleMobileDrawer(!isOpen);
      });
    }

    if ($drawerOverlay.length) {
      $drawerOverlay.off('click').on('click', function() {
        toggleMobileDrawer(false);
      });
    }

    $closeDrawerLinks.off('click').on('click', function() {
      toggleMobileDrawer(false);
    });

    // Mobile Submenu Accordions
    $submenuToggles.off('click').on('click', function(e) {
      e.preventDefault();
      const targetId = $(this).data('dev-nahian-target');
      const $submenu = $('#' + targetId);
      
      if ($submenu.length) {
        $submenu.toggleClass('dev-nahian-car-open');
        const $icon = $(this).find('svg');
        if ($icon.length) {
          $icon.css({
            'transform': $submenu.hasClass('dev-nahian-car-open') ? 'rotate(180deg)' : 'rotate(0deg)',
            'transition': 'transform 0.25s ease'
          });
        }
      }
    });

    /* ==========================================================================
       2. HERO DATE SELECTOR & ITINERARY ESTIMATOR (Front Page)
       ========================================================================== */
    const $heroDateIn    = $('#dev-nahian-car-searchDateIn');
    const $heroDateOut   = $('#dev-nahian-car-searchDateOut');
    const $liveScopeText = $('#dev-nahian-car-liveScopeDays');
    const $heroForm      = $('#dev-nahian-car-heroSearchForm');

    if ($heroDateIn.length && $heroDateOut.length) {
      const today = new Date();
      const plus3 = new Date();
      plus3.setDate(today.getDate() + 3);

      const todayStr = today.toISOString().split('T')[0];
      const plus3Str = plus3.toISOString().split('T')[0];

      if (!$heroDateIn.val()) $heroDateIn.val(todayStr);
      if (!$heroDateOut.val()) $heroDateOut.val(plus3Str);
      
      $heroDateIn.attr('min', todayStr);
      $heroDateOut.attr('min', todayStr);

      function updateHeroScope() {
        const startVal = $heroDateIn.val();
        const endVal = $heroDateOut.val();
        if (!startVal || !endVal) return;

        const start = new Date(startVal);
        const end = new Date(endVal);

        if (end <= start) {
          const nextDay = new Date(start);
          nextDay.setDate(nextDay.getDate() + 1);
          $heroDateOut.val(nextDay.toISOString().split('T')[0]);
        }
        $heroDateOut.attr('min', startVal);

        const diffDays = Math.max(1, Math.ceil((new Date($heroDateOut.val()) - new Date($heroDateIn.val())) / (1000 * 60 * 60 * 24)));
        if ($liveScopeText.length) {
          $liveScopeText.text(diffDays + ' Day' + (diffDays > 1 ? 's' : '') + ' Selected');
        }
      }

      $heroDateIn.off('change').on('change', updateHeroScope);
      $heroDateOut.off('change').on('change', updateHeroScope);
    }

    if ($heroForm.length) {
      $heroForm.off('submit').on('submit', function(e) {
        const $targetFleet = $('#dev-nahian-car-fleets');
        if ($targetFleet.length) {
          e.preventDefault();
          $('html, body').animate({
            scrollTop: $targetFleet.offset().top - 80
          }, 600);
        }
      });
    }

    /* ==========================================================================
       3. HOMEPAGE TAB FILTER
       ========================================================================== */
    const $homeTabs  = $('.dev-nahian-car-filter-tab');
    const $homeCards = $('#dev-nahian-car-fleetGridContainer .dev-nahian-car-box');

    if ($homeTabs.length && $homeCards.length) {
      $homeTabs.off('click').on('click', function(e) {
        e.preventDefault();
        $homeTabs.removeClass('dev-nahian-car-active');
        $(this).addClass('dev-nahian-car-active');

        const filter = $(this).data('dev-nahian-filter');
        $homeCards.each(function() {
          const cat = $(this).data('dev-nahian-category');
          if (filter === 'all' || cat === filter) {
            $(this).css('display', 'flex');
          } else {
            $(this).hide();
          }
        });
      });
    }

    $('.dev-nahian-car-book-trigger').off('click').on('click', function() {
      const model = $(this).data('dev-nahian-model');
      const $pickUp = $('#dev-nahian-car-searchPickUp');
      if ($pickUp.length && model) {
        $pickUp.val(model + ' (Direct FBO Dispatch)');
      }
    });

    /* ==========================================================================
       4. FLEET ARCHIVE SEARCH, MULTI-FACET FILTER & SORT
       ========================================================================== */
    const $catalogSearch   = $('#keywordSearch');
    const $categoryPills    = $('.dev-nahian-car-category-pill');
    const $categoryRadios   = $('input[name="categoryFilter"]');
    const $priceRange       = $('#priceRange');
    const $priceReadout     = $('#priceReadout');
    const $driveCheckboxes  = $('.dev-nahian-car-drive-filter');
    const $chipLabels       = $('.dev-nahian-car-chip-label');
    const $sortBySelect     = $('#sortBySelect');
    const $catalogGrid      = $('#fleetGrid');
    const $catalogCards     = $('.dev-nahian-car-fleet-grid .dev-nahian-car-car-box');
    const $filteredCount    = $('#filteredCount');
    const $emptyState       = $('#emptyState');
    const $resetBtn         = $('#resetFiltersBtn, #resetEmptyBtn');

    if ($catalogGrid.length && $catalogCards.length) {
      function syncVisualStates() {
        $categoryPills.each(function() {
          const isChecked = $(this).find('input[type="radio"]').is(':checked');
          $(this).toggleClass('active', isChecked);
        });

        $chipLabels.each(function() {
          const isChecked = $(this).find('input[type="checkbox"]').is(':checked');
          $(this).toggleClass('active', isChecked);
        });
      }

      function executeCatalogFilters() {
        syncVisualStates();

        const keyword = $catalogSearch.length ? $.trim($catalogSearch.val()).toLowerCase() : '';
        const selectedCategory = $('input[name="categoryFilter"]:checked').val() || 'all';
        const maxPrice = $priceRange.length ? Number($priceRange.val()) : Infinity;

        if ($priceReadout.length && $priceRange.length) {
          $priceReadout.text('$' + maxPrice);
        }

        const selectedDrives = $driveCheckboxes.filter(':checked').map(function() {
          return $(this).val();
        }).get();

        let visibleCount = 0;

        $catalogCards.each(function() {
          const $card = $(this);
          const title = ($card.find('h3').text() || '').toLowerCase();
          const subtitle = ($card.find('.dev-nahian-car-car-sub').text() || '').toLowerCase();
          const category = $card.data('category');
          const price = Number($card.data('price')) || 0;
          const drives = ($card.data('drive') || '').toString().split(',');

          const matchKeyword  = !keyword || title.indexOf(keyword) !== -1 || subtitle.indexOf(keyword) !== -1;
          const matchCategory = selectedCategory === 'all' || category === selectedCategory;
          const matchPrice    = price <= maxPrice;
          const matchDrive    = selectedDrives.length === 0 || selectedDrives.every(d => drives.includes(d));

          if (matchKeyword && matchCategory && matchPrice && matchDrive) {
            $card.css('display', 'flex');
            visibleCount++;
          } else {
            $card.hide();
          }
        });

        if ($filteredCount.length) $filteredCount.text(visibleCount);
        if ($emptyState.length) $emptyState.toggleClass('show', visibleCount === 0);
      }

      function sortCatalogCards() {
        if (!$sortBySelect.length) return;
        const sortVal = $sortBySelect.val();
        const $cardArray = $catalogCards.toArray();

        $cardArray.sort(function(a, b) {
          const pA = Number($(a).data('price')) || 0;
          const pB = Number($(b).data('price')) || 0;
          const hA = Number($(a).data('power')) || 0;
          const hB = Number($(b).data('power')) || 0;

          if (sortVal === 'price-asc') return pA - pB;
          if (sortVal === 'price-desc') return pB - pA;
          if (sortVal === 'power-desc') return hB - hA;
          return 0;
        });

        $.each($cardArray, function(idx, card) {
          $catalogGrid.append(card);
        });
        if ($emptyState.length) $catalogGrid.append($emptyState);
      }

      function resetFilters(e) {
        if (e) e.preventDefault();
        if ($catalogSearch.length) $catalogSearch.val('');
        $('input[name="categoryFilter"][value="all"]').prop('checked', true);
        if ($priceRange.length) $priceRange.val(210);
        $driveCheckboxes.prop('checked', false);
        if ($sortBySelect.length) $sortBySelect.val('featured');
        executeCatalogFilters();
        sortCatalogCards();
      }

      $catalogSearch.off('input').on('input', executeCatalogFilters);
      $categoryRadios.off('change').on('change', executeCatalogFilters);
      $priceRange.off('input').on('input', executeCatalogFilters);
      $driveCheckboxes.off('change').on('change', executeCatalogFilters);
      $sortBySelect.off('change').on('change', sortCatalogCards);
      $resetBtn.off('click').on('click', resetFilters);

      executeCatalogFilters();
    }

    /* ==========================================================================
       5. GALLERY CATEGORY FILTER & LIGHTBOX MODAL
       ========================================================================== */
    const $galFilters = $('.dev-nahian-car-filter-bar .dev-nahian-car-filter-btn');
    const $galItems   = $('.dev-nahian-car-gallery-grid .dev-nahian-car-gallery-item');
    const $lightbox   = $('#galleryLightbox');
    const $lbImg      = $('#lightboxImg');
    const $lbCaption  = $('#lightboxCaption');
    const $lbClose    = $('#lightboxClose');

    if ($galFilters.length && $galItems.length) {
      $galFilters.off('click').on('click', function(e) {
        e.preventDefault();
        $galFilters.removeClass('active');
        $(this).addClass('active');

        const filter = $(this).data('filter');
        $galItems.each(function() {
          const cat = $(this).data('category');
          if (filter === 'all' || cat === filter) {
            $(this).show();
          } else {
            $(this).hide();
          }
        });
      });
    }

    if ($lightbox.length && $galItems.length) {
      $galItems.off('click').on('click', function() {
        const src = $(this).data('src');
        const title = $(this).data('title');
        if ($lbImg.length) $lbImg.attr({ 'src': src, 'alt': title });
        if ($lbCaption.length) $lbCaption.text(title);

        $lightbox.addClass('active');
        $('body').css('overflow', 'hidden');
      });

      function closeLightbox() {
        $lightbox.removeClass('active');
        $('body').css('overflow', '');
        if ($lbImg.length) $lbImg.attr('src', '');
      }

      if ($lbClose.length) $lbClose.off('click').on('click', closeLightbox);
      $lightbox.off('click').on('click', function(e) {
        if ($(e.target).is('#galleryLightbox')) closeLightbox();
      });
    }

    /* ==========================================================================
       6. VEHICLE SINGLE VIEW: PERSPECTIVES, VIDEO & DISPATCH CALC
       ========================================================================== */
    const $detailStageImg  = $('#mainStageImage');
    const $detailViewport  = $('#galleryViewport');
    const $detailThumbs    = $('.dev-nahian-car-thumb-item');
    const $detailLbModal   = $('#lightboxModal');
    const $detailLbImg     = $detailLbModal.length ? $detailLbModal.find('#lightboxImg') : $();
    const $detailLbCap     = $detailLbModal.length ? $detailLbModal.find('#lightboxCaptionText') : $();
    const $detailCloseBtn  = $('#lightboxCloseBtn');
    const $detailPrevBtn   = $('#lightboxPrevBtn');
    const $detailNextBtn   = $('#lightboxNextBtn');
    const $detailEnlargeBtn= $('#openFullscreenBtn');

    let currentPhotoIdx = 0;

    function setPerspective(idx) {
      if (!$detailThumbs.length) return;
      currentPhotoIdx = (idx + $detailThumbs.length) % $detailThumbs.length;

      $detailThumbs.removeClass('active').eq(currentPhotoIdx).addClass('active');
      const $activeThumb = $detailThumbs.eq(currentPhotoIdx);
      const newSrc = $activeThumb.data('src') || $activeThumb.find('img').attr('src');
      const caption = $activeThumb.data('caption') || 'Veloce Perspective';

      if ($detailStageImg.length && newSrc) {
        $detailStageImg.css('opacity', 0.3);
        setTimeout(function() {
          $detailStageImg.attr('src', newSrc).css('opacity', 1);
        }, 120);
      }
      if ($detailLbImg.length && newSrc) $detailLbImg.attr('src', newSrc);
      if ($detailLbCap.length) $detailLbCap.text(caption);
    }

    if ($detailThumbs.length) {
      $detailThumbs.off('click').on('click', function() {
        setPerspective($detailThumbs.index(this));
      });

      function openModal() {
        setPerspective(currentPhotoIdx);
        if ($detailLbModal.length) {
          $detailLbModal.addClass('active').attr('aria-hidden', 'false');
          $('body').css('overflow', 'hidden');
        }
      }

      function closeModal() {
        if ($detailLbModal.length) {
          $detailLbModal.removeClass('active').attr('aria-hidden', 'true');
          $('body').css('overflow', '');
        }
      }

      if ($detailEnlargeBtn.length) $detailEnlargeBtn.off('click').on('click', openModal);
      if ($detailViewport.length) $detailViewport.off('click').on('click', openModal);
      if ($detailCloseBtn.length) $detailCloseBtn.off('click').on('click', closeModal);

      if ($detailPrevBtn.length) {
        $detailPrevBtn.off('click').on('click', function(e) {
          e.stopPropagation();
          setPerspective(currentPhotoIdx - 1);
        });
      }

      if ($detailNextBtn.length) {
        $detailNextBtn.off('click').on('click', function(e) {
          e.stopPropagation();
          setPerspective(currentPhotoIdx + 1);
        });
      }

      if ($detailLbModal.length) {
        $detailLbModal.off('click').on('click', function(e) {
          if ($(e.target).is('#lightboxModal')) closeModal();
        });
      }
    }

    // Single Vehicle Video Engine
    const videoElem = document.getElementById('chassisVideo');
    const $playOverlay = $('#videoPlayOverlayBtn');
    const $restartBtn  = $('#restartVideoBtn');

    if (videoElem && $playOverlay.length) {
      $playOverlay.off('click').on('click', function() {
        videoElem.play();
        videoElem.controls = true;
        $playOverlay.hide();
      });

      videoElem.addEventListener('pause', function() {
        if (!videoElem.seeking) {
          $playOverlay.css('display', 'flex');
          videoElem.controls = false;
        }
      });

      videoElem.addEventListener('play', function() {
        $playOverlay.hide();
        videoElem.controls = true;
      });

      if ($restartBtn.length) {
        $restartBtn.off('click').on('click', function() {
          videoElem.currentTime = 0;
          videoElem.play();
          $playOverlay.hide();
          videoElem.controls = true;
        });
      }
    }

    // Terminal Booking Real-Time Calculator
    const $tStartDate   = $('#startDate');
    const $tEndDate     = $('#endDate');
    const $scopeDays    = $('#scopeDaysText');
    const $totalPrice   = $('#totalPriceFig');
    const $addonsFee    = $('#addonsFeeText');
    const $dropoffBay   = $('#dropoffTerminalSelect');
    const $airportFee   = $('#airportFeeText');
    const $addonChecks  = $('.dev-nahian-car-addon-check');
    const $termForm     = $('#vehicleTerminalForm');
    const $confBox      = $('#confirmationBox');

    const BASE_RATE = 189;

    if ($tStartDate.length && $tEndDate.length) {
      const today = new Date();
      const future = new Date();
      future.setDate(today.getDate() + 3);

      if (!$tStartDate.val()) $tStartDate.val(today.toISOString().split('T')[0]);
      if (!$tEndDate.val()) $tEndDate.val(future.toISOString().split('T')[0]);

      $tStartDate.attr('min', today.toISOString().split('T')[0]);
      $tEndDate.attr('min', today.toISOString().split('T')[0]);

      function calculatePricing() {
        const startVal = $tStartDate.val();
        const endVal = $tEndDate.val();
        if (!startVal || !endVal) return;

        const start = new Date(startVal);
        const end = new Date(endVal);
        const days = Math.max(1, Math.ceil((end - start) / (1000 * 60 * 60 * 24)));

        let addonSum = 0;
        $addonChecks.filter(':checked').each(function() {
          addonSum += Number($(this).data('rate')) || 0;
        });

        if ($addonsFee.length) $addonsFee.text('$' + addonSum.toFixed(2));

        const relocationFee = ($dropoffBay.length && $dropoffBay.val() !== 'same') ? 120 : 0;
        if ($airportFee.length) {
          if (relocationFee > 0) {
            $airportFee.text('$' + relocationFee + '.00 (Inter-Bay)').css('color', 'var(--dev-nahian-car-text-dark)');
          } else {
            $airportFee.text('$0.00 (Waived)').css('color', 'var(--dev-nahian-car-accent-green)');
          }
        }

        const grandTotal = (days * BASE_RATE) + addonSum + relocationFee;

        if ($scopeDays.length) $scopeDays.text(days + ' Day' + (days > 1 ? 's' : ''));
        if ($totalPrice.length) $totalPrice.text('$' + grandTotal.toLocaleString());
      }

      $tStartDate.off('change').on('change', function() {
        if (new Date($tEndDate.val()) <= new Date($tStartDate.val())) {
          const nextDay = new Date($tStartDate.val());
          nextDay.setDate(nextDay.getDate() + 1);
          $tEndDate.val(nextDay.toISOString().split('T')[0]);
        }
        $tEndDate.attr('min', $tStartDate.val());
        calculatePricing();
      });

      $tEndDate.off('change').on('change', calculatePricing);
      if ($dropoffBay.length) $dropoffBay.off('change').on('change', calculatePricing);
      $addonChecks.off('change').on('change', calculatePricing);

      calculatePricing();
    }

    if ($termForm.length && $confBox.length) {
      $termForm.off('submit').on('submit', function(e) {
        e.preventDefault();
        $confBox.addClass('show');
        $('html, body').animate({
          scrollTop: $confBox.offset().top - 100
        }, 500);
      });
    }

    /* ==========================================================================
       7. CHECKOUT INTERACTION & CC FORMATTER
       ========================================================================== */
    const $payLabels  = $('.dev-nahian-car-payment-option-label');
    const $cardInputs = $('#cardInputsContainer');
    const $altNotice  = $('#altPaymentNotice');
    const $cardNum    = $('#cardNumber');
    const $cardExp    = $('#cardExpiry');
    const $cardCvc    = $('#cardCvc');
    const $checkForm  = $('#checkoutAuthorizationForm');
    const $checkAlert = $('#checkoutSuccess');

    if ($payLabels.length) {
      $payLabels.off('click').on('click', function() {
        $payLabels.removeClass('active');
        $(this).addClass('active');

        const $radio = $(this).find('input[type="radio"]');
        $radio.prop('checked', true);

        const isCard = $radio.val() === 'card';
        if ($cardInputs.length) $cardInputs.toggle(isCard);
        if ($altNotice.length) $altNotice.toggle(!isCard);

        if ($cardNum.length) $cardNum.prop('required', isCard);
        if ($cardExp.length) $cardExp.prop('required', isCard);
        if ($cardCvc.length) $cardCvc.prop('required', isCard);
      });
    }

    if ($cardNum.length) {
      $cardNum.off('input').on('input', function() {
        let val = $(this).val().replace(/\D/g, '').substring(0, 16);
        const matches = val.match(/.{1,4}/g);
        $(this).val(matches ? matches.join(' ') : '');
      });
    }

    if ($cardExp.length) {
      $cardExp.off('input').on('input', function() {
        let val = $(this).val().replace(/\D/g, '').substring(0, 4);
        if (val.length >= 2) {
          val = val.substring(0, 2) + '/' + val.substring(2);
        }
        $(this).val(val);
      });
    }

    if ($checkForm.length && $checkAlert.length) {
      $checkForm.off('submit').on('submit', function(e) {
        e.preventDefault();
        $checkAlert.addClass('show');
        $('html, body').animate({
          scrollTop: $checkAlert.offset().top - 100
        }, 500);
      });
    }

    /* ==========================================================================
       8. CLIENT DASHBOARD TABBING (account.php)
       ========================================================================== */
    const $dashBtns  = $('.dev-nahian-car-dash-nav-btn');
    const $dashPanes = $('.dev-nahian-car-dash-pane');
    const $kycForm   = $('#driverProfileForm');
    const $kycAlert  = $('#accountAlert');

    if ($dashBtns.length && $dashPanes.length) {
      $dashBtns.off('click').on('click', function(e) {
        e.preventDefault();
        $dashBtns.removeClass('active');
        $(this).addClass('active');

        const targetId = $(this).data('target');
        $dashPanes.each(function() {
          $(this).toggleClass('active', $(this).attr('id') === targetId);
        });
      });
    }

    if ($kycForm.length && $kycAlert.length) {
      $kycForm.off('submit').on('submit', function(e) {
        e.preventDefault();
        $kycAlert.addClass('show');
        setTimeout(function() {
          $kycAlert.removeClass('show');
        }, 4000);
      });
    }

    /* ==========================================================================
       9. AUTH MODAL / TABS & PASSWORD TOGGLES (login.php)
       ========================================================================== */
    const $tabLoginBtn  = $('#tabLoginBtn');
    const $tabRegBtn    = $('#tabRegBtn');
    const $loginPane    = $('#loginFormPane');
    const $regPane      = $('#regFormPane');
    const $loginAlert   = $('#loginAlert');
    const $regAlert     = $('#regAlert');

    if ($tabLoginBtn.length && $tabRegBtn.length) {
      $tabLoginBtn.off('click').on('click', function() {
        $tabLoginBtn.addClass('active');
        $tabRegBtn.removeClass('active');
        $loginPane.addClass('active');
        $regPane.removeClass('active');
      });

      $tabRegBtn.off('click').on('click', function() {
        $tabRegBtn.addClass('active');
        $tabLoginBtn.removeClass('active');
        $regPane.addClass('active');
        $loginPane.removeClass('active');
      });
    }

    $('.dev-nahian-car-pwd-toggle-btn').off('click').on('click', function() {
      const targetId = $(this).data('target');
      const $field = $('#' + targetId);
      if (!$field.length) return;

      const isPwd = $field.attr('type') === 'password';
      $field.attr('type', isPwd ? 'text' : 'password');

      $(this).html(isPwd
        ? '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>'
        : '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>'
      );
    });

    if ($loginPane.length && $loginAlert.length) {
      $loginPane.off('submit').on('submit', function(e) {
        e.preventDefault();
        $loginAlert.addClass('show');
        setTimeout(function() {
          window.location.href = 'cars.php';
        }, 1200);
      });
    }

    if ($regPane.length && $regAlert.length) {
      $regPane.off('submit').on('submit', function(e) {
        e.preventDefault();
        $regAlert.addClass('show');
        $regPane[0].reset();
        setTimeout(function() {
          $regAlert.removeClass('show');
          if ($tabLoginBtn.length) $tabLoginBtn.trigger('click');
        }, 3000);
      });
    }

    /* ==========================================================================
       10. ACCORDION FAQ
       ========================================================================== */
    const $faqItems = $('.dev-nahian-car-faq-item');
    if ($faqItems.length) {
      $faqItems.find('.dev-nahian-car-faq-question').off('click').on('click', function() {
        const $parent = $(this).closest('.dev-nahian-car-faq-item');
        const isOpen = $parent.hasClass('dev-nahian-car-open');

        $faqItems.removeClass('dev-nahian-car-open').find('.dev-nahian-car-faq-answer').css('max-height', '');

        if (!isOpen) {
          $parent.addClass('dev-nahian-car-open');
          const $answer = $parent.find('.dev-nahian-car-faq-answer');
          $answer.css('max-height', $answer.prop('scrollHeight') + 'px');
        }
      });
    }

    /* ==========================================================================
       11. INTERSECTION OBSERVER - ANIMATED NUMERIC COUNTERS (CounterUp)
       ========================================================================== */
    const counterElements = document.querySelectorAll('.dev-nahian-car-counter-val, [data-dev-nahian-target], [data-target]');
    if (counterElements.length && 'IntersectionObserver' in window) {
      counterElements.forEach(el => {
        let isAnimated = false;
        const observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting && !isAnimated) {
              isAnimated = true;
              const $val = $(el);
              const target = +($val.data('dev-nahian-target') || $val.data('target') || 0);
              let current = 0;
              const step = Math.max(1, Math.ceil(target / 40));
              const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                  $val.text(target);
                  clearInterval(timer);
                } else {
                  $val.text(current);
                }
              }, 30);
            }
          });
        }, { threshold: 0.2 });

        observer.observe(el);
      });
    }

    /* ==========================================================================
       12. TESTIMONIALS CAROUSEL ENGINE
       ========================================================================== */
    const $track   = $('#dev-nahian-car-testimonialTrack');
    const $prevBtn = $('#dev-nahian-car-prevBtn');
    const $nextBtn = $('#dev-nahian-car-nextBtn');
    const $dotsWrap= $('#dev-nahian-car-carouselDots');

    if ($track.length) {
      const $slides = $track.children();
      let activeIdx = 0;

      function getSpv() {
        const w = $(window).width();
        if (w >= 1024) return 3;
        if (w >= 768) return 2;
        return 1;
      }

      function buildDots() {
        if (!$dotsWrap.length) return;
        $dotsWrap.empty();
        const total = Math.max(1, $slides.length - getSpv() + 1);

        for (let i = 0; i < total; i++) {
          const $dot = $('<div class="dev-nahian-car-carousel-dot"></div>');
          if (i === activeIdx) $dot.addClass('dev-nahian-car-active');
          $dot.off('click').on('click', function() {
            activeIdx = i;
            renderCarousel();
          });
          $dotsWrap.append($dot);
        }
      }

      function renderCarousel() {
        const spv = getSpv();
        const maxIdx = Math.max(0, $slides.length - spv);
        if (activeIdx > maxIdx) activeIdx = maxIdx;

        const slideWidthPercent = 100 / spv;
        const shiftAmount = activeIdx * slideWidthPercent;

        $track.css('transform', 'translateX(-' + shiftAmount + '%)');

        if ($dotsWrap.length) {
          $dotsWrap.children().removeClass('dev-nahian-car-active').eq(activeIdx).addClass('dev-nahian-car-active');
        }
      }

      if ($prevBtn.length) {
        $prevBtn.off('click').on('click', function(e) {
          e.preventDefault();
          const spv = getSpv();
          const maxIdx = Math.max(0, $slides.length - spv);
          activeIdx = activeIdx > 0 ? activeIdx - 1 : maxIdx;
          renderCarousel();
        });
      }

      if ($nextBtn.length) {
        $nextBtn.off('click').on('click', function(e) {
          e.preventDefault();
          const spv = getSpv();
          const maxIdx = Math.max(0, $slides.length - spv);
          activeIdx = activeIdx < maxIdx ? activeIdx + 1 : 0;
          renderCarousel();
        });
      }

      let resizeTimer;
      $(window).off('resize.carousel').on('resize.carousel', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
          buildDots();
          renderCarousel();
        }, 120);
      });

      buildDots();
      renderCarousel();
    }

  });
})(jQuery);