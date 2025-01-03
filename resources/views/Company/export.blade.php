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
        @foreach ($companies as $index => $companies)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $companies->code }}</td>
                <td>{{ $companies->name }}</td>
                <td>
            </tr>
    @endforeach
    </tbody>
</table>