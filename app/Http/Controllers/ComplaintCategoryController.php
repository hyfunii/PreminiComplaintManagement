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
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:complaint_categories,name',
                'description' => 'nullable|string|max:255',
            ]);

            ComplaintCategory::create($request->all());

            return redirect()->route('categories.index')->with('success', 'Category created successfully!');
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Failed to create category. Name as already taken')->withInput();
        }
    }

    public function update(Request $request, ComplaintCategory $category)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:complaint_categories,name,' . $category->id,
                'description' => 'nullable|string|max:255',
            ]);

            $category->update($request->all());

            return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Failed to create category. Name as already taken')->withInput();
        }
    }

    public function destroy(ComplaintCategory $category)
    {
        try {
            $category = ComplaintCategory::findOrFail($category->id);
            $category->delete();

            return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Cant delete this data because a lot of data is using it!!');

        }
    }
}

