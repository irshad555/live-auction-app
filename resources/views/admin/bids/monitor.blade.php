@extends('layouts.admin_bidder_app')
@section('title','Auction Monitor')

@section('content')
<main class="app-main">
   <div class="app-content-header">
      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-6">
               <h3 class="mb-0">Auction Monitor</h3>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Auction Monitor</li>
               </ol>
            </div>
         </div>
      </div>
   </div>

   <div class="app-content">
      <div class="row">
         <div class="col-md-12">
            <div class="card mb-3">
               <div class="card-body">
                  <h2>{{ $product->title }}</h2>
                  <p><strong>Start:</strong> {{ $product->start_time }}</p>
                  <p><strong>End:</strong> {{ $product->end_time }}</p>
                  <div id="highest-bid" class="h4 text-success">
                     Highest Bid: ₹{{ $product->bids->max('amount') ?? '0' }}
                  </div>
                  <div class="video-stream mb-4">
                     @if ($product->live_stream_id)
                     <iframe width="100%" height="400" src="https://www.youtube.com/embed/{{ $product->live_stream_id }}" frameborder="0" allowfullscreen></iframe>
                     @endif
                  </div>
               </div>
            </div>

            <div class="card">
               <div class="card-header">
                  <strong>Live Bids</strong>
               </div>
               <div class="card-body p-0">
                  <table class="table table-striped mb-0">
                      <thead class="table-light">
                          <tr>
                              <th>User</th>
                              <th>Amount</th>
                              <th>Time</th>
                          </tr>
                      </thead>
                      <tbody id="bidsTableBody">
                          @foreach($product->bids->sortByDesc('created_at') as $bid)
                          <tr>
                              <td>{{ $bid->user->name ?? 'N/A' }}</td>
                              <td>₹{{ $bid->amount }}</td>
                              <td>{{ $bid->created_at->format('H:i:s') }}</td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
               </div>
            </div>

         </div>
      </div>
   </div>
</main>
@endsection
@section('bottom_scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const productId = {{ $product->id }};

// Real-time bid updates
window.Echo.channel('auction.' + productId)
    .listen('.NewBidPlaced', (e) => {
        // Update highest bid text
        document.getElementById('highest-bid').innerText = `Highest Bid: ₹${e.amount} by ${e.user}`;

        // Add new bid row
        const tableBody = document.getElementById('bidsTableBody');
        const row = `
            <tr>
                <td>${e.user}</td>
                <td>₹${e.amount}</td>
                <td>${e.time}</td>
            </tr>
        `;
        tableBody.insertAdjacentHTML('afterbegin', row);
    });
</script>
@endsection
