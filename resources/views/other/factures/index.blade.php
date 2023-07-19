@extends('other.layouts.app')
@section('content')
<?php 
    use Carbon\carbon;
?>
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
            <td><a href="{{ route('saisiefacture', ['id' => $patient->id]) }}" class="btn btn-sm btn-primary">Saisir facture</a></td>
            <td><a href="{{ route('factures.edit', $patient->id) }}" class="btn btn-sm btn-dark">Historique</a></td>
        </tr>    
        @endforeach
    </tbody>
</table>
<div class="d-flex">{!! $patients->appends(['sort' => 'votes'])->links() !!}</div>

@endsection