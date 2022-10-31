import { useCallback, useState } from 'react'

export default ({ weeks, setWeeks }) => {
	const handleTotalCost = useCallback(() => {
		// take single lottery price, based on selected currency.
		// multiply by no weeks and no cards.
		console.log('here')
		setWeeks((state) => state + 1)
	}, [])

	return (
		<div className="flex gap-x-2.5">
			<button
				type="button"
				className="flex h-16 w-14 items-center justify-center rounded-tl-xl rounded-bl-xl bg-gray-100 text-3xl text-white hover:bg-cyan-400"
				onClick={() =>
					setWeeks((state) => (state > 1 ? state - 1 : state))
				}
			>
				-
			</button>
			<div className="flex flex-col items-center justify-center border-2 border-slate-300 bg-zinc-100">
				<input
					type="number"
					className="border-none bg-transparent p-0 text-center text-lg font-bold focus:ring-0"
					min={1}
					value={weeks}
					onChange={(e) => (e.target.value = weeks)}
				/>
				<span className="text-center text-xs">Week</span>
			</div>
			<button
				type="button"
				className="flex h-16 w-14 items-center justify-center rounded-tr-xl rounded-br-xl bg-gray-100 text-3xl text-white hover:bg-cyan-400"
				onClick={() => setWeeks((state) => state + 1)}
			>
				+
			</button>
		</div>
	)
}
