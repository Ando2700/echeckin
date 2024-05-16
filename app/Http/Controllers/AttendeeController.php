<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AttendeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $email = $request->input('email');

        $query = Attendee::orderBy('firstname', 'asc');

        if ($firstname) {
            $query->where('firstname', 'ilike', '%' . $firstname . '%');
        }

        if ($lastname) {
            $query->where('lastname', 'ilike', '%' . $lastname . '%');
        }

        if ($email) {
            $query->where('email', 'ilike', '%' . $email . '%');
        }

        $totalAttendees = $query->count();

        $attendees = $query->paginate(5);

        return view('admin.attendee.index', compact('attendees', 'totalAttendees'));
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
            $request->validate([
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'required|email|unique:attendees|max:255',
            ]);

            $attendee = new Attendee();
            $attendee->firstname = $request->firstname;
            $attendee->lastname = $request->lastname;
            $attendee->email = $request->email;
            $attendee->save();

            return redirect()->route('attendees.index')->with('success', 'Participant/invité ajouté avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur s\'est produite lors de l\'ajout de du participant. Message d\'erreur : ' . $e->getMessage());
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
        $attendee = Attendee::findOrFail($id);
        return view('admin.attendee.edit', compact('attendee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'required|email|max:255',
            ]);

            $attendee = Attendee::findOrFail($id);
            $attendee->update([
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'email' => $request->input('email'),
            ]);

            return redirect()->route('attendees.index')->with('success', 'Participant mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur s\'est produite lors de la mise à jour du participant. Message d\'erreur : ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attendee = Attendee::findOrFail($id);
        $attendee->delete();
        Session::flash('success', 'Suppression du participant avec succes');
        return redirect()->route('attendees.index');
    }
}
