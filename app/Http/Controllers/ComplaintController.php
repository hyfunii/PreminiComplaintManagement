<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function home()
    {
        return view('user.home');
    }

    public function dashboard()
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            // Jika tidak login, arahkan ke halaman login
            return redirect()->route('login')->with('warning', 'Please login to access this page.');
        }

        $user = Auth::user();

        // Cek apakah user adalah admin (role_id = 1)
        if ($user->role_id == 1) {
            // Jika admin, ambil semua data complaint dengan relasi user, kategori, dan status
            // Tambahkan whereDoesntHave untuk filter keluhan yang belum direspons
            $complaints = Complaint::with('user', 'category', 'status')
                ->whereDoesntHave('responses') // Memastikan keluhan belum direspons
                ->get();
            return view('admin.complaints', compact('complaints'));
        }
        // Jika user biasa (role_id = 2)
        elseif ($user->role_id == 2) {
            // Ambil hanya complaint milik user yang sedang login dan belum direspons
            $categories = ComplaintCategory::all();
            $complaints = Complaint::with('category', 'status')
                ->where('user_id', $user->id)
                ->whereDoesntHave('responses') // Hanya keluhan tanpa respons
                ->get();
            return view('user.our_complaint', compact('complaints', 'categories'));
        }

        // Jika peran tidak dikenali, redirect ke halaman login
        return redirect()->route('login')->with('error', 'Unauthorized action. Please login with valid credentials.');
    }

    public function index()
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            // Jika tidak login, arahkan ke halaman login
            return redirect()->route('login')->with('warning', 'Please login to access this page.');
        }

        $user = Auth::user();

        // Cek apakah user adalah admin (role_id = 1)
        if ($user->role_id == 1) {
            // Jika admin, ambil semua data complaint dengan relasi user, kategori, dan status
            // Tambahkan whereDoesntHave untuk filter keluhan yang belum direspons
            $complaints = Complaint::with('user', 'category', 'status')
                ->whereDoesntHave('responses') // Memastikan keluhan belum direspons
                ->get();
            return view('admin.complaints', compact('complaints'));
        }
        // Jika user biasa (role_id = 2)
        elseif ($user->role_id == 2) {
            // Ambil hanya complaint milik user yang sedang login dan belum direspons
            $categories = ComplaintCategory::all();
            $complaints = Complaint::with('category', 'status')
                ->where('user_id', $user->id)
                ->whereDoesntHave('responses') // Hanya keluhan tanpa respons
                ->get();
            return view('user.complaints', compact('complaints', 'categories'));
        }

        // Jika peran tidak dikenali, redirect ke halaman login
        return redirect()->route('login')->with('error', 'Unauthorized action. Please login with valid credentials.');
    }


    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:complaint_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png|max:2048', // Maksimal 2MB
        ]);

        // Simpan file jika diupload
        $filePath = null;
        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('complaints', 'public');
        }

        // Simpan pengaduan
        Complaint::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'status_id' => 1, // Set status default, misal "Menunggu" atau "Pending"
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
        ]);

        return redirect()->back()->with('success', 'Pengaduan berhasil dikirim.');
    }

    public function search(Request $request)
    {
        // Validasi input pencarian
        $request->validate([
            'query' => 'required|string|min:1',
        ]);

        $query = $request->input('query');

        // Cari pengaduan yang sesuai dengan query pencarian
        $complaints = Complaint::with('user', 'category', 'status')
            ->whereDoesntHave('responses')
            ->where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->get();

        return view('admin.complaints', compact('complaints'));
    }

}
