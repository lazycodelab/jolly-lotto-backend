<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class SavedDetailsController extends Controller
{
    public function index()
	{
        $products = session('products');
        return $products;
	}

    public function store(Request $request) {
        $products = $request->session()->get('products', []);
        $productData = [
            'productID' => $request->productDetails['id'],
            'productName' => $request->productDetails['name'],
            'unitPrice' => $request->price,
            'weekNumber' => $request->weeks,
            'selectedDrawDays' => $request->selectedDrawDays,
            'drawDays' => $request->drawDays,
            'lotteryLines' => $request->lotteryLines
        ];
        $products[$productData['productID']] = $productData;
        $products[$productData['productID']]['time'] = time();
        $request->session()->put('products', $products);

        return response()->json(['status' => 'success', 'message' => 'Product data saved successfully']);
    }
}
