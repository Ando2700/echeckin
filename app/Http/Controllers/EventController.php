<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
    public function list(Request $request)
    {
        $query = DB::table('events')
            ->join('places', 'events.place_id', '=', 'places.id')
            ->join('eventtypes', 'events.eventtype_id', '=', 'eventtypes.id')
            ->select('events.id', 'events.eventname', 'events.datedebut', 'events.datefin', 'events.description', 'places.nomplace', 'eventtypes.eventtype');

        $search = $request->search;
        $place = $request->place;
        $eventtype = $request->eventtype;
        $datedebut = $request->datedebut;
        $datefin = $request->datefin;

        if ($search) {
            $query->where('eventname', 'ilike', '%' . $search . '%');
        }

        if ($place) {
            $query->where('places.nomplace', 'ilike', '%' . $place . '%');
        }

        if ($eventtype) {
            $query->where('eventtypes.eventtype', 'ilike', '%' . $eventtype . '%');
        }

        if ($datedebut) {
            $datedebut = new \DateTime($datedebut);
            $query->where('events.datedebut', '>=', $datedebut->format('Y-m-d H:i:s'));
        }

        if ($datefin) {
            $datefin = new \DateTime($datefin);
            $query->where('events.datefin', '<=', $datefin->format('Y-m-d H:i:s'));
        }

        $events = $query->paginate(5);

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

            $conflitEventPlaceDate = Event::where('place_id', $request->input('place_id'))
                ->where(function ($query) use ($request) {
                    $query->where(function ($q) use ($request) {
                        $q->where('datedebut', '<=', $request->input('datedebut'))
                            ->where('datefin', '>=', $request->input('datedebut'));
                    })->orWhere(function ($q) use ($request) {
                        $q->where('datedebut', '<=', $request->input('datefin'))
                            ->where('datefin', '>=', $request->input('datefin'));
                    })->orWhere(function ($q) use ($request) {
                        $q->where('datedebut', '>=', $request->input('datedebut'))
                            ->where('datefin', '<=', $request->input('datefin'));
                    });
                })
                ->first();

            if ($conflitEventPlaceDate) {
                $lastEvent = Event::where('place_id', $request->input('place_id'))
                    ->orderBy('datefin', 'desc')
                    ->first();

                $suggestedDate = $lastEvent ? Carbon::parse($lastEvent->datefin)->addDay() : null;

                $formatSuggestedDate = $suggestedDate ? $suggestedDate->locale('fr_FR')->isoFormat('LLLL') : null;

                Session::flash('error', 'Il existe déjà un événement avec des dates qui se chevauchent dans le même lieu. Suggestion d\'une nouvelle date : ' . $formatSuggestedDate);
                return redirect()->back()->withInput(['suggestedDate' => $formatSuggestedDate]);
            }

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
            Session::flash('error', 'Erreur apercu: ' . $e->getMessage());
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
        $event = Event::findOrFail($id);
        $places = Place::all();
        $eventtypes = Eventtype::all();
        return view('admin.event.edit', compact('event', 'places', 'eventtypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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

            $event = Event::findOrFail($id);
            
            $event->eventname = $request->input('eventname');
            $event->datedebut = $request->input('datedebut');
            $event->datefin = $request->input('datefin');
            $event->description = $request->input('description');
            $event->place_id = $request->input('place_id');
            $event->eventtype_id = $request->input('eventtype_id');

            $event->save();

            Session::flash('success', 'Mise à jour de l\'événement avec succes');
            return redirect()->route('events.list');
        } catch (QueryException $e) {
            Session::flash('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            Session::flash('error', 'Erreur apercu: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        Session::flash('success', 'Suppression de l\'événement avec succès');
        return redirect()->route('events.list');
    }
}
