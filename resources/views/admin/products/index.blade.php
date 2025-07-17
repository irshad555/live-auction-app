@extends('layouts.admin_bidder_app')
@section('title','products')
@section('top_scripts')
 <!-- jQuery CDN (required for DataTables) -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

  <!-- DataTables JS CDN -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
@endsection
@section('style')

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

@endsection
@section('content')
<!--begin::App Main-->
<main class="app-main">
   <!--begin::App Content Header-->
   <div class="app-content-header">
      <!--begin::Container-->
      <div class="container-fluid">
         <!--begin::Row-->
         <div class="row">
            <div class="col-sm-6">
               <h3 class="mb-0">Products</h3>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">products</li>
               </ol>
            </div>
         </div>
         <!--end::Row-->

  <div class="d-flex align-items-center flex-wrap text-nowrap">
  
   <button id="addProduct" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
  <i class="btn-icon-prepend" data-feather="plus"></i>
  Add Product
</button>

   
  </div>


      </div>
      <!--end::Container-->
   </div>
   <!--end::App Content Header-->
   <!--begin::App Content-->
   <div class="app-content">
      <!--begin::Container-->

 



         <!--begin::Row-->
         <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table id="dataTableExample" class="table display" style="width:100%">
    <thead>
      
            <tr>
            <th>Title</th>
            <th>Starting Price</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
      
    </thead>
    <tbody>
     @foreach ($products as $product)
        <tr data-id="{{ $product->id }}">
            <td>{{ $product->title }}</td>
            <td>${{ $product->starting_price }}</td>
            <td>{{ $product->start_time }}</td>
            <td>{{ $product->end_time }}</td>
            <td> <span class="badge" style="background-color:{{$product->Status['colour_code']}}">
              {{ $product->status->title }}
          </span></td>
            <td>
                <button class="btn btn-sm btn-warning editProduct">Edit</button>
                <button class="btn btn-sm btn-danger deleteProduct">Delete</button>
            </td>
        </tr>
        @endforeach
    
    </tbody>
  </table>
        </div>
      </div>
    </div>
  </div>
        </div>
     </div>
    </div>
    
</main>
<!--end::App Main-->
<!-- Add/Edit Modal (use Bootstrap modal or your own) -->

<!-- Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
      <div id="productModal" style="display:none;">
    <form id="productForm">
        @csrf
        <input type="hidden" id="product_id">
        <input type="text" name="title" id="title" placeholder="Title" class="form-control">
        <input type="text" name="starting_price" id="starting_price" placeholder="Price" class="form-control">
       <label for="start_time" class="form-label">Start Time</label>
        <input type="datetime-local" name="start_time" id="start_time" class="form-control">
        <label for="end_time" class="form-label">End Time</label>
        <input type="datetime-local" name="end_time" id="end_time" class="form-control">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control"></textarea>
        <label for="live_stream_id" class="form-label">Live Stream ID</label>
        <input type="text" name="live_stream_id" id="live_stream_id" class="form-control" placeholder="e.g. YouTube Video ID">
        <button type="submit" class="btn btn-success mt-2">Save</button>
    </form>
</div>
      </div>
    </div>
  </div>
</div>





@endsection
@section('bottom_scripts')

<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace();

    $('#addProduct').on('click', function () {
        $('#addProductModal').modal('show');
    });
</script>

<!-- Initialize DataTable -->
  <script>
    $(document).ready(function () {
      $('#dataTableExample').DataTable();
    });





$(document).ready(function () {
    // Add product
    $('#addProduct').click(function () {
        $('#product_id').val('');
        $('#productForm')[0].reset();
        $('#productModal').show();
    });

});
</script>

<script>
$(document).ready(function () {
    // Edit
    $('.editProduct').click(function () {
        let id = $(this).closest('tr').data('id');
        let editUrl = "{{ route('admin.products.edit', ':id') }}".replace(':id', id);
       
        $.get(editUrl, function (data) {
            $('#product_id').val(data.id);
            $('#title').val(data.title);
            $('#starting_price').val(data.starting_price);
            $('#start_time').val(data.start_time);
            $('#end_time').val(data.end_time);
            $('#description').val(data.description);
            $('#live_stream_id').val(data.live_stream_id);
            $('#productModal').show();
            $('#addProductModal').modal('show');
        });
    });

    // Submit
    $('#productForm').submit(function (e) {
        e.preventDefault();
        let id = $('#product_id').val();
        let url = id
            ? "{{ route('admin.products.update', ':id') }}".replace(':id', id)
            : "{{ route('admin.products.store') }}";

        let method = id ? 'PUT' : 'POST';
        let data = $(this).serialize();
        if (id) {
            data += '&_method=PUT';
        }

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: function () {
                alert('Saved!');
                location.reload();
            }
        });
    });

    // Delete
    $('.deleteProduct').click(function () {
        if (confirm('Delete this product?')) {
            let id = $(this).closest('tr').data('id');
            let deleteUrl = "{{ route('admin.products.destroy', ':id') }}".replace(':id', id);

            $.ajax({
                url: deleteUrl,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function () {
                    alert('Deleted!');
                    location.reload();
                }
            });
        }
    });
});
</script>

<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace(); 
</script>
@endsection