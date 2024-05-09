<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
@extends('admin.layouts.app')
@section('meta_title', 'Echeck-in - Statistiques')
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
                                    <h1>Statistiques</h1>
                                    <hr />
                                    
                                    {{-- Stat for each event --}}
                                    <div class="container">
                                        <div class="row row-cols-1 row-cols-md-3">
                                            @foreach ($statistiques as $statistique)
                                                <div class="col mb-4">
                                                    <div class="card h-100 shadow">
                                                        <div class="card-header font-weight-bold">
                                                            {{ $statistique->eventname }}
                                                        </div>
                                                        <div class="card-body">
                                                            <p class="card-text">
                                                                <i class="fas fa-user-check mr-1" title="Présences"></i> :
                                                                {{ $statistique->nombre_de_presences }}
                                                                @if ($statistique->nombre_de_presences <= 1)
                                                                    personne
                                                                @else
                                                                    personnes
                                                                @endif
                                                            </p>
                                                            <p class="card-text">
                                                                <i class="fas fa-user mr-2"
                                                                    title="Nombre total d'invités "></i> :
                                                                {{ $statistique->nombre_total_invites }}
                                                                @if ($statistique->nombre_de_presences <= 1)
                                                                    personne
                                                                @else
                                                                    personnes
                                                                @endif
                                                            </p>
                                                            @php
                                                                $pourcentage = $statistique->pourcentage_presence;
                                                                $couleur = '';

                                                                if ($pourcentage < 50) {
                                                                    $couleur = 'text-danger';
                                                                } elseif ($pourcentage > 50) {
                                                                    $couleur = 'text-success';
                                                                } else {
                                                                    $couleur = 'text-warning';
                                                                }
                                                            @endphp
                                                            <p class="card-text">
                                                                Taux de présence(%) :
                                                                <span class="font-weight-bold {{ $couleur }}"
                                                                    style="font-size: 1.5em;">{{ $pourcentage }}%</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    {{-- Stat for each event --}}

                                    {{-- CHART --}}
                                    <canvas id="myChart" style="width:100%;max-width:600px"></canvas>

                                    <script>
                                        const xValues = [50, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150];
                                        const yValues = [7, 8, 8, 9, 9, 9, 10, 11, 14, 14, 15];

                                        new Chart("myChart", {
                                            type: "line",
                                            data: {
                                                labels: xValues,
                                                datasets: [{
                                                    fill: false,
                                                    lineTension: 0,
                                                    backgroundColor: "rgba(0,0,255,1.0)",
                                                    borderColor: "rgba(0,0,255,0.1)",
                                                    data: yValues
                                                }]
                                            },
                                            options: {
                                                legend: {
                                                    display: false
                                                },
                                                scales: {
                                                    yAxes: [{
                                                        ticks: {
                                                            min: 6,
                                                            max: 16
                                                        }
                                                    }],
                                                }
                                            }
                                        });
                                    </script>
                                    {{-- CHART --}}

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
