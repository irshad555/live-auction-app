 <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="./index.html" class="brand-link">
            <!--begin::Brand Image-->
            <img
              src="{{ asset('/assets/img/AdminLTELogo.png')}}"
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">Live Auction</span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
  <nav class="mt-2">
    <!--begin::Sidebar Menu-->
    <ul class="nav sidebar-menu flex-column"
        data-lte-toggle="treeview"
        role="navigation"
        aria-label="Main navigation"
        data-accordion="false"
        id="navigation">

      @role('admin')

      <li class="nav-item">
        <a href="{{ route('admin.dashboard') }}" class="nav-link active">
          <i class="nav-icon bi bi-speedometer"></i>
          <p>Dashboard</p>
        </a>
      </li>

       <li class="nav-item">
        <a href="{{ route('admin.products.index') }}" class="nav-link active">
          <i class="nav-icon bi bi-speedometer"></i>
          <p>Products</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('admin.bids.index') }}" class="nav-link active">
          <i class="nav-icon bi bi-speedometer"></i>
          <p>Monitor Bids</p>
        </a>
      </li>
      @endrole

      @role('bidder')
      <li class="nav-item">
        <a href="{{ route('bidder.dashboard') }}" class="nav-link active">
          <i class="nav-icon bi bi-speedometer"></i>
          <p>Dashboard</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('bidder.auctions.index') }}" class="nav-link">
          <i class="nav-icon bi bi-megaphone"></i>
          <p>Live Auctions</p>
        </a>
      </li>
     
      @endrole

    </ul>
    <!--end::Sidebar Menu-->
  </nav>
</div>
<!--end::Sidebar Wrapper-->
</aside>
