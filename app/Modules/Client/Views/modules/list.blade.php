
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
                                <h3 class="text-primary">Modules List</h3>
                                <button class="btn btn-primary"  data-bs-toggle="offcanvas" data-bs-target="#addModuleModel" aria-controls="addModuleModel">Add Module</button>
                            </div>
                            <div class="table-responsive">
                                <table class="table mt-3"  style="width:100%; " id="modules-table" >
                                    <thead class="table-light border-top border-bottom text-start">
                                    <tr>
                                        <th> Name </th>                                  
                                        <th> Created At </th>
                                        <th> Order </th>
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

<!-----add module model ----->
<div class="offcanvas offcanvas-end"  data-bs-backdrop="false" tabindex="-1" id="addModuleModel" aria-labelledby="addModuleModelLabel" style="width: 50%;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title text-primary" id="addModuleModelLabel">Add Module</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('module.post') }}" id="createModuleForm" method="POST">
           @csrf
           <div class="form-group">
                <label for="name">name</label>
                <input type="text" class="form-control form-control-sm " id="nameError" name="name" placeholder="Enter module name">
                <span class="text-danger ms-2 mt-1 " id="uniqueError"></span>
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
<div class="offcanvas offcanvas-end" data-bs-backdrop="false" tabindex="-1" id="editModuleModel" aria-labelledby="addModuleModelLabel" style="width: 50%;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title text-primary" id="addModuleModelLabel">Edit Module</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="moduleUpdateForm">
            @csrf
            <input type="hidden" id="moduleId" name="id">
           <div class="form-group">
                <label for="name">name</label>
                <input type="text" class="form-control form-control-sm" id="moduleName" name="name" placeholder="Enter module name" >
               <span class="text-danger ms-2 mt-1 " id="uniqueErrorUpdate"></span>
            </div>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror  
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Submit</button>
                {{-- <button type="button" class="btn btn-secondary ms-3" data-bs-dismiss="modal">Cancel</button> --}}
            </div>
        </form>   
    </div>
  </div>
<!-- end Modal -->
<style>
 #modules-table th, #modules-table td {  
    padding: 15px;
  }
   

</style> 


@endsection

@section('script')

<script>
   
    $(document).ready(function () {

        //module list
        var modulesTable = new DataTable('#modules-table', {
            processing: true,
            serverSide: true,
            paging: true, 
            info: true,  
            ordering: true, 
            ajax: "{{ route('modules.list') }}",
            columns: [
              
                { data: 'name', name: 'name' },
                {data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) {
                        return dayjs(data).format('YYYY-MM-DD h:mm A');
                    }
                },
                { data: 'order', name: 'order' },
                { data: 'action', name: 'action', orderable: false, searchable: false } 
            ],
            lengthMenu: [10, 25, 50, 100],
            responsive: true,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
            order: [[2, 'desc']],
          
            // Custom rendering for sorting icons
            initComplete: function () {
                $('#modules-table thead th').each(function (index) {
                   if(index !== 3){

                        $(this).css('position', 'relative').append(
                            '<span class="custom-sorting-icons" style="position:absolute;  font-size:14px; color:#4B49AC;">' +
                                '<i class="mdi mdi-arrow-up"></i>' +
                                '<i class="mdi mdi-arrow-down"></i>' +
                            '</span>'
                        );
                   }
                });
            },

            // Custom event to handle sorting
            drawCallback: function () {
                $('#modules-table thead th').removeClass('sorting sorting_asc sorting_desc');
            },

        });


        //roles create
        $('#createModuleForm').on('submit', function (e) {
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
                        $('#createModuleForm')[0].reset();
                        
                        // Close the offcanvas modal
                        var offcanvasElement = document.getElementById('addModuleModel');
                        var offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
                        offcanvas.hide();

                        // Reload DataTable data without full page reload
                        modulesTable.ajax.reload(null, false); 
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        if (errors.name[0] && errors.name[0] === 'The name has already been taken.') {  

                            $('#uniqueError').text(errors.name[0])
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

        //add module modal
        $('#addModuleModel').on('hidden.bs.offcanvas', function () {
            // Reset form
            $('#createModuleForm')[0].reset();
            $('#nameError').removeClass('is-invalid').attr('placeholder', '').val('');
            $('#uniqueError').text('');
        });


        //edit, update module
        $(document).on('click', '.edit-module', function () {
            $('#nameErrorUpdate').text('');
            let moduleId = $(this).data('id');
            $.ajax({
                url:"{{route('module.edit', '')}}/"+moduleId,
                type: 'GET',
                success: function (response) {
                
                    $('#moduleId').val(response.module.id);
                    $('#moduleName').val(response.module.name); 
                },
            });

            $('#moduleUpdateForm').on('submit', function (e) {
                $('#uniqueErrorUpdate').text('');
                e.preventDefault(); 
                var formData = new FormData(this); 
                console.log(formData);
                
                $.ajax({
                    url:"{{ route('module.update', '')}}/"+moduleId,
                    method: 'POST', 
                    data: formData,
                    processData: false,  
                    contentType: false,  
                    success: function (response) {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Module updated successfully",
                            showConfirmButton: false,
                            timer: 1000
                        });
                        $('#moduleUpdateForm')[0].reset();
 
                        var offcanvasElement = document.getElementById('editModuleModel');
                        var offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
                        offcanvas.hide();

                        modulesTable.ajax.reload(null, false); 
                        
                    },
                    error: function (xhr) {
                  
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.name[0] && errors.name[0] === 'The name has already been taken.') {  

                                $('#nameErrorUpdate').text(errors.name[0])
                            }
                            else if(errors.name[0] && errors.name[0] === 'The name field is required.'){
                                
                                let nameField = $('#moduleName');
                                nameField.addClass('is-invalid');
                                nameField.attr('placeholder', 'Module name is required');
                                nameField.val('');
                            }
                        }else {
                            alert('An unexpected error occurred. Please try again.');
                        }
                    }
                });
            });

        });

        //clear error on update modal open/close
        $('#editModuleModel').on('hidden.bs.offcanvas', function () {
            $('#moduleUpdateForm')[0].reset();

            $('#moduleName').removeClass('is-invalid').attr('placeholder', '').val('');
            $('#uniqueErrorUpdate').text('');
        });


        //delete module
        $(document).on('click', '.delete-module', function (e) {
            e.preventDefault();
            var moduleId = $(this).data('id'); 
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
                        url: "{{ route('modules.delete','') }}/"+ moduleId, 
                        type: 'GET',
                       
                        success: function (response) {
                            if (response.success) {
                                modulesTable.ajax.reload(null, false);                         
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

        //module order up/down
        $(document).on('click', '.order-up, .order-down', function () {
            let currentButton = $(this);
            let currentId = currentButton.data('id');
            let row = currentButton.closest('tr');
            let swapRow = currentButton.hasClass('order-up') ? row.prev() : row.next();
            
            if (swapRow.length === 0) {
                return;
            }

            let swapId = swapRow.find('.order-up, .order-down').data('id');

            $.ajax({
                url: "{{ route('modules.update-order') }}",
                type: 'POST',
                data: {
                    current_id: currentId,
                    swap_id: swapId,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        if (currentButton.hasClass('order-up')) {
                            row.insertBefore(swapRow);
                        } else {
                            row.insertAfter(swapRow);
                        }
                    } else {
                        alert('Failed to update order');
                    }
                },
                error: function () {
                    alert('An error occurred while updating order');
                }
            });
        });


    });



</script>

@endsection
