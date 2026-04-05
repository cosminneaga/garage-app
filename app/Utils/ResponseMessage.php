<?php

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

    public string $text;

    public function __construct(string $type, string $text)
    {
        $this->type = Types::from($type)->value;
        $this->text = $text;
    }

    public static function get(string $type, ?string $text = null): self
    {
        return new self($type, $text ?? Types::from($type)->label());
    }
}

// ResponseMessage::get('error', 'message');
