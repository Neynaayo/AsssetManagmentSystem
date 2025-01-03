<table>
    <thead>
    <tr>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Staff No</th>
            <th>Nric No</th>
            <th>Department</th>
            <th>Company</th>
            <th>Position</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($staff as $index => $staff)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $staff->name }}</td>
                <td>{{ $staff->email }}</td>
                <td>{{ $staff->staff_no }}</td>
                <td>{{ $staff->department->name ?? 'N/A' }}</td>
                <td>{{ $staff->company->name ?? 'N/A'}}</td>
                <td>{{ $staff->position }}</td>
                <td>
            </tr>
    @endforeach
    </tbody>
</table>