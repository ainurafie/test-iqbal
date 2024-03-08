<?php
namespace App\Exports;

use App\Models\Target;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TargetExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection(): Collection
    {
        return Target::leftJoin('rekenings', 'targets.id_rekening', '=', 'rekenings.id_rekening')->get()->map(function ($target) {
            return [
                'jenis_rekening' => $target->jenis_rekening,
                'sub_rekening' => $target->sub_rekening ?? '',
                'nama_rekening' => $target->nama_rekening,
                'tahun' => $target->tahun,
                'jumlah_target' => $target->jumlah_target,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Jenis Rekening',
            'Sub Rekening',
            'Nama Rekening',
            'tahun',
            'jumlah_rekening'
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