<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Throwable;

class Handler extends Exception
{
    /**
     * Render the exception as an HTTP response.
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof UnauthorizedException) {
            return response()->view('errors.index', [
                'exception' => $e,
            ], 403);
        }

        return parent::render($request, $e);
    }
}
