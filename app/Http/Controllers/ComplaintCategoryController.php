<?php

namespace App\Http\Controllers;

use App\Models\ComplaintCategory;
use Illuminate\Http\Request;
use Auth;

class ComplaintCategoryController extends Controller
{
    public function index()
    {
        $categories = ComplaintCategory::all();
        $user = Auth::user();
        if ($user->role_id == 1) {
            return view('admin.other.category', compact('categories'));
        } else {
            return redirect()->back()->with('error', 'You not admin!');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        ComplaintCategory::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    public function update(Request $request, ComplaintCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(ComplaintCategory $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}

