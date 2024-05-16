@extends('admin.layouts.app')
@section('meta_title', 'Echeck-in - Event Detail - Detail')
@section('content')
    <div class="site-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md">
                            <div class="d-flex post-entry">
                                <div class="post-content">
                                    {{-- START --}}

                                    <h1>Envoi d'email & QR Code : {{ $event->eventname }}</h1>
                                    <hr>
                                    <a href="{{ route('eventdetails.list') }}" class="btn btn-dark"
                                        title="Liste des événements avec details">Liste des qr code</a>
                                    @if (Session::has('success'))
                                        <div class="alert alert-success">
                                            {{ Session::get('success') }}
                                        </div>
                                    @endif
                                    @if (Session::has('error'))
                                        <div class="alert alert-danger">
                                            {{ Session::get('error') }}
                                        </div>
                                    @endif

                                    <form action="{{ route('eventdetails.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="participant">Participants / Invités :
                                            </label><br>
                                            <button title="" type="button" class="btn btn-outline-dark btn-sm"
                                                data-toggle="modal" data-target="#attendeesModal">
                                                <i class="fas fa-user-group"></i> Sélectionner les participants
                                            </button>
                                        </div>

                                        <div class="form-group">
                                            <textarea name="attendee_id" hidden id="attendeeIdsTextarea" class="form-control" readonly></textarea>
                                        </div>
                                        <span id="countAttendees">0</span> participants sélectionnés.

                                        {{-- <div class="form-group">
                                            <label class="font-weight-bold">Information supplémentaire : (Si besoin)</label>
                                            <textarea class="form-control @error('additional_information') is-invalid @enderror" name="additional_information"
                                                rows="5"></textarea>

                                            @error('additional_information')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div> --}}
                                        <br><br>
                                        <button type="submit" class="btn btn-primary" title="Enregistrer et envoyer">
                                            <i class="fa-solid fa-envelope"></i> Enregistrer et envoyer
                                        </button>
                                        <a title="Liste des événements" href="{{ route('events.list') }}"
                                            class="btn btn-outline-dark"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                                            Retour</a>
                                    </form>

                                    {{-- Modal --}}
                                    <div class="modal fade" id="attendeesModal" tabindex="-1" role="dialog"
                                        aria-labelledby="attendeesModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="attendeesModalLabel">Sélectionner les
                                                        participants</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                {{-- BODY --}}
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Choisir les participants /
                                                                invités :</label>
                                                            <input type="text" id="searchAttendee" class="form-control"
                                                                placeholder="Rechercher un participant">
                                                            <div id="attendeesList">
                                                                @foreach ($attendees as $attendee)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            value="{{ $attendee->id }}"
                                                                            id="attendee_{{ $attendee->id }}"
                                                                            name="attendees[]" onchange="updateTextarea()">
                                                                        <label class="form-check-label"
                                                                            for="attendee_{{ $attendee->id }}">
                                                                            {{ $attendee->firstname . ' ' . $attendee->lastname }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <button type="button" class="btn btn-secondary btn-sm"
                                                                onClick="selectAll();">Tout sélectionner</button>
                                                            <button type="button" class="btn btn-secondary btn-sm"
                                                                onClick="deselectAll();">Tout désélectionner</button>
                                                            <button type="button" class="btn btn-secondary btn-sm"
                                                                onClick="showAll();">Tout afficher</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                {{-- BODY --}}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                        data-dismiss="modal">Fermer</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    {{-- END --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('additional_information');

        function selectAll() {
            var checkboxes = document.getElementsByName('attendees[]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = true;
            }
            updateTextarea();
        }

        function showAll() {
            var attendeesList = document.getElementById('attendeesList');
            var attendees = attendeesList.getElementsByClassName('form-check');

            for (var i = 0; i < attendees.length; i++) {
                attendees[i].style.display = '';
                var checkbox = attendees[i].getElementsByTagName('input')[0];
            }
            updateTextarea();
        }

        function deselectAll() {
            var checkboxes = document.getElementsByName('attendees[]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = false;
            }
            updateTextarea();
        }

        function updateTextarea() {
            var selectedAttendees = document.querySelectorAll('input[name="attendees[]"]:checked');

            var attendeeIds = Array.from(selectedAttendees).map(function(checkbox) {
                return checkbox.value;
            });

            document.getElementById('attendeeIdsTextarea').value = attendeeIds.join(',');
            countAttendees();
        }

        function countAttendees() {
            var selectedAttendees = document.querySelectorAll('input[name="attendees[]"]:checked');
            document.getElementById('countAttendees').innerText = selectedAttendees.length;
        }


        // FILTRE PAR RECHERCHE
        function filterAttendees() {
            var input, filter, attendeesList, attendees, label, txtValue;
            input = document.getElementById('searchAttendee');
            filter = input.value.toUpperCase();
            attendeesList = document.getElementById('attendeesList');
            attendees = attendeesList.getElementsByClassName('form-check');

            for (var i = 0; i < attendees.length; i++) {
                label = attendees[i].getElementsByTagName('label')[0];
                txtValue = label.textContent || label.innerText;

                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    attendees[i].style.display = '';
                } else {
                    attendees[i].style.display = 'none';
                }
            }
        }
        document.getElementById('searchAttendee').addEventListener('input', filterAttendees);
    </script>
@endsection
