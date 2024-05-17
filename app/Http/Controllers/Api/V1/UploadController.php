<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUploadFileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            // Customize the file storage path and filename as per your requirements
            $path = $file->store('photos', 'public');

            // Get the HTTPS URL for the stored file
            $url = Storage::disk('public')->url($path);

            return response()->json([
                'path' => $path,
                'url' => $url,
            ]);
        }

        return response()->json(['message' => 'No file uploaded'], 400);
    }

    public function uploadFile(StoreUploadFileRequest $request)
    {
        // $data = $request->validated();

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Customize the file storage path and filename as per your requirements
            $path = $file->store('files', 'public');
            $type = $file->getClientMimeType();

            // Get the HTTPS URL for the stored file
            $url = Storage::disk('public')->url($path);

            return response()->json([
                'path' => $path,
                'url' => $url,
                'type' => $type,
            ]);
        }

        return response()->json(['message' => 'No file uploaded'], 400);
    }

    public function deleteFile(Request $request)
    {
        $path = $request->input('path');

        if ($path && !Storage::delete('public/'.$path)) {
            return response()->json(['message' => 'File could not be deleted'], 500);
        }

        return response('', 200);
    }
}
