import React from 'react'

export default ({ className }) => {
	return (
		<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 56.793 61"
			className={className}
		>
			<defs>
				<linearGradient
					id="linear-gradient"
					x1="0.022"
					x2="0.976"
					y1="0.135"
					y2="0.89"
					gradientUnits="objectBoundingBox"
				>
					<stop offset="0" stopColor="#ffa319"></stop>
					<stop offset="1" stopColor="#fe7b0a"></stop>
				</linearGradient>
				<filter
					id="Ellipse_4"
					width="56.793"
					height="58.793"
					x="0"
					y="1"
					filterUnits="userSpaceOnUse"
				>
					<feOffset dy="2"></feOffset>
					<feGaussianBlur result="blur"></feGaussianBlur>
					<feFlood floodColor="#d27421"></feFlood>
					<feComposite in2="blur" operator="in"></feComposite>
					<feComposite in="SourceGraphic"></feComposite>
				</filter>
				<filter
					id="_"
					width="25"
					height="61"
					x="17"
					y="0"
					filterUnits="userSpaceOnUse"
				>
					<feOffset dx="1" dy="1"></feOffset>
					<feGaussianBlur result="blur-2"></feGaussianBlur>
					<feFlood floodColor="#873b00"></feFlood>
					<feComposite in2="blur-2" operator="in"></feComposite>
					<feComposite in="SourceGraphic"></feComposite>
				</filter>
			</defs>
			<g data-name="Group 6761">
				<g
					filter="url(#Ellipse_4)"
					transform="translate(-971 -179) translate(971 179)"
				>
					<circle
						cx="28.397"
						cy="28.397"
						r="28.397"
						fill="url(#linear-gradient)"
						data-name="Ellipse 4"
						transform="translate(0 1)"
					></circle>
				</g>
				<g
					filter="url(#_)"
					transform="translate(-971 -179) translate(971 179)"
				>
					<text
						fill="#fff"
						data-name="+"
						fontFamily="Heebo-Bold, Heebo"
						fontSize="41"
						fontWeight="700"
						transform="translate(29 43)"
					>
						<tspan x="-11" y="0">
							+
						</tspan>
					</text>
				</g>
			</g>
		</svg>
	)
}
