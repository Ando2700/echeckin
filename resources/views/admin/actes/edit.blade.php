@extends('admin.layouts.app')
@section('content')
<div class="card-body">
    <h2>Editer acte : {{ $acte->type_acte }} </h2>
    <form action="{{ route('actes.update', $acte->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method("PUT")
            <div class="form-group">
                <label class="font-weight-bold">Tpe d'acte : </label>
                <input type="text" class="form-control @error('type_acte') is-invalid @enderror" name="type_acte" value="{{ $acte->type_acte }}" placeholder="{{ $acte->type_acte }}">
    
                @error('type_acte')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>
    
            <div class="form-group">
                <label class="font-weight-bold">Budget acte : </label>
                <input type="number" class="form-control @error('budget') is-invalid @enderror" name="budget" value="{{ $acte->budget }}" placeholder="">
        
                @error('budget')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label class="font-weight-bold">Annee : </label>
                <input type="number" class="form-control @error('annee') is-invalid @enderror" name="annee" value="{{ $acte->annee }}" placeholder="Annee">
        
                @error('annee')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <input type="submit" class="btn btn-primary" value="Valider">
            <button type="reset" class="btn btn-md btn-warning">Reset</button>
    
        </form>
</div>
@endsection