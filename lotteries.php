<?php include 'header.php';
require_once 'api/ProductSingleDetails.php';
require_once 'api/SingleResult.php';

$api = new ProductSingleDetails;
$result = new SingleResult;

$id = $_GET['id'];
//PRODUCT DETAIL
$details = $api->fetchDetails( $id );
$drawPrice = $api->getProductPrice();
$description = $details->product->description;
$currencySymbol = $api->getCurrencySymbol( $details->lottery->currencyCode );

//LOTTERY DETAIL
$lottery = $details->lottery;
$lotteryName = $lottery->name;
$noOfBalls   = $lottery->numOfBalls;
$maxBallNo   = $lottery->maxBallNumber;
$minBallNo   = $lottery->minBallNumber;
$drawDays    = $lottery->drawDays;
$hours = $lottery->cutOffs[0]->hours;

$bonusBallName = $lottery->bonusBalls[0]->name;
$totalBonusBalls = $lottery->bonusBalls[0]->ballNumber;
$minBonusBalls = $lottery->bonusBalls[0]->minNumber;
$maxBonusBalls = $lottery->bonusBalls[0]->maxNumber;


//LOTTERY RESULTS
$startDate = strtok( $details->product->startDate, 'T');
$lotteryId = $details->product->lotteryId;
//$lotteryResults = $result->fetchDetails( $lotteryId, $startDate );

//$sortedResult = [];
//foreach ( $lotteryResults['lotteryResultsList'] as $k => $v ) {
//	$drawDate = $v['drawDate'];
//	$date = date_create($drawDate);
//	$date = date_format($date,"M Y");
//	$sortedResult[$date][] = $v;
//}

?>
<section class="jlotto-product-page oz-product-bg">
	<div class="jlotto-container">
		<div class="jlotto-product-row">
			<div class="jlotto-product-icon col-32">
				<img src="images/OZLotto.png">
			</div>
			<div class="single-product-price col-32">
				<h2>Next <?php echo $description; ?> Lotto</h2>
				<h1><sub><?php echo $currencySymbol; ?></sub><?php echo $details->product->price; ?> Million</h1>
			</div>
			<?php if( $hours >= 1 ){ ?>
				<div class="lottery-draw-time col-32">
					<p>Draw Cutoff Timer</p>
					<h5 id="cutOff">
						<span class='draw-days'>0</span> Day(s)
						<span class='draw-hours'><?php echo $hours; ?></span>:
						<span class='draw-minutes'>0</span>:
						<span class='draw-seconds'>1</span>
					</h5>
				</div>
			<?php } ?>
		</div>
	</div>
