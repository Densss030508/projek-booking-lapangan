<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $dari;
    protected $sampai;
    protected $lapangan;

    public function __construct($dari, $sampai, $lapangan)
    {
        $this->dari     = $dari;
        $this->sampai   = $sampai;
        $this->lapangan = $lapangan;
    }

    public function collection()
    {
        $query = Transaksi::query();

        if ($this->dari && $this->sampai) {
            $query->whereBetween('tanggal', [$this->dari, $this->sampai]);
        }

        if ($this->lapangan) {
            $query->where('lapangan', $this->lapangan);
        }

        return $query->orderBy('tanggal')->get();
    }

    public function headings(): array
    {
        return ['No', 'Tanggal', 'Lapangan', 'Nama', 'Jam', 'Durasi', 'Total'];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $row->tanggal,
            $row->lapangan,
            $row->nama,
            $row->jam,
            $row->durasi . ' Jam',
            'Rp ' . number_format($row->total, 0, ',', '.'),
        ];
    }
}
