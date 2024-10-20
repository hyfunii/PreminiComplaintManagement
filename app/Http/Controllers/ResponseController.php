<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Response;
use App\Models\Response;

class ResponseController extends Controller
{
    public function index()
    {
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
}
