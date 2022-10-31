export default () => {
	return (
		<section className="bg-orange-50 py-10">
			<div className="mx-auto flex max-w-6xl justify-between gap-x-5">
				<div className="max-w-xl flex-1">
					<h2 className="text-2xl font-semibold text-teal-600">
						Play Australian 6/45 Lotto
					</h2>
					<p className="text-sm text-cyan-900">
						French Lotto combines big jackpots with excellent
						prize-winning odds making it a lucrative choice to play.
						Choose 5 winning numbers plus a "lucky" number to win
						prizes up to €21 million!
					</p>
					<div className="mt-5">
						<div className="flex items-center gap-x-5">
							<img src="/images/draw-list-icon1.svg" alt="" />
							<div>
								<h3 className="text-lg font-semibold text-teal-600">
									Three Draws per week
								</h3>
								<p className="pt-0.5 text-sm text-cyan-900">
									Feel the excitement of French Lotto every
									Monday, Wednesday and Saturday!
								</p>
							</div>
						</div>
					</div>
				</div>
				<div className="max-w-xl flex-1">
					<img src="/images/oz-doc-img.png" alt="ban" />
					<div>
						<details className="transition-all duration-300">
							<summary>Details</summary>
							Something small enough to escape casual notice.
						</details>
					</div>
				</div>
			</div>
		</section>
	)
}
