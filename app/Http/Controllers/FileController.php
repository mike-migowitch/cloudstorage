<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Http\Responses\SuccessJsonResponse;
use App\Models\Directory;
use App\Models\File;
use Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    /**
     * Gets all user files
     * @return JsonResponse
     */
    public function getAllUserFiles(): JsonResponse
    {
        return new JsonResponse(Directory::with('files')->where("user_id", "=", Auth::user()->id)->get());
    }

    /**
     * Uploading a file to the server
     * If the directory name is not passed, then the file will be saved to root
     * If the directory with the given name does not exist, it will be created
     * @param FileRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function upload(FileRequest $request): JsonResponse
    {
        $file = $request->file('file');

        if (!Auth::user()->isFileFitOnDisk($file->getSize())) {
            return new JsonResponse([], 400);
        }

        $directoryName = $request->get('directory_name', 'root');
        $directory = Directory::whereName($directoryName)->where('user_id', '=', Auth::user()->id)->firstOrFail();

        if (!$directory) {
            $directory = new Directory([
                'name' => $directoryName,
                'user_id' => Auth::user()->id
            ]);

            $directory->saveOrFail();
        }

        $path = $file->store('private');

        $file = new File([
            'name' => $file->getClientOriginalName(),
            'user_id' => Auth::user()->id,
            'directory_id' => $directory->id,
            'filename' => $path,
            'disk_space' => $file->getSize()
        ]);

        $file->saveOrFail();

        return new SuccessJsonResponse();
    }

    /**
     * Renaming a file
     * @param File $file
     * @param Request $request
     * @return SuccessJsonResponse
     * @throws AuthorizationException
     * @throws \Throwable
     */
    public function rename(File $file, Request $request): SuccessJsonResponse
    {
        $this->authorize('update', $file);

        $file->name = $request->name;

        $file->saveOrFail();

        return new SuccessJsonResponse();
    }

    /**
     * Deleting a file
     * @param File $file
     * @return SuccessJsonResponse
     * @throws AuthorizationException
     * @throws \Throwable
     */
    public function destroy(File $file): SuccessJsonResponse
    {
        $this->authorize('delete', $file);

        Storage::delete($file->filename);
        $file->deleteOrFail();

        return new SuccessJsonResponse();
    }

    /**
     * Downloading a file
     * @param File $file
     * @return JsonResponse|StreamedResponse
     * @throws AuthorizationException
     */
    public function download(File $file): JsonResponse|StreamedResponse
    {
        $this->authorize('view', $file);

        if (!Storage::exists($file->filename)) {
            return new JsonResponse([], 404);
        }

        return Storage::download($file->filename);
    }
}
