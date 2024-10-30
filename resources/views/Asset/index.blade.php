<x-app-web-layout>
    <x-slot name="title">
        Asset
    </x-slot>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Asset
                            <a href="{{ url('Asset/create') }}" class="btn btn-primary float-end">Add Asset</a>
                           
                            <div class="col-md-5 mn-4">
                                <form action="{{url('Asset/export')}}" method="GET">

                                    <div class="input-group mt-3">
                                        <select name="type" class="form-control">
                                        <option value="">Select type</option>
                                        <option value="xlsx">XLSX</option>
                                        <option value="csv">CSV</option>
                                        <option value="xls">XLS</option>
                                    </select>
                                    <button type="submit" class="btn btn-success">Export / Download</button>
                                </div>
                                </form>
                            </div>
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Search Form -->
                        <form action="{{ url('Asset') }}" method="GET" class="mb-3">
                            <div class="input-group">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search assets..." class="form-control">
                            <button type="submit" class="btn btn-primary mt-2">Search</button>
                            </div>
                        </form>

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Asset Number</th>
                                    <th>Asset Name</th>
                                    <th>Serial Number</th>
                                    <th>Location</th>
                                    <th>Brand</th>
                                    <th>Action</th>
                                    <th>QR-Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assets as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->asset_no }}</td>
                                        <td>{{ $item->asset_name }}</td>
                                        <td>{{ $item->serial_number }}</td>
                                        <td>{{ $item->location }}</td>
                                        <td>{{ $item->brand }}</td>
                                        <td>
                                            <a href="{{ url('Asset/'.$item->id.'/edit') }}" class="btn btn-success mx-2">Edit</a>
                                            <a href="{{ url('Asset/'.$item->id.'/delete') }}" class="btn btn-danger mx-1" onclick="return confirm('Are you sure?')">Delete</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('assets.qrCode', $item->id) }}" class="btn btn-success mx-2">Show Qr-Code</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination Links -->
                        <div  style="margin-top: 10px;">
                            {{ $assets->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-web-layout>
<style>
    .pagination .page-link {
    font-size: 1rem; /* Adjust this to control text/icon size */
    padding: 0.5rem 0.75rem; /* Adjust padding for smaller buttons */
}
.pagination .page-item.active .page-link {
    font-size: 1rem;
}
    </style>