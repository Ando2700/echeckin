@extends('admin.layouts.app')
@section('content')
<h2>Creation de depenses:</h2>
<form action="{{ route('depenses.store') }}" method="POST" enctype="multipart/form-data">
@csrf
    <div class="form-group">
        <label class="font-weight-bold">Type de depense : </label>
        <input type="text" class="form-control @error('type_depense') is-invalid @enderror" name="type_depense" value="{{ old('type_depense') }}" placeholder="Type de depense">

        @error('type_depense')
            <div class="alert alert-danger mt-2">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="form-group">
        <label class="font-weight-bold">Budget depense : </label>
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

<h2>Voici la liste des depenses : </h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Type de depense</th>
                    <th scope="col">Budget</th>
                    <th scope="col">Annee</th>
                    <th scope="col">Action</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($depenses as $depense)
                <tr>
                    <td>{{ $depense->type_depense }}</td>
                    <td>{{ $depense->budget }}</td>
                    <td>{{ $depense->annee }}</td>
                    <td><a href="{{ route('depenses.edit', $depense->id) }}" class="btn btn-sm btn-primary">Update</a></td>
                    <td><form onsubmit="return confirm('Etes vous sur ?');" action="{{ route('depenses.destroy', $depense->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form></td>
                </tr>    
                @endforeach
            </tbody>
        </table>
        <div class="d-flex">{!! $depenses->appends(['sort' => 'votes'])->links() !!}</div>
@endsection