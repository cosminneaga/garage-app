<?php

declare(strict_types=1);

namespace App\Traits;

enum Types: string
{
    case SUCCESS = 'success';
    case ERROR = 'error';
    case WARNING = 'warning';
    case INFO = 'info';

    public function label(): string
    {
        return match ($this) {
            self::SUCCESS => 'Resource saved',
            self::ERROR => 'An error occured',
            self::WARNING => 'Resource modified',
            self::INFO => 'Info message',
        };
    }
}

trait ResponseMessage
{
    public static function flashMessage(string $type, ?string $title = null, ?string $message = null): array
    {
        return [
            'message' => (object) [
                'type' => Types::from($type)->value,
                'title' => $title ?? Types::from($type)->label(),
                'message' => $message ?? '',
            ],
        ];
    }
}
