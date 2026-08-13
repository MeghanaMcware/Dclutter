<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use App\Models\Corporation;
use App\Models\Constituency;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    public function index(Request $request)
    {
        $corporations = Corporation::orderBy('name')->get();
        $constituencies = Constituency::orderBy('name')->get();

        $query = Plant::with(['corporation', 'constituency']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
        }

        if ($request->filled('corporation_id')) {
            $query->where('corporation_id', $request->corporation_id);
        }

        if ($request->filled('constituency_id')) {
            $query->where('constituency_id', $request->constituency_id);
        }

        $plants = $query->latest()->paginate(10);

        return view('admin.masters.plant.index', compact('plants', 'corporations', 'constituencies'));
    }

    public function create()
    {
        $corporations = Corporation::orderBy('name')->get();
        $constituencies = Constituency::with('corporation')->orderBy('name')->get();

        return view('admin.masters.plant.create', compact('corporations', 'constituencies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'corporation_id' => 'required|exists:corporations,id',
            'constituency_id' => 'required|exists:constituencies,id',
            'address' => 'required|string',
            'status' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? ($request->status ? 1 : 0) : 1;

        Plant::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Plant Location created successfully!']);
        }

        return redirect()->route('admin.masters.plants.index')->with('success', 'Plant Location created successfully!');
    }

    public function show($id)
    {
        $plant = Plant::with(['corporation', 'constituency'])->findOrFail($id);

        return view('admin.masters.plant.show', compact('plant'));
    }

    public function edit($id)
    {
        $plant = Plant::findOrFail($id);
        $corporations = Corporation::orderBy('name')->get();
        $constituencies = Constituency::where('corporation_id', $plant->corporation_id)->orderBy('name')->get();

        return view('admin.masters.plant.edit', compact('plant', 'corporations', 'constituencies'));
    }

    public function update(Request $request, $id)
    {
        $plant = Plant::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'corporation_id' => 'required|exists:corporations,id',
            'constituency_id' => 'required|exists:constituencies,id',
            'address' => 'required|string',
            'status' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? ($request->status ? 1 : 0) : 1;

        $plant->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Plant Location updated successfully!']);
        }

        return redirect()->route('admin.masters.plants.index')->with('success', 'Plant Location updated successfully!');
    }

    public function destroy($id)
    {
        $plant = Plant::findOrFail($id);
        $plant->delete();

        return redirect()->route('admin.masters.plants.index')->with('success', 'Plant Location deleted successfully!');
    }
}
