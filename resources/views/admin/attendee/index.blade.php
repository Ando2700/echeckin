@extends('admin.layouts.app')
@section('meta_title', 'Echeck-in - Attendee - Create')
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

                                    <h1>Ajouter un participant/invité :</h1>
                                    <hr>
                                    <form action="{{ route('attendees.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-group">
                                            <label class="font-weight-bold">Nom : </label>
                                            <input type="text"
                                                class="form-control @error('firstname') is-invalid @enderror"
                                                name="firstname" value="{{ old('firstname') }}"
                                                placeholder="Nom du participant/invité ...">

                                            @error('firstname')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Prenom : </label>
                                            <input type="text"
                                                class="form-control @error('lastname') is-invalid @enderror"
                                                name="lastname" value="{{ old('lastname') }}"
                                                placeholder="Prenom du participant/invité ...">

                                            @error('lastname')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Email : </label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                name="email" value="{{ old('email') }}"
                                                placeholder="Ex : sample@gmail.com">

                                            @error('email')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-primary" title="Enregistrer">
                                            <i class="fa-solid fa-floppy-disk"></i> Enregitrer
                                        </button>
                                        <input type="reset" class="btn btn-warning" value="Reset" title="Reset">
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
                                    </form>

                                    <br>

                                    {{--List des participants--}}
                                    <h3>Liste des participants: ({{ $totalAttendees }})</h3>
                                    <form action="{{ route('attendees.index') }}" method="GET" class="mb-3">
                                        <div class="input-group">
                                            <input type="text" name="firstname" class="form-control"
                                                placeholder="Nom ...">
                                            <input type="text" name="lastname" class="form-control"
                                                placeholder="Prénom ...">
                                            <input type="text" name="email" class="form-control"
                                                placeholder="Email ...">

                                            <button type="submit" class="btn btn-dark" title="Rechercher">
                                                <i class="fas fa-search"></i>
                                            </button>

                                            @if (request('firstname') || request('lastname') || request('email') )
                                                <a href="{{ route('attendees.index') }}" class="btn btn-light"
                                                    title="Rafraîchir">
                                                    <i class="fa fa-refresh" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </form>

                                    @if ($attendees->isEmpty())
                                        <div class="alert alert-danger" role="alert">
                                            <p>Aucune correspondance trouvée</p>
                                        </div>
                                    @endif
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nom</th>
                                                <th>Prenom</th>
                                                <th>Email</th>
                                                <th>Modifier</th>
                                                <th>Supprimer</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($attendees as $attendee)
                                                <tr>
                                                    <td>{{ $attendee->firstname }}</td>
                                                    <td>{{ $attendee->lastname }}</td>
                                                    <td>{{ $attendee->email }}</td>
                                                    <td><a class="btn btn-outline-primary btn-sm" href="{{ route('attendees.edit', $attendee->id) }}" title="Modifier - {{ $attendee->firstname }}"><i class="fas fa-pen"></i></a></td>
                                                    <td>
                                                        <form onsubmit="return confirm('Etes vous sur ?');"
                                                            action="{{ route('attendees.destroy', $attendee->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button 
                                                                type="submit"
                                                                class="btn btn-sm btn-outline-danger"
                                                                title="Supprimer - {{ $attendee->firstname }}"><i class="fas fa-trash"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex">{!! $attendees->appends(['search' => request('search')])->links() !!}</div>
                                    {{-- List des participants --}}
                                    {{-- END --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
