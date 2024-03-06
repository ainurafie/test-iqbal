<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Target;
use App\Models\Rekening;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $targets = Target::leftJoin('rekenings', 'targets.id_rekening', '=', 'rekenings.id_rekening')->where(function ($query) use ($search) {
            if ($search) {
                $query->where('tahun', 'like', '%' . $search . '%')
                ->orWhere('jumlah_target', 'like', '%' . $search . '%')
                ->orWhere('rekenings.jenis_rekening', 'like', '%' . $search . '%')
                ->orWhere('rekenings.sub_rekening', 'like', '%' . $search . '%')
                ->orWhere('rekenings.nama_rekening', 'like', '%' . $search . '%');
            }
        })->paginate(10);

        return view('target.index', compact('targets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rekenings = Rekening::get();
        return view('target.create', compact('rekenings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_rekening' => 'numeric|required',
            'tahun' => 'numeric|required',
            'jumlah_target' => 'numeric|required'
        ]);

        $input = $request->all();

        Target::create($input);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => null,
                'message' => 'Target Berhasil Ditambahkan.',
                'redirect' => route('target.index'),
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
        $target = Target::where('id_target', $id)->first();
        $rekenings = Rekening::get();
        return view('target.edit', compact('target', 'rekenings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_rekening' => 'numeric|required',
            'tahun' => 'numeric|required',
            'jumlah_target' => 'numeric|required'
        ]);

        $input = $request->all();

        $target = Target::where('id_target', $id)->first();

        $input = $request->all();

        $target->update($input);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => null,
                'message' => 'Target Berhasil Di ubah.',
                'redirect' => route('target.index'),
            ], 200);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $target = Target::where('id_target', $id)->first();

        $target->delete();

        return redirect()->route('target.index')->with('message', 'Data berhasil di hapus');
    }
}
