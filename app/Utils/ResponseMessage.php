<?php

declare(strict_types=1);

namespace App\Utils;

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
            self::INFO => 'Info message'
        };
    }
}

class ResponseMessage
{
    public string $type;

    public function __construct(string $type, public string $text)
    {
        $this->type = Types::from($type)->value;
    }

    public static function get(string $type, ?string $text = null): self
    {
        return new self($type, $text ?? Types::from($type)->label());
    }
}

// ResponseMessage::get('error', 'message');
