<x-app-web-layout>
    <x-slot name="title">
        {{ $asset->asset_name }} Details
    </x-slot>

    <div class="container mt-5">
        <h4>Asset Details</h4>
        
        <table class="table table-bordered mt-4">
            <tr>
                <th>Asset Number</th>
                <td>{{ $asset->asset_no }}</td>
            </tr>
            <tr>
                <th>Asset Name</th>
                <td>{{ $asset->asset_name }}</td>
            </tr>
            <tr>
                <th>Serial Number</th>
                <td>{{ $asset->serial_number }}</td>
            </tr>
            <tr>
                <th>Location</th>
                <td>{{ $asset->location }}</td>
            </tr>
            <tr>
                <th>Brand</th>
                <td>{{ $asset->brand }}</td>
            </tr>
        </table>

        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Back</a>
    </div>
</x-app-web-layout>
