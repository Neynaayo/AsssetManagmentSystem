@extends('layouts.app')

@section('title', 'Import Excel')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 mt-5">

                @if (session('status'))
                    <div class="alert alert-success">{{session('status')}}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                @endif

            <div class="card">
            <div class="card-header">
                <h2>Import Excel Data for Staffs</h2>
            </div>
             <!-- Added warning message -->
             <div class="alert alert-warning mb-3">
                <strong>Important:</strong>
                <ul class="mb-0">
                    <li>Your Excel file must have column headers in Row 1</li>
                    <li>Data should start from Column A (first column)</li>
                    <li>Do not leave empty rows before the headers</li>
                </ul>
            </div>
            <div class="card-body">

                <form action="{{ route('staffs.importExcelData') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="input-group">
                    <input type="file" name="import_file" class="form-control"/>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
                </form>
                <br>
                <a href="{{ route('staffs.index') }}" class="btn btn-primary float-end">View Staff List</a>

            </div>
            </div>
            </div>
        </div>
    </div>


@endsection
