<table>
    <thead>
    <tr>
        <tr>
            <th>No</th>
            <th>Code</th>
            <th>Name</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($departments as $index => $departments)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $departments->code }}</td>
                <td>{{ $departments->name }}</td>
                <td>
            </tr>
    @endforeach
    </tbody>
</table>