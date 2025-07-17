@extends('layouts.admin_bidder_app')
@section('title', 'Live Auction')

@section('content')
<div class="container mt-4">
    <h2>{{ $product->title }}</h2>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Description:</strong> {{ $product->description }}</p>
            <p><strong>Starting Price:</strong> ₹{{ number_format($product->starting_price, 2) }}</p>
            <p><strong>Start Time:</strong> {{ $product->start_time }}</p>
            <p><strong>End Time:</strong> <span id="end-time">{{ $product->end_time }}</span></p>
            <p><strong>Highest Bid:</strong> <span id="highest-bid">₹{{ $product->bids->max('amount') ?? $product->starting_price }}</span></p>
            <p><strong>Time Left:</strong> <span id="countdown" class="text-danger"></span></p>
            
        </div>
        <div class="video-stream mb-4">
            @if ($product->live_stream_id)
            <iframe width="100%" height="400" src="https://www.youtube.com/embed/{{ $product->live_stream_id }}" frameborder="0" allowfullscreen></iframe>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="bidForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="mb-3">
                    <label for="bid_amount" class="form-label">Your Bid (₹)</label>
                    <input type="number" step="0.01" id="bid_amount" name="amount" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Place Bid</button>
            </form>
        </div>
    </div>
    <div class="chat-box">
        <div id="chatMessages" class="border p-2 mb-2" style="height: 200px; overflow-y: scroll;"></div>
        <form id="chatForm">
            <input type="text" id="chatInput" class="form-control" placeholder="Type your message...">
            <button class="btn btn-primary mt-1">Send</button>
        </form>
    </div>
</div>
@endsection

@section('bottom_scripts')
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.3/echo.iife.js"></script>
<!-- <script src="{{ mix('/js/app.js') }}"></script> -->
@vite(['resources/js/app.js'])
<script>
    Pusher.logToConsole = true;

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
        forceTLS: true
    });
  
</script>

<!-- <script>
    window.Echo.channel('auction-chat.{{ $product->id }}')
        .listen('.MessageSent', (e) => {
            $('#chatMessages').append(`<div><strong>${e.user}:</strong> ${e.message}</div>`);
        });

    $('#chatForm').on('submit', function(e) {
        e.preventDefault();
        $.post("{{ route('chat.send') }}", {
            _token: '{{ csrf_token() }}',
            product_id: {{ $product->id }},
            message: $('#chatInput').val()
        }, () => $('#chatInput').val(''));
    });
</script> -->

<script>
    $(document).ready(function () {
        // Submit chat message
        $('#chatForm').on('submit', function(e) {
            e.preventDefault();

            const message = $('#chatInput').val();
            const productId = {{ $product->id }};

            $.post("{{ route('chat.send') }}", {
                _token: '{{ csrf_token() }}',
                product_id: productId,
                message: message
            }, function () {
                $('#chatInput').val('');
            });
        });

    
       if (typeof Echo !== 'undefined') {
            Echo.channel('auction-chat.{{ $product->id }}')
                .listen('.MessageSent', function(e) {
                    $('#chatMessages').append(`<div><strong>${e.user}:</strong> ${e.message}</div>`);
                });
        }
        else {
            console.error("Echo is not defined. Check your app.js or Vite setup.");
        }
    });
</script>






<script>
$(function () {
   
    let endTime = new Date("{{ \Carbon\Carbon::parse($product->end_time)->toIso8601String() }}").getTime();
    let countdownInterval = setInterval(() => {
        let now = new Date().getTime();
        let distance = endTime - now;

        if (distance < 0) {
            clearInterval(countdownInterval);
            $('#countdown').text("Auction Ended");
            return;
        }

        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((distance % (1000 * 60)) / 1000);
        $('#countdown').text(`${minutes}m ${seconds}s`);
    }, 1000);

  
    $('#bidForm').on('submit', function (e) {
        e.preventDefault();
        console.log("🚀 Bid Form Submitted");

        const amount = $('#bid_amount').val();
        const productId = {{ $product->id }};

        $.ajax({
            url: "{{ route('bidder.bids.store') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                product_id: productId,
                amount: amount
            },
            success: function (response) {
                console.log(response);
                if (response.success) {
                    alert(' Bid placed successfully!');
                } else {
                    alert('' + (response.message || 'Bid failed.'));
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert(' Error placing bid.');
            }
        });
    });


    window.Echo.channel('auction.{{ $product->id }}')
        .listen('.NewBidPlaced', function (e) {
            console.log("📡 New bid broadcasted", e);
            $('#highest-bid').text(`₹${e.amount} by ${e.user}`);
        });
});
</script>
@endsection