<table>
    <thead>
    <tr>
        <tr>
            <th>No</th>
            <th>Location</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Type</th>
            <th>Serial Number</th>
            <th>Spec</th>
            <th>User</th>
            <th>Department</th>
            <th>Previous Owner</th>
            <th>Domain</th>
            <th>Company</th>
            <th>Paid By</th>
            <th>Condition</th>
            <th>Remark</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($assets as $index => $asset)
                                    <tr>
                                        <td>{{ $index + 1 }}</td> 
                                        <td>{{ $asset->location }}</td>
                                        <td>{{ $asset->brand }}</td>
                                        <td>{{ $asset->model }}</td>
                                        <td>{{ $asset->type }}</td>
                                        <td>{{ $asset->serial_number }}</td>
                                        <td>{{ $asset->spec }}</td>
                                        <td>{{ $asset->user_id }}</td>
                                        <td>{{ $asset->department->name ?? 'N/A' }}</td>
                                        <td>{{ $asset->previous_user_id }}</td>
                                        <td>{{ $asset->domain }}</td>
                                        <td>{{ $asset->company->name ?? 'N/A' }}</td>
                                        <td>{{ $asset->paid_by }}</td>
                                        <td>{{ $asset->conditions }}</td>
                                        <td>{{ $asset->remark }}</td>
                                        <td>
            </tr>
    @endforeach
    </tbody>
</table>