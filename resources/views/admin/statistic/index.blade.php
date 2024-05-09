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

                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-6" title="Nombre de statistiques à afficher">
                                                <select id="filterSelect" class="form-select">
                                                    <option value="0">Tout afficher</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="5">5</option>
                                                    <option value="10">10</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6" title="Rechercher des événement">
                                                <input type="text" id="searchInput" class="form-control"
                                                    placeholder="Rechercher par événement">
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <div class="container">
                                        <div class="row row-statistiques row-cols-1 row-cols-md-3">
                                            @foreach ($statistiques as $statistique)
                                                <div class="col mb-4 statistique-card">
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
                                                                    style="font-size: 1.5em;">
                                                                    {{ $pourcentage }}%
                                                                </span>
                                                            </p>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="button"
                                                                title="Graphe de {{ $statistique->eventname }}"
                                                                class="btn btn-dark btn-sm" data-toggle="modal"
                                                                data-target="#exampleModal{{ $loop->index }}">
                                                                <i class="fa fa-area-chart"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Modal  --}}
                                                <div class="modal fade" id="exampleModal{{ $loop->index }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Graphe pour
                                                                    {{ $statistique->eventname }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                @if (!empty($presenceHeure[$statistique->id]))
                                                                    <canvas id="myChart{{ $loop->index }}"
                                                                        style="width:100%;max-width:600px"></canvas>
                                                                @else
                                                                    <p
                                                                        style="font-size: 16px; color: #333; text-align: center; margin-top: 20px;">
                                                                        Aucune statistique pour le moment</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- Modal  --}}
                                            @endforeach
                                        </div>
                                    </div>

                                    <script>
                                        @foreach ($statistiques as $index => $statistique)
                                            const xValues{{ $index }} = @json($intervalHeure[$statistique->id]);
                                            const yValues{{ $index }} = @json(array_values($presenceHeure[$statistique->id]));

                                            new Chart("myChart{{ $index }}", {
                                                type: "line",
                                                data: {
                                                    labels: xValues{{ $index }},
                                                    datasets: [{
                                                        fill: false,
                                                        lineTension: 0,
                                                        backgroundColor: "rgba(0,0,255,1.0)",
                                                        borderColor: "rgba(0,0,255,0.1)",
                                                        data: yValues{{ $index }}
                                                    }]
                                                },
                                                options: {
                                                    legend: {
                                                        display: false
                                                    },
                                                    scales: {
                                                        xAxes: [{
                                                            scaleLabel: {
                                                                display: true,
                                                                labelString: 'Heure par événement'
                                                            }
                                                        }],
                                                        yAxes: [{
                                                            scaleLabel: {
                                                                display: true,
                                                                labelString: 'Nombre de présences'
                                                            },
                                                            ticks: {
                                                                min: 0,
                                                                max: {{ $statistique->nombre_total_invites }},
                                                                stepSize: 1,
                                                            }
                                                        }]
                                                    }
                                                }
                                            });
                                        @endforeach
                                        
                                        document.getElementById('filterSelect').addEventListener('change', function() {
                                            var selectedValue = parseInt(this.value);
                                            var rowDiv = document.querySelector('.row-statistiques');

                                            if (selectedValue === 0) {
                                                rowDiv.classList.remove('row-cols-md-2', 'row-cols-md-3');
                                                rowDiv.classList.add('row-cols-md-3');

                                                var cards = document.querySelectorAll('.statistique-card');
                                                cards.forEach(function(card) {
                                                    card.style.display = 'block';
                                                });
                                            } else {
                                                var rowClass = '';
                                                if (selectedValue == 1) {
                                                    rowClass = 'row-cols-md-1';
                                                } else if (selectedValue == 2) {
                                                    rowClass = 'row-cols-md-2';
                                                } else {
                                                    rowClass = 'row-cols-md-3';
                                                }
                                                rowDiv.classList.remove('row-cols-md-1', 'row-cols-md-2', 'row-cols-md-3');
                                                rowDiv.classList.add(rowClass);

                                                var cards = document.querySelectorAll('.statistique-card');
                                                cards.forEach(function(card, index) {
                                                    if (selectedValue === 0 || index < selectedValue) {
                                                        card.style.display = 'block';
                                                    } else {
                                                        card.style.display = 'none';
                                                    }
                                                });
                                            }
                                        });
                        
                                        document.getElementById('searchInput').addEventListener('input', function() {
                                            var searchValue = this.value.trim().toLowerCase();
                                            var cards = document.querySelectorAll('.statistique-card');
                                            var visibleCount = 0;

                                            cards.forEach(function(card) {
                                                var eventName = card.querySelector('.card-header').textContent.trim().toLowerCase();
                                                if (eventName.includes(searchValue)) {
                                                    card.style.display = 'block';
                                                    visibleCount++;
                                                } else {
                                                    card.style.display = 'none';
                                                }
                                            });

                                            var rowDiv = document.querySelector('.row-statistiques');

                                            if (visibleCount === 1) {
                                                rowDiv.classList.remove('row-cols-md-2', 'row-cols-md-3');
                                                rowDiv.classList.add('row-cols-md-1');
                                            } else if (visibleCount === 2) {
                                                rowDiv.classList.remove('row-cols-md-1', 'row-cols-md-3');
                                                rowDiv.classList.add('row-cols-md-2');
                                            } else {
                                                rowDiv.classList.remove('row-cols-md-1', 'row-cols-md-2');
                                                rowDiv.classList.add('row-cols-md-3');
                                            }
                                        });
                                    </script>

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
