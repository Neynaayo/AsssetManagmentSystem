<table>
    <thead>
    <tr>
        <tr>
            <th>No</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Asset Name</th>
            <th>Location</th>
            <th>Serial Number</th>
            <th>Spec</th>
            <th>Remark</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($availables as $index => $availables)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                            <td>{{ $availables->asset->brand }}</td>
                                            <td>{{ $availables->asset->model }}</td>
                                            <td>{{ $availables->asset->asset_name }}</td>
                                            <td>{{ $availables->asset->location }}</td>
                                            <td>{{ $availables->asset->serial_number }}</td>
                                            <td>{{ $availables->asset->spec }}</td>
                                            <td>{{ $availables->remark }}</td>
                                        <td>
            </tr>
    @endforeach
    </tbody>
</table>