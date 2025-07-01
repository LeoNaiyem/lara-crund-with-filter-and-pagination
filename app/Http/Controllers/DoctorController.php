<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Designation;


class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::orderBy('id', 'desc')->paginate(10);
        return view('pages.doctors.index', compact('doctors'));
    }

    public function create()
    {
        $departments = \App\Models\Department::all();
        $designations = \App\Models\Designation::all();

        return view('pages.doctors.create', [
            'mode' => 'create',
            'doctor' => new Doctor(),
            'departments' => $departments,
            'designations' => $designations,

        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('uploads', 'public');
        }
        Doctor::create($data);
        return redirect()->route('doctors.index')->with('success', 'Successfully created!');
    }

    public function show(Doctor $doctor)
    {
        return view('pages.doctors.view', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        $departments = \App\Models\Department::all();
        $designations = \App\Models\Designation::all();

        return view('pages.doctors.edit', [
            'mode' => 'edit',
            'doctor' => $doctor,
            'departments' => $departments,
            'designations' => $designations,

        ]);
    }

    public function update(Request $request, Doctor $doctor)
    {
        $data = $request->all();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('uploads', 'public');
        }
        $doctor->update($data);
        return redirect()->route('doctors.index')->with('success', 'Successfully updated!');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Successfully deleted!');
    }
}