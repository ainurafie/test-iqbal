<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rekening;
use App\Exports\RekeningExport;
use Maatwebsite\Excel\Facades\Excel;

class RekeningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $rekenings = Rekening::where(function ($query) use ($search) {
            if ($search) {
                $query->where('nama_rekening', 'like', '%' . $search . '%')
                ->orWhere('jenis_rekening', 'like', '%' . $search . '%')
                ->orWhere('sub_rekenings', 'like', '%' . $search . '%');
            }
        })->paginate(10);

        return view('rekening.index', compact('rekenings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rekening.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_rekening' => 'numeric|required',
            'sub_rekening' => 'numeric|required',
            'nama_rekening' => 'string|required|max:255'
        ]);

        $input = $request->all();

        Rekening::create($input);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => null,
                'message' => 'Rekening Berhasil Ditambahkan.',
                'redirect' => route('rekening.index'),
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
        $rekening = Rekening::where('id_rekening', $id)->first();

        return view('rekening.edit', compact('rekening'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'jenis_rekening' => 'numeric|required',
            'sub_rekening' => 'numeric|required',
            'nama_rekening' => 'string|required|max:255'
        ]);

        $input = $request->all();

        $rekening = Rekening::where('id_rekening', $id)->first();

        $input = $request->all();

        $rekening->update($input);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => null,
                'message' => 'Rekening Berhasil Di ubah.',
                'redirect' => route('rekening.index'),
            ], 200);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rekening = Rekening::where('id_rekening', $id)->first();

        $rekening->delete();

        return redirect()->route('rekening.index')->with('message', 'Data berhasil di hapus');
    }
    public function exportRekening(){
        return Excel::download(new RekeningExport(), 'Data Rekening.xlsx', 'Xlsx');
    }
}
