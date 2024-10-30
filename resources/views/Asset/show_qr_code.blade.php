<x-app-web-layout>
    <x-slot name="title">
        {{ $asset->asset_name }} QR Code
    </x-slot>

    <div class="container mt-5">
        <h4>{{ $asset->asset_name }} QR Code</h4>
        <p>Scan the QR code below to view asset details.</p>
        
        <!-- Display the QR code as an SVG -->
        <div>{!! $qrCode !!}</div>

        <!-- Download link for the QR code -->
        <a href="data:image/svg+xml;base64,{{ base64_encode($qrCode) }}" download="{{ $asset->asset_name }}-{{ $asset->serial_number }}-qr-code.svg" class="btn btn-primary mt-3">Download QR Code</a>
    </div>
</x-app-web-layout>
