<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;

class FileController extends Controller
{
    public function webGetThumb(File $file)
    {
        $isImage = in_array($file->type, ['image/png', 'image/jpeg', 'image/gif']);

        if (!$isImage) {
            abort(404);
        }
        $dirname = dirname($file->location);
        $filename = basename($file->location);
        $location = $dirname . DIRECTORY_SEPARATOR . 'thumb_' . $filename;
        return Storage::download($location, 'thumb_' . $file->name);
    }


    public function webGet(File $file)
    {
        return Storage::download($file->location, $file->name);
    }

    public function apiPost(Request $request, $type = null)
    {
        //check uploaded file
        $fileInfo = $request->file('file');
        if (!$fileInfo->isValid()) {
            return ['message' => 'bad upload'];
        }

        $isImage = in_array($fileInfo->getMimeType(), ['image/png', 'image/jpeg', 'image/gif']);

        //is file limit to image?
        if ($type === 'image' && !$isImage) {
            return ['message' => 'invalid format'];
        }

        //build store dirctory
        $user_id = auth()->id();
        $storeDirectory = 'files' . DIRECTORY_SEPARATOR . ($user_id === null ? 'guest' : 'user_id_' . $user_id);

        //store file on disk
        $path = $fileInfo->store($storeDirectory);
        if ($path === false) {
            return ['message' => 'error store'];
        }

        //if file is image, make thumbnail
        if ($isImage) {
            $fullPath = storage_path('app' . DIRECTORY_SEPARATOR . $path);
            $thumbFilename = dirname($fullPath) . DIRECTORY_SEPARATOR . 'thumb_' . basename($fullPath);
            //make thumbnail by image.intervention.io library, also it depend on gd
            Image::make($fullPath)->resize(240, 240)->save($thumbFilename, 60);
        }

        $file = new \App\File();
        $file->name = $fileInfo->getClientOriginalName();
        $file->type = $fileInfo->getMimeType();
        $file->size = $fileInfo->getSize();
        $file->location = $path;
        $file->save();

        return [$path, $file, 'id' => $file->id, 'url' => route('get_file', [$file->id]), 'isImage' => $isImage, 'message' => 'success'];
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\File $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\File $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\File $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\File $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        //
    }
}
