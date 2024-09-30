<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    // Untuk Admin
    public function adminIndex()
    {
        $loans = Loan::with(['user', 'book'])
            ->whereNull('returned_at')
            ->paginate(10);

        return view('admin.loans.index', compact('loans'));
    }

    public function adminHistory()
    {
        $loans = Loan::with(['user', 'book'])
            ->whereNotNull('returned_at')
            ->paginate(10);

        return view('admin.loans.history', compact('loans'));
    }


    // Untuk User
    public function index()
    {
        $loans = Loan::where('user_id', auth()->id())
            ->whereNull('returned_at')
            ->with('book')
            ->paginate(10);

        return view('user.loans.index', compact('loans'));
    }

    public function history()
    {
        $history = Loan::where('user_id', auth()->id())
            ->whereNull('deleted_by_user_at')
            ->with('book')
            ->orderBy('borrowed_at', 'desc')
            ->paginate(10);

        return view('user.loans.history', compact('history'));
    }

    public function borrow(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        if ($book->stock > 0) {
            $book->stock--;
            $book->save();

            $loan = new Loan();
            $loan->user_id = Auth::id();
            $loan->book_id = $book->id;
            $loan->borrowed_at = now();
            $loan->save();

            return redirect()->route('user.loans.index')->with('success', 'Buku berhasil dipinjam.');
        } else {
            return redirect()->route('user.loans.index')->with('error', 'Stok buku tidak tersedia.');
        }
    }

    public function return($id)
    {
        $loan = Loan::findOrFail($id);

        if ($loan->returned_at === null) {
            $loan->returned_at = now();
            $loan->save();

            $book = $loan->book;
            $book->increment('stock');
        }

        return redirect()->route('user.loans.index')->with('success', 'Buku berhasil dikembalikan.');
    }

    public function deleteHistory($id)
    {
        $loan = Loan::where('user_id', auth()->id())->findOrFail($id);

        if ($loan->returned_at !== null) {
            $loan->deleted_by_user_at = now();
            $loan->save();

            return redirect()->route('user.loans.history')->with('success', 'Riwayat peminjaman berhasil dihapus.');
        }

        return redirect()->route('user.loans.history')->with('error', 'Anda hanya bisa menghapus riwayat peminjaman yang sudah dikembalikan.');
    }
}
