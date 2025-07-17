<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductStatus;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ProductRepository implements ProductRepositoryInterface
{
    public function all()
    {
        return Product::with(['bids', 'status'])->latest()->get();
    }

    public function find($id)
    {

         return Product::with('bids')->findOrFail($id);
    }

    public function store($request)
    {
        $product = new Product();
        $product->title = $request->title;
        $product->description = $request->description;
        $product->starting_price = $request->starting_price;
        $product->start_time = $request->start_time;
        $product->end_time = $request->end_time;
        $product->live_stream_id = $request->live_stream_id;
        $product->created_by = Auth::user()->id;
        $product->status_id = ProductStatus::upcoming()->id;
         DB::transaction(function () use ($product) {
           $product->save();
        });
        return $product;
    }

   public function update( $request,$id)
    {
     
        $product = Product::findOrFail($id);

        $product->title = $request->title;
        $product->description = $request->description;
        $product->starting_price = $request->starting_price;
        $product->start_time = $request->start_time;
        $product->end_time =  $request->end_time;
        $product->live_stream_id = $request->live_stream_id;
        $product->updated_by = Auth::user()->id;

        DB::transaction(function () use ($product) {
            $product->save();
        });

        return $product;
    }


    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $product = Product::findOrFail($id);
            $product->delete();
            return true;
        });
    }

    public function getLiveOrUpcoming()
    {
        return Product::whereIn('status_id', [
            ProductStatus::live()->id,
            ProductStatus::upcoming()->id
        ])->get();
    }
}
