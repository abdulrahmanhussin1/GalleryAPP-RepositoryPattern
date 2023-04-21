@extends('pages.layouts.app')
@section('title')
    Albums - Gaalery App
@endsection
@section('content')
    <div class="container mt-5">
        <h4>Albums Page / Gallery App </h4>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session()->has('Add'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('Add') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

            </div>
        @endif

        @if (session()->has('Delete'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('Delete') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add Album
        </button>


    </div>

    <main class="container-xl mt-4">
        <!-- Update the class to container-xl -->
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- Add the class mx-auto for horizontal centering -->
                <div class="row">


                    <!-- Gallery items go here -->
                    @foreach ($albums as $album)
                        <div class="col-md-4">
                            <div class="card mt-5 " style="width: 300px; height: 400px;" >
                                <img src="{{ asset('storage/emptyalbum.png') }} "alt="image.png" class="card-img-top gallery-img" style="height: 75%; object-fit: cover;">

                                <div class="card-body" style="height: 25%;">
                                    <a href="{{ route('albums.show', $album->id) }}"
                                        class="card-title">{{ $album->albumName }}</a>
                                </div>

                                <div class="card-footer text-muted">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal2" data-effect="effect-scale"
                                        data-id="{{ $album->id }}" data-albumName="{{ $album->albumName }}"
                                        data-toggle="modal">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal3" data-effect="effect-scale"
                                        data-id="{{ $album->id }}" data-name="{{ $album->albumName }}"
                                        data-toggle="modal">Delete</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </main>


    <!-- Modal -->
    <!-- Add -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('albums.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="albumName" class="form-label">Album Name</label>
                            <input type="text" name="albumName" class="form-control" id="albumName"
                                placeholder="Enter album name">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Add Album</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="albums/update" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label for="albumName" class="form-label">Album Name</label>
                            <input type="text" name="albumName" class="form-control" id="albumName"
                                placeholder="Enter album name">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Edit Album</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Delete -->
    <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Album</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('albums.destroy', $album->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <input type="text" name="id" id="id" hidden>
                        <p>Are you sure you want to delete album <span id="albumName"></span>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#exampleModal2').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var albumName = button.data('albumname');


                var modal = $(this);
                modal.find('#albumName').val(albumName);
                modal.find('.modal-title').text('Edit Album: ' + albumName);
                modal.find('form').attr('action', 'albums/' + id);
            });
        });
    </script>

    <script>
        $('#exampleModal3').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var albumName = button.data('name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #albumName').text(albumName);
        })
    </script>
@endsection
