<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Place;
use App\Models\Eventtype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $places = Place::all();
        $eventtypes = Eventtype::all();
        return view('admin.event.index', compact('places', 'eventtypes'));
    }

    /**
     * Functio for listing events
     */
    public function list()
    {
        $events = DB::table('events')
            ->join('places', 'events.place_id', '=', 'places.id')
            ->join('eventtypes', 'events.eventtype_id', '=', 'eventtypes.id')
            ->select('events.id', 'events.eventname', 'events.datedebut', 'events.datefin', 'events.description', 'places.nomplace', 'eventtypes.eventtype')
            ->paginate(5);
        return view('admin.event.list', compact('events'));
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
        try {
            $rules = [
                'eventname' => 'required|string|max:255',
                'datedebut' => 'required|date|after_or_equal:now',
                'datefin' => 'required|date|after_or_equal:datedebut',
                'description' => 'required|string',
                'place_id' => 'required|exists:places,id',
                'eventtype_id' => 'required|exists:eventtypes,id',
            ];
            $messages = [
                'datedebut.after_or_equal' => 'La date de début doit être égale ou postérieure à la date actuelle.',
            ];

            $request->validate($rules, $messages);

            $event = new Event();

            $event->eventname = $request->input('eventname');
            $event->datedebut = $request->input('datedebut');
            $event->datefin = $request->input('datefin');
            $event->description = $request->input('description');
            $event->place_id = $request->input('place_id');
            $event->eventtype_id = $request->input('eventtype_id');

            $event->save();

            Session::flash('success', 'Sauvegarde de l\'événement avec succes');
            return redirect()->route('events.index');
        } catch (QueryException $e) {
            Session::flash('error', 'Erreur de sauvegarde: ' . $e->getMessage());
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            Session::flash('error', 'Erreur appercu: ' . $e->getMessage());
            return redirect()->back()->withInput();
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
