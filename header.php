<?php
// Maybe init API calls here?
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="icon" href="images/JollyLottoLogo.svg" type="image/svg" sizes="16x16">
  	<link rel="stylesheet" type="text/css" href="assets/css/slick-theme.min.css">
  	<link rel="stylesheet" href="assets/css/jquery-ui.css">
  	<link rel="stylesheet" type="text/css" href="assets/css/slick.css">
  	<link rel="stylesheet" type="text/css" href="assets/css/style.css?v=1.0.0">
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/jquery-ui-js.js"></script>
</head>
<body>
<header>
	<div class="jlotto-container header-deskop">
		<div class="header-flex">
			<div class="header-logo">
				<a href="<?php echo "https://" . $_SERVER['SERVER_NAME'] ."/jollylotto" ; ?>"><img src="images/JollyLottoLogo.svg"></a>
			</div>
			<div class="header-right-block">
				<div class="header-top-bar">
					<ul>
						<li>
							<p>Current Time: 4:25 PM <br>Current Session: 00:14:55</p>
						</li>
						<li>
							<a href="" class="top-bar-btn green-buton"><img src="images/Icon_SecMen_AddFunds.svg">Add Funds</a>
						</li>
						<li>
							<a href="" class="top-bar-btn"><img src="images/Icon_SecMen_Wallet.svg">Balance £254.55</a>
						</li>
						<li>
							<a href="" class="top-bar-btn down-carret"><img src="images/Icon_SecMen_Account.svg">Jondoe Smith</a>
						</li>
					</ul>
				</div>
				<div class="header-bottom-bar">
					<div class="header-nav">
						<ul>
							<li><a href="" class="down-carret">Lotteries</a>
							<div class="sub-list-row">
								<div class="sub-list-row-flex">
									<a href="australian.php" class="sub-list-col">
										<div class="sub-list-icon">
											<img src="images/Australian6-45.png">
										</div>
										<div class="sub-list-info">
											<h3>Australian 6/45</h3>
											<p>AU$ 83 Million</p>
										</div>
									</a>
									<a href="euro-millions.php" class="sub-list-col">
										<div class="sub-list-icon">
											<img src="images/EuroMillions.png">
										</div>
										<div class="sub-list-info">
											<h3>Euromillions</h3>
											<p>€ 53 Million</p>
										</div>
									</a>
									<a href="oz-lotto.php" class="sub-list-col">
										<div class="sub-list-icon">
											<img src="images/OZLotto.png">
										</div>
										<div class="sub-list-info">
											<h3>Oz Lotto</h3>
											<p>CA$ 10 Million</p>
										</div>
									</a>
									<a href="irish-lotto.php" class="sub-list-col">
										<div class="sub-list-icon">
											<img src="images/IrishLotto.png">
										</div>
										<div class="sub-list-info">
											<h3>Irish Lotto</h3>
											<p>€2.6 Billion</p>
										</div>
									</a>
									<a href="french-lotto.php" class="sub-list-col">
										<div class="sub-list-icon">
											<img src="images/FrenchLotto.png">
										</div>
										<div class="sub-list-info">
											<h3>French Lotto</h3>
											<p>€ 124 Million</p>
										</div>
									</a>
								</div>
							</div>
							</li>
							<li><a href="" class="down-carret">Promotions</a>
							<div class="sub-list-row">
								<div class="sub-list-row-flex">
									<a href="australian.php" class="sub-list-col">
										<div class="sub-list-icon">
											<img src="images/Australian6-45.png">
										</div>
										<div class="sub-list-info">
											<h3>Lucky 5</h3>
											<p>Australian 6/45</p>
											<p>$145 Million</p>
										</div>
									</a>
									<a href="euro-millions.php" class="sub-list-col">
										<div class="sub-list-icon">
											<img src="images/EuroMillions.png">
										</div>
										<div class="sub-list-info">
											<h3>Lucky 5</h3>
											<p>Euromillions</p>
											<p>€26 Million</p>
										</div>

									</a>
									<a href="oz-lotto.php" class="sub-list-col">
										<div class="sub-list-icon">
											<img src="images/OZLotto.png">
										</div>
										<div class="sub-list-info">
											<h3>10 to Win</h3>
											<p>Oz Lotto</p>
											<p>€83 Million</p>
										</div>
									</a>
									<a href="irish-lotto.php" class="sub-list-col">
										<div class="sub-list-icon">
											<img src="images/IrishLotto.png">
										</div>
										<div class="sub-list-info">
											<h3>Lucky 5</h3>
											<p>Irish Lotto</p>
											<p>€19 Million</p>
										</div>
									</a>
									<a href="french-lotto.php" class="sub-list-col">
										<div class="sub-list-icon">
											<img src="images/FrenchLotto.png">
										</div>
										<div class="sub-list-info">
											<h3>Lucky 5</h3>
											<p>French Lotto</p>
											<p>A$83 Million</p>
										</div>
									</a>
								</div>
								<div class="nav-view-all">
									<a href="results.php">View All</a>
								</div>
							</div>
						</li>
							<li><a href="" class="down-carret">Lottery Results</a>
							<div class="sub-list-row">
								<div class="sub-list-row-flex">
									<a href="results.php" class="sub-list-col">
										<div class="sub-list-icon">
											<img src="images/Australian6-45.png">
										</div>
										<div class="sub-list-info">
											<h3>Australian 6/45</h3>
											<p class="day-mnth">Mon 3. May</p>
											<div class="nav-list-no">
												<span class="un-active">08,</span>
												<span class="un-active">12,</span>
												<span class="un-active">15,</span>
												<span class="un-active">29,</span>
												<span class="un-active">42,</span>
												<span class="active-number">34</span>
											</div>
										</div>
									</a>
									<a href="results.php" class="sub-list-col">
										<div class="sub-list-icon">
											<img src="images/EuroMillions.png">
										</div>
										<div class="sub-list-info">
											<h3>Euromillions</h3>
											<p class="day-mnth">Mon 3. May</p>
											<div class="nav-list-no">
												<span class="un-active">08,</span>
												<span class="un-active">12,</span>
												<span class="un-active">15,</span>
												<span class="un-active">29,</span>
												<span class="un-active">33,</span>
												<span class="active-number">05,</span>
												<span class="active-number">09</span>
											</div>
										</div>
									</a>
									<a href="results.php" class="sub-list-col">
										<div class="sub-list-icon">
											<img src="images/OZLotto.png">
										</div>
										<div class="sub-list-info">
											<h3>Oz Lotto</h3>
											<p class="day-mnth">Wed 5. May</p>
											<div class="nav-list-no">
												<span class="un-active">10,</span>
												<span class="un-active">12,</span>
												<span class="un-active">15,</span>
												<span class="un-active">22,</span>
												<span class="un-active">25,</span>
												<span class="active-number">28,</span>
												<span class="active-number">36</span>
											</div>
										</div>
									</a>
									<a href="results.php" class="sub-list-col">
										<div class="sub-list-icon">
											<img src="images/IrishLotto.png">
										</div>
										<div class="sub-list-info">
											<h3>Irish Lotto</h3>
											<p class="day-mnth">Wed 5. May</p>
											<div class="nav-list-no">
												<span class="un-active">10,</span>
												<span class="un-active">12,</span>
												<span class="un-active">15,</span>
												<span class="un-active">22,</span>
												<span class="un-active">25,</span>
												<span class="un-active">28,</span>
												<span class="un-active">36</span>
											</div>
										</div>
									</a>
									<a href="results.php" class="sub-list-col">
										<div class="sub-list-icon">
											<img src="images/FrenchLotto.png">
										</div>
										<div class="sub-list-info">
											<h3>French Lotto</h3>
											<p class="day-mnth">Tue 4. May</p>
											<div class="nav-list-no">
												<span class="un-active">10,</span>
												<span class="un-active">12,</span>
												<span class="un-active">15,</span>
												<span class="un-active">29,</span>
												<span class="un-active">33,</span>
												<span class="un-active">05</span>
											</div>
										</div>
									</a>
								</div>
								<div class="nav-view-all">
									<a href="results.php">View All</a>
								</div>
							</div>
						</li>
							<li><a href="contact-us.php" class="">Contact Us</a></li>
						</ul>
					</div>
					<div class="social-link">
						<ul>
							<li><a href=""><img src="images/MainMenuIconPhone.svg"></a></li>
							<li><a href=""><img src="images/MainMenuIconMail.svg"></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="mobile-header" style="display: none;">
		<div class="mobile-header-row">
			<div class="mobile-hamber">
				<span></span>
				<span></span>
				<span></span>
			</div>
			<div class="header-logo-mobile">
				<a href=""><img src="images/JollyLottoLogo.svg"></a>
				<div class="user-name" style="display:none;">
					<h2>J.Smith</h2>
					<p>Balance $254.55</p>
				</div>
			</div>
			<div class="current-session">
				<p>Current Session:<br>00:14:55</p>

			<div class="mobile-user">
				<img src="images/mobile-user-icon.svg">
			</div>
			</div>
		</div>
		<div class="mobile-slide-row">
			<div class="mobile-nav">
				<ul>
					<li><a href=""><img src="images/Icon_SecMen_SignInRegister.svg">Sign-in / Register</a></li>
					<li><a href=""><img src="images/Icon_SecMen_AddFund.svg">Add Funds</a></li>
					<li><a href=""><img src="images/Icon_SecMen_Home.svg">Home</a></li>
					<li class="sub-list-mobile"><a href="javascript:void(0)"><img src="images/lottery-nav-icon.png">Lotteries</a>
						<ul class="slide-mobile-ul">
							<li><a href=""><img src="images/Australian6-45.png">Australian 6/45</a></li>
							<li><a href=""><img src="images/EuroMillions.png">Euromillions</a></li>
							<li><a href=""><img src="images/OZLotto.png">Oz Lotto</a></li>
							<li><a href=""><img src="images/IrishLotto.png">Irish Lotto</a></li>
							<li><a href=""><img src="images/FrenchLotto.png">French Lotto</a></li>
						</ul>
					</li>
					<li class="sub-list-mobile"><a href="avascript:void(0)"><img src="images/Icon_SecMen_Results.png">Results</a>
						<ul class="slide-mobile-ul">
							<li><a href=""><img src="images/Australian6-45.png">Australian 6/45</a></li>
							<li><a href=""><img src="images/EuroMillions.png">Euromillions</a></li>
							<li><a href=""><img src="images/OZLotto.png">Oz Lotto</a></li>
							<li><a href=""><img src="images/IrishLotto.png">Irish Lotto</a></li>
							<li><a href=""><img src="images/FrenchLotto.png">French Lotto</a></li>
						</ul>
					</li>
					<li class="sub-list-mobile"><a href="avascript:void(0)"><img src="images/Icon_SecMen_Promotions.png">Promotions</a>
					<ul class="slide-mobile-ul">
							<li><a href=""><img src="images/Australian6-45.png">Lucky 5</a></li>
							<li><a href=""><img src="images/FrenchLotto.png">Lucky 5</a></li>
							<li><a href=""><img src="images/EuroMillions.png">10 to Win</a></li>
							<li><a href=""><img src="images/EuroMillions.png">Lucky 5</a></li>
							<li><a href=""><img src="images/EuroMillions.png">Lucky 5</a></li>
						</ul></li>
					<li><a href=""><img src="images/Icon_SecMen_Contact@2xxx.png">Contact Us</a></li>
					<li><a href=""><img src="images/Icon_SecMen_SignInRegister.svg">Account</a></li>
					<li><a href=""><img src="images/Icon_SecMen_Logout.png">Logout</a></li>
				</ul>
			</div>
		</div>
	</div>
</header>