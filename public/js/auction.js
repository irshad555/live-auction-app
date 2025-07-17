let productId = window.productId;

window.Echo.channel('auction.' + productId)
    .listen('NewBidPlaced', (e) => {
        document.getElementById('highest-bid').innerText = `Highest Bid: ₹${e.amount} by ${e.user}`;
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

window.Echo.channel('auction.' + productId)
    .listen('AuctionEnded', (e) => {
        document.getElementById('auctionStatus').innerText = 'Status: Closed';
        document.getElementById('submitBid').disabled = true;
    });

document.getElementById('submitBid')?.addEventListener('click', function () {
    fetch("bidder/bids", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        body: JSON.stringify({
            product_id: productId,
            amount: document.getElementById('bid_amount').value
        })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.success ? 'Bid placed successfully!' : 'Failed to place bid.');
    });
});
