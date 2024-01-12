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
                                    <h1>List des lieux : </h1>
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
                                    <p><a href="{{ route('events.index') }}" class="btn btn-dark">Créer un événement</a></p>
                                    {{-- <form action="{{ route('events.list') }}" method="GET" class="mb-3">
                                        <div class="input-group">
                                            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Rechercher le nom du lieu...">
                                            <input type="text" name="address" class="form-control" placeholder="Adresse du lieu">
                                            <input type="number" name="min_price" class="form-control" placeholder="Prix minimum">
                                            <input type="number" name="max_price" class="form-control" placeholder="Prix maximum">
                                            <button type="submit" class="btn btn-dark" title="Rechercher">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            @if (request('search') || request('min_price') || request('max_price') || request('address'))
                                                <a href="{{ route('events.list') }}" class="btn btn-light" title="Rafraîchir">
                                                    <i class="fa fa-refresh" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </form> --}}
                                    @if ($events->isEmpty())
                                        <div class="alert alert-danger" role="alert">
                                            <p>Aucune correspondance trouvee</p>
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
