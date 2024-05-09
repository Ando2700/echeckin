@extends('admin.layouts.app')
@section('meta_title', 'Echeck-in - Place - List')
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

                                    {{-- Liste des places --}}
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
                                    <p><a href="{{ route('places.index') }}" class="btn btn-dark">Ajouter un lieu</a></p>
                                    <form action="{{ route('places.list') }}" method="GET" class="mb-3">
                                        <div class="input-group">
                                            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Rechercher le nom du lieu...">
                                            <input type="text" name="address" class="form-control" placeholder="Adresse du lieu">
                                            <input type="number" name="min_price" class="form-control" placeholder="Prix minimum">
                                            <input type="number" name="max_price" class="form-control" placeholder="Prix maximum">
                                            <button type="submit" class="btn btn-dark" title="Rechercher">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            @if (request('search') || request('min_price') || request('max_price') || request('address'))
                                                <a href="{{ route('places.list') }}" class="btn btn-light" title="Rafraîchir">
                                                    <i class="fa fa-refresh" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </form>
                                    @if ($places->isEmpty())
                                        <div class="alert alert-danger" role="alert">
                                            <p>Aucune correspondance trouvee</p>
                                        </div>
                                    @endif
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nom de la Place</th>
                                                <th>Adresse</th>
                                                <th>Description</th>
                                                <th>Nombre de places</th>
                                                <th>Prix</th>
                                                <th>Modifier</th>
                                                <th>Supprimer</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($places as $place)
                                                <tr>
                                                    <td>{{ $place->nomplace }}</td>
                                                    <td>
                                                        @if ($place->address)
                                                            {{ $place->address }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {!! Str::limit($place->description, $limit = 100, $end = '...') !!}
                                                        <br><a href="{{ route('places.show', $place->id) }}">Voir détail</a>
                                                    </td>
                                                    <td>{{ $place->numberplace }}</td>
                                                    <td>
                                                        @if ($place->price)
                                                            {{ $place->price }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a title="Modifier - {{ $place->nomplace }}" href="{{ route('places.edit', $place->id) }}"
                                                            class="btn btn-outline-primary btn-sm"><i class="fas fa-pen"></i></a>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('places.destroy', $place->id) }}"
                                                            method="POST" style="display:inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button title="Supprimer - {{ $place->nomplace }}" type="submit" class="btn btn-outline-danger btn-sm"
                                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce lieu ?')"><i class="fas fa-trash"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex">{!! $places->appends(['search' => request('search')])->links() !!}</div>
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
