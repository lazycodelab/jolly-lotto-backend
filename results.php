<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

include 'header.php';
require_once 'api/SingleResult.php';

$lotteryID = $_GET['lotteryID'];
$date = $_GET['date'];

$result = new SingleResult;
$details = $result->fetchDetails( $lotteryID, $date );

?>
<section class="contactUs-page lottery-result-page">
	<div class="jlotto-container">
		<div class="contactUs-row">
			<div class="contactUs-disc">
				<h1>Lottery Results</h1>
				<h2>Supporting Sub Header</h2>
				<p>Small paragraph to help with SEO and Marketing details. Lorem ipsum dolor sir amet...</p>
			</div>
			<div class="lottery-result-table">
				<div class="lottery-result-table-row">
					<table>
						<thead>
							<tr>
								<th></th>
								<th>Lottery</th>
								<th>Last Draw</th>
								<th>Winning Numbers</th>
								<th>Next Estimated Jackpot</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><img src="images/Australian6-45.png"></td>
								<td>EuroMillions</td>
								<td><p>4 May, 2021 <b>Tuesday</b></p></td>
								<td><div class="table-number-row"><span class="bg-grey">08</span><span class="bg-grey">08</span><span class="bg-grey">08</span><span class="bg-grey">08</span><span class="bg-grey">08</span><span class="bg-yellow">08</span><span class="bg-yellow">08</span></div> <a href="">More Results</a></td>
								<td><b>€102 MILLION</b></td>
								<td><button>Play Now</button></td>
							</tr>
							<tr>
								<td><img src="images/FrenchLotto.png"></td>
								<td>French Lotto</td>
								<td><p>4 May, 2021 <b>Tuesday</b></p></td>
								<td><div class="table-number-row"><span class="bg-grey">08</span><span class="bg-grey">08</span><span class="bg-grey">08</span><span class="bg-grey">08</span><span class="bg-grey">08</span><span class="bg-yellow">08</span></div><a href="">More Results</a></td>
								<td><b>€53 MILLION</b></td>
								<td><button>Play Now</button></td>
							</tr>
							<tr>
								<td><img src="images/EuroMillions.png"></td>
								<td>Euromillions</td>
								<td><p>4 May, 2021 <b>Tuesday</b></p></td>
								<td><div class="table-number-row"><p>Latest Result Pending</p></div><a href="">More Results</a></td>
								<td><b>€12 MILLION</b></td>
								<td><button>Play Now</button></td>
							</tr>
							<tr>
								<td><img src="images/IrishLotto.png"></td>
								<td>Euromillions</td>
								<td><p>4 May, 2021 <b>Tuesday</b></p></td>
								<td><div class="table-number-row"><span class="bg-grey">08</span><span class="bg-grey">08</span><span class="bg-grey">08</span><span class="bg-grey">08</span><span class="bg-grey">08</span><span class="bg-yellow">08</span><span class="bg-yellow">08</span></div> <a href="">More Results</a></td>
								<td><b>A€200 MILLION</b></td>
								<td><button>Play Now</button></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
<?php include 'footer.php' ?>