<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\NewBidPlaced;

use App\Models\Product;

class BidController extends Controller
{


    public function store(Request $request)
    {
        
    
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'amount' => 'required|numeric|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        
        $currentHighest = $product->bids()->max('amount') ?? $product->starting_price;

        
        if ($request->amount <= $currentHighest) {
            return response()->json([
                'success' => false,
                'message' => 'Your bid must be higher than the current highest bid (₹' . $currentHighest . ').'
            ]);
        }

        
        $bid = $product->bids()->create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
        ]);

    
        broadcast(new \App\Events\NewBidPlaced($bid))->toOthers();

        return response()->json(['success' => true]);
    }

}
