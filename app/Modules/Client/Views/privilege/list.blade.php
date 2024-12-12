
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
                                <h3 class="text-primary">Priviliges</h3>                              
                            </div>
                            <form id="privilegeForm" method="POST" action="">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="role" class="form-label">Role</label>
                                        <select name="role_id" id="role" class="form-select text-dark">
                                            @foreach ($roles as $role)
                                                <option class="text-dark" value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                        
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Module</th>
                                            <th>All</th>
                                            <th>View</th>
                                            <th>Create</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                            <th>Not Applicable</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($modules as $module)
                                            <tr>
                                                <td>{{ ucfirst($module->name) }}</td>
                                                @foreach (['all', 'view', 'create', 'edit', 'delete', 'not_applicable'] as $action)
                                                    <td>
                                                        <input type="checkbox" 
                                                            name="permissions[]" 
                                                            value="{{ $module->where('name', "$module-$action")->first()->id ?? '' }}" 
                                                            class="form-check-input">
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                        
                                {{-- <div class="mt-3">
                                    <button type="submit" class="btn btn-primary">Update Privileges</button>
                                </div> --}}
                            </form>
                          </div>
                        </div>
                      </div>
                </div>

            </div>
        </div>

    </div>

</div>





@endsection

@section('script')

<script>

    document.getElementById('privilegeForm').addEventListener('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        }).then(response => response.json())
          .then(data => {
              alert(data.message);
          }).catch(error => {
              console.error('Error:', error);
          });
    });
</script>


@endsection
