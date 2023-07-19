<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use Illuminate\Http\Request;
use PHPUnit\Event\Code\Throwable;

class DepenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $depenses = Depense::paginate(5);
        return view('admin.depenses.index', compact('depenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'type_depense' => 'required|string',
                'budget' => 'required|numeric|min:0',
                'annee' => 'required|integer|digits:4',
            ]);
            $depenses = new Depense();
            $depenses->type_depense = $validatedData['type_depense'];
            $depenses->budget = $validatedData['budget'];
            $depenses->annee = $validatedData['annee'];
            $depenses->save();
            return redirect()->route('depenses.index');

        } catch (Throwable $e) {
            report($e);
            return back()->with('error', 'Une erreur s\'est produite lors de la création d\'évenement');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $depense = Depense::findOrFail($id);
        return view('admin.depenses.edit', compact('depense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'type_depense' => 'required|string',
            'budget' => 'required|numeric|min:0',
            'annee' => 'required|integer|digits:4',
        ]);
        $depenses = Depense::findOrFail($id);
        $depenses->update([
            'type_depense' => $request->type_depense,
            'budget' => $request->budget,
            'annee' => $request->annee,
        ]);

        return redirect()->route("depenses.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $depense = Depense::findOrFail($id);  
        $depense->delete();
        return redirect()->route('depenses.index');
    }
}
