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
                <th>Remark</th>
                <th>Action</th>

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
                    <td>{{ $disposals->asset->brand }}</td>
                    <td>{{ $disposals->asset->model }}</td>
                    <td>{{ $disposals->asset->asset_name }}</td>
                    <td>{{ $disposals->asset->location }}</td>
                    <td>{{ $disposals->asset->serial_number }}</td>
                    <td>{{ $disposals->asset->spec }}</td>
                    <td>{{ $disposals->date_loan }}</td>
                    <td>{{ $disposals->remark }}</td>
                    <td>
            </tr>
    @endforeach
    </tbody>
</table>