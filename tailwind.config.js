const defaultTheme = require('tailwindcss/defaultTheme')

/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
		'./storage/framework/views/*.php',
		'./resources/views/**/*.blade.php',
		'./resources/js/**/*.jsx',
	],

	theme: {
		extend: {
			fontFamily: {
				heebo: ['Heebo', ...defaultTheme.fontFamily.sans],
				lato: ['Lato', ...defaultTheme.fontFamily.sans],
				'open-sans': ['"Open Sans"', ...defaultTheme.fontFamily.sans],
			},
		},
	},

	plugins: [require('@tailwindcss/forms')],
}
