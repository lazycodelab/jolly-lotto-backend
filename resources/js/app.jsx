import './bootstrap'
import '../css/app.css'

import React from 'react'
import { createRoot } from 'react-dom/client'
import { createInertiaApp } from '@inertiajs/inertia-react'
import { InertiaProgress } from '@inertiajs/progress'
import Layout from './Shared/Layout'

const appName =
	window.document.getElementsByTagName('title')[0]?.innerText || 'Welcome'

createInertiaApp({
	title: (title) => `${title} - ${appName}`,
	resolve: async (name) => {
		let page = (await import(`./Pages/${name}`)).default

		page.layout ??= (page) => <Layout children={page} />

		return page
	},
	setup({ el, App, props }) {
		const root = createRoot(el)

		root.render(<App {...props} />)
	},
})

InertiaProgress.init({ color: '#4B5563' })
