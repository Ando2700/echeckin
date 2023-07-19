@extends('other.layouts.app')
@section('content')
    <h2>Saisie de facture {{ $patients->nom }} </h2>
    <form action="{{ route('savefacture') }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- @method('PUT') --}}
        <div class="form-group">
            <label for="nom">Patient</label>
            <select class="form-select" name="nom" id="nom" aria-label="nom">
                <option value="{{ $patients->nom }}">{{ $patients->nom }}</option>
            </select>
        </div>
    
            <div class="form-group">
                <label class="font-weight-bold">Date de la facture:</label>
                <input type="date" class="form-control @error('date_facture') is-invalid @enderror" name="date_facture" value="{{ old('date_facture') }}" placeholder="">
    
                @error('date_facture')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>
    
            <input type="submit" class="btn btn-primary" value="Valider">
            <button type="reset" class="btn btn-md btn-warning">Reset</button>
    
        </form>

        <h2>Voici la liste des factures : </h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Id client</th>
                    <th scope="col">Date facture</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($factures as $facture)
                <tr>
                    <td>{{ $facture->patient_id }}</td>
                    <td>{{ $facture->date_facture }}</td>
                    <td><a href="{{ route('saisiedetailfacture', ['id' => $facture->id]) }}" class="btn btn-sm btn-primary">Voir detail</a></td>
                </tr>    
                @endforeach
            </tbody>
        </table>
        {{-- <div class="d-flex">{!! $factures->appends(['sort' => 'votes'])->links() !!}</div> --}}
@endsection