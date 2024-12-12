<!-----change password model----->
<div class="offcanvas offcanvas-end" tabindex="-1" id="userChangePasswordModal" aria-labelledby="userChangePasswordModalModelLabel" style="width: 50%;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title text-primary" id="userChangePasswordModalModelLabel">Change Password</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="userChangePasswordForm" method="POST">
          @csrf
           <input type="hidden" id="userId" name="id">
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" class="form-control form-control-sm" id="user_password" name="password"  placeholder="Enter password" data-placeholder="Enter new password">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" class="form-control form-control-sm" id="user_password_confirmation" name="password_confirmation"  placeholder="Confirm password" data-placeholder="Confirm password">
                <span id="userPasswordConfirmationError" class="text-danger"></span>
            </div>
            <div class="d-flex justify-content-start">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

</div>
<!----end model----->
