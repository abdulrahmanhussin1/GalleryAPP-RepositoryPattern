<?php

namespace App\Repositories;

use App\Models\Album;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\AlbumRepositoryInterface;

class AlbumRepository implements AlbumRepositoryInterface

{
    public function index()
    {
        return Album::where('user_id', auth()->user()->id)->get();
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'albumName' => 'required|string|max:50',
        ]);
        $data['user_id'] = Auth::user()->id;
        return Album::create($data);
    }


    public function show($id)
    {
        return  Album::findOrFail($id);   
    }


    public function update(Request $request, $id)
    {
        $album = Album::findOrFail($id);
        $data = $request->validate([
            'albumName' => 'required|string|max:50|unique:albums,albumName,' . $id,
        ]);
        return $album->update($data);
    }


    public function destroy(Request $request, $id)
    {
        $id = $request->id;
        $album = Album::findOrFail($id);
        return $album->delete();
    }
}
