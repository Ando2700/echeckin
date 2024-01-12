<?php

namespace App\Http\Controllers;

use App\Models\Eventtype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class EventTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Eventtype::orderBy('eventtype', 'asc');

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('eventtype', 'ilike', '%' . $searchTerm . '%');
        }
        $eventtypes = $query->paginate(5);
        return view('admin.event_type.index', compact('eventtypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'eventtype' => 'required|string',
            ]);
            $eventtypeName = ucfirst(strtolower($validatedData['eventtype']));
            $existingEventtype = DB::table('eventtypes')->where(DB::raw('LOWER(eventtype)'), strtolower($eventtypeName))->first();
            if ($existingEventtype) {
                Session::flash('error', 'Le type d\'événement existe déjà');
                return redirect()->back()->withInput($request->input());
            }

            $eventtype = new Eventtype();
            $eventtype->eventtype = $eventtypeName;
            $eventtype->save();

            Session::flash('success', 'Sauvegarde du type d\'événement réussie');
            return redirect()->route('eventtypes.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Erreur lors de l\'enregistrement du type d\'événement');
            return redirect()->back()->withInput($request->input());
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
        $eventtype = Eventtype::findOrFail($id);
        return view('admin.event_type.edit', compact('eventtype'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'eventtype' => 'required|string'
        ]);
        $eventtype = Eventtype::findOrFail($id);        
        $eventtypeName = ucwords(strtolower($request->eventtype));
        $eventtype->update([
            'eventtype' => $eventtypeName,
        ]);
        
        Session::flash('success', 'Modification du type d\'événement réussie');
        return redirect()->route("eventtypes.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $eventtype = Eventtype::findOrFail($id);
        $eventtype->delete();
        Session::flash('success', 'Suppression du type d\'evenement avec succes');
        return redirect()->route('eventtypes.index');
    }
}
