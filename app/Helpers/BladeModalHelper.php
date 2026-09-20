<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Collection;

class BladeModalHelper
{
    public static function modal(string $id): string
    {
        return $id . '_modal';
    }

    public static function trigger(string $id): string
    {
        return $id . '_trigger';
    }

    public static function form(string $id): string
    {
        return $id . '_form';
    }

    public static function submit(string $id): string
    {
        return $id . '_submit';
    }

    public static function picker(string $id): string
    {
        return $id . '_picker';
    }

    public static function pickerStart(string $id): string
    {
        return $id . '_picker_start';
    }

    public static function pickerEnd(string $id): string
    {
        return $id . '_picker_end';
    }

    public static function ids(string $id): Collection
    {
        return Collection::make([
            'modal' => self::modal($id),
            'trigger' => self::trigger($id),
            'form' => self::form($id),
            'submit' => self::submit($id),
            'picker' => self::picker($id),
            'picker_date' => self::pickerStart($id),
            'picker_time' => self::pickerEnd($id),
        ]);
    }
}
