<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // User
    public function show()
    {
        $user = Auth::user();
        $loans = Loan::with('book')->where('user_id', $user->id)->get();
        return view('user.profile', compact('user', 'loans'));
    }

    // Admin
    public function showAdmin()
{
    $user = Auth::user();
    $loans = Loan::with('book', 'user')->get();
    $totalBooks = Book::count();
    return view('admin.profile', compact('user', 'loans', 'totalBooks'));
}

}
