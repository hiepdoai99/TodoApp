<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;


class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        list($type, $data) = explode(';', $request->image);
        list(, $data)      = explode(',', $data);
        $type = str_replace('data:image/','',$type);
        $rand = substr(md5(microtime()),rand(0,26), 20);
        $data = base64_decode($data);
        $imageName = $rand.'.'.$type;
        Storage::disk('public')->put($imageName, $data);
        $path = storage_path('public/' . $imageName);

        $image = new Image();
        $image->image = $imageName;
        $image->url = storage_path('app/public/').$imageName;
        $image->save();

        return response($path, Response::HTTP_CREATED);

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
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        //
    }
}
