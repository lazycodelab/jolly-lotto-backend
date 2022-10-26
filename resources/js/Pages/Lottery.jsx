import { Head, Link } from '@inertiajs/inertia-react'

export default function Lottery() {
	const QuickPickCard = () => (
		<div className="max-w-max bg-zinc-50 p-1.5 border border-slate-300 rounded-md">
			<div className="flex justify-between gap-x-1.5 items-center">
				<button
					type="button"
					className="rounded-xl text-xs bg-gradient-to-r from-orange-400 to-orange-500 text-white py-1 px-4 hover:from-orange-500 font-medium hover:to-orange-400"
				>
					Quick Pick
				</button>
				<button
					type="button"
					className="rounded-xl bg-cyan-400 text-xs font-medium py-1 px-4 text-white"
				>
					Clear
				</button>
				<button
					type="button"
					className="rounded-xl bg-cyan-400 text-xs font-medium py-1 px-4 text-white"
				>
					Delete
				</button>
			</div>
			<div>
				<span className="block text-sm">Select 6 Numbers</span>
				<div className="flex flex-wrap">
					<span className="rounded flex justify-center items-center w-6 text-xs cursor-pointer border border-slate-200 bg-white h-6">
						1
					</span>
				</div>
			</div>
			<div className="mt-3">
				<span className="block text-sm">Select 2 Super</span>
				<div className="flex flex-wrap">
					<span className="rounded flex justify-center items-center w-6 text-xs cursor-pointer border border-slate-200 bg-amber-100 h-6">
						1
					</span>
				</div>
			</div>
		</div>
	)

	const AddQuickCard = () => (
		<div className="max-w-max bg-zinc-50 p-1.5">
			<button type="button">Add Line</button>
		</div>
	)

	return (
		<>
			<Head title="Lottery Page" />
			{/* Hero section */}
			<section className="bg-orange-100 py-3">
				<div className="container px-10 flex justify-between items-center max-w-6xl mx-auto">
					<img src="/images/OZLotto.png" alt="OZ Lotto" />
					<div className="text-center">
						<h2 className="text-2xl font-semibold text-zinc-500">
							Next German Lotto Single Play Lotto
						</h2>
						<h1 className="text-7xl font-bold text-cyan-900">
							$0 Million
						</h1>
					</div>
					<div>
						<span className="block text-zinc-500">
							Draw Cutoff Timer
						</span>
						<div className="bg-white rounded-lg py-1 px-9 font-bold text-xl text-center text-red-600">
							2 Days
						</div>
					</div>
				</div>
			</section>

			<section className="pb-10">
				<div className="container max-w-6xl mx-auto">
					{/* tabbed nav */}
					<nav className="flex items-center bg-orange-50">
						<Link
							className="py-3 px-12 cursor-pointer border-b-2 border-cyan-900 text-center font-semibold text-base text-cyan-900"
							href="/"
						>
							Single Play
						</Link>
						<Link
							className="py-3 px-12 cursor-pointer border-b-2 text-center font-semibold text-base text-cyan-900"
							href="/results"
						>
							Results
						</Link>
					</nav>
					<h2 className="text-2xl text-teal-600 font-semibold mt-8">
						Play German Lotto Single Play
					</h2>
					<h6 className="text-sm text-cyan-900">
						German Lotto Single Play
					</h6>
					<div className="flex items-center justify-between mt-6">
						<h3 className="text-base font-semibold">
							Quickpick, Edit or Delete lines
						</h3>

						<div className="flex gap-x-1.5">
							<button
								type="button"
								class="bg-cyan-400 rounded-md px-5 py-2.5 shadow shadow-cyan-600 text-white text-xs font-semibold"
							>
								Quick Pick All
							</button>
							<button
								type="button"
								class="bg-cyan-400 rounded-md px-5 py-2.5 shadow shadow-cyan-600 text-white text-xs font-semibold"
							>
								Clear All
							</button>
						</div>
					</div>
					<div className="flex gap-1 flex-wrap mt-4 mb-7">
						<QuickPickCard />
						<AddQuickCard />
					</div>
				</div>
				<div className="container flex justify-between items-start max-w-4xl mx-auto">
					<div className="max-w-sm flex-1">
						<h4 className="text-base text-cyan-900 font-semibold">
							Duration
						</h4>
						<div className="flex gap-x-2.5">
							<button
								type="button"
								className="w-14 h-16 flex justify-center items-center bg-gray-100 text-white rounded-tl-xl rounded-bl-xl  text-3xl hover:bg-cyan-400"
							>
								-
							</button>
							<div className="border-2 flex flex-col justify-center items-center border-slate-300 bg-zinc-100">
								<input
									type="number"
									className="bg-transparent text-center font-bold text-lg border-none p-0 focus:ring-0"
									min={1}
									values={1}
								/>
								<span className="text-center text-xs">
									Week
								</span>
							</div>
							<button
								type="button"
								className="w-14 h-16 flex justify-center items-center bg-gray-100 text-white rounded-tr-xl rounded-br-xl text-3xl hover:bg-cyan-400"
							>
								+
							</button>
						</div>
						<div className="mt-7">
							<h4 className="text-base text-cyan-900 font-semibold">
								Select your Draw Days
							</h4>
							<ul>
								<li>
									<input type="checkbox" name="" id="" />
									Wednesday
								</li>
							</ul>
						</div>
					</div>
					<div className="max-w-sm flex-1">
						<h4 className="text-base text-cyan-900 font-semibold">
							EuroMillions
						</h4>
						<div>
							{/* item list here */}
							<div className="flex justify-between">
								<span>3 lines x 1 draw</span>
								<span>$90.00</span>
							</div>
							{/* total line here */}
							<div className="flex justify-between border-t-2 border-gray-300">
								<span>Total:</span>
								<span>$800.00</span>
							</div>
						</div>
						{/* confirm button */}
						<button
							type="submit"
							className="w-full mt-5 rounded-md py-3 px-14 text-white text-lg bg-gradient-to-r from-orange-400 to-orange-500 shadow-orange-700 shadow-md hover:from-orange-500 hover:to-orange-400"
						>
							Play Now
						</button>
					</div>
				</div>
			</section>

			{/* advert/info section */}
			<section className="py-10 bg-orange-50">
				<div className="max-w-6xl mx-auto flex justify-between gap-x-5">
					<div className="max-w-xl flex-1">
						<h2 className="text-2xl text-teal-600 font-semibold">
							Play Australian 6/45 Lotto
						</h2>
						<p className="text-sm text-cyan-900">
							French Lotto combines big jackpots with excellent
							prize-winning odds making it a lucrative choice to
							play. Choose 5 winning numbers plus a "lucky" number
							to win prizes up to €21 million!
						</p>
						<div className="mt-5">
							<div className="flex gap-x-5 items-center">
								<img src="/images/draw-list-icon1.svg" alt="" />
								<div>
									<h3 className="font-semibold text-lg text-teal-600">
										Three Draws per week
									</h3>
									<p className="text-cyan-900 pt-0.5 text-sm">
										Feel the excitement of French Lotto
										every Monday, Wednesday and Saturday!
									</p>
								</div>
							</div>
						</div>
					</div>
					<div className="max-w-xl flex-1">
						<img src="/images/oz-doc-img.png" alt="ban" />
						<div></div>
					</div>
				</div>
			</section>
		</>
	)
}
