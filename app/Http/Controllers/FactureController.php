<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FactureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::paginate(5);
        return view('other.factures.index', compact('patients'));
    }

    public function edit(string $id)
    {
        
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
        
    }
    
    public function saisieFacture(Request $request, string $id){
        $patients = Patient::findOrFail($id);
        // $factures = Facture::paginate(5);
        $factures = DB::table('factures')
        ->where('patient_id', '=', $id)
        ->get();

        return view('other.factures.saisiefacture', compact('patients', 'factures'));
    }

    public function saveFacture(Request $request)
    {
        $this->validate($request , [
            'nom' => 'required|string',
            'date_facture' => 'required|date|before_or_equal:today'
        ]);
        $nomPatient = $request->input('nom');
        $patient = Patient::where('nom', $nomPatient)->first();
        if($patient){
        $patientId = $patient->id;

        $facture = new Facture;
        $facture->patient_id = $patientId;
        $facture->date_facture = $request->input('date_facture');
        $facture->save();
        return redirect()->back()->withErrors('Reussi');
        }
    }


    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
