import { generateRandomNum } from '@/Components/Helpers'
import IconTrash from '@/Components/Icons/IconTrash'
import QuantityInput from '@/Components/LotteryDetails/QuantityInput'
import { Head, Link } from '@inertiajs/inertia-react'
import classNames from 'classnames'
import { useCallback, useEffect, useState } from 'react'

export default function Lottery({ product, lottery }) {
	//const [balls, setBalls] = useState([])
	const [lotteryCards, setLotteryCards] = useState(3)
	const [weeks, setWeeks] = useState(1)
	const [lotteryLines, setLotteryLines] = useState()

	const LotteryLinesList = () => {
		const f = []
		let g = []
		for (let i = 1; i <= lotteryCards; i++) {
			g.push({
				selected: 10,
				completed: false,
			})

			f.push(<QuickPickCard key={i} />)
		}

		return f
	}

	const handleLotteryLines = useCallback(
		(action) => {
			let count = lotteryCards

			if ('add' === action) {
				count += 1
			} else {
				if (count > 1) {
					count -= 1
				}
			}

			setLotteryCards(count)
		},
		[lotteryCards]
	)

	const handleSelectedNumber = useCallback((e) => {
		const isSelected = e.target.dataset.selected

		e.target.setAttribute('data-selected', !isSelected)
	}, [])

	const BallUI = ({ number, isSelected }) => {
		const [selected, setSelected] = useState(isSelected)
		const [totalSelected, setTotalSelected] = useState(5)

		return (
			<span
				className={classNames(
					'flex h-6 w-6 cursor-pointer select-none items-center justify-center rounded border border-slate-200 text-xs',
					{
						'bg-white': !selected,
						'bg-green-500 text-white': selected,
					}
				)}
				onClick={useCallback(() => {
					console.log('totla', totalSelected)
					if (totalSelected < 5) {
						setSelected((state) => !state)
						setTotalSelected((state) => state + 1)
					} else if (totalSelected >= 5 && selected) {
						setSelected((state) => !state)
						setTotalSelected((state) => state - 1)
					}
				}, [totalSelected])}
			>
				{number}
			</span>
		)
	}

	const LotteryBalls = () => {
		//console.log('33', lottery.balls.total)
		const [balls, setBalls] = useState(56)
		const ballUI = []
		const ballsToSelect = 5
		const totalBalls = 56
		const rng = generateRandomNum(ballsToSelect, totalBalls)
		// need to know which card it 	belongs to.
		// then set state for that card index.
		//setLotteryLines((state) => (state[0]['selected'] = ballsToSelect))

		for (let i = 1; i <= balls; i++) {
			ballUI.push(<BallUI number={i} isSelected={rng.has(i)} key={i} />)
		}

		return ballUI
	}

	// @todo: maybe fix this logic?
	//const lotteryLines = useCallback(() => {
	//	const f = []
	//	for (let i = 1; i <= lotteryCards; i++) {
	//		f.push(<QuickPickCard key={i} />)
	//	}

	//	return f
	//}, [lotteryCards])

	const QuickPickCard = () => {
		const [completed, setCompleted] = useState(true)

		return (
			<div
				className={classNames('max-w-[225px] rounded-md border p-1.5', {
					'border-slate-300 bg-zinc-50': completed,
					'border-red-300 bg-red-100': !completed,
				})}
			>
				<div className="flex items-stretch justify-between gap-x-1 pt-8">
					<button
						type="button"
						className="flex-1 rounded-xl bg-gradient-to-r from-orange-400 to-orange-500 py-1 px-2 text-xs font-medium text-white hover:from-orange-500 hover:to-orange-400"
					>
						Quick Pick
					</button>
					<button
						type="button"
						className="rounded-xl bg-cyan-400 py-1 px-4 text-xs font-medium text-white"
					>
						Clear
					</button>
					<button
						type="button"
						className={classNames(
							'rounded-xl py-1 px-4 text-xs font-medium text-white',
							{
								'bg-cyan-400': lotteryCards > 1,
								'cursor-not-allowed bg-gray-300':
									lotteryCards <= 1,
							}
						)}
						onClick={() => handleLotteryLines('remove')}
					>
						<IconTrash className={'w-2.5'} />
					</button>
				</div>
				<div className="mt-3">
					<span className="block text-sm">Select 61 Numbers</span>
					<div className="mt-2 flex flex-wrap gap-1.5">
						<LotteryBalls />
					</div>
				</div>
				<div className="mt-3">
					<span className="block text-sm">Select 2 Super</span>
					<div className="flex flex-wrap">
						<span className="flex h-6 w-6 cursor-pointer items-center justify-center rounded border border-slate-200 bg-amber-100 text-xs">
							1
						</span>
					</div>
				</div>
			</div>
		)
	}

	const AddQuickCard = () => (
		<div
			className="max-w-max bg-zinc-50 p-1.5"
			onClick={() => handleLotteryLines('add')}
		>
			<button type="button">Add Line</button>
		</div>
	)

	return (
		<>
			<Head title="Lottery Page" />
			{/* Hero section */}
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
									{lotteryCards} lines x {weeks} draw
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

			{/* advert/info section */}
			<section className="bg-orange-50 py-10">
				<div className="mx-auto flex max-w-6xl justify-between gap-x-5">
					<div className="max-w-xl flex-1">
						<h2 className="text-2xl font-semibold text-teal-600">
							Play Australian 6/45 Lotto
						</h2>
						<p className="text-sm text-cyan-900">
							French Lotto combines big jackpots with excellent
							prize-winning odds making it a lucrative choice to
							play. Choose 5 winning numbers plus a "lucky" number
							to win prizes up to €21 million!
						</p>
						<div className="mt-5">
							<div className="flex items-center gap-x-5">
								<img src="/images/draw-list-icon1.svg" alt="" />
								<div>
									<h3 className="text-lg font-semibold text-teal-600">
										Three Draws per week
									</h3>
									<p className="pt-0.5 text-sm text-cyan-900">
										Feel the excitement of French Lotto
										every Monday, Wednesday and Saturday!
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
		</>
	)
}
