@extends('admin.layouts.app')
@section('meta_title', 'Echeck-in - Event Type - Modify')
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

                                    <h1>Modification de type d'événement</h1>
                                    <hr>
                                    <form action="{{ route('eventtypes.update', $eventtype->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label class="font-weight-bold">Type d'événement : {{ $eventtype->eventtype }} </label>
                                            <input type="text"
                                                class="form-control @error('eventtype') is-invalid @enderror"
                                                name="eventtype"
                                                placeholder="Type d'événement ..." value="{{ $eventtype->eventtype }}">

                                            @error('eventtype')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <input type="submit" class="btn btn-primary" value="Mettre à jour">
                                        <a href="{{ route('eventtypes.index') }}" class="btn btn-outline-dark"><i
                                            class="fa fa-arrow-left" aria-hidden="true"></i> Retour</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
