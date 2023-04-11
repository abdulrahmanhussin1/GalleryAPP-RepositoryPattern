<?php

namespace App\Repositories;

use App\Models\Album;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Interfaces\ImageRepositoryInterface;

class ImageRepository implements ImageRepositoryInterface
{
 
    public function getAll($id)
    {
        $album = Album::findOrFail($id);
        return Image::where('album_id', $album->id)->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'imageName' => 'required|string|max:50',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'album_id' => 'required|numeric'
        ]);
        if ($request->has('image')) {
            $data['image'] = Storage::putFile("images", $data['image']);
        }
        $data['user_id'] = Auth::user()->id;
        return Image::create($data);
    }


    public function update(Request $request)
    {
        $id = $request->id;
        $image = Image::findOrFail($id);
        $data = $request->validate([
            'album_id' => 'required|exists:albums,id',
        ]);
        return $image->update($data);
    }


    public function destroy(Request $request, $id)
    {
        $image = Image::findOrFail($id);
        if (!empty($image->image)) {
            Storage::delete($image->image);
        }
        return $image->delete();
    }


    public function destroyAll($id)
    {
        $album = Album::findOrFail($id);
        $images = Image::where('album_id', $album->id)->get();
        foreach ($images as $image) {
            if (is_file(public_path($image->file_path))) {
                unlink(public_path($image->file_path));
            }
        }
        // $album->images()->delete();
        return $image->delete();
    }
}
