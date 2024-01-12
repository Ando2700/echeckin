@extends('admin.layouts.app')
@section('meta_title', 'Echeck-in - Attendee - Edit')
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

                                    <h1>Modification de : {{ $attendee->firstname }}</h1>
                                    <hr>
                                    <form action="{{ route('attendees.update', $attendee->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label class="font-weight-bold">Nom : </label>
                                            <input type="text"
                                                class="form-control @error('firstname') is-invalid @enderror"
                                                name="firstname" value="{{ $attendee->firstname }}"
                                                placeholder="Nom du participant/invité ...">

                                            @error('firstname')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Prenom : </label>
                                            <input type="text"
                                                class="form-control @error('lastname') is-invalid @enderror" name="lastname"
                                                value="{{ $attendee->lastname }}"
                                                placeholder="Prenom du participant/invité ...">

                                            @error('lastname')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Email : </label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                name="email" value="{{ $attendee->email }}"
                                                placeholder="Ex : sample@gmail.com">

                                            @error('email')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <input type="submit" class="btn btn-primary" value="Ajouter" title="Ajouter">
                                        <a href="{{ route('attendees.index') }}" class="btn btn-outline-dark"><i
                                            class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                                    </form>                                
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
