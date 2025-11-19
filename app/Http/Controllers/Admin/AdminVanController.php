<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Van;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminVanController extends Controller
{
    public function index()
    {
        $vans = Van::all();
        return view('admin.vans.index', compact('vans'));
    }

    public function create()
    {
        return view('admin.vans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'seats' => 'required|integer|min:1',
            'price_per_day' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            // Store in storage/app/public/vans
            $imageName = $request->file('image')->store('vans', 'public');
        }

        Van::create([
            'name' => $request->name,
            'model' => $request->model,
            'seats' => $request->seats,
            'price_per_day' => $request->price_per_day,
            'image' => $imageName,
        ]);

        return redirect()->route('admin.vans.index')->with('success', 'Van added successfully!');
    }

    public function edit(Van $van)
    {
        return view('admin.vans.edit', compact('van'));
    }

    public function update(Request $request, Van $van)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'seats' => 'required|integer|min:1',
            'price_per_day' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($van->image && Storage::disk('public')->exists($van->image)) {
                Storage::disk('public')->delete($van->image);
            }

            $imageName = $request->file('image')->store('vans', 'public');
            $van->image = $imageName;
        }

        // Update other fields
        $van->name = $request->name;
        $van->model = $request->model;
        $van->seats = $request->seats;
        $van->price_per_day = $request->price_per_day;

        $van->save();

        return redirect()->route('admin.vans.index')->with('success', 'Van updated successfully!');
    }

    public function destroy(Van $van)
    {
        // Delete image if exists
        if ($van->image && Storage::disk('public')->exists($van->image)) {
            Storage::disk('public')->delete($van->image);
        }

        $van->delete();
        return redirect()->route('admin.vans.index')->with('success', 'Van deleted successfully!');
    }
}
