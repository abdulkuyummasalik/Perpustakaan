<?php

namespace App\Http\Controllers;

use App\Exports\LoansExport;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class LoanController extends Controller
{
    const BORROW_DURATION_DAYS = 7; // Durasi peminjaman dalam hari
    const FINE_PER_MINUTE = 100;

    // Untuk Admin
    public function adminHistory(Request $request)
    {
        $search = $request->input('search');

        $loans = Loan::with(['user', 'book'])
            ->whereNotNull('returned_at')
            ->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            })
            ->orWhereHas('book', function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%");
            })
            ->simplePaginate(10);

        return view('admin.loans.history', compact('loans', 'search'));
    }

    public function exportExcell()
    {
        $file_name = 'riwayat_peminjaman.xlsx';

        return Excel::download(new LoansExport(), $file_name);
    }

    // Untuk User
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Peminjaman aktif
        $loansQuery = Loan::with('book')->where('user_id', $userId)->whereNull('returned_at');
        if ($request->filled('search')) {
            $loansQuery->whereHas('book', function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('author', 'like', '%' . $request->search . '%');
            });
        }
        $loans = $loansQuery->simplePaginate(10);

        // Riwayat peminjaman
        $historyQuery = Loan::with('book')->where('user_id', $userId)->whereNotNull('returned_at');
        if ($request->filled('search')) {
            $historyQuery->whereHas('book', function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('author', 'like', '%' . $request->search . '%');
            });
        }
        $history = $historyQuery->simplePaginate(10);

        return view('user.loans.index', compact('loans', 'history'));
    }

    public function borrow(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        if ($book->stock > 0) {
            $book->decrement('stock');

            Loan::create([
                'user_id' => Auth::id(),
                'book_id' => $book->id,
                'borrowed_at' => now(),
                'due_date' => now()->addMinutes(1), // Mengatur tanggal jatuh tempo 1 menit setelah pinjam
            ]);

            return redirect()->route('user.loans.index')->with('success', 'Buku berhasil dipinjam.');
        } else {
            return redirect()->route('user.loans.index')->with('error', 'Stok buku tidak tersedia.');
        }
    }


    public function return($id)
    {
        $loan = Loan::findOrFail($id);

        if (is_null($loan->returned_at)) {
            // Hitung denda jika ada
            $loan->final_fine = $loan->calculateFine(); // Panggil metode dari model
            $loan->returned_at = now();
            $loan->save();

            $loan->book->increment('stock');
        }

        return redirect()->route('user.loans.index')->with('success', 'Buku berhasil dikembalikan.');
    }
}
