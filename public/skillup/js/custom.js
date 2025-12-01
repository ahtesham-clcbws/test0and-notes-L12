// $(function () {
// 	"use strict";
// csrf token for ajax requests
const csrfToken = $('meta[name="_token"]').attr('content');
$.ajaxSetup({
	headers: {
		'X-CSRF-Token': csrfToken
	}
});
// $(document).ajaxStart(function () {
// 	startLoader();
// });
// $(document).ajaxComplete(function () {
// 	stopLoader();
// });
function startLoader() {
	$('#fullpage_loader').show();
	bodyOverflowStart();
}
function stopLoader() {
	$('#fullpage_loader').hide();
	bodyOverflowStop();
}
function bodyOverflowStart() {
	document.body.style.overflow = 'hidden';
}
function bodyOverflowStop() {
	document.body.style.overflow = 'overlay';
}

// Script Navigation
! function (n, e, i, a) {
	n.navigation = function (t, s) {
		var o = {
			responsive: !0,
			mobileBreakpoint: 992,
			showDuration: 300,
			hideDuration: 300,
			showDelayDuration: 0,
			hideDelayDuration: 0,
			submenuTrigger: "hover",
			effect: "fade",
			submenuIndicator: !0,
			hideSubWhenGoOut: !0,
			visibleSubmenusOnMobile: !1,
			fixed: !1,
			overlay: !0,
			overlayColor: "rgba(0, 0, 0, 0.5)",
			hidden: !1,
			offCanvasSide: "left",
			onInit: function () { },
			onShowOffCanvas: function () { },
			onHideOffCanvas: function () { }
		},
			u = this,
			r = Number.MAX_VALUE,
			d = 1,
			f = "click.nav touchstart.nav",
			l = "mouseenter.nav",
			c = "mouseleave.nav";
		u.settings = {};
		var t = (n(t), t);
		n(t).find(".nav-menus-wrapper").prepend("<span class='nav-menus-wrapper-close-button'>✕</span>"), n(t).find(".nav-search").length > 0 && n(t).find(".nav-search").find("form").prepend("<span class='nav-search-close-button'>✕</span>"), u.init = function () {
			u.settings = n.extend({}, o, s), "right" == u.settings.offCanvasSide && n(t).find(".nav-menus-wrapper").addClass("nav-menus-wrapper-right"), u.settings.hidden && (n(t).addClass("navigation-hidden"), u.settings.mobileBreakpoint = 99999), v(), u.settings.fixed && n(t).addClass("navigation-fixed"), n(t).find(".nav-toggle").on("click touchstart", function (n) {
				n.stopPropagation(), n.preventDefault(), u.showOffcanvas(), s !== a && u.callback("onShowOffCanvas")
			}), n(t).find(".nav-menus-wrapper-close-button").on("click touchstart", function () {
				u.hideOffcanvas(), s !== a && u.callback("onHideOffCanvas")
			}), n(t).find(".nav-search-button").on("click touchstart", function (n) {
				n.stopPropagation(), n.preventDefault(), u.toggleSearch()
			}), n(t).find(".nav-search-close-button").on("click touchstart", function () {
				u.toggleSearch()
			}), n(t).find(".megamenu-tabs").length > 0 && y(), n(e).resize(function () {
				m(), C()
			}), m(), s !== a && u.callback("onInit")
		};
		var v = function () {
			n(t).find("li").each(function () {
				n(this).children(".nav-dropdown,.megamenu-panel").length > 0 && (n(this).children(".nav-dropdown,.megamenu-panel").addClass("nav-submenu"), u.settings.submenuIndicator && n(this).children("a").append("<span class='submenu-indicator'><span class='submenu-indicator-chevron'></span></span>"))
			})
		};
		u.showSubmenu = function (e, i) {
			g() > u.settings.mobileBreakpoint && n(t).find(".nav-search").find("form").slideUp(), "fade" == i ? n(e).children(".nav-submenu").stop(!0, !0).delay(u.settings.showDelayDuration).fadeIn(u.settings.showDuration) : n(e).children(".nav-submenu").stop(!0, !0).delay(u.settings.showDelayDuration).slideDown(u.settings.showDuration), n(e).addClass("nav-submenu-open")
		}, u.hideSubmenu = function (e, i) {
			"fade" == i ? n(e).find(".nav-submenu").stop(!0, !0).delay(u.settings.hideDelayDuration).fadeOut(u.settings.hideDuration) : n(e).find(".nav-submenu").stop(!0, !0).delay(u.settings.hideDelayDuration).slideUp(u.settings.hideDuration), n(e).removeClass("nav-submenu-open").find(".nav-submenu-open").removeClass("nav-submenu-open")
		};
		var h = function () {
			n("body").addClass("no-scroll"), u.settings.overlay && (n(t).append("<div class='nav-overlay-panel'></div>"), n(t).find(".nav-overlay-panel").css("background-color", u.settings.overlayColor).fadeIn(300).on("click touchstart", function (n) {
				u.hideOffcanvas()
			}))
		},
			p = function () {
				n("body").removeClass("no-scroll"), u.settings.overlay && n(t).find(".nav-overlay-panel").fadeOut(400, function () {
					n(this).remove()
				})
			};
		u.showOffcanvas = function () {
			h(), "left" == u.settings.offCanvasSide ? n(t).find(".nav-menus-wrapper").css("transition-property", "left").addClass("nav-menus-wrapper-open") : n(t).find(".nav-menus-wrapper").css("transition-property", "right").addClass("nav-menus-wrapper-open")
		}, u.hideOffcanvas = function () {
			n(t).find(".nav-menus-wrapper").removeClass("nav-menus-wrapper-open").on("webkitTransitionEnd moztransitionend transitionend oTransitionEnd", function () {
				n(t).find(".nav-menus-wrapper").css("transition-property", "none").off()
			}), p()
		}, u.toggleOffcanvas = function () {
			g() <= u.settings.mobileBreakpoint && (n(t).find(".nav-menus-wrapper").hasClass("nav-menus-wrapper-open") ? (u.hideOffcanvas(), s !== a && u.callback("onHideOffCanvas")) : (u.showOffcanvas(), s !== a && u.callback("onShowOffCanvas")))
		}, u.toggleSearch = function () {
			"none" == n(t).find(".nav-search").find("form").css("display") ? (n(t).find(".nav-search").find("form").slideDown(), n(t).find(".nav-submenu").fadeOut(200)) : n(t).find(".nav-search").find("form").slideUp()
		};
		var m = function () {
			u.settings.responsive ? (g() <= u.settings.mobileBreakpoint && r > u.settings.mobileBreakpoint && (n(t).addClass("navigation-portrait").removeClass("navigation-landscape"), D()), g() > u.settings.mobileBreakpoint && d <= u.settings.mobileBreakpoint && (n(t).addClass("navigation-landscape").removeClass("navigation-portrait"), k(), p(), u.hideOffcanvas()), r = g(), d = g()) : k()
		},
			b = function () {
				n("body").on("click.body touchstart.body", function (e) {
					0 === n(e.target).closest(".navigation").length && (n(t).find(".nav-submenu").fadeOut(), n(t).find(".nav-submenu-open").removeClass("nav-submenu-open"), n(t).find(".nav-search").find("form").slideUp())
				})
			},
			g = function () {
				return e.innerWidth || i.documentElement.clientWidth || i.body.clientWidth
			},
			w = function () {
				n(t).find(".nav-menu").find("li, a").off(f).off(l).off(c)
			},
			C = function () {
				if (g() > u.settings.mobileBreakpoint) {
					var e = n(t).outerWidth(!0);
					n(t).find(".nav-menu").children("li").children(".nav-submenu").each(function () {
						n(this).parent().position().left + n(this).outerWidth() > e ? n(this).css("right", 0) : n(this).css("right", "auto")
					})
				}
			},
			y = function () {
				function e(e) {
					var i = n(e).children(".megamenu-tabs-nav").children("li"),
						a = n(e).children(".megamenu-tabs-pane");
					n(i).on("click.tabs touchstart.tabs", function (e) {
						e.stopPropagation(), e.preventDefault(), n(i).removeClass("active"), n(this).addClass("active"), n(a).hide(0).removeClass("active"), n(a[n(this).index()]).show(0).addClass("active")
					})
				}
				if (n(t).find(".megamenu-tabs").length > 0)
					for (var i = n(t).find(".megamenu-tabs"), a = 0; a < i.length; a++) e(i[a])
			},
			k = function () {
				w(), n(t).find(".nav-submenu").hide(0), navigator.userAgent.match(/Mobi/i) || navigator.maxTouchPoints > 0 || "click" == u.settings.submenuTrigger ? n(t).find(".nav-menu, .nav-dropdown").children("li").children("a").on(f, function (i) {
					if (u.hideSubmenu(n(this).parent("li").siblings("li"), u.settings.effect), n(this).closest(".nav-menu").siblings(".nav-menu").find(".nav-submenu").fadeOut(u.settings.hideDuration), n(this).siblings(".nav-submenu").length > 0) {
						if (i.stopPropagation(), i.preventDefault(), "none" == n(this).siblings(".nav-submenu").css("display")) return u.showSubmenu(n(this).parent("li"), u.settings.effect), C(), !1;
						if (u.hideSubmenu(n(this).parent("li"), u.settings.effect), "_blank" == n(this).attr("target") || "blank" == n(this).attr("target")) e.open(n(this).attr("href"));
						else {
							if ("#" == n(this).attr("href") || "" == n(this).attr("href")) return !1;
							e.location.href = n(this).attr("href")
						}
					}
				}) : n(t).find(".nav-menu").find("li").on(l, function () {
					u.showSubmenu(this, u.settings.effect), C()
				}).on(c, function () {
					u.hideSubmenu(this, u.settings.effect)
				}), u.settings.hideSubWhenGoOut && b()
			},
			D = function () {
				w(), n(t).find(".nav-submenu").hide(0), u.settings.visibleSubmenusOnMobile ? n(t).find(".nav-submenu").show(0) : (n(t).find(".nav-submenu").hide(0), n(t).find(".submenu-indicator").removeClass("submenu-indicator-up"), u.settings.submenuIndicator ? n(t).find(".submenu-indicator").on(f, function (e) {
					return e.stopPropagation(), e.preventDefault(), u.hideSubmenu(n(this).parent("a").parent("li").siblings("li"), "slide"), u.hideSubmenu(n(this).closest(".nav-menu").siblings(".nav-menu").children("li"), "slide"), "none" == n(this).parent("a").siblings(".nav-submenu").css("display") ? (n(this).addClass("submenu-indicator-up"), n(this).parent("a").parent("li").siblings("li").find(".submenu-indicator").removeClass("submenu-indicator-up"), n(this).closest(".nav-menu").siblings(".nav-menu").find(".submenu-indicator").removeClass("submenu-indicator-up"), u.showSubmenu(n(this).parent("a").parent("li"), "slide"), !1) : (n(this).parent("a").parent("li").find(".submenu-indicator").removeClass("submenu-indicator-up"), void u.hideSubmenu(n(this).parent("a").parent("li"), "slide"))
				}) : k())
			};
		u.callback = function (n) {
			s[n] !== a && s[n].call(t)
		}, u.init()
	}, n.fn.navigation = function (e) {
		return this.each(function () {
			if (a === n(this).data("navigation")) {
				var i = new n.navigation(this, e);
				n(this).data("navigation", i)
			}
		})
	}
}
	(jQuery, window, document), $(document).ready(function () {
		$("#navigation").navigation()
	});

