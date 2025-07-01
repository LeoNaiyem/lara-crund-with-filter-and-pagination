<?php

namespace App\Http\Controllers;

use App\Models\Cattle;
use App\Models\CattleCategory;
use Illuminate\Http\Request;


class CattleController extends Controller
{
    public function index()
    {
        $cattle = Cattle::orderBy('id', 'desc')->paginate(10);
        return view('pages.cattle.index', compact('cattle'));
    }

    public function create()
    {

        return view('pages.cattle.create', [
            'mode' => 'create',
            'cattle' => new Cattle(),
            'cattleCategories'=>CattleCategory::all(),

        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('uploads', 'public');
        }
        Cattle::create($data);
        return redirect()->route('cattle.index')->with('success', 'Successfully created!');
    }

    public function show(Cattle $cattle)
    {
        return view('pages.cattle.view', compact('cattle'));
    }

    public function edit(Cattle $cattle)
    {

        return view('pages.cattle.edit', [
            'mode' => 'edit',
            'cattle' => $cattle,

        ]);
    }

    public function update(Request $request, Cattle $cattle)
    {
        $data = $request->all();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('uploads', 'public');
        }
        $cattle->update($data);
        return redirect()->route('cattle.index')->with('success', 'Successfully updated!');
    }

    public function destroy(Cattle $cattle)
    {
        $cattle->delete();
        return redirect()->route('cattle.index')->with('success', 'Successfully deleted!');
    }
}