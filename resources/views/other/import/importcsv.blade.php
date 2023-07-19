@extends('other.layouts.app')
@section('content')
    <h4>Import CSV : </h4>
    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
        <label class="font-weight-bold">Type d'acte : </label>
        <input type="file" accept=".csv" class="form-control @error('csv_file') is-invalid @enderror" name="csv_file" value="{{ old('csv_file') }}" placeholder="Type d'acte">
        </div>
        <input type="submit" class="btn btn-warning" value="Save">
        <input type="reset" class="btn btn-dark"value="Reset">
    </form>
@endsection