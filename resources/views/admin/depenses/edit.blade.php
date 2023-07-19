@extends('admin.layouts.app')
@section('content')
<div class="card-body">
    <h2>Editer depense : {{ $depense->type_depense }} </h2>
    <form action="{{ route('depenses.update', $depense->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method("PUT")
            <div class="form-group">
                <label class="font-weight-bold">Tpe d'depense : </label>
                <input type="text" class="form-control @error('type_depense') is-invalid @enderror" name="type_depense" value="{{ $depense->type_depense }}" placeholder="{{ $depense->type_depense }}">
    
                @error('type_depense')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label class="font-weight-bold">Budget depense : </label>
                <input type="number" class="form-control @error('budget') is-invalid @enderror" name="budget" value="{{ $depense->budget }}" placeholder="">
        
                @error('budget')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>
    
            <div class="form-group">
                <label class="font-weight-bold">Annee : </label>
                <input type="number" class="form-control @error('annee') is-invalid @enderror" name="annee" value="{{ $depense->annee }}" placeholder="Annee">
        
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