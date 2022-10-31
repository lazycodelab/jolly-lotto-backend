import classNames from 'classnames'
import { useCallback, useState } from 'react'
import { generateRandomNum } from '../Helpers'
import IconTrash from '../Icons/IconTrash'

export default () => {
	const lotteryCards = 3
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

	const BallUI = ({ number, isSelected }) => {
		const [selected, setSelected] = useState(isSelected)
		const [totalSelected, setTotalSelected] = useState(5)
		let totalSelectedOK = 5

		console.log('totla d', totalSelectedOK)

		return (
			<span
				className={classNames(
					'flex h-6 w-6 cursor-pointer select-none items-center justify-center rounded border border-slate-200 text-xs',
					{
						'bg-white': !selected,
						'bg-green-500 text-white': selected,
					}
				)}
				onClick={() => {
					if (totalSelectedOK < 5) {
						console.log('whenn')
						//setSelected((state) => !state)
						totalSelectedOK += 1
						//setTotalSelected((state) => state + 1)
					} else if (totalSelectedOK >= 5 && selected) {
						//setSelected((state) => !state)
						totalSelectedOK -= 1
						//setTotalSelected((state) => state - 1)
					}
				}}
			>
				{number}
			</span>
		)
	}

	return (
		<div
			className={classNames('max-w-[225px] rounded-md border p-1.5', {
				'border-slate-300 bg-zinc-50': true,
				//'border-red-300 bg-red-100': false,
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
							'cursor-not-allowed bg-gray-300': lotteryCards <= 1,
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
