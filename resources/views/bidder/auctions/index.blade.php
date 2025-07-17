@extends('layouts.admin_bidder_app')

@section('title', 'Available Auctions')

@section('content')
<div class="container mt-4">
    <h2>Available Auctions</h2>

    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5>{{ $product->title }}</h5>
                        <p>Starting Price: ₹{{ $product->starting_price }}</p>
                        <p>Ends: {{ $product->end_time }}</p>
                        <a href="{{ route('bidder.auctions.show', $product->id) }}" class="btn btn-sm btn-primary">Join Auction</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
