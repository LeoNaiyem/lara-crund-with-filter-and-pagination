<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;


class PatientController extends Controller
{
    public function index(Request $request)
    {

        $query = Patient::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('mobile')) {
            $query->where('mobile', $request->mobile);
        }
        $patients = $query->orderBy('id', 'desc')->paginate(10)->onEachSide(1);

        $patients->appends($request->all());
        return view('pages.patients.index', compact('patients'));
    }

    public function create()
    {

        return view('pages.patients.create', [
            'mode' => 'create',
            'patient' => new Patient(),

        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('uploads', 'public');
        }
        Patient::create($data);
        return redirect()->route('patients.index')->with('success', 'Successfully created!');
    }

    public function show(Patient $patient)
    {
        return view('pages.patients.view', compact('patient'));
    }

    public function edit(Patient $patient)
    {

        return view('pages.patients.edit', [
            'mode' => 'edit',
            'patient' => $patient,

        ]);
    }

    public function update(Request $request, Patient $patient)
    {
        $data = $request->all();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('uploads', 'public');
        }
        $patient->update($data);
        return redirect()->route('patients.index')->with('success', 'Successfully updated!');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Successfully deleted!');
    }
}