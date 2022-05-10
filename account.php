<?php include 'header.php' ?>
<section class="account-page-nav-bar">
	<div class="auto-container">
		<div class="account-nav-row">
			<ul>
				<li><a href="">Account</a></li>
				<li><a href="">Wallet</a></li>
				<li><a href="">Orders</a></li>
				<li><a href="">Notifications</a></li>
			</ul>
		</div>
	</div>
</section>	
<section class="current-acc-status">
	<div class="auto-container">
		<div class="current-acc-row">
			<div class="current-acc-heading">
				<p><b>Current Account Status: <span class="active-acc"> Active</span> <span class="or-color"> Or</span> <span class="acc-disable"> Disabled </span> </b>please email customer service for more information at info@jollylotto.com</p>
			</div>
			<div class="account-accordion-container">
			<div class="accordion-container">
				  <div class="set">
				    <a href="#">
				     Profile
				     <i class="down-carret"></i>
				    </a>
					<div class="content">
						<div class="acc-data-tab">
				    		<div class="persnal-acc-data">
					    		<h3>Personal Details</h3>
					    		<form>
					    			<div class="form-field col-12">
					    				<label>Title <sub>*</sub></label>
					    				<select>
					    					<option>Mr.</option>
					    					<option>Mrs.</option>
					    				</select>
					    				
					    			</div>
					    			<div class="form-field col-35">
					    				<label>First Name <sub>*</sub></label>
					    				<input type="text" name="">
					    			</div>
					    			<div class="form-field col-50">
					    				<label>Last Name <sub>*</sub></label>
					    				<input type="text" name="">
					    			</div>
					    		</form>
					    	</div>
					    </div>
				    </div>
				  </div>
				  <div class="set">
				    <a href="#">
				     Order History
				     <i class="down-carret"></i>
				    </a>
					<div class="content">
				    	<div class="acc-data-tab">
				    		<form>
				    			<div class="form-field col-25">
				    				<label>Title *</label>
				    				<div class="date-calender"><input type="text" name="" id="datepicker">
				    				</div>
				    			</div>
				    			<div class="form-field col-25">
				    				<label>First Name</label>
				    				<input type="text" name="">
				    			</div>
				    			<div class="form-field col-25">
				    				<label>Last Name</label>
				    				<select>
				    					<option>All</option>
				    				</select>
				    			</div>
				    		</form>
				    		<div class="reset-search">
				    			<button class="reset-search-text">Reset</button>
				    			<button class="reset-search-btn orange-btn">Search</button>
				    		</div>
				    		<div class="acc-sale-row-scroll">
				    		<div class="acc-sale-row">
				    			<div class="acc-sale-head">
				    				<div class="sale-name">
				    					<p><b>Sale Date</b></p>
				    				</div>
				    				<div class="sale-order-number">
				    					<p><b>Order Number</b></p>
				    				</div>
				    				<div class="sale-order-via">
				    					<p><b>Order Via</b></p>
				    				</div>
				    				<div class="sale-order-via">
				    					<p><b>Total Bet <br>Amount (GBP)</b></p>
				    				</div>
				    				<div class="sale-order-bet">
				    					
				    				</div>
				    			</div>
				    			<div class="acc-sale-body">
					    			<div class="acc-sale-body-data errow-active">
					    				<div class="sale-name">
					    					<p>2019 Sep 11, 13:05PST</p>
					    				</div>
					    				<div class="sale-order-number">
					    					<p>ORD-123456789-01</p>
					    				</div>
					    				<div class="sale-order-via">
					    					<p>Phone</p>
					    				</div>
					    				<div class="sale-order-via">
					    					<p>5.00</p>
					    				</div>
					    				<div class="sale-order-bet">
					    					<p><a href="">Bet Again</a></p>
					    				</div>
					    			</div>
					    			<div class="acc-sale-slide-data">
					    				<div class="acc-item-sale">
					    					<div class="acc-item">
					    						<p><b>Item #</b></p>
					    					</div>
					    					<div class="acc-item-product">
					    						<p><b>Product</b></p>
					    					</div>
					    					<div class="acc-item-type">
					    						<p><b>Type</b></p>
					    					</div>
					    					<div class="acc-item-subscription">
					    						<p><b>Subscription</b></p>
					    					</div>
					    					<div class="acc-item-promo-code">
					    						<p><b>Promo Code</b></p>
					    					</div>
					    					<div class="acc-item-lines">
					    						<p><b>Lines</b></p>
					    					</div>
					    					<div class="acc-item-drows">
					    						<p><b>Drows</b></p>
					    					</div>
					    					<div class="acc-item-price">
					    						<p><b>Price Per Unit</b></p>
					    					</div>
					    					<div class="acc-item-priceSum">
					    						<p><b>Price Sum</b></p>
					    					</div>
					    					<div class="acc-item-promo-amt">
					    						<p><b>Promo Amount</b></p>
					    					</div>
					    					<div class="acc-item-promo-bet">
					    						<p><b>Bet Amount</b></p>
					    					</div>
					    					<div class="acc-item-billing">
					    						<p><b>Billing Interval</b></p>
					    					</div>
					    					<div class="acc-item-source">
					    						<p><b>Source</b></p>
					    					</div>
					    					<div class="acc-item-status">
					    						<p><b>Status</b></p>
					    					</div>
					    					<div class="acc-item-fulfilment">
					    						<p><b>Fulfilment Date <span class="acc-exlamation">!</span></b></p>
					    					</div>
					    					<div class="acc-item-total-winning">
					    						<p><b>Total Winnings <span class="small-font">product currency</span></b></p>
					    					</div>
					    					<div class="acc-item-total-winning">
					    						<p><b>Total Winnings <span class="small-font">account currency</span></b></p>
					    					</div>
					    				</div>
					    				<div class="acc-item-slide-sale-info-row">
					    				<div class="acc-item-slide-sale-info errow-active">
					    					<div class="acc-item">
					    						<p>1</p>
					    					</div>
					    					<div class="acc-item-product">
					    						<p>Irish Lotto</p>
					    					</div>
					    					<div class="acc-item-type">
					    						<p>Single</p>
					    					</div>
					    					<div class="acc-item-subscription">
					    						<p>No</p>
					    					</div>
					    					<div class="acc-item-promo-code">
					    						<p>SR-009</p>
					    					</div>
					    					<div class="acc-item-lines">
					    						<p>1</p>
					    					</div>
					    					<div class="acc-item-drows">
					    						<p>2</p>
					    					</div>
					    					<div class="acc-item-price">
					    						<p>5.00</p>
					    					</div>
					    					<div class="acc-item-priceSum">
					    						<p>10.00</p>
					    					</div>
					    					<div class="acc-item-promo-amt">
					    						<p>-25%</p>
					    					</div>
					    					<div class="acc-item-promo-bet">
					    						<p>7.50</p>
					    					</div>
					    					<div class="acc-item-billing">
					    						<p>Once</p>
					    					</div>
					    					<div class="acc-item-source">
					    						<p><b>Wallet</b></p>
					    					</div>
					    					<div class="acc-item-status">
					    						<p><b>Paid</b></p>
					    					</div>
					    					<div class="acc-item-fulfilment">
					    						<p>2019 Jul 20</p>
					    					</div>
					    					<div class="acc-item-total-winning">
					    						<p>EUR 128.00</p>
					    					</div>
					    					<div class="acc-item-total-winning">
					    						<p>GBP 150.00</p>
					    					</div>
					    				</div>
					    				<div class="acc-item-slide-drow-date">
					    				<div class="acc-item-slide-drow-col">
					    					<div class="acc-item">
					    						<p><b>Drow Date</b></p>
					    					</div>
					    					<div class="acc-item-product">
					    						<p><b>Settled</b></p>
					    					</div>
					    					<div class="acc-item-type">
					    						<p><b>Board Numbers</b></p>
					    					</div>
					    					<div class="acc-item-subscription">
					    						<p><b>Matching <br>Numbers</b></p>
					    					</div>
					    					<div class="acc-item-promo-code">
					    						<p><b>Acualt Winning Numbers</b></p>
					    					</div>
					    					<div class="acc-item-lines">
					    						<p><b>Win Ammont <span class="acc-exlamation">!</span></b></p>
					    					</div>
					    					<div class="acc-item-drows">
					    						<p><b>Customers Shares</b></p>
					    					</div>
					    					<div class="acc-item-price">
					    						<p><b>Syndicate Fill Status <span class="acc-exlamation">!</span></b></p>
					    					</div>
					    					<div class="acc-item-priceSum">
					    						<p><b>Syndicate Number</b></p>
					    					</div>
					    					<div class="acc-item-promo-amt">
					    						<p><b>Ticket Serial Number</b></p>
					    					</div>
					    				</div>
					    				<div class="acc-item-slide-drow-col">
					    					<div class="acc-item">
					    						<p>2019 Aug 03</p>
					    					</div>
					    					<div class="acc-item-product">
					    						<p>Yes</p>
					    					</div>
					    					<div class="acc-item-type">
					    						<p>1,2,3,4,5,6,7</p>
					    					</div>
					    					<div class="acc-item-subscription">
					    						<p>3,5</p>
					    					</div>
					    					<div class="acc-item-promo-code">
					    						<p>3,5,19,22,26,<b>26</b></p>
					    					</div>
					    					<div class="acc-item-lines">
					    						<p>EUR 8.00(4.00)</p>
					    					</div>
					    					<div class="acc-item-drows">
					    						<p>5/50</p>
					    					</div>
					    					<div class="acc-item-price">
					    						<p></p>
					    					</div>
					    					<div class="acc-item-priceSum">
					    						<p>IRCT1234</p>
					    					</div>
					    					<div class="acc-item-promo-amt">
					    						<p>11678-2051..</p>
					    					</div>
					    				</div>
					    				<div class="acc-item-slide-drow-col">
					    					<div class="acc-item">
					    						<p>2019 Aug 03</p>
					    					</div>
					    					<div class="acc-item-product">
					    						<p>Yes</p>
					    					</div>
					    					<div class="acc-item-type">
					    						<p>1,2,3,4,5,6,<b>7</b></p>
					    					</div>
					    					<div class="acc-item-subscription">
					    						<p>3,5</p>
					    					</div>
					    					<div class="acc-item-promo-code">
					    						<p>3,5,19,22,26,<b>26</b></p>
					    					</div>
					    					<div class="acc-item-lines">
					    						<p>EUR 57200(11.44)</p>
					    					</div>
					    					<div class="acc-item-drows">
					    						<p>5/50</p>
					    					</div>
					    					<div class="acc-item-price">
					    						<p class="green-color">50/50</p>
					    					</div>
					    					<div class="acc-item-priceSum">
					    						<p>IRCT1234</p>
					    					</div>
					    					<div class="acc-item-promo-amt">
					    						<p>11678-2051..</p>
					    					</div>
					    				</div>
					    				<div class="acc-item-slide-drow-col">
					    					<div class="acc-item">
					    						<p>Pending</p>
					    					</div>
					    					<div class="acc-item-product">
					    						<p>Yes</p>
					    					</div>
					    					<div class="acc-item-type">
					    						<p>1,2,3,4,5,6,7</p>
					    					</div>
					    					<div class="acc-item-subscription">
					    						<p></p>
					    					</div>
					    					<div class="acc-item-promo-code">
					    						<p></p>
					    					</div>
					    					<div class="acc-item-lines">
					    						<p></p>
					    					</div>
					    					<div class="acc-item-drows">
					    						<p>5/50</p>
					    					</div>
					    					<div class="acc-item-price">
					    						<p></p>
					    					</div>
					    					<div class="acc-item-priceSum">
					    						<p>IRCT9999</p>
					    					</div>
					    					<div class="acc-item-promo-amt">
					    						<p></p>
					    					</div>
					    				</div>
							    			<div class="tab-load-all">
											<a href="">Load More</a>
										</div>
					    				</div>

					    			</div>
					    			</div>
					    		</div>		
				    		</div>
				    	</div>
				    	</div>
				    </div>
				  </div>
				  <div class="set">
				    <a href="#">
				     Limits
				     <i class="down-carret"></i>
				    </a>
					<div class="content">
				    	<div class="acc-data-tab">
				    	<div class="acc-limit-tab">
				    		<form>
				    			<div class="limit-form-col-49">
				    			<div class="form-field">
				    				<label>Play Limit:</label>
				    				<input type="text" name="" placeholder="1000.00">
				    			</div>
				    			<div class="form-field">
				    				<label>Per</label>
				    				<select>
				    					<option>1 Day</option>
				    				</select>
				    			</div>
				    			<div class="form-field">
				    				<div class="limit-field-info">
				    					<b>Remaining:</b> <span>550.25</span>
				    				</div>
				    				<div class="limit-field-info">
				    					<b>Until:</b> <span>2019 Oct 31, 05:02:55 PM</span>
				    				</div>
				    				<div class="limit-field-info">
				    					<b>Pending Change::</b> <span>$100 per Week starts on 2020 Jan 31, 00:00PST .</span>
				    				</div>
				    			</div>

				    			<div class="form-field">
				    				<button class="cancel-pending">Cancel Pending Change</button>
				    			</div>
				    			</div>
				    			<div class="limit-form-col-49">
				    			<div class="form-field">
				    				<label>Deposit Limit:</label>
				    				<input type="text" name="">
				    			</div>
				    			<div class="form-field">
				    				<label>Per</label>
				    				<select>
				    					<option>Select Period</option>
				    				</select>
				    			</div>
				    			</div>
				    			<div class="limit-form-col-49">
				    				<div class="loss-limit">
				    					<p>Your potential Loss Limit: $50.00 over 1 Day.</p>
				    				</div>
				    			</div>
				    			
				    		</form>
				    		<div class="please-note">
				    			<p><span>!</span>Please note: decreasing a limit will take effect immediately. Increasing a limit will take effect 24 hours after confirmation.</p>
				    		</div>
				    		<div class="reset-search">
				    			<button class="reset-search-text">Cancel</button>
				    			<button class="reset-search-btn orange-btn">Confirm Limits</button>
				    		</div>
				    	</div>
				    </div>
				    </div>
				  </div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php include 'footer.php' ?>