/**
 *
 * @param {object} elm
 */
function singleQuickPick(elm) {
	const numbersBoard = elm.closest('[data-count]')
	const isSelectionComplete = numbersBoard.getAttribute(
		'data-selection-complete'
	)

	// Bail if board is already completed.
	if (isSelectionComplete) return false

	const lotToPick = parseInt(lottery.numOfBalls)
	const lotMax = parseInt(lottery.maxBallNumber)
	const bonusToPick = parseInt(lottery.totalBonusBalls)
	const bonusMax = parseInt(lottery.maxBonusBalls)

	// quick pick both lottery and bonus numbers.
	const lotteryNumbers = numbersBoard.querySelector('[data-lottery-numbers]')
	const bonusNumbers = numbersBoard.querySelector('[data-bonus-numbers]')

	// clear selected numbers first.
	singleResetPick(elm)
	selectRandomSlot(lotteryNumbers, lotToPick, lotMax)
	selectRandomSlot(bonusNumbers, bonusToPick, bonusMax)

	// Mark current board as completed.
	numbersBoard.setAttribute('data-selection-complete', 'true')
}

/**
 *
 * @param {object} elm
 */
function singleResetPick(elm) {
	const numbersBoard = elm.closest('[data-count]')
	numbersBoard.removeAttribute('data-selection-complete')

	// Add back error class.
	numbersBoard.classList.add('error-ticket')

	const selectedNumbers = numbersBoard.querySelectorAll(
		'.select-ticket-box span'
	)
	selectedNumbers.forEach((number) =>
		number.classList.remove('selected-ticket')
	)
}

/**
 *
 */
function multiResetPick() {
	const allBoards = document.querySelectorAll('.clear-btn')

	allBoards.forEach((board) => {
		singleResetPick(board)
	})
}

/**
 *
 * @param {object} elm
 * @param {number} toSelect
 * @param {number} maxRange
 */
function selectRandomSlot(elm, toSelect, maxRange) {
	const numbersBoard = elm.closest('[data-count]')
	const rng = generateRandomNum(toSelect, maxRange)

	numbersBoard.classList.remove('error-ticket')

	rng.forEach((x) => {
		elm.querySelector('.select-ticket-box:nth-of-type(' + x + ')')
			.querySelector('span')
			.classList.add('selected-ticket')
	})
}

/**
 *
 */
function multiQuickPick() {
	const allBoards = document.querySelectorAll('.quick-pick')

	allBoards.forEach((board) => {
		singleQuickPick(board)
	})
}

/**
 *
 * @param {number} quantity
 * @param {number} max
 * @returns Set
 */
function generateRandomNum(quantity, max) {
	const set = new Set()
	while (set.size < quantity) {
		set.add(Math.floor(Math.random() * max) + 1)
	}
	return set
}

