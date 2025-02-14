<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Admin;
use Exception;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request for both users and admins.
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'role' => 'required|in:user,admin',
            ]);
            $credentials = $request->only('email', 'password');
            if ($request->role === 'admin') {
                if (Auth::guard('admin')->attempt($credentials)) {
                    return redirect()->route('books.index')->with('success', 'Welcome Admin!');
                }
            } elseif ($request->role === 'user') {
                if (Auth::guard('web')->attempt($credentials)) {
                    return redirect()->route('user.index')->with('success', 'Welcome User!');
                }
            }
            return back()->withErrors(['email' => 'Invalid credentials or role selection.']);

        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }

    /**
     * Logout both users and admins.
     */
    public function logout(Request $request)
    {
        try {
            Auth::guard('web')->logout();
            Auth::guard('admin')->logout();
            return redirect('/login')->with('success', 'You have logged out successfully.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Logout failed: ' . $e->getMessage()]);
        }
    }
}
