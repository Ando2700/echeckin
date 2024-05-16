<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statistiques = DB::select('
        SELECT 
            e.id,
            e.eventname,
            e.datedebut,
            e.datefin,
            COUNT(p.attendee_id) AS nombre_de_presences,
            COUNT(i.attendee_id) AS nombre_total_invites,
            CASE 
                WHEN COUNT(i.attendee_id) = 0 THEN 0
                ELSE ROUND((COUNT(p.attendee_id) * 100.0 / NULLIF(COUNT(i.attendee_id), 0)), 2)
            END AS pourcentage_presence
        FROM 
            events e
        LEFT JOIN 
            invitations i ON e.id = i.event_id
        LEFT JOIN 
            presences p ON i.event_id = p.event_id AND i.attendee_id = p.attendee_id
                    AND p.date_heure_presence BETWEEN e.datedebut AND e.datefin
        GROUP BY 
            e.id, e.eventname, e.datedebut, e.datefin
        ORDER BY 
            e.eventname ASC;
        ');

        foreach ($statistiques as $statistique) {
            $datedebut = Carbon::parse($statistique->datedebut);
            $datefin = Carbon::parse($statistique->datefin);
            $hours = [];
            while ($datedebut <= $datefin) {
                $hours[] = $datedebut->hour . ':00';
                $datedebut->addHour();
            }
            $intervalHeure[$statistique->id] = $hours;
        }
        // dd($intervalHeure);
        $presenceHeure = [];
        foreach ($statistiques as $statistique) {
            $heuresPresence = DB::table('presences')
                ->where('event_id', $statistique->id)
                ->whereBetween('date_heure_presence', [$statistique->datedebut, $statistique->datefin])
                ->select(DB::raw('DATE_TRUNC(\'hour\', date_heure_presence) as heure'), DB::raw('COUNT(*) as nombre_de_presences'))
                ->groupBy(DB::raw('DATE_TRUNC(\'hour\', date_heure_presence)'))
                ->pluck('nombre_de_presences', 'heure')
                ->toArray();
        
            $allHours = [];
            $currentHour = Carbon::parse($statistique->datedebut)->startOfHour();
            $endDate = Carbon::parse($statistique->datefin)->startOfHour();
        
            while ($currentHour <= $endDate) {
                $allHours[$currentHour->format('Y-m-d H:i:s')] = 0;
                $currentHour->addHour();
            }
        
            $presenceHeure[$statistique->id] = array_merge($allHours, $heuresPresence);
        }        
        // dd(array_values($presenceHeure));
        return view('admin.statistic.index', compact('statistiques', 'intervalHeure', 'presenceHeure'));
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
