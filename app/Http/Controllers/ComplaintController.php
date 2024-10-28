<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Complaint;
use App\Models\ComplaintStatus;
use App\Models\ComplaintCategory;
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
            $complaintsByStatus = Complaint::select('status_id', ComplaintStatus::raw('count(*) as total'))
                ->groupBy('status_id')
                ->pluck('total', 'status_id');

            $submitted = $complaintsByStatus[1] ?? 0;
            $processed = $complaintsByStatus[2] ?? 0;
            $done = $complaintsByStatus[3] ?? 0;

            $latestcomplaints = Complaint::with('user', 'category', 'status')
                ->latest()
                ->first();

            return view('admin.dashboard', compact('submitted', 'processed', 'done', 'latestcomplaints'));

        } elseif ($user->role_id == 2) {
            $categories = ComplaintCategory::all();
            $complaints = Complaint::with('category', 'status')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            $myComplaints = $complaints->where('status_id', 1);
            $processedComplaints = $complaints->where('status_id', 2);
            $completedComplaints = $complaints->where('status_id', 3);

            return view('user.our_complaint', compact('myComplaints', 'processedComplaints', 'completedComplaints', 'categories'));
        }

        return redirect()->route('login')->with('error', 'Unauthorized action. Please login with valid credentials.');
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
                ->get()
                ->sortByDesc('created_at');
            return view('admin.complaints', compact('complaints'));
        } elseif ($user->role_id == 2) {
            $categories = ComplaintCategory::all();
            $complaints = Complaint::with('category', 'status')
                ->where('user_id', $user->id)
                ->get();
            return view('user.complaints', compact('complaints', 'categories'));
        }

        return redirect()->route('login')->with('error', 'Unauthorized action. Please login with valid credentials.');
    }

    public function show($id)
    {
        $complaint = Complaint::with('user', 'category', 'status')->findOrFail($id);

        return view('admin.complaint_details', compact('complaint'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:complaint_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $existingComplaint = Complaint::where('user_id', Auth::id())
            ->where('description', $request->description)
            ->first();

        if ($existingComplaint) {
            return redirect()->back()->withErrors(['description' => 'This complaint has been made!'])->withInput();
        }

        $filePath = null;
        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('complaints', 'public');
        }

        $complaint = Complaint::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'status_id' => 1,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
        ]);

        if ($filePath) {
            File::create([
                'complaint_id' => $complaint->id,
                'file_path' => $filePath,
                'file_type' => $request->file('file_path')->getClientMimeType(),
            ]);
        }

        return redirect()->route('complaints.dashboard')->with('success', 'Complaint sent!');
    }


    public function edit($id)
    {
        $complaint = Complaint::findOrFail($id);
        $categories = ComplaintCategory::all();

        return view('complaints.edit', compact('complaint', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category_id' => 'required|exists:complaint_categories,id',
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $existingComplaint = Complaint::where('user_id', Auth::id())
            ->where('description', $request->description)
            ->first();

        if ($existingComplaint) {
            return redirect()->back()->withErrors(['title' => 'You already have a complaint with this title. Please choose a different title.']);
        }

        $complaint = Complaint::findOrFail($id);

        $complaint->title = $request->input('title');
        $complaint->description = $request->input('description');
        $complaint->category_id = $request->input('category_id');

        if ($request->hasFile('image')) {
            if ($complaint->file_path) {
                Storage::disk('public')->delete($complaint->file_path);
            }

            $filePath = $request->file('image')->store('complaints', 'public');
            $complaint->file_path = $filePath;

            File::updateOrCreate(
                ['complaint_id' => $complaint->id],
                ['file_path' => $filePath, 'file_type' => $request->file('image')->getClientOriginalExtension()]
            );
        }

        $complaint->save();

        return redirect()->back()->with('success', 'Complaint updated successfully!');
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
            ->where('status_id', 1)
            ->where(function ($q) use ($query) {
                $q->whereHas('user', function ($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%");
                })
                    ->orWhere('title', 'LIKE', "%{$query}%");
            })
            ->get();

        return view('admin.complaints', compact('complaints'));
    }

}
