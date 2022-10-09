<?php

namespace App\Http\Controllers;

use App\Http\Requests\DirectoryRequest;
use App\Models\Directory;
use Illuminate\Http\JsonResponse;

class DirectoryController extends Controller
{

    /**
     * Get all directories
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse(Directory::all());
    }

    /**
     * Creates a new directory and if successful returns it
     *
     * @param DirectoryRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function createDirectory(DirectoryRequest $request) : JsonResponse
    {
        $dir = new Directory(['name' => $request->name]);
        $dir->saveOrFail();

        return new JsonResponse($dir);
    }
}
