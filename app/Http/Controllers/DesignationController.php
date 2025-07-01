<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;


class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::latest()->paginate(10);
        return view('pages.designations.index', compact('designations'));
    }

    public function create()
    {

        return view('pages.designations.create', [
            'mode' => 'create',
            'designation' => new Designation(),

        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('uploads', 'public');
        }
        Designation::create($data);
        return redirect()->route('designations.index')->with('success', 'Successfully created!');
    }

    public function show(Designation $designation)
    {
        return view('pages.designations.view', compact('designation'));
    }

    public function edit(Designation $designation)
    {

        return view('pages.designations.edit', [
            'mode' => 'edit',
            'designation' => $designation,

        ]);
    }

    public function update(Request $request, Designation $designation)
    {
        $data = $request->all();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('uploads', 'public');
        }
        $designation->update($data);
        return redirect()->route('designations.index')->with('success', 'Successfully updated!');
    }

    public function destroy(Designation $designation)
    {
        $designation->delete();
        return redirect()->route('designations.index')->with('success', 'Successfully deleted!');
    }
}