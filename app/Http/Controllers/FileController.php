<?php

namespace App\Http\Controllers;

use App\Models\Directory;
use App\Models\File;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        if (!$request->file()) {
            return new JsonResponse([], 400);
        }

        $file = $request->file('file');
        $path = $file->store('private');

        $directoryName = $request->get('directory_name', 'root');
        $directory = Directory::whereName($directoryName)->where('user_id', '=', Auth::user()->id)->limit(1)->get();

        if (!$directory) {
            $directory = new Directory([
                'name' => $directoryName,
                'user_id' => Auth::user()->id
            ]);

            $directory->saveOrFail();
        }

        $file = new File([
            'name' => $file->getClientOriginalName(),
            'user_id' => Auth::user()->id,
            'expired_at' => $request->get('expired_at', null),
            'directory_id' => $directory->id,
            'filename' => $path,
            'disk_space' => $file->getSize()
        ]);

        $file->saveOrFail();
    }
}
