import React from 'react'
import { Link, Head } from '@inertiajs/inertia-react'
// Import Swiper React components
import { Swiper, SwiperSlide } from 'swiper/react'

// Import Swiper styles
import 'swiper/css'

const sectionData = [
	{
		title: 'Choice',
		content:
			'Choose which lotteries you want to play. You can play your favorite numbers, or “Quick Pick” for a random selection.',
		icon: '',
	},
	{
		title: 'Confirmation',
		content:
			"As soon as your order id processed we'll send you a confirmation of your lottery numbers and dates of play.",
		icon: '',
	},
	{
		title: 'Winnings',
		content:
			"When you win a lotto prize, we'll immediately notify you and deposit your winning in to your Lotto Express account.",
		icon: '',
	},
]

const qualityData = [
	{
		title: 'Exciting',
		content: [
			"The world's most exciting lotteries.",
			'Play for the biggest jackpots on Earth!',
		],
	},
	{
		title: 'Secure',
		content: [
			'Highest security standards in the industry.',
			'Exceeding regulated security requirements.',
			'Frequent system upgrades to keep your data safe.',
		],
	},
	{
		title: 'Honest',
		content: [
			'Service charges are included in the price.',
			'No additional fees to collect your winnings or for any other reason.',
		],
	},
]

export default function Home(props) {
	const SwiperElm = () => {
		return (
			<Swiper
				spaceBetween={50}
				slidesPerView={3}
				onSlideChange={() => {}}
				onSwiper={(swiper) => console.log(swiper)}
			>
				<SwiperSlide className="flex flex-col items-center justify-between bg-amber-100 space-y-2.5 py-6 border-l-8 border-r-8 border-yellow-300/80 rounded-lg">
					<img src="#" />
					<h3>
						<span>Lottery Name</span> <strong>69M</strong>
					</h3>
					<button
						type="button"
						className="bg-gradient-to-r from-orange-400 to-orange-500 text-sm text-white rounded-lg py-2 px-8 shadow-orange-700 shadow-md hover:from-orange-500 hover:to-orange-400"
					>
						Play Now
					</button>
					<span>Meta text here</span>
				</SwiperSlide>
			</Swiper>
		)
	}

	const SectionCard = ({ data }) => (
		<div className="space-y-10 max-w-sm">
			<h3 className="uppercase text-center  text-2xl text-orange-400 font-medium">
				{data.title}
			</h3>
			<p className="text-amber-900">{data.content}</p>
			<img
				className="mx-auto max-w-[80px]"
				src="/images/choice-icon.svg"
			/>
		</div>
	)

	const QualityCard = ({ data }) => (
		<div className="space-y-4 max-w-sm">
			<h3 className="uppercase text-2xl text-green-600 font-medium">
				{data.title}
			</h3>
			<ul className="space-y-3">
				{data.content.map((item, idx) => (
					<li key={idx} className="font-medium text-neutral-800">
						{item}
					</li>
				))}
			</ul>
		</div>
	)

	return (
		<>
			<Head title="Home" />
			{/* Hero section */}
			<section>{/* slider here */}</section>

			{/* Products section */}
			<section className="py-12">
				<div className="container mx-auto">
					<h2 className="text-2xl text-center text-teal-600 font-bold uppercase">
						Play the world's biggest lotteries online at
						jollylotto.com
					</h2>

					<div className="mt-10 max-w-6xl mx-auto">
						<SwiperElm />
					</div>
				</div>
			</section>

			<section className="bg-orange-50 py-14">
				<div className="container mx-auto max-w-6xl">
					<div className="flex justify-between">
						{sectionData.map((data, idx) => (
							<SectionCard key={idx} data={data} />
						))}
					</div>
					<h2 className="text-2xl text-orange-400 text-center mt-16 font-semibold">
						WE DO THE WORK SO YOU CAN HAVE THE FUN!
					</h2>
				</div>
			</section>
			<section className="py-14">
				<div className="container mx-auto max-w-6xl">
					<div className="flex justify-between">
						{qualityData.map((data, idx) => (
							<QualityCard key={idx} data={data} />
						))}
					</div>
				</div>
			</section>
		</>
	)
}
