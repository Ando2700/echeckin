<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Attendee;
use App\Models\Invitation;
use App\Models\Eventdetail;
use App\Mail\InvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Page to insert event detail 
     * @param Request $request
     * @param string $id
     * 
     */
    public function detail(Request $request, string $id)
    {
        $event = Event::findOrFail($id);
        $attendees = DB::table('attendees')
            ->whereNotIn('id', function ($query) use ($id) {
                $query->select('attendee_id')
                    ->from('invitations')
                    ->where('event_id', $id);
            })
            ->get();
        return view('admin.eventdetail.detail', compact('event', 'attendees'));
    }

    /**
     * Listing all event details
     * @param Request $request
     * 
     */
    public function list(Request $request)
    {
        $invitations = Invitation::all();
        $invitationsParDossier = $invitations->groupBy(function ($invitation) {
            preg_match('/qr_code\/(\d+)/', $invitation->qr_code, $matches);
            return isset($matches[1]) ? $matches[1] : 'autre';
        });
        return view('admin.eventdetail.list', compact('invitations', 'invitationsParDossier'));
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
                'event_id' => 'required',
                'additional_information' => 'string|nullable',
                'attendee_id' => 'required'
            ];
            $messages = [
                'attendee_id.required' => 'Cochez au moins un participant.',
            ];

            $request->validate($rules, $messages);

            $eventdetail = new Eventdetail();
            $eventdetail->event_id = $request->event_id;
            $eventdetail->additional_information = $request->additional_information;
            $eventdetail->save();

            $attendeeIds = explode(',', $request->attendee_id);

            foreach ($attendeeIds as $attendeeId) {
                $eventInvitation = new Invitation();
                $eventInvitation->event_id = $request->event_id;
                $eventInvitation->attendee_id = trim($attendeeId);

                $reference = $request->event_id . $attendeeId;
                for ($i = 0; $i < 8; $i++) {
                    $reference .= rand(0, 9);
                }
                $eventInvitation->reference = $reference;

                $qrCodeContent = "Reference: {$eventInvitation->reference}\nEventID: {$eventInvitation->event_id}\nAttendeeID: {$eventInvitation->attendee_id}";
                $qrCode = QrCode::format('svg')->size('200')->generate($qrCodeContent);
                $qrCodeFileName = "attendee_{$eventInvitation->attendee_id}.svg";
                $qrCodePath = "public/qr_code/{$eventInvitation->event_id}/$qrCodeFileName";
                Storage::put($qrCodePath, $qrCode);
                $eventInvitation->qr_code = str_replace('public/', '', $qrCodePath);
                $eventInvitation->save();

                $attendee = Attendee::find($eventInvitation->attendee_id);
                $event = Event::find($eventInvitation->event_id);
                Mail::to($attendee->email)->send(new InvitationMail($event, $eventInvitation));
            }

            Session::flash('success', 'Email(s) envoyé(s) et enregistrement du/des participant(s) avec succes');
            return redirect()->route("events.list");
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
