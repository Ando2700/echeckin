@extends('admin.layouts.app')
@section('meta_title', 'Echeck-in - Place - Create')
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

                                    <h1>Création d'un lieu d'événement</h1>
                                    <hr>
                                    <a href="{{ route('places.list') }}" class="btn btn-dark" title="Liste des lieux">Liste des lieux</a>
                                    <form action="{{ route('places.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @if (Session::has('success'))
                                            <div class="alert alert-success">
                                                {{ Session::get('success') }}
                                            </div>
                                        @endif
                                        @if (Session::has('error'))
                                            <div class="alert alert-danger">
                                                {{ Session::get('error') }}
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <label class="font-weight-bold">Nom du lieu : </label>
                                            <input type="text"
                                                class="form-control @error('nomplace') is-invalid @enderror" name="nomplace"
                                                placeholder="Ajouter le nom du lieu ...">
                                            @error('nomplace')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Adresse : </label>
                                            <input type="text"
                                                class="form-control @error('address') is-invalid @enderror" name="address"
                                                placeholder="Adresse du lieu ...">
                                            @error('address')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Nombre de place(s) : </label>
                                            <input type="number"
                                                class="form-control @error('numberplace') is-invalid @enderror"
                                                name="numberplace" placeholder="Entrer le nombre de places ...">
                                            @error('numberplace')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5"
                                                placeholder="Entrer la description"></textarea>

                                            @error('description')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Prix du lieu : </label>
                                            <input type="number" class="form-control @error('price') is-invalid @enderror"
                                                name="price" placeholder="Entrer le prix du lieu ...">
                                            @error('price')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Images :</label>
                                            <input type="file"
                                                class="form-control @error('images.*') is-invalid @enderror" name="images[]"
                                                multiple accept="image/*">

                                            @error('images.*')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-primary" title="Enregistrer">
                                            <i class="fa-solid fa-floppy-disk"></i> Enregitrer
                                        </button>
                                        <input type="reset" class="btn btn-warning" value="Reset" title="Reset">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description');
    </script>
@endsection
