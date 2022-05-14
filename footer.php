<footer>
	<div class="auto-container">
			<div class="footer-row">
				<div class="footer-col">
					<h2>Learn About Lotto Express</h2>
					<ul>
						<li><a href="">About Lotto Express</a></li>
					</ul>
				</div>
				<div class="footer-col">
					<h2>Play Lotteries Online</h2>
					<ul>
						<li><a href="">French Lotto</a></li>
						<li><a href="">Oz Lotto</a></li>
						<li><a href="">Irish Lotto</a></li>
						<li><a href="">EuroMillions</a></li>
					</ul>
				</div>
				<div class="footer-col">
					<h2>Lottery Results & Winnings</h2>
					<ul>
						<li><a href="">French Lotto</a></li>
						<li><a href="">Oz Lotto</a></li>
						<li><a href="">Irish Lotto</a></li>
						<li><a href="">EuroMillions</a></li>
					</ul>
				</div>
				<div class="footer-col">
					<h2>Useful Links</h2>
					<ul>
						<li><a href="">Responsible</a></li>
						<li><a href="">Gaming Contact Us</a></li>
					</ul>
				</div>
				<div class="footer-col">
					<h2>Need Help</h2>
					<ul class="need-ul">
						<li><a href=""><img src="images/ContactEmail.svg">Email</a></li>
						<li><a href=""><img src="images/ContactCall.svg">Call</a></li>
					</ul>
				</div>
				<div class="footer-col">
					<h2>Find Us On!</h2>
					<ul class="footer-social-icon">
						<li><a href=""><img src="images/CwU_Footer_FB.svg"></a></li>
						<li><a href=""><img src="images/CwU_Footer_Twitter.svg"></a></li>
					</ul>
				</div>
			</div>
			<div class="footer-bottom-row">
				<div class="footer-nav-link">
					<ul>
						<li><a href="">Responsible Gaming</a></li>
						<li><a href="terms-and-conditions.php">Terms and Conditions</a></li>
						<li><a href="privacy-policy.php">Privacy Policy</a></li>
						<li><a href="contact-us.php">Contact Us</a></li>
					</ul>
				</div>
				<div class="footer-bottom-logo-row">
					<div class="footer-bottom-logo-col">
						<img src="images/ST_Footer_GCRC.png">
					</div>
					<div class="footer-bottom-logo-col">
						<img src="images/lock-icon.png">
					</div>
					<div class="footer-bottom-logo-col">
						<img src="images/ST_Footer_18.png">
					</div>

					<div class="footer-bottom-logo-col">
						<img src="images/ST_Footer_GA.svg">
					</div>
					<div class="footer-bottom-logo-col">
						<img src="images/ST_Footer_GC.svg">
					</div>
				</div>

			</div>
	</div>
</footer>

