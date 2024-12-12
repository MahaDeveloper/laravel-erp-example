@extends('Client::layouts.app')
<style>
    .image-preview {
        max-width: 300px;
        max-height: 300px;
        margin-top: 15px;
    }

    .image-container {
        display: none;
    }

    #users-table th,
        #users-table td {
            padding: 15px;
    }

</style>

@section('content')
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper">
            @include('Client::layouts.sidebar')

            <div class="main-panel">

                <div class="content-wrapper">
                    <div class="container">

                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h3 class="text-primary">User List</h3>
                                        <button class="btn btn-primary" data-bs-toggle="offcanvas"
                                            data-bs-target="#addUserModel" aria-controls="addUserModel">Add User</button>
                                    </div>
                                    <div class="table-responsive ">
                                        <table class="table mt-3 " style="width:80%;" id="users-table">
                                            <thead class="table-light border-top border-bottom text-start">
                                                <tr>
                                                    <th> S.No. </th>
                                                    <th> Name </th>
                                                    <th> Email </th>
                                                    <th> Mobile </th>
                                                    <th> Created Date </th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-start">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

<!-----add client model ----->
     <div class="offcanvas offcanvas-end" data-bs-backdrop="false" tabindex="-1" id="addUserModel"
     aria-labelledby="addUserModelLabel" style="width: 50%;">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title text-primary" id="addUserModelLabel">Add User</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="addUserForm" action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control form-control-sm " id="nameError" name="name"
                                placeholder="Enter name">
                        </div>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Email</label>
                            <input type="email" class="form-control form-control-sm " id="emailError" name="email"
                                placeholder="Enter email">
                        </div>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Mobile</label>
                            <input type="text" class="form-control form-control-sm " id="mobileError" name="mobile"
                                placeholder="Enter mobile number">
                        </div>
                        @error('mobile')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @php $roles = DB::table('roles')->where('id', '!=', 1)->get(); @endphp
                    <div class="col-md-6">
                        <div class="form-group">
                            <label >Select Role</label>
                            <select class="form-select form-select-sm text-dark" id="roleSelect" name="role">
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                            </select>
                            <span class="text-danger" id="roleError"></span>
                        </div>
                        @error('role')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @if(Auth::user()->is_primary === 1)
                    @php $clients = DB::table('clients')->where('id', '!=', 1)->get(); @endphp
                    <div class="col-md-6">
                        <div class="form-group">
                            <label >Select Client</label>
                            <select class="form-select form-select-sm text-dark" id="clientSelect" name="client_id">
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->company_name }}</option>
                            @endforeach
                            </select>
                            <span class="text-danger" id="clientError"></span>
                        </div>
                        @error('client_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @endif
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
 <!-----end model----->


 <!-----update user model ----->
 <div class="offcanvas offcanvas-end" data-bs-backdrop="false" tabindex="-1" id="editUserModel"
 aria-labelledby="editUserModelLabel" style="width: 50%;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title text-primary" id="editUserModelLabel">Edit User</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="userUpdateForm" method="POST" >
            @csrf
            <input type="hidden" id="editUserId" name="id">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control form-control-sm " id="name" name="name"
                            placeholder="Enter name">
                    </div>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Email</label>
                        <input type="email" class="form-control form-control-sm " id="email" name="email"
                            placeholder="Enter email">
                    </div>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Mobile</label>
                        <input type="text" class="form-control form-control-sm " id="mobile" name="mobile"
                            placeholder="Enter mobile number">
                    </div>
                    @error('mobile')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                @php
                    $roles = DB::table('roles')->where('id', '!=', 1)->get();
                    $selcted_role_id = DB::table('model_has_roles')->where('model_type','App\Modules\Client\Models\User')->where('model_id',Auth::user()->id)->value('role_id');
                    $selected_role = DB::table('roles')->find($selcted_role_id);
                @endphp
                <div class="col-md-6">
                <div class="form-group">
                    <label >Select Role</label>
                    <select class="form-select form-select-sm text-dark" id="editRoleSelect" name="role">
                        <option value="{{  $selected_role->name }}" selected>{{  $selected_role->name }}</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger" id="roleError"></span>
                </div>
                @error('role')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-----end model----->


@include('Client::user.change-password')

@endsection

@section('script')
    <script>
        //client list
        $(document).ready(function() {

            //user list
            var usersTable = new DataTable('#users-table', {
                processing: true,
                serverSide: true,
                paging: true,
                info: true,
                scrollX: false,
                ordering: true,
                ajax: "{{ route('users.list') }}",
                columns: [{data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email',name: 'email'},
                    {data: 'mobile',name: 'mobile'},
                    { data: 'created_at',name: 'created_at',
                        render: function(data, type, row) {
                            return dayjs(data).format('YYYY-MM-DD h:mm A');
                        }
                    },
                    {
                        data: 'action', name: 'action',orderable: false,searchable: false
                    }
                ],
                lengthMenu: [10, 25, 50, 100],
                responsive: true,
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
                order: [
                    [0, 'desc']
                ],

                // Custom rendering for sorting icons
                initComplete: function() {
                    $('#users-table thead th').each(function(index) {
                        if (index !== 5) {
                            $(this).css('position', 'relative').append(
                                '<span class="custom-sorting-icons" style="position:absolute; font-size:14px; color:#4B49AC;">' +
                                '<i class="mdi mdi-arrow-up"></i>' +
                                '<i class="mdi mdi-arrow-down"></i>' +
                                '</span>'
                            );
                        }
                    });
                },

                drawCallback: function() {
                    $('#users-table thead th').removeClass('sorting sorting_asc sorting_desc');
                },
            });

            //add user
            $("#addUserForm").on("submit", function(e) {
                e.preventDefault();
                $('#roleError').text('');
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                });
                var formData = new FormData(
                    document.getElementById("addUserForm")
                );

                $.ajax({
                    url: $(this).attr("action"),
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: response.success,
                                showConfirmButton: false,
                                timer: 1500,
                            });
                            $('#addUserForm')[0].reset();

                            // Close the offcanvas modal
                            var offcanvasElement = document.getElementById('addUserModel');
                            var offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
                            offcanvas.hide();

                            usersTable.ajax.reload(null, false);
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.email) {
                                let emailField = $('#emailError');
                                emailField.addClass('is-invalid');
                                emailField.attr('placeholder', errors.email);
                                emailField.val('');
                            }
                            if (errors.name) {
                                let nameField = $('#nameError');
                                nameField.addClass('is-invalid');
                                nameField.attr('placeholder', 'name required');
                                nameField.val('');
                            }
                            if (errors.mobile) {
                                let mobileField = $('#mobileError');
                                mobileField.addClass('is-invalid');
                                mobileField.attr('placeholder', errors.mobile);
                                mobileField.val('');
                            }
                            if (errors.role) {
                                $('#roleError').text(errors.role);
                            }


                        } else {
                            alert('An unexpected error occurred. Please try again.');
                        }
                    },
                });

            });

            //add user modal
            $('#addUserModel').on('hidden.bs.offcanvas', function() {
                $('#creatClientForm')[0].reset();
                $('#nameError, #emailError, #mobileError,#roleError').removeClass('is-invalid').attr('placeholder', '').val('');
                $('#roleError').text('');

            });

            $('#nameError, #emailError, #mobileError').on('click',function() {
                $(this).removeClass('is-invalid');

            });

            $('#roleSelect').on('change', function(){

                $('#roleError').text('');
            });

            //edit, update user
            $(document).on('click', '.edit-user', function() {
                let userId = $(this).data('id');
                $.ajax({
                    url: "{{ route('users.edit', '') }}/" + userId,
                    type: 'GET',
                    success: function(response) {

                        $('#editUserId').val(response.user.id);

                        $('#name').val(response.user.name);
                        $('#mobile').val(response.user.mobile);
                        $('#email').val(response.user.email);

                    },
                });

                $('#userUpdateForm').on('submit', function(e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    console.log(formData);

                    $.ajax({
                        url: "{{ route('users.update', '') }}/" + userId,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "User updated successfully",
                                showConfirmButton: false,
                                timer: 1000
                            });
                            $('#userUpdateForm')[0].reset();
                            var offcanvasElement = document.getElementById(
                                'editUserModel');
                            var offcanvas = bootstrap.Offcanvas.getInstance(
                                offcanvasElement);
                            offcanvas.hide();

                            usersTable.ajax.reload(null, false);
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.email) {
                                let emailField = $('#email');
                                emailField.addClass('is-invalid');
                                emailField.attr('placeholder', errors.email);
                                emailField.val('');
                            }
                            if (errors.name) {
                                let nameField = $('#name');
                                nameField.addClass('is-invalid');
                                nameField.attr('placeholder', 'name required');
                                nameField.val('');
                            }
                            if (errors.mobile) {
                                let mobileField = $('#mobile');
                                mobileField.addClass('is-invalid');
                                mobileField.attr('placeholder', errors.mobile);
                                mobileField.val('');
                            }
                            } else {
                                alert('An unexpected error occurred. Please try again.');
                            }
                        }

                    });
                });

            });

             //add user modal
             $('#editUserModel').on('hidden.bs.offcanvas', function() {
                $('#userUpdateForm')[0].reset();
                $('#name, #email, #mobile,#role').removeClass('is-invalid').attr('placeholder', '').val('');
                $('#role').text('');

            });

            //change password
            $(document).on('click', '.change-password', function () {

                let userId = $(this).data('id');
                $('#userId').val(userId);

                // change password form
                $('#userChangePasswordForm').off('submit').on('submit', function (e) {
                    alert('dddddd');

                    e.preventDefault();
                    $('#userPasswordConfirmationError').text('');

                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                    });
                    var formData = new FormData(this);

                    $('.form-control').removeClass('is-invalid');
                    $('.form-control').attr('placeholder', function () {
                        return $(this).data('placeholder');
                    });

                    $.ajax({
                        url:"{{route('user.change-pw', '')}}/"+userId,
                        type: 'POST',
                        data: formData,
                        success: function (response) {
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: response.success,
                                showConfirmButton: false,
                                timer: 1000,
                            });

                            form[0].reset();

                        },
                        error: function (xhr) {
                            if (xhr.status === 422) {
                            let response = xhr.responseJSON;

                            if (response.errors) {
                                let errors = response.errors;

                                if (errors.password && errors.password[0] === 'The password field is required.') {
                                    let passwordField = $('#user_password');
                                    passwordField.addClass('is-invalid');
                                    passwordField.attr('placeholder', 'Password required');
                                    passwordField.val('');
                                } else if (errors.password && errors.password[0] === 'The password field confirmation does not match.') {
                                    $('#userPasswordConfirmationError')
                                        .removeClass('d-none')
                                        .text('Password confirmation does not match.');
                                }

                                if (errors.user_password_confirmation) {
                                    let passwordConfirmationField = $('#user_password_confirmation');
                                    passwordConfirmationField.addClass('is-invalid');
                                    passwordConfirmationField.attr('placeholder', 'Password confirmation required');
                                    passwordConfirmationField.val('');
                                }
                            }

                        } else {
                            alert('An unexpected error occurred. Please try again.');
                        }

                        },
                    });

                });

                $('#password, #password_confirmation').on('input', function(){
                    $(this).removeClass('is-invalid');
                    $('#userPasswordConfirmationError').text('');
                });

                $('#userChangePasswordModal').on('hidden.bs.offcanvas', function () {

                    $('#userChangePasswordForm')[0].reset();
                    $('#password, #password_confirmation').removeClass('is-invalid').attr('placeholder', '').val('');
                });
            });

        });
    </script>
@endsection
