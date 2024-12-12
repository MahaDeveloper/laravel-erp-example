
@extends('Client::layouts.app')

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
                                <h3 class="text-primary">Roles List</h3>
                                <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#addRoleModel" aria-controls="addRoleModel">Add Role</button>
                            </div>
                            <div class="table-responsive" >
                                
                                <table class="table mt-3" style="width:100%; " id="roles-table" >
                                    <thead class="table-light border-top border-bottom text-start">
                                        <tr>
                                            <th class=""> S.No. </th>
                                            <th class=""> Name </th>
                                            <th class=""> Created At </th>
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


<!-----add role model ----->
<div class="offcanvas offcanvas-end"  data-bs-backdrop="false" tabindex="-1" id="addRoleModel" aria-labelledby="addRoleModelLabel" style="width: 50%;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title text-primary" id="addRoleModelLabel">Add Role</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="roleForm" action="{{ route('roles.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name" >Role Name</label>
                <input type="text" class="form-control form-control-sm" id="nameError" name="name" placeholder="Enter role name">
                <span class="text-danger ms-2 mt-1" id="uniqueError"></span> <!-- Error message container -->
            </div>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
        
        
    </div>
  </div>
<!-----end model----->

<!-- Edit Module Modal -->
<div class="offcanvas offcanvas-end" data-bs-backdrop="false" tabindex="-1" id="editRoleModel" aria-labelledby="editRoleModelLabel" style="width: 50%;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title text-primary" id="editRoleModelLabel">Edit Role</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="roleUpdateForm">
            @csrf
            <input type="hidden" id="roleId" name="id">
           <div class="form-group">
                <label for="name">name</label>
                <input type="text" class="form-control form-control-sm Update" id="roleName" name="name" placeholder="Enter role name">
                <span class="text-danger ms-2 mt-1" id="uniqueErrorUpdate"></span>
            </div>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror   
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Submit</button>
              
            </div>
        </form>   
    </div>
  </div>
<!-- end Modal -->

<style>
    #roles-table th, #roles-table td {  
       padding: 15px;
     }
       
</style> 

@endsection

@section('script')
<script>
    //roles list
    $(document).ready(function () {

        //role list
        var rolesTable =   new DataTable('#roles-table', {
            processing: true,
            serverSide: true,
            paging: true, 
            info: true,  
            ordering: true, 
            ajax: "{{ route('roles.list') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                {
                data: 'created_at',
                name: 'created_at',
                render: function(data, type, row) {
                    return dayjs(data).format('YYYY-MM-DD h:mm A');
                }
            },
                { data: 'action', name: 'action', orderable: false, searchable: false } 
            ],
            lengthMenu: [10, 25, 50, 100],
            responsive: true,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
            order: [[0, 'desc']],
            
            // Custom rendering for sorting icons
            initComplete: function () {
                $('#roles-table thead th').each(function (index) {
                    if(index !== 3){

                        $(this).css('position', 'relative').append(
                        '<span class="custom-sorting-icons" style="position:absolute; font-size:14px; color:#4B49AC;">' +
                            '<i class="mdi mdi-arrow-up"></i>' +
                            '<i class="mdi mdi-arrow-down"></i>' +
                        '</span>'
                    );
                    }
                });
            },

            // Custom event to handle sorting
            drawCallback: function () {
                // Hide the default sorting icons after sorting
                $('#roles-table thead th').removeClass('sorting sorting_asc sorting_desc');
            },
        });
        
        //roles create
        $('#roleForm').on('submit', function (e) {
            e.preventDefault(); 
            $('#uniqueError').text('');
            var formData = $(this).serialize();
            $.ajax({
                url: $(this).attr('action'), 
                type: 'POST',
                data: formData,
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.success,
                        showConfirmButton: false,
                        timer: 1000
                        });
                       // Reset form and clear input
                        $('#roleForm')[0].reset();

                        var offcanvasElement = document.getElementById('addRoleModel');
                        var offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
                        offcanvas.hide();

                        // Reload DataTable data without full page reload
                        rolesTable.ajax.reload(null, false); 
                    }
                },
                error: function (xhr) {
                  
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                      
                        if (errors.name[0] && errors.name[0] === 'The name has already been taken.') {  

                            $('#uniqueError').text(errors.name)
                        }
                        else if(errors.name[0] && errors.name[0] === 'The name field is required.'){
                            
                            let nameField = $('#nameError');
                            nameField.addClass('is-invalid');
                            nameField.attr('placeholder', 'name required');
                            nameField.val('');
                        }
                    }else {
                        alert('An unexpected error occurred. Please try again.');
                    }
                }
            });

            $('#nameError').on('click', function(){
                $(this).removeClass('is-invalid');
            });
        });

        //add role modal
        $('#addRoleModel').on('hidden.bs.offcanvas', function () {
            // Reset form
            $('#roleForm')[0].reset();
            $('#nameError').removeClass('is-invalid').attr('placeholder', '').val('');
            $('#uniqueError').text('');
        });

        //edit, update role
        $(document).on('click', '.edit-role', function () {
          
            let roleId = $(this).data('id');

            $.ajax({
                url:"{{route('roles.edit', '')}}/"+roleId,
                type: 'GET',
                success: function (response) {
                
                    $('#roleId').val(response.role.id);
                    $('#roleName').val(response.role.name); 
                },
            });
        

            $('#roleUpdateForm').on('submit', function (e) {
                e.preventDefault(); 
               
                var formData = new FormData(this); 
               
                $.ajax({
                    url:"{{ route('roles.update', '')}}/"+roleId,
                    method: 'POST', 
                    data: formData,
                    processData: false,  
                    contentType: false,  
                    success: function (response) {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Role updated successfully",
                            showConfirmButton: false,
                            timer: 1000
                        });
                         // Reset form and clear input
                         $('#roleUpdateForm')[0].reset();
                        
                        // Close the offcanvas modal
                        var offcanvasElement = document.getElementById('editRoleModel');
                        var offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
                        offcanvas.hide();

                        // Reload DataTable data without full page reload
                        rolesTable.ajax.reload(null, false);  
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                        
                            if (errors.name[0] && errors.name[0] === 'The name has already been taken.') {  

                                $('#uniqueErrorUpdate').text(errors.name)
                            }
                            else if(errors.name[0] && errors.name[0] === 'The name field is required.'){
                                
                                let nameField = $('#roleName');
                                nameField.addClass('is-invalid');
                                nameField.attr('placeholder', 'Role name is required');
                                nameField.val('');
                            }
                        }else {
                            alert('An unexpected error occurred. Please try again.');
                        }
                    }
                
                });
            });
        });

        //update role modal
        $('#editRoleModel').on('hidden.bs.offcanvas', function () {
            // Reset form
            $('#roleUpdateForm')[0].reset();
            $('#roleName').removeClass('is-invalid').attr('placeholder', '').val('');
            $('#uniqueErrorUpdate').text('');
        });
        
        //delete role
        $(document).on('click', '.delete-role', function (e) {
            e.preventDefault();
            var roleId = $(this).data('id'); 
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
                        url: "{{ route('roles.delete','') }}/"+ roleId, 
                        type: 'GET',
                       
                        success: function (response) {
                            if (response.success) {
                                rolesTable.ajax.reload(null, false);                         
                                Swal.fire(
                                    'Deleted!',
                                    'The module has been deleted.',
                                    'success'
                                );
                            }
                        },
                        error: function (xhr) {
                            Swal.fire(
                                'Error!',
                                'An error occurred while trying to delete the module.',
                                'error'
                            );
                        },
                    });
                }
            });
        });


        
    });
    

      



 

   



</script>

@endsection
