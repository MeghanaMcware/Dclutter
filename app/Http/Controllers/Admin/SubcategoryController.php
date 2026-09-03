<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of subcategories.
     */
    public function index()
    {
        $subcategories = Subcategory::with('category')->latest()->get();
        return view('admin.masters.subcategories.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new subcategory.
     */
    public function create()
    {
        $categories = Category::where('status', true)->orderBy('name')->get();
        return view('admin.masters.subcategories.create', compact('categories'));
    }

    /**
     * Store a newly created subcategory in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $iconPath = null;
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('subcategories', 'public');
        }

        Subcategory::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'icon' => $iconPath,
            'status' => true,
        ]);

        return redirect()->route('admin.masters.subcategories.index')
            ->with('success', 'Subcategory created successfully!');
    }

    /**
     * Show the form for editing the specified subcategory.
     */
    public function edit(Subcategory $subcategory)
    {
        $categories = Category::where('status', true)->orderBy('name')->get();
        return view('admin.masters.subcategories.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified subcategory in storage.
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('icon')) {
            if ($subcategory->icon && Storage::disk('public')->exists($subcategory->icon)) {
                Storage::disk('public')->delete($subcategory->icon);
            }
            $subcategory->icon = $request->file('icon')->store('subcategories', 'public');
        }

        $subcategory->category_id = $validated['category_id'];
        $subcategory->name = $validated['name'];
        $subcategory->status = (bool) $validated['status'];
        $subcategory->save();

        return redirect()->route('admin.masters.subcategories.index')
            ->with('success', 'Subcategory updated successfully!');
    }

    /**
     * Toggle the status of the specified subcategory.
     */
    public function toggleStatus(Subcategory $subcategory)
    {
        $subcategory->status = !$subcategory->status;
        $subcategory->save();

        return response()->json([
            'success' => true,
            'status' => $subcategory->status,
            'message' => 'Subcategory status updated successfully.',
        ]);
    }

    /**
     * Remove the specified subcategory from storage.
     */
    public function destroy(Subcategory $subcategory)
    {
        if ($subcategory->icon && Storage::disk('public')->exists($subcategory->icon)) {
            Storage::disk('public')->delete($subcategory->icon);
        }

        $subcategory->delete();

        return redirect()->route('admin.masters.subcategories.index')
            ->with('success', 'Subcategory deleted successfully!');
    }
}
