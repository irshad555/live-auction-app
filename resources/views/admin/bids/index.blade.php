@extends('layouts.admin_bidder_app')
@section('title', 'All Auctions')

@section('content')
<div class="container mt-4">
    <h3>All Auctions</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Start</th>
                <th>End</th>
                <th>Bids</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->title }}</td>
                <td>{{ $product->start_time }}</td>
                <td>{{ $product->end_time }}</td>
                <td>{{ $product->bids->count() }}</td>
                <td>
                    <a href="{{ route('admin.bids.monitor', $product->id) }}" class="btn btn-sm btn-primary">
                        Monitor
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