const validateEmail = (email) => {
	return email.match(
		/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
	);
};
// Script Show Calling Number
$('#number').on('click', function () {
	var tel = $(this).data('last');
	$(this).find('span').html('<a href="tel:' + tel + '">' + tel + '</a>');
});

// Metis Menu
$('#side-menu').metisMenu();

// Tooltip
// $('[data-toggle="tooltip"]').tooltip();

// Bottom To Top Scroll Script
$(window).on('scroll', function () {
	var height = $(window).scrollTop();
	if (height > 100) {
		$('#back2Top').fadeIn();
	} else {
		$('#back2Top').fadeOut();
	}
});

// Script For Fix Header on Scroll
$(window).on('scroll', function () {
	var scroll = $(window).scrollTop();

	if (scroll >= 50) {
		$(".header").addClass("header-fixed");
	} else {
		$(".header").removeClass("header-fixed");
	}
});

// Property Slide
$('.reviews-slide').slick({
	slidesToShow: 3,
	arrows: true,
	dots: false,
	infinite: true,
	autoplaySpeed: 2000,
	autoplay: true,
	responsive: [
		{
			breakpoint: 1024,
			settings: {
				arrows: true,
				dots: false,
				slidesToShow: 2
			}
		},
		{
			breakpoint: 600,
			settings: {
				arrows: true,
				dots: false,
				slidesToShow: 1
			}
		}
	]
});

