
<!-- partial:partials/_navbar.html -->
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
<div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
<a class="navbar-brand brand-logo me-5" href="{{ route('dashboard') }}"><img src="{{ asset('admin-template/assets/images/p-mini.png') }}" class="me-2" alt="logo" style="width: 80px; height: 50px;" /></a>
<a class="navbar-brand brand-logo-mini" href="index.htm{{ route('dashboard') }}"><img src="{{ asset('admin-template/assets/images/pro-mini.png') }}" alt="logo" /></a>
</div>
<div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
<button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize" id="headNavbarToggle">
<span class="icon-menu"></span>
</button>
<ul class="navbar-nav mr-lg-2">
<li class="nav-item nav-search d-none d-lg-block">
  <div class="input-group">
    <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
      <span class="input-group-text" id="search">
        <i class="icon-search"></i>
      </span>
    </div>
    <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
  </div>
</li>
</ul>
<ul class="navbar-nav navbar-nav-right">
<li class="nav-item dropdown">
  <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
    <i class="icon-bell mx-0"></i>
    <span class="count"></span>
  </a>
  <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
    <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
    <a class="dropdown-item preview-item">
      <div class="preview-thumbnail">
        <div class="preview-icon bg-success">
          <i class="ti-info-alt mx-0"></i>
        </div>
      </div>
      <div class="preview-item-content">
        <h6 class="preview-subject font-weight-normal">Application Error</h6>
        <p class="font-weight-light small-text mb-0 text-muted"> Just now </p>
      </div>
    </a>
    <a class="dropdown-item preview-item">
      <div class="preview-thumbnail">
        <div class="preview-icon bg-warning">
          <i class="ti-settings mx-0"></i>
        </div>
      </div>
      <div class="preview-item-content">
        <h6 class="preview-subject font-weight-normal">Settings</h6>
        <p class="font-weight-light small-text mb-0 text-muted"> Private message </p>
      </div>
    </a>
    <a class="dropdown-item preview-item">
      <div class="preview-thumbnail">
        <div class="preview-icon bg-info">
          <i class="ti-user mx-0"></i>
        </div>
      </div>
      <div class="preview-item-content">
        <h6 class="preview-subject font-weight-normal">New user registration</h6>
        <p class="font-weight-light small-text mb-0 text-muted"> 2 days ago </p>
      </div>
    </a>
  </div>
</li>
<li class="nav-item nav-profile dropdown">
  <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
    <img src="{{ asset('admin-template/assets/images/user.png') }}" alt="profile" />
  </a>
 
  <div class="dropdown-menu dropdown-menu-right navbar-dropdown " aria-labelledby="profileDropdown">
    <div class="bg-light p-2">
      <h5 class="text-center text-bold text-primary mt-1 ">{{ Auth::user()->name }}</h5>
    </div>
    <h6 class="border-bottom border-2 mx-2"></h6>
    <a class="dropdown-item" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#changePasswordModal" aria-controls="changePasswordModal">
      <i class="ti-settings text-primary"></i> Change Password </a>
    <a class="dropdown-item" href="{{ route('logout') }}">
      <i class="ti-power-off text-primary"></i> Logout </a>
  </div>
</li>
{{-- <h5 class="text-center text-bold text-primary mt-1 ">{{ Auth::user()->name }}</h5> --}}
</ul>
<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
<span class="icon-menu"></span>
</button>
</div>
</nav>


<!-----change password model----->
<div class="offcanvas offcanvas-end" tabindex="-1" id="changePasswordModal" aria-labelledby="changePasswordModalLabel" style="width: 50%;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title text-primary" id="changePasswordModalLabel">Change Password</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('update-pw') }}" id="changePasswordForm" method="POST">
          @csrf
          <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" class="form-control form-control-sm" id="current_password" name="current_password" 
                   placeholder="Enter current password" data-placeholder="Enter current password">
            <span id="currentPasswordError" class="text-danger "></span>
        </div>
        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" class="form-control form-control-sm" id="password" name="password"  placeholder="Enter new password" data-placeholder="Enter new password">
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control form-control-sm" id="password_confirmation" name="password_confirmation"  placeholder="Confirm new password" data-placeholder="Confirm new password">
            <span id="passwordConfirmationError" class="text-danger "></span>
        </div>
          <div class="d-flex justify-content-start">
              <button type="submit" class="btn btn-primary">Submit</button>
        
          </div>
      </form>
    

    </div>

</div>
<!----end model----->
