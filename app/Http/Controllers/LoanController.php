<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    // Untuk Admin
    public function adminIndex(Request $request)
    {
        $search = $request->input('search');
        $loans = Loan::with(['user', 'book'])
            ->whereNull('returned_at')
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('book', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                });
            })
            ->simplePaginate(10);

        return view('admin.loans.index', compact('loans', 'search'));
    }

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
        // Peminjaman Aktif
        $loansQuery = Loan::with('book')->where('user_id', auth()->id())->whereNull('returned_at');

        if ($request->has('search') && !empty($request->search)) {
            $loansQuery->whereHas('book', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('author', 'like', '%' . $request->search . '%');
            });
        }

        $loans = $loansQuery->simplePaginate(5);

        // Riwayat Peminjaman
        $historyQuery = Loan::with('book')->where('user_id', auth()->id())->whereNotNull('returned_at');

        if ($request->has('search') && !empty($request->search)) {
            $historyQuery->whereHas('book', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('author', 'like', '%' . $request->search . '%');
            });
        }

        $history = $historyQuery->simplePaginate(5);

        return view('user.loans.index', compact('loans', 'history'));
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
}