$(function () {
	$('body').on(
		'click',
		'.select-ticket-box-row .select-ticket-box span',
		function () {
			var idx = $(this).parents('.lottery-table-col').data('count')
			var _counts = $(this)
				.parents('.select-ticket-box-row')
				.find('span.selected-ticket').length
			var _felm = $('input[name="ballCount_' + idx)
			var _fval = $(_felm).val()
			var mx = parseInt(lottery.numOfBalls)
			if (!$(this).hasClass('selected-ticket')) {
				if (_counts < mx) {
					$(this).addClass('selected-ticket')
					_counts = parseInt(_fval) + 1
				}
			} else {
				$(this).removeClass('selected-ticket')
				_counts = parseInt(_fval) - 1
			}
			$(_felm).val(_counts)
			if (_counts < mx) {
				$(this).parents('.lottery-table-col').addClass('error-ticket')
			} else {
				$(this)
					.parents('.lottery-table-col')
					.removeClass('error-ticket')
			}
		}
	)

	$('body').on('click', '.trash-icon', function () {
		var count_tickets = $('body').find('[data-count]').length
		if (count_tickets > 1) {
			$(this).parents('.lottery-table-col').remove()
			$('[data-lines]').text(parseInt($('[data-lines]').text()) - 1)
			totalPriceCalucate()
		}
	})

	/*Countdown Timer*/
	var count = getCounterData($('#cutOff'))
	var timer = setInterval(function () {
		count--
		if (count == 0) {
			clearInterval(timer)
			return
		}
		setCounterData(count, $('#cutOff'))
	}, 1000)

	//WEEK DURATION
	const minus = $('.quantity__minus')
	const plus = $('.quantity__plus')
	const input = $('.quantity__input')
	minus.click(function (e) {
		e.preventDefault()
		var value = input.val()
		if (value > 1) {
			value--
		}
		input.val(value)
		$('[data-draws]').text(value)
		totalPriceCalucate()
	})

	plus.click(function (e) {
		e.preventDefault()
		var value = input.val()
		value++
		input.val(value)
		$('[data-draws]').text(value)
		totalPriceCalucate()
	})

	$(document).on('click', '[data-lottery-draw-days]', function () {
		var countCheck = $('[data-lottery-draw-days]:checked').length
		if (countCheck < 1) {
			$(this).prop('checked', true)
		}
		totalPriceCalucate()
	})

	totalPriceCalucate()

	//RESULT DISPLAY
	$(document).on('change', '[data-select-result-month]', function () {
		var month = $(this).val()
		jQuery('[data-result-month]').hide()
		jQuery('[data-result-month="' + month + '"]').show()
		$('html, body').animate(
			{
				scrollTop: $('#lottery-result-month').offset().top - 50,
			},
			500
		)
	})

	//OTHER PAGES
	$('#home-banner-slider').slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		dots: true,
	})
	$('#play-lotery-row').slick({
		infinite: true,
		slidesToShow: 5,
		slidesToScroll: 1,
		arrows: true,
		dots: false,
		nextArrow:
			'<button class="btn-next btn-style-class"><img src="images/arrow-right.svg"></button>',
		prevArrow:
			'<button class="btn-previous btn-style-class"><img src="images/arrow-left.svg"></button>',

		responsive: [
			{
				breakpoint: 1100,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 1,
				},
			},
			{
				breakpoint: 767,
				settings: 'unslick',
			},
		],
	})

	$('.mobile-hamber').click(function () {
		$('.mobile-slide-row').toggleClass('slide-from-left')
		$(this).toggleClass('change-cross')
		$('.header-logo-mobile').toggleClass('hide-header-logo')
	})

	$('.set > a').on('click', function (e) {
		e.preventDefault()
		$(this).next('.content').slideToggle('400')
		$(this).toggleClass('up-carret')
		$(this).toggleClass('active')
	})

	$('.nav-tabs > li > a').click(function (event) {
		event.preventDefault()
		var active_tab_selector = $('.nav-tabs > li.active > a').attr('href')
		var actived_nav = $('.nav-tabs > li.active')
		actived_nav.removeClass('active')
		$(this).parents('li').addClass('active')
		$(active_tab_selector).removeClass('active')
		$(active_tab_selector).addClass('hide')
		var target_tab_selector = $(this).attr('href')
		$(target_tab_selector).removeClass('hide')
		$(target_tab_selector).addClass('active')
	})
	$('.result-accordian-body').click(function (e) {
		$(this).next('.result-accordian-slide-bottom').slideToggle('slow')
		$(this).toggleClass('up-carret')
	})
	$('li.sub-list-mobile > a').click(function (e) {
		$(this).next('.mobile-nav ul li.sub-list-mobile ul').slideToggle('slow')
		$(this).toggleClass('avtive-nav')
	})

	$(function () {
		$('#datepicker').datepicker()
	})

	$('.acc-sale-body-data, .acc-item-slide-sale-info').click(function (e) {
		$(this).toggleClass('errow-un-active')
		$(this)
			.next('.acc-sale-slide-data, .acc-item-slide-drow-date')
			.slideToggle('slow')
	})
	$('.acc-sale-body-data').click(function (e) {
		$(this).parent().toggleClass('active-slide-grey')
	})
	$('.acc-item-slide-sale-info').click(function (e) {
		$(this).parent().toggleClass('active-slide-light-green')
	})

	$('button#popup-1, div#PoPup-open-1 .close-popup').click(function () {
		$('div#PoPup-open-1').slideToggle()
	})
	$('button#popup-2, div#PoPup-open-2 .close-popup').click(function () {
		$('div#PoPup-open-2').slideToggle()
	})
	$('button#popup-3, div#PoPup-open-3 .close-popup').click(function () {
		$('div#PoPup-open-3').slideToggle()
	})
	$('button#popup-4, div#PoPup-open-4 .close-popup').click(function () {
		$('div#PoPup-open-4').slideToggle()
	})
	$('button#popup-5, div#PoPup-open-5 .close-popup').click(function () {
		$('div#PoPup-open-5').slideToggle()
	})
})

function getCounterData(obj) {
	var days = parseInt($('.draw-days', obj).text())
	var hours = parseInt($('.draw-hours', obj).text())
	var minutes = parseInt($('.draw-minutes', obj).text())
	var seconds = parseInt($('.draw-seconds', obj).text())
	return seconds + minutes * 60 + hours * 3600 + days * 3600 * 24
}

function setCounterData(s, obj) {
	var days = Math.floor(s / (3600 * 24))
	var hours = Math.floor((s % (60 * 60 * 24)) / 3600)
	var minutes = Math.floor((s % (60 * 60)) / 60)
	var seconds = Math.floor(s % 60)

	$('.draw-days', obj).html(days)
	$('.draw-hours', obj).html(hours)
	$('.draw-minutes', obj).html(minutes)
	$('.draw-seconds', obj).html(seconds)
}

function totalPriceCalucate() {
	if (typeof lottery != 'undefined') {
		var drawPrice = $('[data-draw-price]').attr('data-draw-price')
		var duration = $('[data-week-duration]').val()
		var countLines = $('.pro-lottery-table').children('[data-count]').length
		var drawDays = $('[data-lottery-draw-days]:checked').length

		var total =
			parseFloat(duration) *
			parseFloat(drawDays) *
			parseFloat(countLines) *
			parseFloat(drawPrice)
		$('[data-lotto-total]').text(total.toFixed(2))
		$('[data-lotto-total]').html(total.toFixed(2))
	}
}

function addLine($count) {
	for (let i = 0; i < $count; i++) {
		const toClone = $('.lottery-table-col[data-count]').last()
		const nextv = $(toClone).data('count')
		const g = parseInt(nextv) + 1
		const h = $(toClone).clone()
		$(h).attr('data-count', g)
		$(h)
			.find('input')
			.attr('name', 'ballCount_' + g)
		$(h).find('input').val(0)

		singleResetPick($(h).find('.quick-pick').get(0))
		//$(h).find('span').removeClass('selected-ticket')
		//$(h).find('.trash-icon').removeClass('btn-inactive')
		$(h).insertBefore($('.lottery-table-col[data-last-iv]'))
		//$(h).find('.quick-pick').trigger('click')
		$('[data-lines]').text(parseInt($('[data-lines]').text()) + 1)
		multiQuickPick()
		totalPriceCalucate()
	}
}
