<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\ProductRepositoryInterface;

class AuctionController extends Controller
{


    protected $products;

    public function __construct(ProductRepositoryInterface $products)
        {
            $this->products = $products;
        }

    public function index()
        {
            $products = $this->products->getLiveOrUpcoming();

            return view('bidder.auctions.index', compact('products'));
        }

    public function show($id)
        {
            $product = $this->products->find($id);
            return view('bidder.auctions.show', compact('product'));
        }

}
