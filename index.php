<?php
include_once 'header.php';
require_once 'api/ProductSingle.php';

$api = new ProductSingle;
$products = $api->getListing();

?>
<section class="baner-section">
	<div class="jlotto-container">
		<div class="banner-slider-row" id="home-banner-slider">
			<div class="banner-slider">
				<div class="banner-man">
					<img src="images/banner-man-1.png">
				</div>
				<div class="banner-slider-disc">
					<h1>Header Lorem Ipsum</h1>
					<p>Support Lorem Ipsum</p>
					<h2>$100 MILLION</h2>
					<a href="" class="orange-btn">Play Now</a>
				</div>
			</div>
			<div class="banner-slider">
				<div class="banner-man">
					<img src="images/banner-man-1.png">
				</div>
				<div class="banner-slider-disc">
					<h1>Header Lorem Ipsum</h1>
					<p>Support Lorem Ipsum</p>
					<h2>$100 MILLION</h2>
					<a href="" class="orange-btn">Play Now</a>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="play-lottery-section">
	<div class="jlotto-container">
		<div class="play-lottery-title">
			<h2>PLAY THE WORLDS BIGGEST LOTTERIES ONLINE AT JOLLYLOTTO.COM</h2>
		</div>
			<div class="play-lotery-row" id="play-lotery-row">
				<?php foreach( $products as $product ) : ?>
					<div class="lottery-slide-col">
						<div class="lottery-slide-iner bg-yellow">
							<img src="images/left-curve.png" class="left-curve-image">
							<img src="images/right-curve.png" class="right-curve-image">
							<div class="lottery-slide-box">
								<div class="lottery-icon">
									<img src="images/Australian6-45.png">
								</div>
								<div class="lotter-price">
									<span class="lotery-tick-name"><?php echo $product['lotteryName']; ?></span>
									<sub><?php echo $product['name']; ?></sub><b><?php echo $product['price']; ?>M</b>
								</div>
								<div class="play-now-btn">
									<a href="lotteries.php?id=<?php echo $product['id']; ?>">Play Now</a>
								</div>
								<div class="lottery-day">
									<p>1 DAY 22:58:21</p>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
		</div>
	</div>
</section>
<section class="we-do-work">
	<div class="jlotto-container">
		<div class="we-do-work-row">
			<div class="we-do-work-col">
				<div class="we-do-disc">
					<h2>CHOICE</h2>
					<p>Choose which lotteries you want to play. You can play your favourite numbers, or “Quick Pick” for a random selection.</p>
					<div class="we-do-icon">
						<img src="images/choice-icon.svg">
					</div>
				</div>
			</div>
			<div class="we-do-work-col">
				<div class="we-do-disc">
					<h2>CONFIRMATION</h2>
					<p>As soon as your order id processed we'll send you a confirmation of your lottery numbers and dates of play.</p>
					<div class="we-do-icon">
						<img src="images/choice-icon2.svg">
					</div>
				</div>
			</div>
			<div class="we-do-work-col">
				<div class="we-do-disc">
					<h2>WINNINGS</h2>
					<p>When you win a lotto prize, we'll immediately notify you and deposit your winning in to your Lotto Express account.</p>
					<div class="we-do-icon">
						<img src="images/choice-icon3.svg">
					</div>
				</div>
			</div>
		</div>
		<div class="we-do-bottom-line">
			<h3>WE DO THE WORK SO YOU CAN HAVE THE FUN!</h3>
		</div>
	</div>
</section>
<section class="exciting-section">
	<div class="jlotto-container">
		<div class="we-do-work-row">
			<div class="we-do-work-col">
				<div class="excitimg-disc">
					<h2>EXCITING</h2>
					<ul>
						<li>The world’s most exciting lotteries.</li>
						<li>Play for the biggest jackpots on Earth!</li>
					</ul>
				</div>
			</div>
			<div class="we-do-work-col">
				<div class="excitimg-disc">
					<h2>SECURE</h2>
					<ul>
						<li>Highest security standards in the industry.</li>
						<li>Exceeding regulated security requirements.</li>
						<li>Frequent system upgrades to keep your data safe.</li>
					</ul>
				</div>
			</div>
			<div class="we-do-work-col">
				<div class="excitimg-disc">
					<h2>HONEST</h2>
					<ul>
						<li>Service charges are included in the price.</li>
						<li>No additional fees to collect your winnings or for any other reason.</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
<?php include 'footer.php' ?>