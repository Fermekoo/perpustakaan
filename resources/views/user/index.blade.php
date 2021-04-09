@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
@stop
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">User</div>

                <div class="card-body">
                <button class="btn btn-outline-success" data-toggle="modal" data-target="#addModal">Create User</button>
                <br>
                <br>
                @include('alert')
                    <table id="authors" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>User Type</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@if(auth()->user()->user_type == 'Admin')
<!-- Modal Add  -->
<div class="modal fade" id="addModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Create</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
            <form action="{{ route('user.create') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="name" name="name" class="form-control" placeholder="Enter Name" id="name">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter Email" id="email">
            </div>
            <div class="form-group">
                <label for="email">Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-outline-success">Save</button>
            </div>
        </form>
      </div>
      
    </div>
  </div>

<!-- Modal Edit  -->
<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Edit</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
            <form action="" method="POST" id="formEdit">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="name" name="name" class="form-control" placeholder="Enter Name" id="editName">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter Email" id="editEmail">
            </div>
            <div class="form-group">
                <label for="email">Password <small>*Leave blank if you dont want to update the password</small></label>
                <input type="password" name="password" class="form-control">
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-outline-success">Update</button>
            </div>
        </form>
      </div>
      
    </div>
  </div>

<!-- Modal Delete  -->
<div class="modal fade" id="deleteModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Delete</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
            <form action="" method="POST" id="formDelete">
            @csrf
            @method('DELETE')
            Are you sure you want to delete this data?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-warning" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-outline-success">Yes</button>
            </div>
        </form>
      </div>
      
    </div>
  </div>
  @endif;
@endsection
@section('js')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js" defer></script>
<script>
    $(document).ready(function() {
    $('#authors').DataTable({
        proccessing: true,
        serverSide: true,
        ajax: '{{ route("user.data") }}',
        columns: [
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'user_type', name: 'user_type'},
            {data: 'action', name: 'action', render: function(data, type, row){
                return "<button data-id='"+row.id+"' id='editBtn' data-name='"+row.name+"' data-email='"+row.email+"' data-toggle='modal' data-target='#editModal' class='btn btn-outline-info btn-sm'>Detail</button> @if(auth()->user()->user_type == 'Admin')<button id='delBtn' data-id='"+row.id+"' data-toggle='modal' data-target='#deleteModal' class='btn btn-outline-danger btn-sm'>Delete</button>@endif"
            },searchable: false, orderable:false }
        ]
    });

    $(document).on('click','#editBtn', function(){
        let id      = $(this).data('id');
        let name    = $(this).data('name');
        let email    = $(this).data('email');

        $('#editName').val(name);
        $('#editEmail').val(email);

        let action   = '{{ route("user.update", ":id") }}';
            action   = action.replace(':id', id);
            $('#formEdit').prop('action', action);

    });
    $(document).on('click','#delBtn', function(){
        let id      = $(this).data('id');

        let action   = '{{ route("user.delete", ":id") }}';
            action   = action.replace(':id', id);
            $('#formDelete').prop('action', action);

    })


} );
</script>
@stop