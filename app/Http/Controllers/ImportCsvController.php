<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use App\Models\Depense;
use Illuminate\Http\Request;

class ImportCsvController extends Controller
{
    public function index(){
        return view('other.import.importcsv');
    }

    public function importCSV(Request $request){
        if($request->hasFile('csv_file')){
            $path = $request->file('csv_file')->getRealPath();
            $file = fopen($path, 'r');
            fgetcsv($file);
            while (($row = fgetcsv($file, 1000, ';')) !== false) {
                $dateComponents = explode('/', $row[0]);
                $jour = $dateComponents[0];
                $mois = $dateComponents[1];
                $annee = $dateComponents[2];

                $reference = $row[1];
                $montant = $row[2];
                $depense = Depense::where('reference', $reference)->first();

                $charge = new Charge();
                $charge->jour = $jour;
                $charge->mois = $mois;
                $charge->annee = $annee;
                $charge->montant_depense = $montant;
                $charge->depense_id = $depense->id;
                $charge->save();
            }
            fclose($file);
        }
        return redirect()->route('charges.index');
    }
}
