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

    #clients-table th,
        #clients-table td {
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
                                        <h3 class="text-primary">Client List</h3>
                                        <button class="btn btn-primary" data-bs-toggle="offcanvas"
                                            data-bs-target="#addClientModel" aria-controls="addClientModel">Add Client</button>
                                    </div>
                                    <div class="table-responsive ">
                                        <table class="table mt-3 " style="width:80%;" id="clients-table">
                                            <thead class="table-light border-top border-bottom text-start">
                                                <tr>
                                                    <th> S.No. </th>
                                                    <th> Company Name </th>
                                                    <th> Company Logo</th>
                                                    <th> Email </th>
                                                    <th> Mobile </th>
                                                    <th> Created Date </th>
                                                    <th class="">Action</th>
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
    <div class="offcanvas offcanvas-end" data-bs-backdrop="false" tabindex="-1" id="addClientModel"
        aria-labelledby="addClientModelLabel" style="width: 50%;">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title text-primary" id="addClientModelLabel">Add Client</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="addClientForm" action="{{ route('client.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Company Name</label>
                            <input type="text" class="form-control form-control-sm " id="companyNameError"
                                name="company_name" placeholder="Enter company name">

                        </div>
                        @error('company_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                 
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Address</label>
                            <input type="text" class="form-control form-control-sm " id="addressError" name="address"
                                placeholder="Enter address">
                        </div>
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">State</label>
                            <input type="text" class="form-control form-control-sm " id="stateError" name="state"
                                placeholder="Enter state">
                        </div>
                        @error('state')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Country</label>
                            <input type="text" class="form-control form-control-sm " id="countryError" name="country"
                                placeholder="Enter country">
                        </div>
                        @error('country')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Pin Code</label>
                            <input type="text" class="form-control form-control-sm " id="pincodeError" name="pin_code"
                                placeholder="Enter pincode">
                        </div>
                        @error('pin_code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Company Logo</label>
                            <input class="form-control form-control-sm" type="file" id="company_logo"
                                name="company_logo">
                                <span class="text-danger" id="companyLogoError"></span>
                        </div>
                       
                        <!-- Image Preview -->
                        <div class="image-container">
                            <img id="imagePreview" class="image-preview" src="{{ asset('') }}" alt="Image Preview" width="100">
                        </div>
                        @error('company_logo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="mt-5">
                            <div class="form-check form-check-primary">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="subscribe" >
                                    Subscribe </label>
                                    <span class="text-danger" id="subscribeError"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <!-----end model----->

    <!-----update client model ----->
    <div class="offcanvas offcanvas-end" data-bs-backdrop="false" tabindex="-1" id="editClientModel"
        aria-labelledby="editClientModelLabel" style="width: 50%;">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title text-primary" id="editClientModelLabel">Edit Client</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="clientUpdateForm" method="POST" >
                @csrf
                <input type="hidden" id="clientId" name="id">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Company Name</label>
                            <input type="text" class="form-control form-control-sm " id="companyName"
                                name="company_name" placeholder="Enter company name">

                        </div>
                        @error('company_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                 
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Address</label>
                            <input type="text" class="form-control form-control-sm " id="address" name="address"
                                placeholder="Enter address">
                        </div>
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">State</label>
                            <input type="text" class="form-control form-control-sm " id="state" name="state"
                                placeholder="Enter state">
                        </div>
                        @error('state')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Country</label>
                            <input type="text" class="form-control form-control-sm " id="country" name="country"
                                placeholder="Enter country">
                        </div>
                        @error('country')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Pin Code</label>
                            <input type="text" class="form-control form-control-sm " id="pincode" name="pin_code"
                                placeholder="Enter pincode">
                        </div>
                        @error('pin_code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Company Logo</label>
                            <input class="form-control form-control-sm" type="file" id="companyLogoUpdate"
                                name="company_logo">
                                <span class="text-danger" id="companyLogoUpdateError"></span>
                        </div>
                       <div>
                        <img src="{{ asset('') }}" alt="" id="companyLogoImage" width="100">
                       </div>
                        <!-- Image Preview -->
                        <div class="image-container">
                            <img id="imagePreview1" class="image-preview" src="{{ asset('') }}" alt="Image Preview" width="100">
                        </div>
                        @error('company_logo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="mt-5">
                            <div class="form-check form-check-primary">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="subscribe" >
                                    Subscribe </label>
                                    <span class="text-danger" id="subscribe"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <!-----end model----->

@endsection

@section('script')
    <script>
       
        $(document).ready(function() {

            //preview company logo image
            $("#company_logo").change(function(event) {
                $('#companyLogoError').text('');
               
                let reader = new FileReader();
                reader.onload = function() {
                    $("#imagePreview").attr("src", reader.result);
                    $(".image-container").show();
                };
                reader.readAsDataURL(event.target.files[0]);
            });

            $("#companyLogoUpdate").change(function(event) {
                $('#companyLogoUpdateError').text('');
                
                let reader = new FileReader();
                reader.onload = function() {
                    $("#imagePreview1").attr("src", reader.result);
                    $(".image-container").show();
                };
                reader.readAsDataURL(event.target.files[0]);

            });

            //client list
            var clientsTable = new DataTable('#clients-table', {
                processing: true,
                serverSide: true,
                paging: true,
                info: true,
                scrollX: false,
                ordering: true,
                ajax: "{{ route('clients.list') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'company_logo',
                        name: 'company_logo'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'mobile',
                        name: 'mobile'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, row) {
                            return dayjs(data).format('YYYY-MM-DD h:mm A');
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
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
                    $('#clients-table thead th').each(function(index) {
                        if (index !== 6) {
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
                    $('#clients-table thead th').removeClass('sorting sorting_asc sorting_desc');
                },
            });
          
            //add client
            $("#addClientForm").on("submit", function(e) {
                e.preventDefault();
                $('#companyLogoError').text('');
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                });
                var formData = new FormData(
                    document.getElementById("addClientForm")
                );
                console.log(formData);
                var subscribe = $("#subscribeError").is(":checked") ? 1 : 0;
                formData.append("subscribe", subscribe);
               
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
                            $('#addClientForm')[0].reset();

                            // Close the offcanvas modal
                            var offcanvasElement = document.getElementById('addClientModel');
                            var offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
                            offcanvas.hide();

                            clientsTable.ajax.reload(null, false);
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: response.message,
                                // footer: '<a href="#">Why do I have this issue?</a>'
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
                            if (errors.company_logo) {
                                $('#companyLogoError').text('Company logo required');
                            }
                            if (errors.company_name) {
                                let companyNameField = $('#companyNameError');
                                companyNameField.addClass('is-invalid');
                                if (errors.company_name[0] ===
                                    'The company name has already been taken.') {
                                    companyNameField.attr('placeholder', errors.company_name);
                                } else {
                                    companyNameField.attr('placeholder',
                                        'company name required');
                                }
                                companyNameField.val('');
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
                            if (errors.subscribe) {
                                let subscribeField = $('#subscribeError');
                                subscribeField.addClass('is-invalid');
                                subscribeField.attr('placeholder', 'subscribe required');
                                subscribeField.val('');
                            }
                            if (errors.pin_code) {
                                let pincodeField = $('#pincodeError');
                                pincodeField.addClass('is-invalid');
                                pincodeField.attr('placeholder', errors.pin_code);
                                pincodeField.val('');
                            }
                            if (errors.address) {
                                let addressField = $('#addressError');
                                addressField.addClass('is-invalid');
                                addressField.attr('placeholder', 'address required');
                                addressField.val('');
                            }
                            if (errors.state) {
                                let stateField = $('#stateError');
                                stateField.addClass('is-invalid');
                                stateField.attr('placeholder', 'state required');
                                stateField.val('');
                            }
                            if (errors.country) {
                                let countryField = $('#countryError');
                                countryField.addClass('is-invalid');
                                countryField.attr('placeholder', 'country required');
                                countryField.val('');
                            }
                        } else {
                            alert('An unexpected error occurred. Please try again.');
                        }
                    },
                });

            });

            //add client modal
            $('#addClientModel').on('hidden.bs.offcanvas', function() {
                $('#creatClientForm')[0].reset();
                $('#nameError, #emailError, #mobileError, #companyNameError, #companyLogoError, #pincodeError, #subscribeError, #addressError, #stateError, #countryError').removeClass('is-invalid').attr('placeholder', '').val('');
                $('#companyLogoError').text('');
            });

            $('#nameError, #emailError, #mobileError, #companyNameError, #companyLogoError, #pincodeError, #subscribeError, #addressError,#stateError, #countryError').on('click',function() {
                    $(this).removeClass('is-invalid');
                    $('#companyLogoError').text('');
                });

            //delete client
            $(document).on('click', '.delete-client', function(e) {
                e.preventDefault();

                var clientId = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: "{{ route('clients.delete', '') }}/" + clientId,
                            type: 'GET',

                            success: function(response) {
                                if (response.success) {
                                    clientsTable.ajax.reload(null, false);
                                    Swal.fire(
                                        'Deleted!',
                                        'The client has been deleted.',
                                        'success'
                                    );
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'An error occurred while trying to delete the client.',
                                    'error'
                                );
                            },
                        });
                    }
                });
            });


            //edit, update client
            $(document).on('click', '.edit-client', function() {

                let clientId = $(this).data('id');

                $.ajax({
                    url: "{{ route('clients.edit', '') }}/" + clientId,
                    type: 'GET',
                    success: function(response) {
                      
                        $('#clientId').val(response.client.id);
                        $('#companyName').val(response.client.company_name);
                        $('#name').val(response.client.display_name);
                        $('#mobile').val(response.client.mobile);
                        $('#email').val(response.client.email);
                        $('#address').val(response.client.primary_address);
                        $('#pincode').val(response.client.pin_code);
                        $('#state').val(response.client.state);
                        $('#country').val(response.client.country);
                       
                        if (response.client.is_subscribed === 1) {
                          
                            $('#subscribe').prop('checked', true); 
                        } else {
                          
                           $('#subscribe').prop('checked', false);
                        } 

                        // const imagePath = "{{ asset('storage/images') }}/" + response.client.company_logo;
                        $('#companyLogoImage').attr('src', response.client.company_logo);
                    },
                });

                $('#clientUpdateForm').on('submit', function(e) {
                    e.preventDefault();
                    $('#companyLogoUpdateError').text('');
                    var formData = new FormData(this);
                    var subscribe = $("#subscribe").is(":checked") ? 1 : 0;
                    formData.append("subscribe", subscribe);

                    console.log(formData);

                    $.ajax({
                        url: "{{ route('clients.update', '') }}/" + clientId,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Client updated successfully",
                                showConfirmButton: false,
                                timer: 1000
                            });

                            $('#clientUpdateForm')[0].reset();

                            // Close the offcanvas modal
                            var offcanvasElement = document.getElementById(
                                'editClientModel');
                            var offcanvas = bootstrap.Offcanvas.getInstance(
                                offcanvasElement);
                            offcanvas.hide();

                            // Reload DataTable data without full page reload
                            clientsTable.ajax.reload(null, false);
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
                            if (errors.company_logo &&  $("#imagePreview1").attr("src", '')) {
                               $('#companyLogoUpdateError').text('Company logo required');
                            }
                            if (errors.company_name) {
                                let companyNameField = $('#companyName');
                                companyNameField.addClass('is-invalid');
                                if (errors.company_name[0] ===
                                    'The company name has already been taken.') {
                                    companyNameField.attr('placeholder', errors.company_name);
                                } else {
                                    companyNameField.attr('placeholder',
                                        'company name required');
                                }
                                companyNameField.val('');
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
                            // if (errors.subscribe) {
                            //     $('#subscribe').text('subscribe required'); 
                            // }
                            if (errors.pin_code) {
                                let pincodeField = $('#pincode');
                                pincodeField.addClass('is-invalid');
                                pincodeField.attr('placeholder', errors.pin_code);
                                pincodeField.val('');
                            }
                            if (errors.address) {
                                let addressField = $('#address');
                                addressField.addClass('is-invalid');
                                addressField.attr('placeholder', 'address required');
                                addressField.val('');
                            }
                            if (errors.state) {
                                let stateField = $('#state');
                                stateField.addClass('is-invalid');
                                stateField.attr('placeholder', 'state required');
                                stateField.val('');
                            }
                            if (errors.country) {
                                let countryField = $('#country');
                                countryField.addClass('is-invalid');
                                countryField.attr('placeholder', 'country required');
                                countryField.val('');
                            }
                        } else {
                            alert('An unexpected error occurred. Please try again.');
                        }
                        }

                    });
                });
            });

            //update role modal
            $('#editClientModel').on('hidden.bs.offcanvas', function() {
                // Reset form
                $('#clientUpdateForm')[0].reset();
                $('#name, #companyName, #email, #mobile, #companyLogoUpdateError, #pincode, #subscribe, #address, #state, #country').removeClass('is-invalid').attr('placeholder', '').val('');
                    
                $('#companyLogoUpdateError').text('');
            });

            $('#name, #email, #mobile, #companyName, #companyLogoUpdateError, #pincode, #subscribe, #address, #state, #country').on('click',
            function() {
                $(this).removeClass('is-invalid');
                $('#companyLogoUpdateError').text('');
            });


        });
    </script>
@endsection
