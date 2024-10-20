<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\ComplaintCategory;
use Auth;

class ComplaintController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Mendapatkan user yang sedang login

        // Cek apakah user adalah admin (role_id = 1)
        if ($user->role_id == 1) {
            // Jika admin, ambil semua data complaint dengan relasi user, kategori, dan status
            $complaints = Complaint::with('user', 'category', 'status')->get();
            return view('admin.complaints', compact('complaints'));
        }
        // Jika user biasa (role_id = 2)
        elseif ($user->role_id == 2) {
            // Ambil hanya complaint milik user yang sedang login
            $categories = ComplaintCategory::all();
            $complaints = Complaint::with('category', 'status')->where('user_id', $user->id)->get();
            return view('user.complaints', compact('complaints','categories'));
            // return view('user.home', compact('complaints'));
        }

        // Default fallback jika role tidak dikenali
        abort(403, 'Unauthorized action.');
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

}
