<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $directory = 'pages.fields';
    public function index()
    {
        $fields = Field::orderBy('id', 'desc')->paginate(10);
        return view($this->directory . 'index', compact('fields'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->directory . 'index')->with('mode', 'create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'message' => 'required|string',
            'gender' => 'required|in:Male,Female,Other',
            'uploaded_file' => 'nullable|file|max:2048',
            'country' => 'required|string',
            'subscribe' => 'nullable|boolean',
            'birth_date' => 'required|date|before:today',
            'age' => 'required|integer|max:100',
            'email' => 'required|email|max:45',
        ]);
        $data = $request->all();
        Field::create($data);
        return redirect(route('fields.index'))->with('message', 'Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Field $field)
    {
        return view($this->directory . 'view', compact('field'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Field $field)
    {
        return view($this->directory . 'edit', compact($field))->with('mode', 'update');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Field $field)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'message' => 'required|string',
            'gender' => 'required|in:Male,Female,Other',
            'uploaded_file' => 'nullable|file|max:2048',
            'country' => 'required|string',
            'subscribe' => 'nullable|boolean',
            'birth_date' => 'required|date|before:today',
            'age' => 'required|integer|max:100',
            'email' => 'required|email|max:45',
        ]);
        $data = $request->all();
        $field->update($data);
        return redirect(route('fields.index'))->with('message', 'Update Success!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Field $field)
    {
        $field->delete();
        redirect(route('fields.index'))->with('message', 'Delete Success!');
    }
}
