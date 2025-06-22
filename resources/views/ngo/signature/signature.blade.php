@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="d-flex justify-content-between align-record-centre mb-2 mt-3">
            <h5 class="mb-0">Signature</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-record"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-record active" aria-current="page">Donation</li>
                </ol>
            </nav>
        </div>
        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container mt-4">
            <form action="{{ route('signatures.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label>Program Manager Signature:</label>
                <input type="file" name="signature_pm" accept="image/*"><br>

                <label>Director Signature:</label>
                <input type="file" name="signature_director" accept="image/*"><br>

                <button type="submit">Save Signatures</button>
            </form>

        </div>
    </div>
@endsection
