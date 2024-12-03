<?php

namespace App\Exports;

use App\Models\Loan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LoansExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Mengambil semua data pinjaman beserta relasi user
        return Loan::with('user')->get();
    }

    // headings: nama-nama kolom di file excel
    public function headings(): array
    {
        return [
            'No',
            'Nama Pengguna',
            "Judul Buku",
            "Tanggal Pinjam",
            "Tanggal Dikembalikan",
            "Denda",
        ];
    }

    // map: memetakan data ke dalam array sesuai dengan urutan headings
    public function map($item): array
    {
        return [
            $item->id,
            $item->user->name,
            $item->book->title,
            $item->borrowed_at->timezone('Asia/Jakarta')->format('Y-m-d'),
            $item->returned_at ? $item->returned_at->format('Y-m-d') : 'Belum Dikembalikan',
            $item->final_fine ? $item->final_fine : ($item->returned_at ? 'Tidak Ada Denda' : 'Belum Dikembalikan')
        ];
        
    }
}
