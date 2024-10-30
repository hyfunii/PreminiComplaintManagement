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
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Please login to access this page.');
        }

        $user = Auth::user();

        if ($user->role_id == '1') {
            $responses = Response::whereHas('complaint', function ($query) {
                $query->where('status_id', '!=', 3);
            })->with('admin', 'complaint')->get()->sortByDesc('created_at');

            $doneResponses = Response::whereHas('complaint', function ($query) {
                $query->where('status_id', 3);
            })->with('admin', 'complaint')->get()->sortByDesc('created_at');

            return view('admin.response', compact('responses', 'doneResponses'));
        } else if ($user->role_id == '2') {
            return redirect()->route('complaints.dashboard')->with('error', 'You not admin!');
        }

        return redirect()->route('ea');
    }

    public function detail($id)
    {
        $response = Response::with('admin', 'complaint')->findOrFail($id);

        return view('admin.response_details', compact('response'));
    }

    public function create($id)
    {
        $complaint = Complaint::findOrFail($id);

        return view('admin.response_proses', compact('complaint'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'response_text' => 'required|string',
            'complaint_id' => 'required|exists:complaints,id',
            'admin_id' => 'required|exists:users,id',
        ]);

        $exitstresponse = Response::where('complaint_id' , $request->complaint_id)->first();

        if ($exitstresponse) {
            return redirect()->route('response.index')->with('error', 'this complaint has responded!.');
        }

        $response = new Response();
        $response->complaint_id = $request->complaint_id;
        $response->admin_id = $request->admin_id;
        $response->response_text = $request->response_text;
        $response->save();


        $complaint = Complaint::findOrFail($request->complaint_id);
        $complaint->status_id = 2;
        $complaint->save();

        return redirect()->route('complaints.index')->with('success', 'response was successful');
    }

    public function cancel($id)
    {
        $response = Response::findOrFail($id);

        $complaint = $response->complaint;

        $response->delete();

        $complaint->status_id = 1;
        $complaint->save();

        return redirect()->route('response.index')->with('success', 'response cancelled.');
    }


    public function done($id)
    {
        $response = Response::findOrFail($id);
        $complaint = $response->complaint;

        $complaint->status_id = 3;
        $complaint->save();

        return redirect()->route('response.index')->with('success', 'Complaint status updated to Done.');
    }

    public function ourComplaints()
    {
        $user = Auth::user();

        $complaints = Complaint::where('user_id', $user->id)
            ->with('category', 'status')
            ->get();
        return view('user.our_complaint', compact('complaints'));
    }

    public function ourResponse($id)
    {
        $user = Auth::user();

        $complaint = Complaint::where('id', $id)
            ->where('user_id', $user->id)
            ->with('category', 'status')
            ->firstOrFail();

        $response = Response::where('complaint_id', $complaint->id)
            ->with('admin')
            ->first();

        return view('user.our_response', compact('complaint', 'response'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:1',
        ]);

        $query = $request->input('query');

        $responses = Response::with('complaint.user')
            ->where('response_text', 'LIKE', "%{$query}%")
            ->orWhereHas('complaint', function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhereHas('user', function ($q) use ($query) {
                        $q->where('name', 'LIKE', "%{$query}%");
                    });
            })
            ->whereHas('complaint', function ($q) {
                $q->where('status_id', 2);
            })
            ->get();

        $doneResponses = Response::with('complaint.user')
            ->whereHas('complaint', function ($q) use ($query) {
                $q->where('status_id', 3)
                    ->where(function ($q) use ($query) {
                        $q->where('title', 'LIKE', "%{$query}%")
                            ->orWhereHas('user', function ($q) use ($query) {
                                $q->where('name', 'LIKE', "%{$query}%");
                            });
                    });
            })
            ->get();

        return view('admin.response', compact('responses', 'doneResponses'));
    }

}
