<?php
namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface ImageRepositoryInterface
{
    public function getAll($id);
    public function store(Request $request);
    public function update(Request $request);
    public function destroy(Request $request, $id);
    public function destroyAll($id);

}