<?php

namespace App\Http\Controllers;

use App\Models\Acte;
use Illuminate\Http\Request;
use PHPUnit\Event\Code\Throwable;

class ActeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actes = Acte::paginate(5);
        return view('admin.actes.index', compact('actes'));
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
                'type_acte' => 'required|string',
                'budget' => 'required|numeric|min:0',
                'annee' => 'required|integer|digits:4',
            ]);
            $actes = new Acte();
            $actes->type_acte = $validatedData['type_acte'];
            $actes->budget = $validatedData['budget'];
            $actes->annee = $validatedData['annee'];
            $actes->save();
            return redirect()->route('actes.index');

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
        $acte = Acte::findOrFail($id);
        return view('admin.actes.edit', compact('acte'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'type_acte' => 'required|string',
            'budget' => 'required|numeric|min:0',
            'annee' => 'required|integer|digits:4',
        ]);
        $actes = Acte::findOrFail($id);
        $actes->update([
            'type_acte' => $request->type_acte,
            'budget' => $request->budget,
            'annee' => $request->annee,
        ]);

        return redirect()->route("actes.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $acte = Acte::findOrFail($id);  
        $acte->delete();
        return redirect()->route('actes.index');
    }
}
