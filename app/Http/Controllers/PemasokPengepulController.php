<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PemasokPengepulController extends Controller
{
    public function index()
    {
        // Ambil semua user dengan role = 2 (petani)
        $petanis = User::where('role_id', 2)->get();

        return view('pengepul.pemasok.index', compact('petanis'));
    }
}
