@extends('admin.layouts.app')
@section('content')
<div class="card-body">
    <h2>Editer patient : {{ $patients->nom }} </h2>
    <form action="{{ route('patients.update', $patients->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method("PUT")
            <div class="form-group">
                <label class="font-weight-bold">Nom du/de la patient(e)</label>
                <input type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ $patients->nom }}" placeholder="{{ $patients->nom }}">
    
                @error('nom')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>
    
            <div class="form-group">
                <label class="font-weight-bold">Debut de naissance</label>
                <input type="date" class="form-control @error('date_naissance') is-invalid @enderror" name="date_naissance" value="{{ $patients->date_naissance }}" placeholder="">
    
                @error('date_naissance')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>
    
            <div class="form-group">
                <label for="genre">Genre</label>
                <select class="form-select" name="genre" id="genre" aria-label="genre">
                    <option name=genre value="Homme">Homme</option>
                    <option name=genre value="Femme">Femme</option>
                </select>
            </div>
    
            <div class="form-group">
                <label for="remboursement">Remboursement</label>
                <select class="form-select" name="remboursement" id="remboursement" aria-label="remboursement">
                    <option value=""></option>
                    <option value="true">true</option>
                    <option value="false">false</option>
                </select>
            </div>
    
            <input type="submit" class="btn btn-primary" value="Valider">
            <button type="reset" class="btn btn-md btn-warning">Reset</button>
    
        </form>
</div>
@endsection