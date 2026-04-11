<?php

namespace App\Exports;

use App\Models\Transaksi;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    protected $dari;
    protected $sampai;
    protected $lapangan;
    protected $no = 0;
    protected $totalPendapatan = 0;

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

        $data = $query->orderBy('tanggal', 'desc')->get();

        $this->totalPendapatan = $data->sum('total');

        return $data;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Booking',
            'Lapangan',
            'Jam Booking',
            'Durasi',
            'Nama Penyewa',
            'No HP',
            'ID Transaksi',
            'Total Bayar',
            'Status',
        ];
    }

    public function map($row): array
    {
        $this->no++;

        $jamArray = array_map('trim', explode(',', $row->jam));
        $jumlahJam = count($jamArray);

        $jamTampil = $jumlahJam >= 4
            ? $jamArray[0] . ' - ' . end($jamArray)
            : implode(', ', $jamArray);

        return [
            $this->no,
            Carbon::parse($row->tanggal)->translatedFormat('d M Y'),
            $row->lapangan,
            $jamTampil,
            $row->durasi . ' Jam',
            $row->nama,
            $row->no_hp,
            $row->kode_transaksi,
            'Rp ' . number_format($row->total, 0, ',', '.'),
            'Berhasil',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet;

                // =========================
                // 🔥 JUDUL KIXA DI ATAS
                // =========================
                $sheet->mergeCells('A1:J1');
                $sheet->setCellValue('A1', 'LAPORAN TRANSAKSI KIXA');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                    ],
                ]);

                // geser header tabel ke bawah
                $sheet->insertNewRowBefore(2, 1);

                // =========================
                // STYLE HEADER
                // =========================
                $sheet->getStyle('A2:J2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                    ],
                ]);

                // =========================
                // TOTAL PENDAPATAN
                // =========================
                $lastRow = $sheet->getHighestRow() + 1;

                $sheet->setCellValue('H' . $lastRow, 'Total Pendapatan');
                $sheet->setCellValue(
                    'I' . $lastRow,
                    'Rp ' . number_format($this->totalPendapatan, 0, ',', '.')
                );

                $sheet->getStyle('H' . $lastRow . ':I' . $lastRow)->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);
            },
        ];
    }
}
