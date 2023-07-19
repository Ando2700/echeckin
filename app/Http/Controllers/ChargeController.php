<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use App\Models\Depense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $depenses = Depense::all();
        $charges = Charge::all();
        $type_charges = DB::table('v_type_charge')->paginate(5);
        return view('other.charges.index', compact('depenses', 'charges', 'type_charges'));
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
        $this->validate($request , [
            'type_depense' => 'required|string',
            'jour' => 'required|min:1|max:31',
            'mois' =>'required|array',
            'mois.*' =>'string',
            'annee' => 'required|integer|min:1900|max:2099|digits:4',
            'montant_depense' => 'required|numeric|min:0',
        ]);
        $typeDepense = $request->input('type_depense');
        $depense = Depense::where('type_depense', $typeDepense)->first();
        if($depense){
        $depenseId = $depense->id;

        foreach($request->input('mois') as $mois){
            $charge = new Charge;
            $charge->depense_id = $depenseId;
            $charge->jour = $request->input('jour');
            $charge->mois = $mois;
            $charge->annee = $request->input('annee');
            $charge->montant_depense = $request->input('montant_depense');
            $charge->save();
        }
        
        return redirect()->back()->withErrors('Reussi');
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
