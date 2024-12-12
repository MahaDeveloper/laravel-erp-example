
    $(function() {
        $.ajaxSetup({
            headers : {
                'CSRFToken' : getCSRFTokenValue()
            }
        });
    });
   
    $(document).ready(function () {
        $('#modules-table').DataTable({
            processing: true,
            serverSide: true,
            paging: true, 
            info: true,  
            ordering: true, 
            ajax: "{{ route('modules.list') }}",
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
            dom: '<"d-flex justify-content-between"lf>rtip',
            order: [[0, 'asc']],
        });
    });


    $(document).on('click', '.edit-module', function () {

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
                    location.reload(); 
                },
                error: function (xhr, status, error) {
                    alert('An error occurred while updating the module.'); 
                }
            });
        });


    });


   
