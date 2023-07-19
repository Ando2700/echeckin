<?php

namespace App\Http\Controllers;

use App\Models\Acte;
use App\Models\Facture;
use Illuminate\Http\Request;
use App\Models\Detailfacture;
use Illuminate\Support\Facades\DB;

class DetailFactureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {        
        return view('other.detailfactures.index');
    }

    public function saisieDetailFacture(Request $request, string $id){
        $factures = Facture::findOrFail($id);
        $actes = Acte::all();
        
        // DETAIL SIMPLE SANS VUE
        // $detailfactures = DB::table('detailfactures')
        // ->where('facture_id', '=', $id)
        // ->get();

        $detailfacture_patient = DB::table('v_detailfacture_patient')
        ->where('facture_id', '=', $id)
        ->get();

        $montant = DB::table('v_montant_total')
        ->where('facture_id', '=', $factures->id)
        ->get();

        return view('other.detailfactures.saisiedetailfacture', compact('factures', 'actes', 'detailfacture_patient', 'montant'));
    }

    public function saveDetailFacture(Request $request)
    {
        $this->validate($request , [
            'id' => 'required|string',
            'type_acte' => 'required|string',
            'montant'=> 'required|numeric',
        ]);

        $facture_id = $request->input('id');
        $type_acte = $request->input('type_acte');

        $factures = Facture::where('id', $facture_id)->first();
        $actes = Acte::where('type_acte', $type_acte)->first();
        if($factures && $actes){
        $facturesId = $factures->id;
        $actesId = $actes->id;

        $detailfacture = new Detailfacture;
        $detailfacture->facture_id = $facturesId;
        $detailfacture->acte_id = $actesId;
        $detailfacture->montant = $request->input('montant');
        $detailfacture->save();
        return redirect()->back()->withErrors('Reussi');
        }
    }
    
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
