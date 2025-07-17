<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class AdminBidMonitorController extends Controller
{
   protected $products;

    public function __construct(ProductRepositoryInterface $products)
    {
        $this->products = $products;
    }

  
    public function index()
    {
       
         $products = $this->products->all();
        return view('admin.bids.index', compact('products'));
    }

    public function monitor($auctionId)
    {
            $product = $this->products->find($auctionId);
        return view('admin.bids.monitor', compact('product'));
    }


}
