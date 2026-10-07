<?php

namespace App\Http\Controllers;

use App\Actions\FileGroupUpload;
use App\Enums\Type\FileType;
use App\Http\Requests\StoreFileGroupRequest;
use App\Models\File;
use App\Models\User;
use App\Traits\RelatedModelGuard;
use App\Traits\ResponseMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    use ResponseMessage;
    use RelatedModelGuard;

    public function userImage(Request $request, User $user)
    {
        $path = Storage::disk('local')->path($user->image_path);
        abort_unless(file_exists($path), 404);

        return response()->file($path);
    }

    public function preview(Request $request, File $file)
    {
        $path = Storage::disk('local')->path($file->path);
        abort_unless(file_exists($path), 404);

        return response()->file($path);
    }

    public function store(
        StoreFileGroupRequest $request,
        FileGroupUpload $upload
    ): RedirectResponse {
        $upload->handle(
            FileType::tryFrom($request->type),
            $request->description,
            $request->file('files')
        );

        return back()
            ->with(self::flashMessage(
                'success',
                'Resources created',
                'Files has been uploaded successfully'
            ));
    }

    public function modelIndex(request $request, string|int $model_id): JsonResponse
    {
        self::guard('show', $request, $model_id);

        return response()->json(self::$entity->files);
    }

    public function modelStore(
        StoreFileGroupRequest $request,
        string|int $model_id,
        FileGroupUpload $upload
    ): RedirectResponse {
        self::guard('update', $request, $model_id);

        $files = $upload->handle(
            FileType::tryFrom($request->type),
            $request->description,
            $request->file('files')
        );
        self::$entity->files()->attach($files);

        return back()
            ->with(self::flashMessage(
                'success',
                'Resources created',
                'Files has been uploaded successfully'
            ));
    }
}
