@extends('admin.layouts.app')
@section('content')
<?php 
    use Carbon\carbon;
?>
<h2>Creation de patient(e): </h2>
    <form action="{{ route('patients.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="form-group">
            <label class="font-weight-bold">Nom du/de la patient(e)</label>
            <input type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom') }}" placeholder="Nom Patient">
            @error('nom')
                <div class="alert alert-danger mt-2">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label class="font-weight-bold">Debut de naissance</label>
            <input type="date" class="form-control @error('date_naissance') is-invalid @enderror" name="date_naissance" value="{{ old('date_naissance') }}" placeholder="">

            @error('date_naissance')
                <div class="alert alert-danger mt-2">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="genre">Genre</label>
            <select class="form-select" name="genre" id="genre" aria-label="genre">
                <option value="">Select genre</option>
                <option name="genre" value="Homme">Homme</option>
                <option name="genre" value="Femme">Femme</option>
            </select>
        </div>

        <div class="form-group">
            <label for="remboursement">Remboursement</label>
            <select class="form-select" name="remboursement" id="remboursement" aria-label="remboursement">
                <option value="">Select remboursement</option>
                <option value="true">true</option>
                <option value="false">false</option>
            </select>
        </div>

        <input type="submit" class="btn btn-primary" value="Valider">
        <button type="reset" class="btn btn-md btn-warning">Reset</button>

    </form>

    <h2>Voici la liste des patients : </h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nom du/de la patient(e)</th>
                    <th scope="col">Date de naissance</th>
                    <th scope="col">Remboursement</th>
                    <th scope="col">Action</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patients as $patient)
                <tr>
                    <td>{{ $patient->nom }}</td>
                    <td>{{ Carbon::parse($patient->date_naissance)->format('d F Y') }}</td>
                    <td>@if ($patient->remboursement==1)
                        true
                    @else
                        false
                    @endif</td>
                    <td><a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-sm btn-primary">Update</a></td>
                    <td><a href="{{ route('patients.destroy', $patient->id) }}" class="btn btn-sm btn-danger">Delete</a></td>
                </tr>    
                @endforeach
            </tbody>
        </table>
        <div class="d-flex">{!! $patients->appends(['sort' => 'votes'])->links() !!}</div>
@endsection