<?php

namespace App\Http\Controllers;

use App\Models\Finca;
use Illuminate\Http\Request;

class fincaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return Finca::where('user_id', auth()->id())->get();

        }
    }
}