$('.best-course').slick({
	slidesToShow: 4,
	arrows: true,
	dots: false,
	infinite: true,
	autoplaySpeed: 2000,
	autoplay: true,
	pauseOnHover: true,
	responsive: [
		{
			breakpoint: 1024,
			settings: {
				arrows: true,
				dots: false,
				slidesToShow: 2
			}
		},
		{
			breakpoint: 600,
			settings: {
				arrows: true,
				dots: false,
				slidesToShow: 1
			}
		}
	]
});

$('.ebooks-pdf').slick({
	slidesToShow: 6,
	arrows: true,
	dots: false,
	infinite: true,
	autoplaySpeed: 2000,
	autoplay: true,
	responsive: [
		{
			breakpoint: 1024,
			settings: {
				arrows: true,
				dots: false,
				slidesToShow: 2
			}
		},
		{
			breakpoint: 600,
			settings: {
				arrows: true,
				dots: false,
				slidesToShow: 1
			}
		}
	]
});

$('.video-ebooks-pdf').slick({
	slidesToShow: 4,
	arrows: true,
	dots: false,
	infinite: true,
	autoplaySpeed: 2000,
	autoplay: true,
	responsive: [
		{
			breakpoint: 1024,
			settings: {
				arrows: true,
				dots: false,
				slidesToShow: 2
			}
		},
		{
			breakpoint: 600,
			settings: {
				arrows: true,
				dots: false,
				slidesToShow: 1
			}
		}
	]
});

