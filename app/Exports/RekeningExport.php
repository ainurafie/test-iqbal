<?php
namespace App\Exports;

use App\Models\Rekening;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekeningExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection(): Collection
    {
        return Rekening::get()->map(function ($rekening) {
            return [
                'jenis_rekening' => $rekening->jenis_rekening,
                'sub_rekening' => $rekening->sub_rekening ?? '',
                'nama_rekening' => $rekening->nama_rekening
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Jenis Rekening',
            'Sub Rekening',
            'Nama Rekening'
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