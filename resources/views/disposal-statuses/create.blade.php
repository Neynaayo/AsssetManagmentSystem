@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Disposal Status</h1>

    <form action="{{ route('disposal-statuses.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Status Name</label>
            <a href="{{ route('disposal-statuses.index') }}" class="btn btn-primary float-end">Back</a>
            <br>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <br>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection
