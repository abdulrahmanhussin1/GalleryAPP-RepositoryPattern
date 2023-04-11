<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\AlbumRepositoryInterface;
use App\Repositories\Interfaces\ImageRepositoryInterface;

class AlbumController extends Controller
{
    private $albumRepository, $imageRepository;

    public function __construct(AlbumRepositoryInterface $albumRepository,ImageRepositoryInterface $imageRepository)
    {
        $this->albumRepository = $albumRepository;
        $this->imageRepository = $imageRepository;
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $albums = $this->albumRepository->index();
        if ($albums->count() > 0) {
            return view('pages.albums.albums', ['albums' => $albums]);
        } else {
            return view('pages.albums.empty', compact('albums'));
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->albumRepository->store($request);
        session()->flash('Add', 'album Created successfully');
        return redirect('/albums');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $album = $this->albumRepository->show($id);
        $album_all = $this->albumRepository->index();
        $images = $this->imageRepository->getAll($id);

        return view('pages.albums.showAlbum', compact("images", "album", "album_all"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Album $album)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->albumRepository->update($request, $id);
        return redirect('/albums')->with('success', 'menuItems updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $this->albumRepository->destroy($request, $id);
        session()->flash('Delete', 'Album Deleted Successfully');
        return redirect('/albums');
    }
}
