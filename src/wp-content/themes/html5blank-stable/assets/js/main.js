'use strict'

const DEBUG = {
  all: false,
  GNAV: false
}

jQuery(function ($) {
  $(document).ready(function () {
  /******************************************
  init
  ******************************************/
    // const startPos = 0
    // const winScrollTop = 0

    // Add class for animation
    // $('.section--title, .section--content-inner').addClass('wow fadeInUp')

    new WOW().init()
    backToTop()
    smoothScrolling()
    $('.parallax').parallax()

    if (!String.prototype.padStart) {
      String.prototype.padStart = function padStart (targetLength, padString) {
        targetLength = targetLength >> 0 // truncate if number, or convert non-number to 0;
        padString = String(typeof padString !== 'undefined' ? padString : ' ')
        if (this.length >= targetLength) {
          return String(this)
        } else {
          targetLength = targetLength - this.length
          if (targetLength > padString.length) {
            padString += padString.repeat(targetLength / padString.length) // append to original to ensure we are longer than needed
          }
          return padString.slice(0, targetLength) + String(this)
        }
      }
    }

    /******************************************
    window scroll
    ******************************************/
    $(window).on('scroll', function () {
    // Stop this if the menu is shown
      if (DEBUG.GNAV) {
        $('.site-header').attr('style', 'position: fixed')
      }
    /*
    winScrollTop = $(this).scrollTop()

    if (winScrollTop <= 150) {
      $('.site-header').attr('style', 'background: transparent')
    }

    if (winScrollTop >= startPos) {
      if (winScrollTop >= 200) {
        $('.site-header').addClass('hide')
        $('.site-header').attr('style', 'background: rgba(0, 0, 0, 0.9)')
      }
    } else {
      $('.site-header').removeClass('hide')
    }
    startPos = winScrollTop
    */
    })

    $('.header .header--nav .dropdown-menu').css('top', $('.header--nav').outerHeight())
    /******************************************
    window resize
    ******************************************/
    $(window).on('resize', function () {
      $('.header .header--nav .dropdown-menu').css('top', $('.header--nav').outerHeight())
    })

    if ('ontouchstart' in window) { // check for touch device
      // Toggle right-menu on mobile
      $('.page--content-right').on('click', function () {
        $(this).toggleClass('active')
      })
    }

    // Toggle menu on mobile
    $('.menu-trigger').on('click', function () {
      if ($('.navbar-collapse').hasClass('show')) {
        $('.navbar-collapse').collapse('hide')
      } else {
        $('.navbar-collapse').collapse('show')
      }

      $(this).toggleClass('active')
      return false
    })

    // Search post by year
    $('select[name=select--year]').change(function () {
      const year = $(this).val()
      location.href = year ? G_CURRENT_REQUEST + '?y=' + year : G_CURRENT_REQUEST
    })

    // Toggle organization chart
    $('.toggle-organization-chart').on('click', function () {
      $(this).toggleClass('show-chart')
    })

    $('#jcci-groups .groups--item-inner').each(function (i, el) {
      const me = $(el)
      const title = me.find('.groups--title')
      const number = me.find('.groups--title-number')
      const text = me.find('.groups--title-text')
      const thumb = me.find('.groups--thumb')
      const desc = me.find('.groups--desc')
      let totalHeight = number.height() + text.height() + 16
      totalHeight = title.height() - 16
      $(desc).attr('style', 'top: ' + totalHeight + 'px; min-height: calc( 100% - ' + totalHeight + 'px );')
    })

    function sameHeightItem () {
      const arr_height = []
      $('.page-intro-register .same-height').each(function (i, el) {
        arr_height.push($(el).height())
      })
      $('.page-intro-register .same-height').height(Math.max.apply(null, arr_height))
    }

    if ('ontouchstart' in window) { // check for touch device
      $('.pll-switcher').on('click', function () {
        const me = $(this)
        console.log(me)
      // if ($(this).hasClass('active')) {
      //   var h
      //   h = $(this).find('img').css('height')
      //   $(this).find('.team-desc').stop(true).animate({ top: h }, 350, 'easeOutQuad')
      //   $(this).find('img').stop(true).animate({ 'margin-top': '0px' }, 400, 'easeOutQuad')
      //   $(this).removeClass('active')
      // } else {
      //   var h = $(this).find('img').css('height')
      //   $(this).find('.team-desc').stop(true).animate({ top: '0px' }, 350, 'easeOutQuad')
      //   $(this).find('img').stop(true).animate({ 'margin-top': '-100px' }, 400, 'easeOutQuad')
      //   $(this).addClass('active')
      // }
      })
    }

    // $('.nav-item.dropdown').mouseover(function () {
    //   const me = $(this)
    //   if (!me.hasClass('show')) {
    //     me.addClass('show')
    //     me.find('.dropdown-menu').addClass('show')
    //   }
    // }).mouseout(function () {
    //   const me = $(this)
    //   if (me.hasClass('show')) {
    //     me.removeClass('show')
    //     me.find('.dropdown-menu').removeClass('show')
    //   }
    // })

    var SECTION_MAIN_SLIDER_ID = 'slider'
    var MAIN_SLIDER_ID = 'main-slider'

    var SECTION_SERVICES_SLIDER_ID = 'jcci-services'
    var SERVICES_SLIDER_ID = 'services--slider'

    var PAGE_NEWSPAPER_SLIDER_ID = 'page-newspaper-slide'
    var SECTION_NEWSPAPER_SLIDER_ID = 'newspaper-slide'

    // Newspaper slider
    const owlNewspaper = $('#' + SECTION_NEWSPAPER_SLIDER_ID)
    owlNewspaper.owlCarousel({
      dots: false,
      items: 1,
      mouseDrag: false,
      onInitialized: onInitialized,
      touchDrag: false
    })

    // Main visual slider on frontpage
    const owlMainSlider = $('#' + MAIN_SLIDER_ID)
    owlMainSlider.owlCarousel({
      animateOut: 'fadeOut',
      autoplay: true,
      autoplayTimeout: 5000,
      autoplayHoverPause: true,
      dots: false,
      items: 1,
      loop: true,
      mouseDrag: false,
      touchDrag: false
    })

    // Service slider on frontpage
    const owlServiceSlider = $('#' + SERVICES_SLIDER_ID)
    owlServiceSlider.owlCarousel({
      dots: false,
      items: G_CURRENT_LANGUAGE == 'ja' ? 3 : 1,
      mouseDrag: false,
      onInitialized: onInitialized,
      responsiveClass: true,
      responsive: {
        0: {
          items: 1
        },
        576: {
          items: 3
        }
      },
      touchDrag: false
    })

    // slider banner on frontpage
    const owlBannerSlider = $('#banner-slider')
    owlBannerSlider.owlCarousel({
      items: 4,
      loop: true,
      responsiveClass: true,
      responsive: {
        0: {
          items: 1
        },
        425: {
          items: 3
        },
        1024: {
          items: 4
        }
      }
    })

    customOwlNav(SECTION_MAIN_SLIDER_ID, owlMainSlider)
    customOwlCounter(SECTION_MAIN_SLIDER_ID, owlMainSlider)

    customOwlNav(SECTION_SERVICES_SLIDER_ID, owlServiceSlider)
    customOwlCounter(SECTION_SERVICES_SLIDER_ID, owlServiceSlider)

    customOwlNav(PAGE_NEWSPAPER_SLIDER_ID, owlNewspaper)
    customOwlCounter(PAGE_NEWSPAPER_SLIDER_ID, owlNewspaper)

    function onInitialized () {
      const windowWidth = $(window).width()
      const me = this
      let size = me.options.items
      const totalItems = me._items.length
      let parentId = ''

      if (me.options.responsive && windowWidth < 576) {
        size = 1
      }

      let totalPage = Math.ceil(totalItems / size)

      if (size > 1) {
        totalPage += 1
      }
      if (totalPage < 10) {
        totalPage = '0' + totalPage
      }
      if (me.$element[0].id === SERVICES_SLIDER_ID) {
        parentId = SECTION_SERVICES_SLIDER_ID
      } else if (me.$element[0].id === SECTION_NEWSPAPER_SLIDER_ID) {
        parentId = PAGE_NEWSPAPER_SLIDER_ID
      }
      $('#' + parentId).find('.slider--btn-prev').css('opacity', '0')
      $('#' + parentId).find('.slider--counter-total').text(totalPage)
    }

    function customOwlNav (parentId, owlSlider) {
      $('#' + parentId + ' .slider--nav').on('click', function () {
        const me = $(this)
        const direction = me.data('direction')
        if (direction === 'next') {
          owlSlider.trigger('next.owl.carousel')
        }
        if (direction === 'prev') {
          owlSlider.trigger('prev.owl.carousel')
        }
      })
    }

    function customOwlCounter (parentId, owlSlider) {
      owlSlider.on('changed.owl.carousel', function (event) {
        const items = event.item.count
        let index = event.item.index
        const size = event.page.size
        let totalPage = Math.ceil(items / size)
        const isLoop = event.relatedTarget.options.loop
        if (size > 1) {
          totalPage += 1
        }
        if (isLoop) {
          index = index == 1 ? items : index - 1
        } else {
          index += 1
        }

        if (index > totalPage) {
          index = totalPage
        }

        if (index == totalPage && !isLoop) {
          $('#' + parentId).find('.slider--btn-next').css('opacity', '0')
        } else {
          $('#' + parentId).find('.slider--btn-next').css('opacity', '1')
        }

        if (index == 1 && !isLoop) {
          $('#' + parentId).find('.slider--btn-prev').css('opacity', '0')
        } else {
          $('#' + parentId).find('.slider--btn-prev').css('opacity', '1')
        }

        if (index < 10) {
          index = '0' + index
        }
        if (totalPage < 10) {
          totalPage = '0' + totalPage
        }
        $('#' + parentId).find('.slider--counter-current').text(index)
        $('#' + parentId).find('.slider--counter-total').text(totalPage)
      })
    }

    function backToTop () {
      $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
          $('#back-to-top').fadeIn()
          const minus = $('.footer--menu').offset().top - ($(window).height() + $(window).scrollTop())

          if (minus <= 0) {
            $('.back-to-top-inner').attr('style', 'position: absolute; top: -6rem;')
          } else {
            $('.back-to-top-inner').attr('style', 'position: fixed; top: unset;')
          }
        } else {
          $('#back-to-top').fadeOut()
        }
      })

      $('#back-to-top').click(function (e) {
        e.preventDefault()
        $('body,html').animate({
          scrollTop: 0
        }, 800)
        return false
      })
    }

    function smoothScrolling () {
      if (!$('a[href*="#"]').hasClass('smooth-scroll')) { return }
      // Select all links with hashes
      $('a[href*="#"]')
      // Remove links that don't actually link to anything
        .not('[href="#"]')
        .not('[href="#0"]')
        .click(function (event) {
        // On-page links
          if (
            location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') &&
          location.hostname == this.hostname
          ) {
          // Figure out element to scroll to
            var target = $(this.hash)
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']')
            // Does a scroll target exist?
            if (target.length) {
            // Only prevent default if animation is actually gonna happen
              event.preventDefault()
              console.log(target.offset())
              $('html, body').animate({
                scrollTop: target.offset().top
              }, 1000, function () {
              // Callback after animation
              // Must change focus!
                var $target = $(target)
                $target.focus()
                if ($target.is(':focus')) { // Checking if the target was focused
                  return false
                } else {
                  $target.attr('tabindex', '-1') // Adding tabindex for elements not focusable
                  $target.focus() // Set focus again
                };
              })
            }
          }
        })
    }

    // Detect touch screen and enable scrollbar if necessary
    function is_touch_device () {
      try {
        document.createEvent('TouchEvent')
        return true
      } catch (e) {
        return false
      }
    }
  })
})
