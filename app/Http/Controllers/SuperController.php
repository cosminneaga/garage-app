<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;

class SuperController extends Controller
{
    public function users(Request $request)
    {
        $search = $request->string('search')->value();

        return view('pages.super.users.index', [
            'data' => User::search($search)->paginate(10),
        ]);
    }

    public function companies(Request $request)
    {
        $search = $request->string('search')->value();

        return view('pages.super.companies.index', [
            'data' => Company::search($search)->paginate(10),
        ]);
    }

    public function suppliers(Request $request)
    {
        $search = $request->string('search')->value();

        return view('pages.super.suppliers.index', [
            'data' => Supplier::search($search)->paginate(10),
        ]);
    }
}
