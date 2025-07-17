<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductController extends Controller
{
    protected $products;

    public function __construct(ProductRepositoryInterface $products)
    {
        $this->products = $products;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->products->all();
        return view('admin.products.index', compact('products'));
    }

 
    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = $this->products->store($request);
        return response()->json(['success' => true, 'product' => $product]);
    }

    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = $this->products->find($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request,$id)
    {
        $product = $this->products->update($request,$id);
        return response()->json(['success' => true, 'product' => $product]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       $this->products->delete($id);
        return response()->json(['success' => true]);
    }
}