// location Slide
$('.slide_items').slick({
	slidesToShow: 3,
	arrows: true,
	dots: true,
	infinite: true,
	speed: 500,
	cssEase: 'linear',
	autoplaySpeed: 2000,
	autoplay: true,
	responsive: [
		{
			breakpoint: 1024,
			settings: {
				arrows: true,
				dots: true,
				slidesToShow: 2
			}
		},
		{
			breakpoint: 600,
			settings: {
				arrows: true,
				dots: true,
				slidesToShow: 1
			}
		}
	]
});

// location Slide
$('.tutor-slide').slick({
	slidesToShow: 3,
	arrows: true,
	dots: true,
	infinite: true,
	speed: 500,
	cssEase: 'linear',
	autoplaySpeed: 2000,
	autoplay: true,
	responsive: [
		{
			breakpoint: 1024,
			settings: {
				arrows: true,
				dots: true,
				slidesToShow: 2
			}
		},
		{
			breakpoint: 600,
			settings: {
				arrows: true,
				dots: true,
				slidesToShow: 1
			}
		}
	]
});

// Property Slide
$('.testi-slide').slick({
	slidesToShow: 3,
	arrows: false,
	autoplay: true,
	responsive: [
		{
			breakpoint: 1023,
			settings: {
				arrows: false,
				slidesToShow: 2
			}
		},
		{
			breakpoint: 768,
			settings: {
				arrows: false,
				slidesToShow: 2
			}
		},
		{
			breakpoint: 480,
			settings: {
				arrows: false,
				slidesToShow: 1
			}
		}
	]
});

function initSelect2() {
	if ($('.selectTwo').length) {
		$('.selectTwo').select2({
			placeholder: "",
		});
	}
}
initSelect2();

// Parent
$('#prt').select2({
	placeholder: "Parent",
	allowClear: true
});

// Show
$('#show').select2({
	placeholder: "10",
	allowClear: true
});

// Home Slider
$('.home-slider').slick({
	centerMode: false,
	slidesToShow: 1,
	responsive: [
		{
			breakpoint: 768,
			settings: {
				arrows: true,
				slidesToShow: 1
			}
		},
		{
			breakpoint: 480,
			settings: {
				arrows: false,
				slidesToShow: 1
			}
		}
	]
});

