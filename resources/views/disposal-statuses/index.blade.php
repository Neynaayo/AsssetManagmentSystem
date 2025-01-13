@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Disposal Statuses</h1>
    <a href="{{ route('disposal-statuses.create') }}" class="btn btn-primary">Add New Status</a>
    <a href="{{ route('disposals.index') }}" class="btn btn-primary float-end">Back</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Status Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($statuses as $status)
                <tr>
                    <td>{{ $status->id }}</td>
                    <td>{{ $status->name }}</td>
                    <td>
                        <a href="{{ route('disposal-statuses.edit', $status) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('disposal-statuses.destroy', $status) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure To delete This Status?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
