<?php

namespace App\Http\Controllers;

use App\Models\File;
use Auth;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index()
    {
        $files = File::with('complaint')->get()->sortByDesc('created_at');

        $user = Auth::user();
        if ($user->role_id == 1) {
            return view('admin.files', compact('files'));
        } else {
            return redirect()->back()->with('error', 'You not admin!');
        }
    }

}
