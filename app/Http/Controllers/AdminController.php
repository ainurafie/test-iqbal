<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rekening;
use App\Models\Target;
use App\Models\Transaksi;

class AdminController extends Controller
{
    public function index() {
        $rekening_count= Rekening::get()->count();
        $target_count= Target::get()->count();
        $transaksi_count= Transaksi::get()->count();
        return view('admin.dashboard', compact('rekening_count', 'target_count', 'transaksi_count'));
    }
}
