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
                <th>Date Disposals</th>
                <th>Disposal Status</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($disposals as $index => $disposal)
                {{-- @php
                    $untilDateLoan = \Carbon\Carbon::parse($Disposals->until_date_loan);
                    $isOverdue = $untilDateLoan->isPast();
                @endphp --}}
                <tr>
                    <td>{{ $index + 1 }}</td>
                                            <td>{{ $disposal->asset->brand }}</td>
                                            <td>{{ $disposal->asset->model }}</td>
                                            <td>{{ $disposal->asset->asset_name }}</td>
                                            <td>{{ $disposal->asset->location }}</td>
                                            <td>{{ $disposal->asset->serial_number }}</td>
                                            <td>{{ $disposal->asset->spec }}</td>
                                            <td>{{ $disposal->date_loan }}</td>
                                            <td>{{ $disposal->disposalStatus->name ?? 'N/A' }}</td>
                                            <td>{{ $disposal->remark }}</td>
            </tr>
    @endforeach
    </tbody>
</table>