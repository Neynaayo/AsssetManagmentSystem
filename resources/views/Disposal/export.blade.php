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
                <th>Status Disposals</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($disposals as $index => $disposals)
                {{-- @php
                    $untilDateLoan = \Carbon\Carbon::parse($Disposals->until_date_loan);
                    $isOverdue = $untilDateLoan->isPast();
                @endphp --}}
                <tr>
                    <td>{{ $index + 1 }}</td>
                                            <td>{{ $Disposal->asset->brand }}</td>
                                            <td>{{ $Disposal->asset->model }}</td>
                                            <td>{{ $Disposal->asset->asset_name }}</td>
                                            <td>{{ $Disposal->asset->location }}</td>
                                            <td>{{ $Disposal->asset->serial_number }}</td>
                                            <td>{{ $Disposal->asset->spec }}</td>
                                            <td>{{ $Disposal->date_loan }}</td>
                                            <td>{{ $Disposal->disposalStatus->name ?? 'N/A' }}</td>
                                            <td>{{ $Disposal->remark }}</td>
            </tr>
    @endforeach
    </tbody>
</table>