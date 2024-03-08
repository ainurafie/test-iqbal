<?php

namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransaksiExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection(): Collection
    {
        return Transaksi::leftJoin('rekenings', 'transaksis.id_rekening', '=', 'rekenings.id_rekening')->get()->map(function ($transaksi) {
            return [
                'jenis_sub_rekening' => $transaksi->jenis_rekening . ' ' . $transaksi->sub_rekening,
                'nama_rekening' => $transaksi->nama_rekening,
                'tanggal_setor' => $transaksi->tanggal_setor,
                'jumlah_setor' => $transaksi->jumlah_setor,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Kode Rekening',
            'Nama Rekening',
            'Tanggal Setor',
            'Target (RP)',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A:C' => ['width' => 200],
        ];
    }
}
