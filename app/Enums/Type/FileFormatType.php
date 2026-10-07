<?php

namespace App\Enums\Type;

use App\Traits\HasEnumOptions;
use Illuminate\Support\Collection;

enum FileFormatType: string
{
    use HasEnumOptions;

    case ALL = 'all';
    case IMAGE = 'image';
    case DOCUMENT = 'document';
    case VIDEO = 'video';

    public function label(): string
    {
        return match ($this) {
            self::ALL => 'All Files',
            self::IMAGE => 'Images',
            self::DOCUMENT => 'Documents',
            self::VIDEO => 'Videos',
        };
    }

    public function form(): string
    {
        return match ($this) {
            self::ALL => '*/*',
            self::IMAGE => 'image/*',
            self::DOCUMENT => '.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv,.zip,.rar,.7z',
            self::VIDEO => 'video/mp4,video/webm,video/quicktime,video/x-msvideo,video/x-matroska,video/mpeg,video/ogg,video/3gpp,video/x-flv,'
        };
    }

    public function validation(): string
    {
        return match ($this) {
            self::ALL => 'file',
            self::IMAGE => 'jpg,jpeg,png,gif,webp',
            self::DOCUMENT => 'pdf,doc,docx,xls,xlsx,ppt,pptx,txt',
            self::VIDEO => 'mp4,webm,quicktime,x-msvideo,x-matroska,mpeg,ogg,3gpp,x-flv',
        };
    }

    public static function mergeForm(array $args): string
    {
        return Collection::make($args)
            ->map(fn (FileFormatType $type) => $type->form())
            ->implode(',');
    }

    public static function mergeValidation(array $args): string
    {
        return 'mimes:' . Collection::make($args)
            ->map(fn (FileFormatType $type) => $type->validation())
            ->implode(',');
    }

    public static function checkMime(FileFormatType $type, string $mime): bool
    {
        return Collection::make(explode(',', $type->validation()))
            ->contains(str($mime)->after('/')->toString());
    }
}
