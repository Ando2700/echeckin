@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <h1>Dashboard</h1>
        <form action="{{ route('dashboard.tableau') }}" enctype="multipart/form-data" method="post">
            @csrf
            @method('get')
            <div class="col">
                <div class="row">
                    <div class="col">
                        Mois :<input class="form-control" type="number" name="mois" placeholder="mois">
                    </div>
                    <div class="col">
                        Annee :<input class="form-control" type="number" name="annee" placeholder="annee"><br/>
                    </div>
                </div>
            </div>
            <input class="btn btn-primary" type="submit" value="Filter">
        </form>
        <h1>Recette - Depense - Benefice</h1>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Recette</div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Type acte</th>
                                        <th>Reel</th>
                                        <th>Budget</th>
                                        <th>Realisation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recettes as $recette)
                                    <tr>
                                        <td>{{ $recette->type_acte }}</td>
                                        <td>{{ $recette->montant_total }}</td>
                                        <td>{{ $recette->budget }}</td>
                                        <td>{{ $recette->realisation }} % </td>
                                    </tr>
                                    @empty
                                        Recette vide.
                                    @endforelse

                                    <tr>
                                        <td></td>
                                        <td><strong>{{ $sommeacte }}</strong></td>
                                        <td><strong>{{ $sommebudget }}</strong></td>
                                        <td><strong>{{ number_format($totalrealisation, '2', ',', ' ') }} %</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Dépense</div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Type acte</th>
                                        <th>Reel</th>
                                        <th>Budget</th>
                                        <th>Realisation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($depenses as $depense)
                                    <tr>
                                        <td>{{ $depense->type_depense }}</td>
                                        <td>{{ $depense->montant_total }}</td>
                                        <td>{{ $depense->budget }}</td>
                                        <td>{{ $depense->realisation }} % </td>
                                    </tr>
                                    @empty
                                        Requette vide.
                                    @endforelse

                                    <tr>
                                        <td></td>
                                        <td><strong>{{ $sommedepense }}</strong></td>
                                        <td><strong>{{ $sommebudgetdepense }}</strong></td>
                                        <td><strong>{{ number_format($totalrealisationdepense, '2', ',', ' ') }} %</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Bénéfice</div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>-</th>
                                        <th>Reel</th>
                                        <th>Budget</th>
                                        <th>Realisation</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Recette</td>
                                        <td>{{ $sommeacte }}</td>
                                        <td>{{ $sommebudget }}</td>
                                        <td>{{ number_format($totalrealisation, '2', ',', ' ') }} %</td>
                                    </tr>
                                    <tr>
                                        <td>Depense</td>
                                        <td>{{ $sommedepense }}</td>
                                        <td>{{ $sommebudgetdepense }}</td>
                                        <td>{{ number_format($totalrealisationdepense, '2', ',', ' ') }} %</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><strong>{{ $beneficesomme }}</strong></td>
                                        <td><strong>{{ $beneficebudget }}</strong></td>
                                        <td><strong>{{ number_format($benefice, '2', ',', ' ') }}</strong> %</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

    </div>
@endsection
