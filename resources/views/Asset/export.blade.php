<table>
    <thead>
    <tr>
        <tr>
            {{-- <th>ID</th> --}}
            <th>Asset Number</th>
            <th>Asset Name</th>
            <th>Serial Number</th>
            <th>Location</th>
            <th>Brand</th>
            {{-- <th>Action</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach ($assets as $item)
            <tr>
                {{-- <td>{{ $item->id }}</td> --}}
                <td>{{ $item->asset_no }}</td>
                <td>{{ $item->asset_name }}</td>
                <td>{{ $item->serial_number }}</td>
                <td>{{ $item->location }}</td>
                <td>{{ $item->brand }}</td>
                <td>
            </tr>
    @endforeach
    </tbody>
</table>