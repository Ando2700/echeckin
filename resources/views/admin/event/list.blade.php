@extends('admin.layouts.app')
@section('meta_title', 'Echeck-in - Event - List')
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
                                    <?php
                                    use Carbon\Carbon;
                                    ?>
                                    {{-- Liste des evenements --}}
                                    <h1>Liste des événements : </h1>
                                    <hr>
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
                                    @php
                                        use Illuminate\Support\Str;
                                    @endphp
                                    <p><a href="{{ route('events.index') }}" class="btn btn-dark" title="Créer un événement">Créer un événement</a></p>
                                    <form action="{{ route('events.list') }}" method="GET" class="mb-3">
                                        <div class="input-group">
                                            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Rechercher un événement...">
                                            <input type="datetime-local" name="datedebut" class="form-control" title="Sélectionnez la date de début (minimum)">
                                            <input type="datetime-local" name="datefin" class="form-control" title="Sélectionnez la date de fin (maximum)">
                                            <input type="text" name="place" value="{{ request('place') }}" class="form-control" placeholder="Rechercher un lieu...">
                                            <input type="text" name="eventtype" value="{{ request('eventtype') }}" class="form-control" placeholder="Type d'événement...">
                                            <button type="submit" class="btn btn-dark" title="Rechercher">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            @if (request('search') || request('place') || request('eventtype') || request('datedebut') || request('datefin'))
                                                <a href="{{ route('events.list') }}" class="btn btn-light" title="Rafraîchir">
                                                    <i class="fa fa-refresh" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </form>
                                    @if ($events->isEmpty())
                                        <div class="alert alert-danger" role="alert">
                                            <p>Aucune correspondance trouvée</p>
                                        </div>
                                    @endif
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nom de l'événement</th>
                                                <th>Date de debut</th>
                                                <th>Date de fin</th>
                                                <th>Description</th>
                                                <th>Nom du lieu</th>
                                                <th>Type d'événement</th>
                                                <th>Detail événement</th>
                                                <th>Modifier</th>
                                                <th>Supprimer</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($events as $event)
                                                <tr>
                                                    <th>{{ $event->eventname }}</th>
                                                    <td>{{ Carbon::parse($event->datedebut)->locale('fr_FR')->isoFormat('LLLL') }}
                                                    </td>
                                                    <td>{{ Carbon::parse($event->datefin)->locale('fr_FR')->isoFormat('LLLL') }}
                                                    </td>
                                                    <td>
                                                        {!! Str::limit($event->description, $limit = 100, $end = '...') !!}
                                                    </td>
                                                    <td>{{ $event->nomplace }}</td>
                                                    <td>{{ $event->eventtype }}</td>
                                                    <td><a title="Detail evenement-{{ $event->eventname }}" href="{{ route('eventdetails.detail', $event->id) }}" class="btn btn-success btn-sm">Ajouter les details</a></td>
                                                    <td>
                                                        <a title="Modifier - {{ $event->eventname }}" href="{{ route('events.edit', $event->id) }}"
                                                            class="btn btn-outline-primary btn-sm"><i class="fas fa-pen"></i></a>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('events.destroy', $event->id) }}"
                                                            method="POST" style="display:inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button 
                                                                title="Supprimer - {{ $event->eventname }}" 
                                                                type="submit" 
                                                                class="btn btn-outline-danger btn-sm"
                                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce lieu ?')"><i class="fas fa-trash"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex">{!! $events->appends(['search' => request('search')])->links() !!}</div>
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
