import { generateRandomNum } from '@/Components/Helpers'
import IconAdd from '@/Components/Icons/IconAdd'
import LineCard from '@/Components/LotteryDetails/LineCard'
import QuantityInput from '@/Components/LotteryDetails/QuantityInput'
import SectionInfo from '@/Components/LotteryDetails/SectionInfo'
import { Head, Link } from '@inertiajs/inertia-react'
import classNames from 'classnames'
import { useCallback, useEffect, useState } from 'react'

export default function Lottery({ product, lottery }) {
	//const [balls, setBalls] = useState([])
	const [lotteryCards, setLotteryCards] = useState(3)
	const [weeks, setWeeks] = useState(1)

	const LotteryLinesList = () => {
		const [lotteries, setLotteries] = useState([])
		let g = []

		useEffect(() => {
			for (let i = 1; i <= 3; i++) {
				g.push({
					line: <LineCard key={i} />,
					selected: 10,
					completed: false,
				})
			}
			setLotteries(g)
		}, [])

		return lotteries.map((lottery) => lottery.line)
	}

	const AddQuickCard = () => (
		<div
			className="flex w-full max-w-[225px] cursor-pointer flex-col items-center justify-center rounded-md border border-slate-300 bg-zinc-50 p-1.5"
			onClick={() => handleLotteryLines('add')}
		>
			<IconAdd className={'w-16'} />
			<span className="mt-2.5 block text-base font-semibold text-cyan-900">
				Add Line
			</span>
		</div>
	)

	return (
		<>
			<Head title="Lottery Page" />
			<section className="bg-orange-100 py-3">
				<div className="container mx-auto flex max-w-6xl items-center justify-between px-10">
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
						<div className="rounded-lg bg-white py-1 px-9 text-center text-xl font-bold text-red-600">
							2 Days
						</div>
					</div>
				</div>
			</section>

			<section className="pb-10">
				<div className="container mx-auto max-w-6xl">
					{/* tabbed nav */}
					<nav className="flex items-center bg-orange-50">
						<Link
							className="cursor-pointer border-b-2 border-cyan-900 py-3 px-12 text-center text-base font-semibold text-cyan-900"
							href="/"
						>
							Single Play
						</Link>
						<Link
							className="cursor-pointer border-b-2 py-3 px-12 text-center text-base font-semibold text-cyan-900"
							href="/results"
						>
							Results
						</Link>
					</nav>
					<h2 className="mt-8 text-2xl font-semibold text-teal-600">
						Play German Lotto Single Play
					</h2>
					<h6 className="text-sm text-cyan-900">
						German Lotto Single Play
					</h6>
					<div className="mt-6 flex items-center justify-between">
						<h3 className="text-base font-semibold">
							Quickpick, Edit or Delete lines
						</h3>

						<div className="flex gap-x-1.5">
							<button
								type="button"
								className="rounded-md bg-cyan-400 px-5 py-2.5 text-xs font-semibold text-white shadow shadow-cyan-600"
							>
								Quick Pick All
							</button>
							<button
								type="button"
								className="rounded-md bg-cyan-400 px-5 py-2.5 text-xs font-semibold text-white shadow shadow-cyan-600"
							>
								Clear All
							</button>
						</div>
					</div>
					<div className="mt-4 mb-20 flex flex-wrap gap-x-1.5 gap-y-3">
						{/*{console.log('sdsd', lotteryLines)}*/}
						<LotteryLinesList />
						<AddQuickCard />
					</div>
				</div>
				<div className="container mx-auto flex max-w-4xl items-start justify-between">
					<div className="max-w-sm flex-1">
						<h4 className="text-base font-semibold text-cyan-900">
							Duration
						</h4>

						<QuantityInput weeks={weeks} setWeeks={setWeeks} />
						<div className="mt-7">
							<h4 className="text-base font-semibold text-cyan-900">
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
						<h4 className="text-base font-semibold text-cyan-900">
							EuroMillions
						</h4>
						<div>
							{/* item list here */}
							<div className="flex justify-between">
								<span>
									{/*{lotteryCards} lines x {weeks} draw*/}
								</span>
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
							className="mt-5 w-full rounded-md bg-gradient-to-r from-orange-400 to-orange-500 py-3 px-14 text-lg text-white shadow-md shadow-orange-700 hover:from-orange-500 hover:to-orange-400"
						>
							Play Now
						</button>
					</div>
				</div>
			</section>

			<SectionInfo />
		</>
	)
}
