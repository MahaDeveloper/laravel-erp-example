
@extends('Client::layouts.app', ['hideNavbar' => true])
@section('content')

<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-center py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="{{ asset('admin-template/assets/images/pro-icon.png') }}" class="" alt="logo">
              </div>
              <h4>Hello! lets get started</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form class="pt-3" id="loginForm" action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="email" 
                         placeholder="Email" data-placeholder="Email" name="email">
              </div>
              <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="password" 
                         placeholder="Password" data-placeholder="Password" name="password">
              </div>
              <span class="text-danger" id="subscribe"></span>
                @if ($errors->has('email'))
                    <span class="error text-danger">{{ $errors->first('email') }}</span>
                @endif  
                <div class="mt-3 d-grid gap-2">
                    <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit">SIGN IN</button>
                </div>
            </form>
            
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

@endsection


@section('script')
<script>
$(document).ready(function () {
    $('#loginForm').on('submit', function (e) {
        e.preventDefault(); 
        $('#subscribe').text('');
        $('.form-control').removeClass('is-invalid');
        $('.form-control').attr('placeholder', function () {
            return $(this).data('placeholder');
        });

        let formData = $(this).serialize();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response.redirect) {
                    window.location.href = response.redirect;
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;

                    if (errors.email) { 

                      let emailField = $('#email');
                      emailField.addClass('is-invalid');
                      if(errors.email[0] === 'Invalid email or password'){
                        emailField.attr('placeholder', 'Invalid email or password');
                      }else if(errors.email === 'The email field is required.'){
                        emailField.attr('placeholder', 'email required');
                      }else{
                        emailField.attr('placeholder', errors.email);
                      }
                      emailField.val('');
                    }
                   
                    if (errors.password) {
                        let passwordField = $('#password');
                        passwordField.addClass('is-invalid');
                        passwordField.attr('placeholder', 'password required');
                        passwordField.val('');
                    }
                    if(errors.subscribe){
                     $('#subscribe').text(errors.subscribe);
                    }
                }
            },
        });
    });

    
});


</script>
@endsection

