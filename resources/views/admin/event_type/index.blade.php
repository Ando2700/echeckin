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

                                    <h1>Création de type d'événement</h1>
                                    <hr>
                                    <form action="{{ route('eventtypes.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-group">
                                            <label class="font-weight-bold">Type d'événement : </label>
                                            <input type="text"
                                                class="form-control @error('eventtype') is-invalid @enderror"
                                                name="eventtype" value="{{ old('eventtype') }}"
                                                placeholder="Type d'événement ...">

                                            @error('eventtype')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <input type="submit" class="btn btn-primary" value="Ajouter" title="Ajouter">
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

                                    <h3>Liste des types d'événement: </h3>
                                    <form action="{{ route('eventtypes.index') }}" method="GET" class="mb-3">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Rechercher...">
                                            <button type="submit" class="btn btn-dark" title="Rechercher">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            @if (request('search'))
                                                <a href="{{ route('eventtypes.index') }}" class="btn btn-light"
                                                    title="Rafraîchir"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                                            @endif
                                        </div>
                                    </form>

                                    @if ($eventtypes->isEmpty())
                                        <div class="alert alert-danger" role="alert">
                                            <p>Aucune correspondance trouvee</p>
                                        </div>
                                    @endif
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Type d'événement</th>
                                                <th>Action</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($eventtypes as $eventtype)
                                                <tr>
                                                    <td>{{ $eventtype->eventtype }}</td>
                                                    <td><a class="btn btn-primary btn-sm" href="{{ route('eventtypes.edit', $eventtype->id) }}" title="Modifier - {{ $eventtype->eventtype }}">Modifier</a></td>
                                                    <td>
                                                        <form onsubmit="return confirm('Etes vous sur ?');"
                                                            action="{{ route('eventtypes.destroy', $eventtype->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button 
                                                                type="submit"
                                                                class="btn btn-sm btn-danger"
                                                                title="Supprimer - {{ $eventtype->eventtype }}">Supprimer</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex">{!! $eventtypes->appends(['search' => request('search')])->links() !!}</div>
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
