<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Response;
use App\Models\Response;
use App\Models\Complaint;
use Auth;

class ResponseController extends Controller
{
    public function index()
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            // Jika tidak login, arahkan ke halaman login
            return redirect()->route('login')->with('warning', 'Please login to access this page.');
        }

        $user = Auth::user();
        // Mengambil semua data responses beserta admin dan complaint
        $responses = Response::with('admin', 'complaint')->get();

        // Return view ke response.index dengan mengirimkan data responses
        return view('admin.response', compact('responses'));
    }

    public function detail($id)
    {
        $response = Response::with('admin', 'complaint')->findOrFail($id);

        return view('admin.response_details', compact('response'));
    }

    public function create($id)
    {
        // Ambil data keluhan berdasarkan ID yang dipilih
        $complaint = Complaint::findOrFail($id);

        // Kembalikan view dengan data keluhan yang dipilih
        return view('admin.response_proses', compact('complaint'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'response_text' => 'required|string',
            'complaint_id' => 'required|exists:complaints,id',
            'admin_id' => 'required|exists:users,id',
        ]);

        // Simpan data respon ke dalam tabel responses
        $response = new Response();
        $response->complaint_id = $request->complaint_id;
        $response->admin_id = $request->admin_id;
        $response->response_text = $request->response_text;
        $response->save();


        // Update status keluhan di tabel complaints menjadi status ID 2 (proses)
        $complaint = Complaint::findOrFail($request->complaint_id);
        $complaint->status_id = 2; // Status 'Proses'
        $complaint->save();

        // Redirect kembali ke halaman complaints atau halaman lain sesuai kebutuhan
        return redirect()->route('complaints.index')->with('success', 'Respon berhasil disimpan dan status keluhan diperbarui.');
    }

    // Menampilkan daftar pengaduan yang dibuat oleh user
    // Menampilkan daftar pengaduan yang dibuat oleh user yang sedang login
    public function ourComplaints()
    {
        // Mengambil pengguna yang sedang login
        $user = Auth::user();

        // Mengambil semua complaint yang hanya dibuat oleh user yang sedang login
        $complaints = Complaint::where('user_id', $user->id)  // Filter by user_id
            ->with('category', 'status')  // Memuat relasi kategori dan status
            ->get();

        // Return view untuk menampilkan daftar pengaduan user
        return view('user.our_complaint', compact('complaints'));
    }

    // Menampilkan detail dari complaint dan response
    public function ourResponse($id)
    {
        // Mengambil pengguna yang sedang login
        $user = Auth::user();

        // Cari complaint berdasarkan ID dan pastikan itu milik user yang sedang login
        $complaint = Complaint::where('id', $id)
            ->where('user_id', $user->id)  // Filter by user_id
            ->with('category', 'status')   // Memuat relasi kategori dan status
            ->firstOrFail();

        // Cari response jika sudah ada
        $response = Response::where('complaint_id', $complaint->id)
            ->with('admin')  // Memuat relasi admin yang memberikan respon
            ->first();

        // Return view untuk menampilkan detail pengaduan dan responnya
        return view('user.our_response', compact('complaint', 'response'));
    }

    public function search(Request $request)
    {
        // Validasi input pencarian
        $request->validate([
            'query' => 'required|string|min:1',
        ]);

        $query = $request->input('query');

        // Cari respons yang sesuai dengan query pencarian
        $responses = Response::with('complaint.user')
            ->where('response_text', 'LIKE', "%{$query}%")
            ->get();

        return view('admin.response', compact('responses'));
    }

}
