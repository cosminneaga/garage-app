<?php

namespace App\Actions;

use App\Enums\Type\FileType;
use App\Models\File;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FileGroupUpload
{
    public function __construct(#[CurrentUser] protected User $user)
    {
        //
    }

    public function handle(FileType $type, string $description, array $files, string $name = 'files'): Collection
    {
        return DB::transaction(function () use ($type, $description, $files, $name) {
            return Collection::make($files)
                ->map(function (UploadedFile $file) use ($name, $type, $description) {
                    $path = $file->store($name, 'local');

                    return File::create([
                        'type' => $type,
                        'description' => $description,
                        'name' => $file->getClientOriginalName(),
                        'extension' => $file->getClientOriginalExtension(),
                        'path' => $path,
                        'uploaded_by' => $this->user->id,
                    ]);
                });
        });
    }
}
