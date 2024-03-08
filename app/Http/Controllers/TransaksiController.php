<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Rekening;
use App\Exports\TransaksiExport;
use Maatwebsite\Excel\Facades\Excel;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $transaksis = Transaksi::leftJoin('rekenings', 'transaksis.id_rekening', '=', 'rekenings.id_rekening')->where(function ($query) use ($search) {
            if ($search) {
                $query->where('tanggal_setor', 'like', '%' . $search . '%')
                ->orWhere('setor', 'like', '%' . $search . '%')
                ->orWhere('rekenings.jenis_rekening', 'like', '%' . $search . '%')
                ->orWhere('rekenings.sub_rekening', 'like', '%' . $search . '%')
                ->orWhere('rekenings.nama_rekening', 'like', '%' . $search . '%');
            }
        })->paginate(10);

        return view('transaksi.index', compact('transaksis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rekenings = Rekening::get();
        return view('transaksi.create', compact('rekenings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_rekening' => 'numeric|required',
            'tanggal_setor' => 'date|required',
            'jumlah_setor' => 'numeric|required'
        ]);

        $input = $request->all();

        Transaksi::create($input);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => null,
                'message' => 'Transaksi Berhasil Ditambahkan.',
                'redirect' => route('transaksi.index'),
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $transaksi = Transaksi::where('id_transaksi', $id)->first();
        $rekenings = Rekening::get();
        return view('transaksi.edit', compact('transaksi', 'rekenings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_rekening' => 'numeric|required',
            'tanggal_setor' => 'date|required',
            'jumlah_setor' => 'numeric|required'
        ]);

        $input = $request->all();

        $transaksi = Transaksi::where('id_transaksi', $id)->first();

        $input = $request->all();

        $transaksi->update($input);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => null,
                'message' => 'Transaksi Berhasil Di ubah.',
                'redirect' => route('transaksi.index'),
            ], 200);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaksi = Transaksi::where('id_transaksi', $id)->first();

        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('message', 'Data berhasil di hapus');
    }

    public function exportTransaksi(){
        return Excel::download(new TransaksiExport(), 'Data Transaksi.xlsx', 'Xlsx');
    }
}