// custom file input
$('.custom-file-input').on('change', function () {
	console.log($(this).closest('div').find('.custom-file-label'));
	var fileEvent = $(this);
	var file = fileEvent[0].files[0];
	var fileName = '';
	if (fileEvent[0].files[0]) {
		fileName = file['name'];
		// $(this).closest('.custom-file-label').html(fileName)
	} else {
		fileName = 'Choose File';
		// $(this).closest('.custom-file-label').html(fileName)
	}
	$(this).closest('div').find('.custom-file-label').html(fileName)
	console.log(fileEvent[0].files[0]['name']);
})
var loginModal = document.getElementById('login');
var loginBsModal = new bootstrap.Modal(loginModal)

// variables declaration
var studentEmailValid = false;
var studentMobileValid = false;
var studentPasswordValid = false;
var registrationModal = document.getElementById('login');
var businessEmailCheck = false;
var businessMobileCheck = false;
var corporateMobileValid = false;
var verifyusername = $('#verifyusername_register');
var usernameError = $('#userid_new_error');

// });

// global function & method
function uniqueEmailCheck(event, type) {
	var emailInput = $(event);
	if (validateEmail(emailInput.val())) {
		var formData = new FormData();
		formData.append('form_name', 'unique_email_check');
		formData.append('email', emailInput.val());
		formData.append('type', type);
		console.log(Array.from(formData));
		$.ajax({
			url: '/',
			data: formData,
			processData: false,
			type: 'post',
			contentType: false
		}).done(function (data) {
			console.log(data)
			if (data == 'true') {
				businessEmailCheck = false;
				studentEmailValid = false;
				showAlert('Email Already in use.', 'In Use', 'error');
				$(event).css('border-color', 'crimson')
			} else {
				businessEmailCheck = true;
				studentEmailValid = true;
				$(event).css('border-color', '#198754')
			}
		}).fail(function (data) {
			console.log(data)
		});
	} else {
		businessEmailCheck = false;
		studentEmailValid = false;
		$(event).css('border-color', 'crimson')
	}
}
function mobileNumberCheck(event, type) {
	var mobileInput = $(event);
	var formData = new FormData();
	if (mobileInput.val().toString().length > 9) {
		formData.append('form_name', 'unique_mobile_check');
		formData.append('mobile', mobileInput.val());
		formData.append('type', type);
		console.log(Array.from(formData));
		$.ajax({
			url: '/',
			data: formData,
			processData: false,
			type: 'post',
			contentType: false
		}).done(function (data) {
			console.log(data)
			if (data == 'true') {
				businessMobileCheck = false;
				studentMobileValid = false;
				corporateMobileValid = false;
				if (type == 'corporate') {
					showAlert(
						'Mobile number Already exist. Please contact support from contact page along with your BRANCH code and all the information which you use to query before.',
						'In Use', 'error');
				} else {
					showAlert('Mobile number Already exist.', 'In Use', 'error');
				}
				$(event).css('border-color', 'crimson')
			} else {
				businessMobileCheck = true;
				studentMobileValid = true;
				corporateMobileValid = true;
				$(event).css('border-color', '#198754')
			}
		}).fail(function (data) {
			console.log(data)
		});
	}
}
function sendOtp(type) {
	console.log(type)
	if (type == 'register') {
		if (!studentMobileValid) {
			showAlert('Please input valid mobile number.', 'Mobile Invalid', 'error');
			return;
		}
	}
	if (type == 'corporate') {
		if (!corporateMobileValid) {
			showAlert('Please input valid mobile number.', 'Mobile Invalid', 'error');
			return;
		}
	}
	var verifystatus = $('#verifystatus_' + type);
	var mobile_input = $("#mobile_" + type);
	var mobile_otp_new = $("#mobile_otp_" + type);
	var mobileNumber = parseInt(mobile_input.val());

	verifystatus.val(0);
	console.log(mobileNumber);
	var mobileStr = mobileNumber.toString();
	console.log(mobileStr.length);

	if (!mobileNumber || mobileStr.length > 10 || mobileStr.length < 10) {
		showAlert('10 digit mobile no is required', 'Error', 'warning');
		mobile_input.css('border-color', 'crimson');
	} else {
		// return;
		var formData = new FormData();
		formData.append('form_name', 'mobile_otp');
		formData.append('mobile', mobileNumber);
		$.ajax({
			url: '/',
			data: formData,
			type: 'post',
			processData: false,
			contentType: false
		}).done(function (data) {
			console.log(data);
			// return;
			if (data) {
				var response = JSON.parse(data);
				// alert('Success');
				var lastFour = mobileStr.substr(mobileStr.length - 4);
				var message = "An OTP has been sent to your mobile number +91XXXXXX" + lastFour + " and OTP is valid for 10 minutes"
				if (response['success']) {
					showAlert(message, "OTP Send!", "info").then((willDelete) => {
						if (willDelete) {
							mobile_otp_new.focus();
						} else {
							mobile_otp_new.focus();
						}
					});
					mobile_input.css('border-color', '#2e3092');
					mobile_input.css('background-color', 'none');
					mobile_input.attr('readonly', 'readonly');
				} else {
					showAlert(response.message, "Info!", "info").then((willDelete) => {
						if (willDelete) {
							mobile_otp_new.focus();
						} else {
							mobile_otp_new.focus();
						}
					});
					mobile_input.css('border-color', '#2e3092');
					mobile_input.css('background-color', 'none');
				}
			} else {
				showAlert('Server issue, please try again later.', 'Error', 'error');
				// alert('Server Error');
			}
		}).fail(function (data) {
			showAlert('Server error, please try again later.', 'Error', 'error');
			// alert('Server Error');
			console.log(data);
		})
	}
}
function verifyOtp(type) {
	var mobileInput = $('#mobile_' + type);
	var mobileOtpInput = $('#mobile_otp_' + type);
	var mobileNumber = parseInt(mobileInput.val());
	var mobileOtp = parseInt(mobileOtpInput.val());
	var verifystatus = $('#verifystatus_' + type);
	var mobileStr = mobileNumber.toString();
	console.log(mobileStr.length);

	verifystatus.val(0);
	console.log(mobileNumber);
	if (!mobileNumber || mobileStr.length > 10 || mobileStr.length < 10) {
		showAlert('10 digit mobile no is required for verify the OTP', 'Error', 'warning');
		mobile_input.css('border-color', 'crimson');
	}
	if (!mobileOtp || mobileOtp.length > 10 || mobileOtp.length < 10) {
		showAlert('6 digit OTP is required', 'Error', 'warning');
		mobile_input.css('border-color', 'crimson');
		return;
	}
	var formData = new FormData();
	formData.append('form_name', 'verify_otp');
	formData.append('mobile', mobileNumber);
	formData.append('otp', mobileOtp);
	formData.append('type', 'mobile');
	$.ajax({
		url: '/',
		data: formData,
		type: 'post',
		processData: false,
		contentType: false
	}).done(function (data) {
		console.log(data);
		// return;
		if (data == 'true') {
			showAlert('OTP verified.');
			mobileInput.attr('readonly', 'readonly');
			mobileOtpInput.attr('readonly', 'readonly');
			verifystatus.val(1);
			studentMobileValid = true;
			// alert('Success');
		} else {
			// alert('Server Error');
			showAlert('OTP not verified.', 'Error', 'warning');
			mobileInput.removeAttr('readonly');
			mobileOtpInput.removeAttr('readonly');
			verifystatus.val(0);
			studentMobileValid = false;
		}
	}).fail(function (data) {
		// alert('Server Error');
		showAlert('Server error, please try later.', 'Error', 'warning');
		mobileInput.removeAttr('readonly');
		mobileOtpInput.removeAttr('readonly');
		verifystatus.val(0);
		console.log(data);
	})
}
function showAlert(text, title = 'Success', icon = 'success', button = 'Ok') {
	return swal({
		title,
		text,
		icon,
		button
	});
}


