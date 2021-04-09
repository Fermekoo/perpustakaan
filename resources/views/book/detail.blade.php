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
                @include('alert')
                <form action="{{ route('book.update',$book->id) }}" method="POST" enctype="multipart/form-data" id="formBook">
                  @csrf
                  @method('PUT')
                <div class="form-group">
                    <label for="inputStatus">Author</label>
                    <select class="form-control select2" id="authorId" name="authorId" style="width: 100%;" required>
                        <option value="">-Pilih-</option>
                        @foreach($authors as $author)
                        <option value="{{ $author->id }}" {{ ($book->author_id == $author->id) ? 'selected' : '' }}>{{ $author->name }}</option>
                        @endforeach
                    </select>
                </div>
              
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" value="{{ $book->title }}" class="form-control" required>
                    <small class="text-danger">{{ $errors->first("title") }}</small>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control" id="description" rows="4" required>{{ $book->description }}</textarea>
                    <small class="text-danger">{{ $errors->first("description") }}</small>
                </div>
                <div class="form-group">
                    <label for="amount">Published Date</label>
                    <input type="date" id="publishedDate" name="publishedDate" value="{{ $book->published_date }}" class="form-control" required>
                    <small class="text-danger">{{ $errors->first("publishedDate") }}</small>
                </div>
                <div class="row">
                      <div class="col-md-10">
                        <div class="form-group">
                          <img  id='img-upload' src="{{ asset('storage/books/'.$book->cover) }}" alt="gambar Project" class="img-fluid" width="570" height="270">
                        </div>
                      </div>
                    </div>
                @if(auth()->user()->user_type == 'Admin')
                <div class="form-group">
                    <label for="exampleInputFile">Book Cover</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="imgInp" name="cover">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div>
                  @endif
                <div class="form-group">
                    <a href="{{route('book.index')}}" class="btn btn-outline-info">Cancel</a>
                    @if(auth()->user()->user_type == 'Admin')
                    <button type="submit" class="btn btn-outline-success">Update</button>
                    @endif
                </div>
              </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready( function() {
  $(document).on('change', '.btn-file :file', function() {
  var input = $(this),
    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
  input.trigger('fileselect', [label]);
  });
  $('.btn-file :file').on('fileselect', function(event, label) {
      var input = $(this).parents('.input-group').find(':text'),
          log = label;
      if( input.length ) {
          input.val(log);
      } else {
          if( log ) alert(log);
      }
  });
  function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              $('#img-upload').attr('src', e.target.result);
          }
          reader.readAsDataURL(input.files[0]);
      }
  }
  $("#imgInp").change(function(){
      readURL(this);
  });
});
</script>
@stop