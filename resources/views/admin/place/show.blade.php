@extends('admin.layouts.app')
@section('meta_title', 'Echeck-in - Place - Detail')
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
                                    <h2>{{ $place->nomplace }} :</h2>
                                    @if ($place->address)
                                        <h4>Adresse : {{ $place->address }}</h4>
                                    @else
    
                                    @endif
                                    <hr>
                                    <p><strong>Image(s)</strong></p>
                                    @if ($place->images->count() > 0)
                                        <div id="carousel-image" class="carousel slide carousel-fade w-75"
                                            data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                <div class="carousel-indicators">
                                                    @foreach ($place->images as $key => $image)
                                                        <button type="button" data-bs-target="#carousel-image"
                                                            data-bs-slide-to="{{ $key }}"
                                                            class="{{ $key == 0 ? 'active' : '' }}"
                                                            aria-label="Slide {{ $key + 1 }}"></button>
                                                    @endforeach
                                                </div>
                                                @foreach ($place->images as $key => $image)
                                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                        <img src="{{ asset('storage/' . $image->path) }}"
                                                            alt="{{ $place->nomplace }}" class="d-block w-100 h-75">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button class="carousel-control-prev" type="button"
                                                data-bs-target="#carousel-image" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                data-bs-target="#carousel-image" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                    @else
                                        <p>Aucune image disponible pour cette place.</p>
                                    @endif
                                    <p><strong>Description : </strong></p>
                                    {!! $place->description !!}
                                    <p><strong>Nombre de place(s) : {{ $place->numberplace }}</strong></p>
                                    <p><strong>Prix :</strong>
                                        @if ($place->price)
                                            {{ $place->price }} Ariary
                                        @else
                                            -
                                        @endif
                                    </p>
                                    <a href="{{ route('places.list') }}" class="btn btn-outline-dark"><i
                                            class="fa fa-arrow-left" aria-hidden="true"></i> Retour</a>

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
