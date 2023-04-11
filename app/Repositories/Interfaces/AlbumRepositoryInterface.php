<?php
namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface AlbumRepositoryInterface
{
    public function index();
    public function store(Request $request);
    public function show($id);
    public function update(Request $request, $id);
    public function destroy(Request $request, $id);
}
