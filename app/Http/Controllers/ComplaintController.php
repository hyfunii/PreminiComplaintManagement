<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\ComplaintCategory;
use App\Models\Response;
use Auth;

class ComplaintController extends Controller
{
    public function home()
    {
        return view('user.home');
    }

    public function dashboard()
    {
        if (!Auth::check()) {

            return redirect()->route('login')->with('warning', 'Please login to access this page.');
        }

        $user = Auth::user();

        if ($user->role_id == 1) {
            $complaints = Complaint::with('user', 'category', 'status')
                ->whereDoesntHave('responses')
                ->get();
            return view('admin.complaints', compact('complaints'));
        } elseif ($user->role_id == 2) {
            $categories = ComplaintCategory::all();
            $complaints = Complaint::with('category', 'status')
                ->where('user_id', $user->id)
                ->get();
            return view('user.our_complaint', compact('complaints', 'categories'));
        }
    }

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Please login to access this page.');
        }

        $user = Auth::user();

        if ($user->role_id == 1) {
            $complaints = Complaint::with('user', 'category', 'status')
                ->whereDoesntHave('responses')
                ->get();
            return view('admin.complaints', compact('complaints'));
        } elseif ($user->role_id == 2) {
            $categories = ComplaintCategory::all();
            $complaints = Complaint::with('category', 'status')
                ->where('user_id', $user->id)
                ->whereDoesntHave('responses')
                ->get();
            return view('user.complaints', compact('complaints', 'categories'));
        }

        return redirect()->route('login')->with('error', 'Unauthorized action. Please login with valid credentials.');
    }


    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:complaint_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);


        $filePath = null;
        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('complaints', 'public');
        }

        Complaint::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'status_id' => 1,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
        ]);

        return redirect()->route('complaints.dashboard')->with('success', 'Pengaduan berhasil dikirim.');
    }

    public function destroy($id)
    {
        $complaint = Complaint::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $complaint->files()->delete();
        $complaint->delete();

        return redirect()->route('complaints.dashboard')->with('success', 'Your complaint has been successfully canceled.');
    }
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:1',
        ]);

        $query = $request->input('query');

        $complaints = Complaint::with('user', 'category', 'status')
            ->whereDoesntHave('responses')
            ->where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->get();

        return view('admin.complaints', compact('complaints'));
    }

}
