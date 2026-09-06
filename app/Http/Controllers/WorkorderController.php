<?php

namespace App\Http\Controllers;

use App\Traits\RelatedModelGuard;


class WorkorderController extends Controller
{
    use RelatedModelGuard;

    public function modelStore() {}

    public function modelEdit() {}

    public function modelUpdate() {}

    public function modelDestroy() {}
}
