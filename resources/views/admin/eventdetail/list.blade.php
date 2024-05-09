@extends('admin.layouts.app')
@section('meta_title', 'Echeck-in - Event detail - List')
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

                                    <h1>Liste des QR Code</h1>
                                    <hr>
                                    @foreach ($invitationsParDossier as $dossier => $invitationsDansCeDossier)
                                        <div class="mb-4">
                                            <h2>Dossier qr_code/{{ $dossier }} : </h2>
                                            <div class="row">
                                                @foreach ($invitationsDansCeDossier as $invitation)
                                                    <div class="col-md-3 mb-3">
                                                        <img 
                                                            src="{{ asset('storage/' . $invitation->qr_code) }}"
                                                            alt="{{ $invitation->id }}" class="img-fluid">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach

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