// REGISTRATION ONLY
// var loginModal = 
// bootstrap.Modal.getInstance(registrationModal).hide();
registrationModal.addEventListener('show.bs.modal', function (event) {
	resetRegisterFormInputs();
});
registrationModal.addEventListener('hide.bs.modal', function (event) {
	resetRegisterFormInputs();
});
registrationModal.addEventListener('shown.bs.modal', function (event) {
	resetRegisterFormInputs();
});
registrationModal.addEventListener('hidden.bs.modal', function (event) {
	resetRegisterFormInputs();
});

function resetRegisterFormInputs() {
	$('#registration')[0].reset();

	$('#fname_new').css('border-color', '#e6ebf5');
	$('#fname_new').css('background-color', '#ffffff');

	$('#email_new').css('border-color', '#e6ebf5');
	$('#email_new').css('background-color', '#ffffff');

	$('#mobile_register').removeAttr('readonly');
	$('#mobile_register').css('border-color', '#e6ebf5');
	$('#mobile_register').css('background-color', '#ffffff');

	$('#mobile_otp_register').removeAttr('readonly');
	$('#mobile_otp_register').css('border-color', '#e6ebf5');
	$('#mobile_otp_register').css('background-color', '#ffffff');

	$('#password').css('border-color', '#e6ebf5');
	$('#password').css('background-color', '#ffffff');

	$('#confirm_password_new').css('border-color', '#e6ebf5');
	$('#confirm_password_new').css('background-color', '#ffffff');

	$('#branch_code_new').css('border-color', '#e6ebf5');
	$('#branch_code_new').css('background-color', '#ffffff');
	
	$('#verifystatus_institute').val(0);
	$('#branch_code_new').removeAttr('readonlny');
	$('#institute_name').val('');
	$('#institute_name').hide();
}
$('#userid_new').on('input', function () {
	var user_name_str = $(this).val();
	var string = user_name_str.replace(/[^a-z0-9]/gi, '');
	var lowerCased = string.toLowerCase();
	$(this).val(lowerCased);
	var input = lowerCased.toString();
	var error1 = 'Username should be minimum 8 characters.';
	var error2 = 'Username already taken, please choose another.';
	if (input.length > 7) {
		usernameError.hide();
		console.log(input);

		var formData = new FormData();
		formData.append('form_name', 'student_username_check');
		formData.append('username', input);
		console.log(Array.from(formData));

		$.ajax({
			url: '/',
			data: formData,
			processData: false,
			type: 'post',
			contentType: false
		}).done(function (data) {
			console.log(data)
			if (data == 'true') {
				$('#userid_new').css('border-color', 'crimson')
				usernameError.html(error2);
				usernameError.show();
				verifyusername.val(0);
			} else {
				$('#userid_new').css('border-color', '#198754')
				verifyusername.val(1);
				usernameError.html();
				usernameError.hide();
			}
		}).fail(function (data) {
			console.log(data)
		});
	} else {
		usernameError.html(error1);
		usernameError.show();
	}
});
$('#fname_new').on('input', function () {
	if ($(this).toString().length > 4) {
		$(this).css('border-color', '#198754')
	} else {
		$(this).css('border-color', 'crimson')
	}
})
function inputConfirmPassword(event) {
	validatePassword(event)
	if (checkPasswordmatch()) {
		$('#password').css('border-color', '#198754');
		$(event).css('border-color', '#198754');
		studentPasswordValid = true;
	} else {
		$('#password').css('border-color', 'crimson');
		$(event).css('border-color', 'crimson');
		studentPasswordValid = false;
	}
}
function checkPasswordmatch() {
	if ($('#password').val() == $('#confirm_password_new').val()) {
		studentPasswordValid = true;
		return true;
	}
	studentPasswordValid = false;
	return false;
}
function branchRemove() {
	$('#branch_name').val('');
}
function branchCheck() {
	$('#branchRemove').hide();
}
function validatePassword(event) {
	var passwordStr = $(event).val().toString();
	if (passwordStr.length > 4) {
		$(event).css('border-color', '#198754');
		studentPasswordValid = true;
	} else {
		$(event).css('border-color', 'crimson');
		studentPasswordValid = false;
	}
}
function registerStateSelected(event) {
	console.log(event.value);
	var formData = new FormData();
	formData.append('form_name', 'get_cities');
	formData.append('state_id', event.value);
	$.ajax({
		url: '/',
		data: formData,
		type: 'post',
		processData: false,
		contentType: false
	}).done(function (data) {
		console.log(data);
		// return;
		if (data != 'false') {
			var options = '<option selected value="">Select City</option>';
			var cities = JSON.parse(data);
			if (cities.length) {
				$(cities).each(function (index, city) {
					options += '<option value="' + city.id + '">' + city.name + '</option>';
				});
				$('#city_id_register').html(options);
				$('#city_id_register').attr('required', 'required');
				$('#citiesRegisterDiv').show();
			} else {
				$('#citiesDiv').hide();
				$('#city_id_register').html('');
				$('#city_id_register').removeAttr('required');
			}
		} else {
			$('#citiesRegisterDiv').hide();
			$('#city_id_register').html('');
			$('#city_id_register').removeAttr('required');
		}
	}).fail(function (data) {
		$('#citiesRegisterDiv').hide();
		$('#city_id_register').html('');
		$('#city_id_register').removeAttr('required');
		console.log(data);
	});
}
$('#registration').submit(function (event) {
	event.preventDefault();
	var formData = new FormData($(this)[0]);
	formData.append('form_name', 'registration_form');
	console.log(Array.from(formData));
	// return;
	if ($("#branch_code_new").val() != '' && $("#is_valid_branch").val() == 0) {
		showAlert('Please validate branch name before continue.', 'Error', 'warning');
		return;
	}
	if (!studentPasswordValid || !studentEmailValid || !studentMobileValid) {
		var thisMessage = 'Please check your form again before submitting, there is errors in your form. or contact support.';
		if (!studentPasswordValid) {
			thisMessage = 'Passwords not macthed, or invalid password type.';
		}
		if (!studentEmailValid) {
			thisMessage = 'Unable to verify your email.';
		}
		if (!studentMobileValid) {
			thisMessage = 'Mobile number is invalid, or otp is not verified.';
		}
		showAlert(thisMessage, 'Error', 'warning');
		return;
	}
	$.ajax({
		url: '/',
		data: formData,
		processData: false,
		type: 'post',
		contentType: false
	}).done(function (data) {
		console.log(data);
		console.log(JSON.parse(data));
		// return;
		if (data == 'true') {
			var message = 'You are successfully registered, please login to continue.';
			if ($("#branch_code_new").val() != '' && $("#is_valid_branch").val() == 0) {
				message = 'Registeration succesfully goes to institute, please contact for activation.'
			}
			showAlert(message, "Registered");
		} else {
			showAlert('Server issue, please try again later.', 'Error', 'error');
		}
		bootstrap.Modal.getInstance(registrationModal).hide();
	}).fail(function (data) {
		showAlert('Server error, please try again later.', 'Error', 'error');
		console.log(data)
	});
});