<script src="assets/js/slick.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#home-banner-slider').slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		dots: true
	});
	jQuery('#play-lotery-row').slick({
		infinite: true,
		slidesToShow: 5,
		slidesToScroll: 1,
		arrows: true,
		dots: false,
		nextArrow: '<button class="btn-next btn-style-class"><img src="images/arrow-right.svg"></button>',
		prevArrow: '<button class="btn-previous btn-style-class"><img src="images/arrow-left.svg"></button>',

   		responsive: [
			       	{
						breakpoint: 1100,
						settings: {
						slidesToShow: 4,
						slidesToScroll: 1
			      	}
				    },
			        {
			           breakpoint: 767,
			           settings: "unslick"
			        }
		]
	});

	jQuery(".mobile-hamber").click(function(){
		jQuery(".mobile-slide-row").toggleClass("slide-from-left");
		jQuery(this).toggleClass("change-cross");
		jQuery(".header-logo-mobile").toggleClass("hide-header-logo");
	});

	//jQuery(".select-ticket-box-row .select-ticket-box span").click(function(){
	//	jQuery(this).toggleClass("selected-tokan");
	//});


	const minus = jQuery('.quantity__minus');
	const plus = jQuery('.quantity__plus');
	const input = jQuery('.quantity__input');
	minus.click(function(e) {
		e.preventDefault();
		var value = input.val();
		if (value > 1) {
			value--;
		}
		input.val(value);

		('[data-draws]').text(value)
	});

	plus.click(function(e) {
		e.preventDefault();
		var value = input.val();
		value++;
		input.val(value);

		$('[data-draws]').text(value)
	})


	jQuery(".set > a").on("click", function(e) {
		e.preventDefault()
		 jQuery(this).next('.content').slideToggle('400');
		 jQuery(this).toggleClass("up-carret");
		 jQuery(this).toggleClass("active");
		// if (jQuery(this).hasClass("active")) {
		// 	jQuery(this).removeClass("active");
		// 	jQuery(this)
		// 	.siblings(".content")
		// 	.slideUp(200);
		// 	jQuery(".set > a i")
		// 	.removeClass("up-carret")
		// 	.addClass("down-carret");
		// }
		// else {
		// 	jQuery(".set > a i").removeClass("up-carret").addClass("down-carret");
		// 	jQuery(this).find("i").removeClass("down-carret").addClass("up-carret");
		// 	jQuery(".set > a").removeClass("active");
		// 	jQuery(this).addClass("active");
		// 	jQuery(".content").slideUp(200);
		// 	jQuery(this).siblings(".content").slideDown(200);
		// }
	});


	jQuery('.nav-tabs > li > a').click(function(event) {
		event.preventDefault();
		var active_tab_selector = jQuery('.nav-tabs > li.active > a').attr('href');
		var actived_nav = jQuery('.nav-tabs > li.active');
		actived_nav.removeClass('active');
		jQuery(this).parents('li').addClass('active');
		jQuery(active_tab_selector).removeClass('active');
		jQuery(active_tab_selector).addClass('hide');
		var target_tab_selector = $(this).attr('href');
		jQuery(target_tab_selector).removeClass('hide');
		jQuery(target_tab_selector).addClass('active');
	});
	jQuery('.result-accordian-body').click(function(e) {
	    jQuery(this).next('.result-accordian-slide-bottom').slideToggle('slow');
	    jQuery(this).toggleClass('up-carret');
	});
	jQuery('li.sub-list-mobile > a').click(function(e) {
      jQuery(this).next('.mobile-nav ul li.sub-list-mobile ul').slideToggle('slow');
        jQuery(this).toggleClass('avtive-nav');
    });
	// calender
				  jQuery( function() {
				    jQuery( "#datepicker" ).datepicker();
				  } );

					jQuery('.acc-sale-body-data, .acc-item-slide-sale-info').click(function(e) {
						 jQuery(this).toggleClass("errow-un-active");
					    jQuery(this).next('.acc-sale-slide-data, .acc-item-slide-drow-date').slideToggle('slow');
					});
					jQuery('.acc-sale-body-data').click(function(e) {
						 jQuery(this).parent().toggleClass("active-slide-grey");
					});
					jQuery('.acc-item-slide-sale-info').click(function(e) {
						 jQuery(this).parent().toggleClass("active-slide-light-green");
					});

					jQuery("button#popup-1, div#PoPup-open-1 .close-popup").click(function(){
					  jQuery("div#PoPup-open-1").slideToggle();
					});
					jQuery("button#popup-2, div#PoPup-open-2 .close-popup").click(function(){
					  jQuery("div#PoPup-open-2").slideToggle();
					});
					jQuery("button#popup-3, div#PoPup-open-3 .close-popup").click(function(){
					  jQuery("div#PoPup-open-3").slideToggle();
					});
					jQuery("button#popup-4, div#PoPup-open-4 .close-popup").click(function(){
					  jQuery("div#PoPup-open-4").slideToggle();
					});
					jQuery("button#popup-5, div#PoPup-open-5 .close-popup").click(function(){
					  jQuery("div#PoPup-open-5").slideToggle();
					});
});
</script>
</body>
</html>