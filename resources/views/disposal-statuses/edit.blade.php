@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Disposal Status</h1>

    <form action="{{ route('disposal-statuses.update', $disposalStatus) }}" method="POST">

        @csrf
        @method('PUT')
        <div class="form-group">
            <a href="{{ route('disposal-statuses.index') }}" class="btn btn-primary float-end">Back</a>

            <label for="name">Status Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $disposalStatus->name }}" required>
        </div>
        <br>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