// LOGIN ONLY
$('#userlogin').submit(function (event) {
	event.preventDefault();
	var planclickValue = $("input[name='planclick']").val();
	var formData = new FormData($(this)[0]);
	formData.append('form_name', 'login_form');
	console.log(Array.from(formData));
	$.ajax({
		url: '/',
		data: formData,
		processData: false,
		type: 'post',
		contentType: false
	}).done(function (data) {
		console.log(data);
		
		if (data == 'true') {
		    if(planclickValue != 0)
		    {
		        window.location = planclickValue;
		    }
		    else
		    {
		        window.location = '/student';
		    }
		    
		} else {
			showAlert('Server issue, please try again later.', 'Error', 'error');
		}
	}).fail(function (data) {
		showAlert('Server fail, please try again later.', 'Error', 'error');
		console.log(data)
	});
})
$("#user_logo").change(function () {

	var photo = $("#user_logo").val();
	var ext = $("#user_logo").val().split('.').pop().toLowerCase();
	if ($.inArray(ext, ['jpg', 'jpeg', 'JPG', 'JPEG', 'PNG', 'png']) == -1) {
		swal({
			title: "Oh!Snap",
			text: "Only Accept JPEG/JPG/PNG Files ",
			icon: "error",
			button: "close!",
		});
		$("#user_logo").val("");
		$("#user_logo").focus();

	} else {
		var file, img, height, width;
		var a = (this.files[0].size);
		if ((file = this.files[0])) {
			img = new Image();
			img.onload = function () {
				//alert("width : "+this.width + " and height : " + this.height);
				width = this.width;
				height = this.height;
				console.log(height);
				console.log(width);

			};
			img.src = _URL.createObjectURL(file);
		}
		if (parseInt(width) > 1000 || parseInt(height) > 1000) {

			swal({
				title: "Oh!Snap",
				text: "Image Width & Height Must be 1000px X 1000px",
				icon: "error",
				button: "close!",
			});
			$("#user_logo").val("");
			$("#user_logo").focus();

		} else {

			if ((Math.round(a) / 1024) > 100) {

				swal({
					title: "Oh!Snap",
					text: "Image Size Must be under 100 KB",
					icon: "error",
					button: "close!",
				});
				$("#user_logo").val("");
				$("#user_logo").focus();

			} else {

				//readURL(this);

			}
		}
	}
});