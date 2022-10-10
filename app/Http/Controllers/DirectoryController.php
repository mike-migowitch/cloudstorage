<?php

namespace App\Http\Controllers;

use App\Http\Requests\DirectoryRequest;
use App\Models\Directory;
use Auth;
use Illuminate\Http\JsonResponse;

class DirectoryController extends Controller
{

    /**
     * Get all user directories
     *
     * @return JsonResponse
     */
    public function getAllUserDirectories(): JsonResponse
    {
        return new JsonResponse(Directory::all()->where("user_id", "=", Auth::user()->id));
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
        $dir = new Directory([
            'name' => $request->name,
            'user_id' => Auth::user()->id
        ]);

        $dir->saveOrFail();

        return new JsonResponse($dir);
    }

    /**
     * Returns the disk space occupied by a directory
     * @param Directory $directory
     * @return JsonResponse
     */
    public function getDiskSpaceUsage(Directory $directory): JsonResponse
    {
        $this->authorize('view', $directory);

        return new JsonResponse([$directory->name => $directory->getDiskSpaceUsage()]);
    }
}
