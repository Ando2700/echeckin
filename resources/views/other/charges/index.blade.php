@extends('other.layouts.app')
@section('content')
<?php 
    use Carbon\carbon;
?>
    <h1>Charge:</h1>
    <p>Ajouter des depenses : </p>
    <form action="{{ route('charges.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="type_depense">Type de depense</label>
            <select class="form-select" name="type_depense" id="type_depense" aria-label="type_depense">
                @foreach ($depenses as $depense)
                    <option value="{{ $depense->type_depense }}">{{ $depense->type_depense }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="form-group">
            <label class="font-weight-bold">Montant depense:</label>
            <input type="number" class="form-control @error('montant_depense') is-invalid @enderror" name="montant_depense" value="{{ old('montant_depense') }}" placeholder="">
            @error('montant_depense')
                <div class="alert alert-danger mt-2">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <div class="row">
            <div class="col">
                <p> Jour :<input name="jour"type="number" class="form-control" placeholder="jour"></p>
            </div>
            <div class="col">
                <div class="row">
                    <label for="mois">Mois:</label><br>
                    <div class="col">
                        <input type="checkbox" name="mois[]" value="01"> January<br>
                        <input type="checkbox" name="mois[]" value="02"> February<br>
                        <input type="checkbox" name="mois[]" value="03"> March<br>
                        <input type="checkbox" name="mois[]" value="04"> April<br>
                        <input type="checkbox" name="mois[]" value="05"> May<br>
                        <input type="checkbox" name="mois[]" value="06"> June<br>
                    </div>
                    <div class="col">
                        <input type="checkbox" name="mois[]" value="07"> July<br>
                        <input type="checkbox" name="mois[]" value="08"> August<br>
                        <input type="checkbox" name="mois[]" value="09"> Septmeber<br>
                        <input type="checkbox" name="mois[]" value="10"> October<br>
                        <input type="checkbox" name="mois[]" value="11"> November<br>
                        <input type="checkbox" name="mois[]" value="12"> December<br>    
                    </div>
                </div>
            </div>
            <div class="col">
                <p>Annee :<input name="annee" type="number" class="form-control" placeholder="annee"></p>
            </div>
        </div>
        <br/>
            <input type="submit" class="btn btn-primary" value="Valider">
            <button type="reset" class="btn btn-md btn-warning">Reset</button>
    
        </form>
        <h2>Voici la liste des charges : </h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Type depense</th>
                    <th scope="col">Date depense</th>
                    <th scope="col">Montant depense</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($type_charges as $type_charge)
                <tr>
                    <td>{{ $type_charge->type_depense }}</td>
                    <td>{{ Carbon::parse($type_charge->date)->format('d F Y') }}</td>
                    <td>{{ $type_charge->montant_depense }}</td>
                </tr>    
                @endforeach
            </tbody>
        </table>
        <div class="d-flex">{!! $type_charges->appends(['sort' => 'votes'])->links() !!}</div>
        {{-- <p>Total depense 
        @forelse ($somme as $somme)
        <strong>{{ $somme->somme_charge }}</strong>    
        @empty
            Pas encore de depense.
        @endforelse 
        </p>  --}}
@endsection