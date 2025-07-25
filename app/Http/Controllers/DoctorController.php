<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Designation;


class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::with('department', 'designation');

        // Apply search filter
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Apply department filter
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        // Get paginated result with filters
        $doctors = $query->orderBy('id', 'desc')->paginate(10)->onEachSide(1);

        // Keep query parameters in pagination links
        $doctors->appends($request->all());

        // Get departments for dropdown
        $departments = Department::all();

        return view('pages.doctors.index', compact('doctors', 'departments'));
    }

    public function create()
    {
        $departments = Department::all();
        $designations = Designation::all();

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
        $departments = Department::all();
        $designations = Designation::all();

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