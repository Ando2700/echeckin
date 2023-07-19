<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use PHPUnit\Event\Code\Throwable;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients=Patient::paginate(5);
        return view('admin.patients.index', compact('patients'));
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
                'nom' => 'required|string',
                'date_naissance' => 'required|date|before_or_equal:today',
                'genre' => 'required|string',
                'remboursement' => 'required|string',
            ]);
            $patients = new Patient();
            $patients->nom = $validatedData['nom'];
            $patients->date_naissance = $validatedData['date_naissance'];
            $patients->genre = $validatedData['genre'];
            $patients->remboursement = $validatedData['remboursement'];
            $patients->save();
            return redirect()->route('patients.index');

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
        $patients = Patient::findOrFail($id);
        return view('admin.patients.edit', compact('patients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nom' => 'required|string',
            'date_naissance' => 'required|date',
            'genre' => 'required|string', 
            'remboursement' => 'required|string',
        ]);
        $patients = Patient::findOrFail($id);
        $patients->update([
            'date_naissance' => $request->date_naissance,
            'nom' => $request->nom,
            'genre' => $request->genre,
            'remboursement' => $request->remboursement,
        ]);
        // $patients = Patient::findOrFail($id);
        // $patients->nom = $request->nom;
        // $patients->date_naissance = $request->date_naissance;
        // $patients->genre = $request->genre;
        // $patients->remboursement = $request->remboursement;

        // $patients->save();
        return redirect()->route("patients.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
