@extends('pages.layouts.app')
@section('title')
    {{ $album->albumName }} page - Gaalery App
@endsection
@section('content')
    <div class="container mt-5">
        <h4>{{ $album->albumName }} Album / Gallery App </h4>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add Image
        </button>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal3">
            Delete All Images
        </button>
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
                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <main class="container-xl mt-4">

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="row">
                    @if ($images->count() == 0)
                        <div class="alert alert-warning" role="alert"><strong>Warning! there in image created</strong>
                        </div>
                    @else
                        @foreach ($images as $image)
                            <div class="col-md-3">
                                <div class="card">
                                    <img src="{{ asset("storage/$image->image") }}" alt="image.png"
                                        class="card-img-top gallery-img">
                                    <div class="card-body">
                                        <p class="small">{{ 'Image Name : ' }}<strong class="small"
                                                class="card-title">{{ $image->imageName }}</strong></p>
                                        <p class="small">{{ 'Album Name : ' }} <strong
                                                class="small">{{ $image->album->albumName }}</strong></p>
                                    </div>
                                    <div class="card-footer text-muted">

                                        <form action="{{ route('images.destroy', $image->id) }}" method="post">
                                            @csrf @method('delete')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete </button>
                                        </form>

                                        <form action="{{ url('images/update') }}" method="post">
                                            @csrf @method('PUT')
                                            <div class="mb-3">
                                                <input type="text" name="id" hidden value="{{ $image->id }}">
                                                <label class="form-label" for="Album Name">Album Name</label>
                                                <select class="form-select" name="album_id"
                                                    aria-label="Default select example">
                                                    <option selected>Open this select Album</option>
                                                    @foreach ($album_all as $albums)
                                                        <option value="{{ $albums->id }}">{{ $albums->albumName }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-outline-primary">move to another
                                                album</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                </div>
            </div>
        </div>
        @endif
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
                    <form action="{{ route('images.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="albumName" class="form-label">Image Name</label>
                            <input type="text" name="imageName" class="form-control" id="albumName"
                                placeholder="Enter album name">
                        </div>
                        <div class="mb-3">
                            <label for="albumCover" class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" id="albumCover">
                        </div>
                        <div class="mb-3" hidden>
                            <label class="form-label" for="Album Name">Album Name</label>
                            <select class="form-select" name="album_id" aria-label="Default select example">
                                <option value="{{ $album->id }}" selected>{{ $album->albumName }}</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Add Image</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Delete -->
    <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete All Images</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url("/albums/$album->id/deleteAllImage") }}" method="post">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <input type="text" name="id" id="id" hidden>
                        <p>Are you sure you want to delete all Images <span id="albumName"></span>?</p>
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
        $('#exampleModal3').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var imageName = button.data('imageName')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #imageName').text(imageName);
        })
    </script>
@endsection
