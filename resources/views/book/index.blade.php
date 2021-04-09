@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
@stop
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Book</div>

                <div class="card-body">
                @if(auth()->user()->user_type == 'Admin')
                <a class="btn btn-outline-success" href="{{ route('book.create') }}">Create Book</a>
                @endif;
                <br>
                <br>
                @include('alert')
                    <table id="authors" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Published Date</th>
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
@endif
@endsection
@section('js')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js" defer></script>
<script>
    $(document).ready(function() {
    $('#authors').DataTable({
        proccessing: true,
        serverSide: true,
        ajax: '{{ route("book.data") }}',
        columns: [
            {data: 'title', name: 'title'},
            {data: 'author', name: 'author'},
            {data: 'published_date', name: 'published_date'},
            {data: 'action', name: 'action', render: function(data, type, row){
                return "<a href='"+row.detail+"' id='editBtn' class='btn btn-outline-info btn-sm'>Detail</a> @if(auth()->user()->user_type == 'Admin')<button id='delBtn' data-id='"+row.id+"' data-toggle='modal' data-target='#deleteModal' class='btn btn-outline-danger btn-sm'>Delete</button>@endif"
            },searchable: false, orderable:false }
        ]
    });

    $(document).on('click','#delBtn', function(){
        let id      = $(this).data('id');

        let action   = '{{ route("book.delete", ":id") }}';
            action   = action.replace(':id', id);
            $('#formDelete').prop('action', action);

    })


} );
</script>
@stop