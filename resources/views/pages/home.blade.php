@extends('pages.layouts.app')
@section('title')
    Home - Gallery App
@endsection
@section('content')
    <h3>Home Page</h3>
    <h4> welcome {{ Auth::user()->name }}</h4>
    <main class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    @if ($images->count() <= 0)
                        <div class="alert alert-warning" role="alert"><strong>Warning! there in no image or albums
                                created</strong><a href="{{ route('albums.index') }}" class="alert-link"> Add album</a></div>
                    @else
                        @foreach ($images as $image)
                            <!-- Gallery items go here -->
                            <div class="col-md-3">
                                <div class="card">
                                    <img src="{{ asset("storage/$image->image") }}" alt="Image 1"
                                        class="card-img-top gallery-img">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $image->imageName }}</h5>
                                        <a href="{{ route('albums.show', $image->album->id) }}" class="small">
                                            album:<strong>{{ $image->album->albumName }}</strong></a>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                </div>
            </div>
        </div>
        @endif

    </main>
@endsection
