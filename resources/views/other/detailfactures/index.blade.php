@extends('other.layouts.app')
@section('content')
<h2>Detail facture N: {{ $factures->id }} </h2>
<form action="{{ route('savedetailfacture') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="form-group">
            <label for="nom">Facture</label>
            <select class="form-select" name="id" id="id" aria-label="nom">
                <option value="{{ $factures->id }}">{{ $factures->id }}</option>
            </select>
            @error('id')
                <div class="alert alert-danger mt-2">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="nom">Acte</label>
            <select class="form-select" name="type_acte" id="type_acte" aria-label="type_acte">
            @foreach ($actes as $acte)
                <option value="{{ $acte->type_acte }}">{{ $acte->type_acte }}</option>                
            @endforeach
            </select>     
            @error('type_acte')
                <div class="alert alert-danger mt-2">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="montant">Montant</label>
            <input type="number" class="form-control @error('montant') is-invalid @enderror" name="montant" value="{{ old('montant') }}" placeholder="">
            @error('montant')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
        </div>

        <input type="submit" class="btn btn-primary" value="Valider">
        <button type="reset" class="btn btn-md btn-warning">Reset</button>

    </form>
@endsection