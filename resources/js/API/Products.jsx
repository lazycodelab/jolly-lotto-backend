import axios from 'axios'
import { useEffect, useState } from 'react'

//@todo: fix this entire logic.
export default function Products() {
	// make an api call here to fetch all the produscst.
	const [products, setProducts] = useState([])

	useEffect(() => {
		const response = axios.get('/products')
		response.then(({ data }) => {
			setProducts(data)
		})
	}, [])

	return products
}
