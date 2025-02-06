{{-- @extends('layouts.app')

@section('title', 'Asset QR Code Details')

@section('content')
    <x-slot name="title">
        {{ $asset->asset_name }} QR Code
    </x-slot>

    <div class="container mt-5">
        <h4>{{ $asset->asset_name }} - ({{ $asset->serial_number }}) QR Code</h4>
        <p>Scan the QR code below to view asset details.</p>
        
        <!-- Display the QR code as an SVG -->
        <div>{!! $qrCode !!}</div>

        <!-- Download link for the QR code -->
        <a href="data:image/svg+xml;base64,{{ base64_encode($qrCode) }}" download="{{ $asset->asset_name }}-{{ $asset->serial_number }}-qr-code.svg" class="btn btn-primary mt-3">Download QR Code</a>
    </div>
@endsection --}}

@extends('layouts.app')

@section('title', 'QR Code')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-body p-5">
            <div class="text-center">
                <h2 class="mb-4 text-primary font-weight-bold">Asset QR Code</h2>
                
                <!-- Asset Information -->
                <div class="mb-4">
                    <h3 class="h4 text-dark">{{ $asset->asset_name }}</h3>
                    <p class="text-muted mb-4">Serial Number: {{ $asset->serial_number }}</p>
                </div>

                <!-- QR Code Display -->
                <div class="qr-code-container mb-4">
                    <img src="{{ $encodedImage }}" alt="QR Code" class="img-fluid" style="max-width: 400px;">
                </div>

                <!-- Download Button -->
                <div class="mt-4">
                    <a href="{{ route('assets.qr-code.download', $asset->id) }}" 
                       class="btn btn-primary btn-lg shadow-sm">
                        <i class="fas fa-download me-2"></i>Download QR Code
                    </a>
                </div>

                <!-- Scanning Instructions -->
                <div class="mt-4 text-muted">
                    <p><i class="fas fa-info-circle me-2"></i>Scan this QR code to view complete asset details</p>
                    <a href="{{ route('assets.index') }}" class="btn btn-primary float-end">Back</a>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
.qr-code-container {
    background: white;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: inline-block;
    margin: 0 auto;
}

.card {
    border: none;
    border-radius: 1rem;
    background: linear-gradient(to bottom, #ffffff, #f8f9fa);
}

.text-primary {
    color: #003399 !important;
}
</style>
@endsection