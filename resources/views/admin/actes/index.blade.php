@extends('admin.layouts.app')
@section('content')
<h2>Creation d'actes: </h2>
<form action="{{ route('actes.store') }}" method="POST" enctype="multipart/form-data">
@csrf
    <div class="form-group">
        <label class="font-weight-bold">Type d'acte : </label>
        <input type="text" class="form-control @error('type_acte') is-invalid @enderror" name="type_acte" value="{{ old('type_acte') }}" placeholder="Type d'acte">

        @error('type_acte')
            <div class="alert alert-danger mt-2">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="form-group">
        <label class="font-weight-bold">Budget acte : </label>
        <input type="number" class="form-control @error('budget') is-invalid @enderror" name="budget" value="{{ old('budget') }}" placeholder="Budget acte">

        @error('budget')
            <div class="alert alert-danger mt-2">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="form-group">
        <label class="font-weight-bold">Annee : </label>
        <input type="number" class="form-control @error('annee') is-invalid @enderror" name="annee" value="{{ old('annee') }}" placeholder="Annee">

        @error('annee')
            <div class="alert alert-danger mt-2">
                {{ $message }}
            </div>
        @enderror
    </div>
    <input type="submit" class="btn btn-primary" value="Valider">
    <button type="reset" class="btn btn-md btn-warning">Reset</button>

</form>

<h2>Voici la liste des actes : </h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Type d'acte</th>
                    <th scope="col">Budget</th>
                    <th scope="col">Annee</th>
                    <th scope="col">Action</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($actes as $acte)
                <tr>
                    <td>{{ $acte->type_acte }}</td>
                    <td>{{ $acte->budget }}</td>
                    <td>{{ $acte->annee }}</td>
                    <td><a href="{{ route('actes.edit', $acte->id) }}" class="btn btn-sm btn-primary">Update</a></td>
                    <td><form onsubmit="return confirm('Etes vous sur ?');" action="{{ route('actes.destroy', $acte->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form></td>
                </tr>    
                @endforeach
            </tbody>
        </table>
        <div class="d-flex">{!! $actes->appends(['sort' => 'votes'])->links() !!}</div>
@endsection