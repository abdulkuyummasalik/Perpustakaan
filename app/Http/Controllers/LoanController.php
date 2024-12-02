<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    const BORROW_DURATION_DAYS = 7; // Durasi peminjaman dalam hari
    const FINE_PER_DAY = 1000; // Denda per hari per buku

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
                'due_date' => now()->addDays(self::BORROW_DURATION_DAYS), // Mengatur tanggal jatuh tempo
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
