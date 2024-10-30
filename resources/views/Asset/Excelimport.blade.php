<x-app-web-layout>

    <div class="container">
        <div class="row">
            <div class="col-md-8 mt-5">

                @if (session('status'))
                    <div class="alert alert-success">{{session('status')}}</div>
                @endif

            <div class="card">
            <div class="card-header">
                <h2>Import Excel Data into Database in Asset System</h2>
            </div>
            <div class="card-body">

                <form action="{{url('Asset/import')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="input-group">
                    <input type="file" name="import_file" class="form-control"/>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
                </form>
            </div>
            </div>
            </div>
        </div>
    </div>


</x-app-web-layout>
