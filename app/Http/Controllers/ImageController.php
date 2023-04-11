<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Image;
use App\Repositories\ImageRepository;
use App\Repositories\Interfaces\ImageRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    private $imageRepository;

    public function __construct(ImageRepositoryInterface $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return abort(404);
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
        $this->imageRepository->store($request);
        session()->flash('Add', 'image Created successfully');
        return redirect()->back();
    }


    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request)
    {
        $this->imageRepository->update($request);
        return redirect()->back()->with('success', 'Image has been moved to another album successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $this->imageRepository->destroy($request,$id);
        session()->flash('Delete', 'image Deleted Successfully');
        return redirect()->back();
    }

    public function destroyAll($id)
    {
        $this->imageRepository->destroyAll($id);
        return redirect()->back()->with('success', 'All images in the album have been deleted successfully.');
    }
}
