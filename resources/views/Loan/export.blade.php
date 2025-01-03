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
                <th>Loan By</th>
                <th>Date Loan</th>
                <th>Until date Loan</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loans as $index => $loans)
                @php
                    $untilDateLoan = \Carbon\Carbon::parse($loans->until_date_loan);
                    $isOverdue = $untilDateLoan->isPast();
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $loans->asset->brand }}</td>
                    <td>{{ $loans->asset->model }}</td>
                    <td>{{ $loans->asset->asset_name }}</td>
                    <td>{{ $loans->asset->location }}</td>
                    <td>{{ $loans->asset->serial_number }}</td>
                    <td>{{ $loans->asset->spec }}</td>
                    <td>{{ $loans->loanedByStaff->name ?? 'N/A' }}</td>
                    <td>{{ $loans->date_loan }}</td>
                    <td class="{{ $isOverdue ? 'text-danger' : 'text-success' }}">
                        {{ $loans->until_date_loan }}
                    </td>
                    <td>{{ $loans->remark }}</td>
                    <td>
            </tr>
    @endforeach
    </tbody>
</table>