</section>
<section class="product-tab-section">
	<div class="jlotto-container">
		<div class="product-tab">
			<ul class="product-tab-list nav-tabs oz-product-bg">
				<li class="active-list active"><a href="#tab1">Single Play</a></li>
				<!-- <li><a href="#tab2">Syndicate Play</a></li>
				<li><a href="#tab3">Bundle Play</a></li> -->
				<li><a href="#tab4">Results</a></li>
			</ul>
			<div class="pro-tab-detail tab-content active" id="tab1">
				<div class="pro-tab-info-iner">
					<div class="pro-tab-headings">
						<h3>Play <?php echo $description; ?></h3>
						<p><?php echo $description; ?></p>
					</div>
					<div class="lottery-option-row">
						<p>Quickpick, Edit or Delete lines</p>
						<div class="lottery-opt-btn">
							<button data-btn-quick-pick-all onclick="multiQuickPick()">Quick Pick All</button>
							<button data-btn-clear-all onclick="multiResetPick()">Clear All</button>
						</div>
					</div>
					<div class="pro-lottery-table">
						<div class="lottery-table-col lottery-ticket" data-count="1">
							<input type="hidden" name="ballCount_1" value="0">
							<div class="lottery-table-col-iner">
								<div class="lotter-table-head">
									<div class="table-check-icon">
										<img src="images/tick-mark.png">
									</div>
									<div class="quick-action-row"  style="display: block">
										<div class="acton-btns">
											<button class="quick-pick" onclick="singleQuickPick(this)">Quick Pick</button>
											<button class="clear-btn" onclick="singleResetPick(this)">Clear</button>
											<button class="trash-icon"><img src="images/IconTrash.svg"></button>
										</div>
									</div>
									<div class="select-no-heading">
										<p>Select <?php echo $noOfBalls; ?> Numbers</p>
									</div>
									<div class="select-ticket-box-row" data-lottery-numbers>
										<?php for ($i = $minBallNo; $i <= $maxBallNo; $i++) : ?>
											<div class="select-ticket-box">
												<span><?php echo $i; ?></span>
											</div>
										<?php endfor; ?>
									</div>
									<div class="select-no-heading">
										<p>Select <?php echo $totalBonusBalls . ' ' .  $bonusBallName; ?></p>
									</div>
									<div class="select-ticket-box-row" data-bonus-numbers>
										<?php for ($i = $minBonusBalls; $i <= $maxBonusBalls; $i++) : ?>
											<div class="select-ticket-box">
												<span class="yellow-ticket"><?php echo $i; ?></span>
											</div>
										<?php endfor; ?>
									</div>
								</div>
							</div>
						</div>

						<div class="lottery-table-col" data-last-iv>
							<div class="lottery-table-col-iner">
								<div class="add-line-icon-row">
									<div class="add-line-icon-col" onclick="addLine(1)">
										<img src="images/add-plus-icon.svg">
										<h5>Add Line</h5>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="lottery-ticket-detail-section">
					<input type="hidden" data-draw-price="<?php echo $drawPrice; ?>">
					<div class="ticket-discription-col">
						<div class="lottery-duration-row">
							<h4>Duration</h4>
							  <div class="duration-quantity">
							    <a href="#" class="quantity__minus"><span>-</span></a>
							    <div class="input-counter">
							    <input name="quantity" type="text" class="quantity__input" value="1" data-week-duration>
							    Week
							    </div>
							    <a href="#" class="quantity__plus"><span>+</span></a>
							  </div>
						</div>
						<div class="select-you-lottery-draw">
							<h4>Select your Draw Days</h4>
							<ul>
								<?php for ($i = 0; $i < count($drawDays); $i++) :
									$totalDays = count($drawDays) - 1;
									$checked = '';
									if( $i == $totalDays )
										$checked = 'checked';
									$day = $drawDays[$i];
									$earlier = new DateTime("$day->drawDay");
									$later = new DateTime("now");
									$abs_diff = $later->diff($earlier)->format("%a");
									$dateHuman = $earlier->format("M d");
								?>
								 <li>
								    <input class="styled-checkbox" id="day-slot-<?php echo $i; ?>" name="drawDays[]" type="checkbox" value="<?php echo $day->drawDay; ?>" <?php echo $checked; ?> data-lottery-draw-days>
								    <label for="day-slot-<?php echo $i; ?>">
								    	<span><?php echo $day->drawDay; ?></span>
								    	<span><?php echo $dateHuman; ?></span>
								    	<span class="time-slot">
								    		<img src="images/clock.svg"><?php echo $abs_diff; ?> days
								    	</span>
								    </label>
								  </li>
								<?php endfor; ?>
							</ul>
						</div>
					</div>
					<div class="lotto-play-section">
						<h4><?php echo $details->lottery->name; ?></h4>
						<div class="table-play-block">
							<span><span data-lines>1</span> lines x <span data-draws>1</span> draw</span>
							<span><?php echo $currencySymbol; ?><span data-lotto-total><?php echo $drawPrice;?></span></span>
						</div>
						<div class="table-play-block play-totel">
							<span><b>Total:</b></span>
							<span><b><?php echo $currencySymbol; ?><span data-lotto-total><?php echo $drawPrice;?></span></b></span>
						</div>
						<div class="table-play-block">
							<button class="jlotto-play-lottery">Play Now</button>
						</div>
					</div>
				</div>
			</div>
			<div class="pro-tab-detail tab-content hide" id="tab2"></div>
			<div class="pro-tab-detail tab-content hide" id="tab3"></div>
			<div class="pro-tab-detail tab-content hide" id="tab4">
				<div class="pro-tab-info-iner result-flex-row">
					<div class="result-flex-col-70">
						<div class="pro-tab-headings">
							<h3>French Lotto Results</h3>
							<p>Small paragraph to help with SEO and Marketing details. <br>Lorem ipsum dolor sir amet...</p>
						</div>
						<?php  if ( !empty( $sortedResult ) ) {
							$monthYear = $resultList = '';
							$i = 1;
							foreach ( $sortedResult as $month => $lottoResult ) {
								$display = '';
								if ( $i != 1 )
									$display  = 'style="display:none;"';

								$monthYear .= '<option value="'.$month.'" '.$selected.'>'.$month.'</option>';
								$resultList .= '<div class="result-warp-by-month" data-result-month="'.$month.'" '.$display.'>';
								foreach ( $lottoResult as $lottoData ) {
									$resultList .= '<div class="result-accordian-slider">';
									$lottoDrawDate = date_create($lottoData['drawDate']);
									$lottoDrawDate = date_format($lottoDrawDate,"d M");
									$resultList .= '<div class="result-accordian-body">
											<div class="table-date">
												<p>'.$lottoDrawDate.'</p>
											</div>
											<div class="table-prize">
												<p>'.$currencySymbol.$lottoData['jackpot'].'</p>
											</div>
											<div class="table-number">
												<div class="table-number-row">';
												$board = explode( ',', $lottoData['board'] );
												foreach ($board as $num) {
													$resultList .= '<span class="bg-grey">'.$num.'</span>';
												}
									$resultList .= '</div>
											</div>
										</div>
										<div class="result-accordian-slide-bottom" style="display:none">
											<div class="result-accordian-slide-info">
												<div class="slide-info-head">
													<div class="prize-tier">
														<p><b>Prize Tiers</b></p>
													</div>
													<div class="winner-prize">
														<p><b>Winners</b></p>
													</div>
													<div class="prize-value">
														<p><b>Prize Value</b></p>
													</div>
													<div class="prize-payout">
														<p><b>Prize Payout</b></p>
													</div>
												</div>';
												$breakdowns = $lottoData['breakdowns'];
												$totalPrizes = 0;
												foreach ($breakdowns as $bdval) {
													$totalPrizes += $bdval['winners'];
													$resultList .= '<div class="slide-info-body">
																		<div class="prize-tier">
																			<p>'.$bdval['type'].'</p>
																		</div>
																		<div class="winner-prize">
																			<p>'.$bdval['winners'].'</p>
																		</div>
																		<div class="prize-value">
																			<p>'.$currencySymbol.$bdval['amount'].'</p>
																		</div>
																		<div class="prize-payout">
																			<p>0</p>
																		</div>
																	</div>';
												}
									$resultList .= '<div class="slide-info-footer">
														<div class="prize-tier">
															<p><b>Total</b></p>
														</div>
														<div class="winner-prize">
															<p>'.$totalPrizes.'</p>
														</div>
														<div class="prize-value">
															<p></p>
														</div>
														<div class="prize-payout">
															<p>0</p>
														</div>
													</div>
												</div>
										</div>
									</div>';
								}
								$resultList .= '</div>';
								$i++;
							}
							?>
							<div class="select-month">
								<label>Select Month</label>
								<select id="lottery-result-month" data-select-result-month>
									<?php echo $monthYear; ?>
								</select>
							</div>
						<?php } ?>

						<div class="result-accordian-section">
							<div class="result-table-title">
								<h3>Results</h3>
							</div>
							<div class="result-accordian-row">
								<div class="result-accordian-col">
									<div class="result-accordian-header">
										<div class="table-date">
											<p>Draw Date</p>
										</div>
										<div class="table-prize">
											<p>Total Prizes</p>
										</div>
										<div class="table-number">
											<p>Numbers</p>
										</div>
									</div>

									<?php echo $resultList; ?>

								</div>
							</div>
						</div>
					</div>
					<div class="result-flex-col-30">
						<div class="sub-form-row">
							<h3>Get Connected</h3>
							<p>Enter your name and email address below to receive up-to-date weekly lottery results emails on the world's top jackpots!</p>
							<form>
								<div class="form-field half-width">
									<label>First Name</label>
									<input type="text" name="">
								</div>
								<div class="form-field half-width">
									<label>Last Name</label>
									<input type="text" name="">
								</div>
								<div class="form-field full-width">
									<label>Email</label>
									<input type="text" name="">
								</div>
								<div class="form-field full-width">
									<div class="align-btn">
									<button class="jlotto-play-lottery">Subscribe</button>
									</div>
								</div>
								<div class="form-bottom-img">
									<img src="images/GetConnectedBannet.png">
								</div>
							</form>
						</div>
						<div class="sub-form-row">
							<h3>Did you Win?</h3>
							<p>Enter your numbers you want to check for the displayed Lottery and period.</p>
							<div class="lottery-table-col-iner">
								<div class="lotter-table-head">
									<div class="select-no-heading">
										<p>Select 5 Numbers</p>
									</div>
									<div class="select-ticket-box-row">
										<div class="select-ticket-box">
											<span>1</span>
										</div>
										<div class="select-ticket-box">
											<span>2</span>
										</div>
										<div class="select-ticket-box">
											<span>3</span>
										</div>
										<div class="select-ticket-box">
											<span>4</span>
										</div>
										<div class="select-ticket-box">
											<span class="">5</span>
										</div>
										<div class="select-ticket-box">
											<span>6</span>
										</div>
										<div class="select-ticket-box">
											<span>7</span>
										</div>
										<div class="select-ticket-box">
											<span>8</span>
										</div>
										<div class="select-ticket-box">
											<span>9</span>
										</div>
										<div class="select-ticket-box">
											<span>10</span>
										</div>
										<div class="select-ticket-box">
											<span>11</span>
										</div>
										<div class="select-ticket-box">
											<span>12</span>
										</div>
										<div class="select-ticket-box">
											<span>13</span>
										</div>
										<div class="select-ticket-box">
											<span>14</span>
										</div>
										<div class="select-ticket-box">
											<span>15</span>
										</div>
										<div class="select-ticket-box">
											<span>16</span>
										</div>
										<div class="select-ticket-box">
											<span class="">17</span>
										</div>
										<div class="select-ticket-box">
											<span>18</span>
										</div>
										<div class="select-ticket-box">
											<span>10</span>
										</div>
										<div class="select-ticket-box">
											<span>20</span>
										</div>
										<div class="select-ticket-box">
											<span>21</span>
										</div>
										<div class="select-ticket-box">
											<span>22</span>
										</div>
										<div class="select-ticket-box">
											<span>23</span>
										</div>
										<div class="select-ticket-box">
											<span>24</span>
										</div>
										<div class="select-ticket-box">
											<span>25</span>
										</div>
										<div class="select-ticket-box">
											<span class="">26</span>
										</div>
										<div class="select-ticket-box">
											<span>27</span>
										</div>
										<div class="select-ticket-box">
											<span>28</span>
										</div>
										<div class="select-ticket-box">
											<span>29</span>
										</div>
										<div class="select-ticket-box">
											<span>30</span>
										</div>
										<div class="select-ticket-box">
											<span>31</span>
										</div>
										<div class="select-ticket-box">
											<span>32</span>
										</div>
										<div class="select-ticket-box">
											<span>33</span>
										</div>
										<div class="select-ticket-box">
											<span>34</span>
										</div>
										<div class="select-ticket-box">
											<span>35</span>
										</div>
										<div class="select-ticket-box">
											<span>36</span>
										</div>
										<div class="select-ticket-box">
											<span class="">37</span>
										</div>
										<div class="select-ticket-box">
											<span>38</span>
										</div>
										<div class="select-ticket-box">
											<span>39</span>
										</div>
										<div class="select-ticket-box">
											<span>40</span>
										</div>
										<div class="select-ticket-box">
											<span>41</span>
										</div>
										<div class="select-ticket-box">
											<span>42</span>
										</div>
										<div class="select-ticket-box">
											<span>43</span>
										</div>
										<div class="select-ticket-box">
											<span>44</span>
										</div>
										<div class="select-ticket-box">
											<span>45</span>
										</div>
										<div class="select-ticket-box">
											<span>46</span>
										</div>
										<div class="select-ticket-box">
											<span>47</span>
										</div>
										<div class="select-ticket-box">
											<span class="">48</span>
										</div>
										<div class="select-ticket-box">
											<span>49</span>
										</div>
										<div class="select-ticket-box">
											<span>50</span>
										</div>
										<div class="select-ticket-box">
											<span>51</span>
										</div>
										<div class="select-ticket-box">
											<span>52</span>
										</div>
										<div class="select-ticket-box">
											<span>53</span>
										</div>
										<div class="select-ticket-box">
											<span>54</span>
										</div>
										<div class="select-ticket-box">
											<span>55</span>
										</div>
										<div class="select-ticket-box">
											<span>56</span>
										</div>
									</div>
									<div class="select-no-heading">
										<p>Select 1 Powerball</p>
									</div>
									<div class="select-ticket-box-row">
										<div class="select-ticket-box">
											<span class="yellow-ticket">1</span>
										</div>
										<div class="select-ticket-box">
											<span class="yellow-ticket">2</span>
										</div>
										<div class="select-ticket-box">
											<span class="yellow-ticket">3</span>
										</div>
										<div class="select-ticket-box">
											<span class="yellow-ticket">4</span>
										</div>
										<div class="select-ticket-box">
											<span class="yellow-ticket">5</span>
										</div>
										<div class="select-ticket-box">
											<span class="yellow-ticket">6</span>
										</div>
										<div class="select-ticket-box">
											<span class="yellow-ticket">7</span>
										</div>
										<div class="select-ticket-box">
											<span class="yellow-ticket">8</span>
										</div>
										<div class="select-ticket-box">
											<span class="yellow-ticket">9</span>
										</div>
										<div class="select-ticket-box">
											<span class="yellow-ticket">10</span>
										</div>
										<div class="select-ticket-box">
											<span class="yellow-ticket">11</span>
										</div>
										<div class="select-ticket-box">
											<span class="yellow-ticket">12</span>
										</div>
										<div class="select-ticket-box">
											<span class="yellow-ticket">13</span>
										</div>
										<div class="select-ticket-box">
											<span class="yellow-ticket">14</span>
										</div>
									</div>
								</div>
							</div>
							<div class="check-number-row">
								<button class="blue-btn">Clear</button>
								<button class="jlotto-play-lottery">Check Numbers</button>
							</div>
							<div class="winner-name">
								<p>5 Apr</p>
								<div class="table-number-row"><span class="bg-grey">08</span><span class="bg-grey">08</span><span class="bg-grey">08</span><span class="bg-grey">08</span><span class="bg-grey">08</span><span class="bg-yellow">08</span><span class="bg-yellow">08</span></div>
								<div class="winner-prize-money">
								<p class="winner-color">Winner! €1,000,000.00</p>
							</div>
							</div>
							<div class="winner-name">
								<p>5 Apr</p>
								<div class="table-number-row"><span class="bg-grey">08</span><span class="bg-grey">12</span><span class="bg-grey">15</span></div>
								<div class="winner-prize-money">
									<p class="winner-color">Winner! €5.00</p>
								</div>
							</div>
							<div class="winner-name">
								<p>5 Apr</p>
								<div class="table-number-row"><span class="bg-grey">08</span><span class="bg-grey">08</span><span class="bg-grey">08</span><span class="bg-grey">08</span><span class="bg-grey">08</span><span class="bg-yellow">08</span><span class="bg-yellow">08</span></div>
								<div class="winner-prize-money">
								<p class="not-winner-color">Winner! €1,000,000.00</p>
							</div>
							</div>

						</div>
						<div class="cash-prize-warrent-row">
							<div class="warrent-logo">
								<img src="images/warrenty-logo.svg">
							</div>
							<div class="cash-winner-row">
								<div class="cash-winner-logo">
									<img src="images/IrishLotto.png">
								</div>
								<div class="cash-winner-prize">
									<p>French Lotto</p>
									<h3>€5 MILLION</h3>
								</div>
							</div>
							<div class="prize-garrenty-list">
								<ul>
									<li>Always a Cash Prize</li>
									<li>10 Chances to Win</li>
									<li>Best Service</li>
									<li>Great Price</li>
								</ul>
								<div class="align-btn">
								<button class="jlotto-play-lottery">Play Now</button>
							</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="play-country-lotto-section bg-for-oz">
	<div class="jlotto-container">
		<div class="play-country-lotto-row">
			<div class="play-country-lotto-col">
				<h2>Play Australian 6/45 Lotto</h2>
				<p>French Lotto combines big jackpots with excellent prize-winning odds making it a lucrative choice to play. Choose 5 winning numbers plus a "lucky" number to win prizes up to €21 million!</p>
				<div class="lotto-draw-list">
					<div class="lotto-draw-list-col">
						<div class="lotto-draw-list-icon">
							<img src="images/draw-list-icon1.svg">
						</div>
						<div class="lotto-draw-list-disc">
							<h3>Three Draws per week</h3>
							<p>Feel the excitement of French Lotto every Monday, Wednesday and Saturday!</p>
						</div>
					</div>
					<div class="lotto-draw-list-col">
						<div class="lotto-draw-list-icon">
							<img src="images/draw-list-icon2.svg">
						</div>
						<div class="lotto-draw-list-disc">
							<h3>Fantastic Prize odds</h3>
							<p>Overall odds of winning any prize are better than 1 in 6!</p>
						</div>
					</div>
					<div class="lotto-draw-list-col">
						<div class="lotto-draw-list-icon">
							<img src="images/draw-list-icon3.svg">
						</div>
						<div class="lotto-draw-list-disc">
							<h3>Bonne Chance!</h3>
							<p>Jackpots climb quickly with up to 3 rollovers every week!</p>
						</div>
					</div>
				</div>
			</div>
			<div class="play-country-lotto-col">
				<div class="play-country-lotto-location">
					<img src="images/oz-doc-img.png">
				</div>
				<div class="accordion-container">
				  <div class="set">
				    <a href="#">
				      Quick Facts
				      <i class="down-carret"></i>
				    </a>
				    <div class="content">
				    	<div class="content-iner">
					      <h4>French Lotto Record Jackpot</h4>
					      <p>€21 million</p>
					 	</div>
					 	<div class="content-iner">
					      <h4>Prizes</h4>
					      <p>10 lucative prize categories</p>
					 	</div>
					 	<div class="content-iner">
					      <h4>Drow Format</h4>
					      <p>5 winning numbers are drown  from a field of 1-49 and 1 Lucky Number from a seprate field of 1-10.</p>
					 	</div>
					 	<div class="content-iner">
					      <h4>Drow Days</h4>
					      <p>Every Monday, Wednesday and Saturday at 21:30 CET</p>
					 	</div>
					 	<div class="content-iner">
					      <h4>Cut-OFF Time</h4>
					      <p>12 hours before draw to place a bet.</p>
					 	</div>
				    </div>
				  </div>
				  <div class="set">
				    <a href="#">
				      10 Prize Categories
				     <i class="down-carret"></i>
				    </a>
					<div class="content">
				    	<div class="content-iner">
					      <h4>French Lotto Record Jackpot</h4>
					      <p>€21 million</p>
					 	</div>
					 	<div class="content-iner">
					      <h4>Prizes</h4>
					      <p>10 lucative prize categories</p>
					 	</div>
					 	<div class="content-iner">
					      <h4>Drow Format</h4>
					      <p>5 winning numbers are drown  from a field of 1-49 and 1 Lucky Number from a seprate field of 1-10.</p>
					 	</div>
					 	<div class="content-iner">
					      <h4>Drow Days</h4>
					      <p>Every Monday, Wednesday and Saturday at 21:30 CET</p>
					 	</div>
					 	<div class="content-iner">
					      <h4>Cut-OFF Time</h4>
					      <p>12 hours before draw to place a bet.</p>
					 	</div>
				    </div>
				  </div>
				  <div class="set">
				    <a href="#">
				      Why Play?
				     <i class="down-carret"></i>
				    </a>
					<div class="content">
				    	<div class="content-iner">
					      <h4>French Lotto Record Jackpot</h4>
					      <p>€21 million</p>
					 	</div>
					 	<div class="content-iner">
					      <h4>Prizes</h4>
					      <p>10 lucative prize categories</p>
					 	</div>
					 	<div class="content-iner">
					      <h4>Drow Format</h4>
					      <p>5 winning numbers are drown  from a field of 1-49 and 1 Lucky Number from a seprate field of 1-10.</p>
					 	</div>
					 	<div class="content-iner">
					      <h4>Drow Days</h4>
					      <p>Every Monday, Wednesday and Saturday at 21:30 CET</p>
					 	</div>
					 	<div class="content-iner">
					      <h4>Cut-OFF Time</h4>
					      <p>12 hours before draw to place a bet.</p>
					 	</div>
				    </div>
				  </div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	lottery = {
		cutOffsHours: <?php if( isset( $hours ) && !empty( $hours ) ){ echo $hours; }else{ echo ""; } ?>,
		numOfBalls: <?php if( isset( $noOfBalls ) && !empty( $noOfBalls ) ){ echo $noOfBalls; }else{ echo ""; } ?>,
		maxBallNumber: <?php if( isset( $maxBallNo ) && !empty( $maxBallNo ) ){ echo $maxBallNo; }else{ echo ""; } ?>,
		minBallNumber: <?php if( isset( $minBallNo ) && !empty( $minBallNo ) ){ echo $minBallNo; }else{ echo ""; } ?>,
		totalBonusBalls: <?php echo $totalBonusBalls; ?>,
		maxBonusBalls: <?php echo $maxBonusBalls; ?>,
	};
</script>
<?php include 'footer.php' ?>