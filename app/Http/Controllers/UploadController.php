<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function upload(Request $request)
    {
        $validateData = $request->validate([
            'me88Username' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|email',
            'file' => 'required|file',
        ]);
        try {
            // Store the uploaded file
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');

            // Send the email with the uploaded file as an attachment
            \Mail::to('cheing_86@hotmail.com')->send(new \App\Mail\SendReceipt(
                $filePath,
                $validateData['me88Username'],
                $validateData['username'],
                $validateData['email']
            ));

            return response()->json(['message' => 'Upload successful']);
        } catch (\Exception $e) {
            \Log::error('Failed to process upload or send email', ['error' => $e->getMessage()]);

            return response()->json(['error' => 'Failed to process your request'], 500);
        }
    }
}
