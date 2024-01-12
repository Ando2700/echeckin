@extends('admin.layouts.app')
@section('meta_title', 'Echeck-in - Event Type - Create')
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

                                    <h1>Création d'événement</h1>
                                    <hr>
                                    <a href="{{ route('events.list') }}" class="btn btn-dark" title="Liste des lieux">Liste des événements</a>
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

                                    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-group">
                                            <label class="font-weight-bold">Nom de l'événement :</label>
                                            <input type="text"
                                                class="form-control @error('eventname') is-invalid @enderror"
                                                name="eventname" value="{{ old('eventname') }}"
                                                placeholder="Type d'événement ...">

                                            @error('eventname')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Date de début :</label>
                                            <input type="datetime-local"
                                                class="form-control @error('datedebut') is-invalid @enderror"
                                                name="datedebut" value="{{ old('datedebut') }}">

                                            @error('datedebut')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Date de fin :</label>
                                            <input type="datetime-local"
                                                class="form-control @error('datefin') is-invalid @enderror" name="datefin"
                                                value="{{ old('datefin') }}">

                                            @error('datefin')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Description :</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5"
                                                placeholder="Entrer la description"></textarea>

                                            @error('description')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Lieu de l'événement :</label>
                                            <select class="form-select" name="place_id" id="place_id">
                                                <option value="">Sélectionner un lieu...</option>
                                                @foreach ($places as $place)
                                                    <option value="{{ $place->id }}">{{ $place->nomplace }}</option>
                                                @endforeach
                                            </select>

                                            @error('place_id')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Type d'événement :</label>
                                            <select class="form-select" name="eventtype_id" id="eventtype_id">
                                                <option value="">Sélectionner le type d'evenement...</option>
                                                @foreach ($eventtypes as $eventtype)
                                                    <option value="{{ $eventtype->id }}">{{ $eventtype->eventtype }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('eventtype_id')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <input type="submit" class="btn btn-primary" value="Ajouter" title="Ajouter">
                                        <input type="reset" class="btn btn-warning" value="Reset" title="Reset">
                                    </form>

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
        CKEDITOR.replace('description');
    </script>
@endsection
