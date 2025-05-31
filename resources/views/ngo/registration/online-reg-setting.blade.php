@extends('ngo.layout.master')
@section('content')
<div class="wrapper">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3 m-2">
            <h5 class="mb-0">Online Registration Setting</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Registration Setting</li>
                </ol>
            </nav>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Professional Card -->
        <div class="card shadow-sm p-4 rounded bg-white">
            <h6 class="mb-3">Online Registraion Status: 
            </h6>

            <form method="POST" action="{{ route('registration.toggle') }}">
                @csrf
                <div class="toggle-container">
                    <label class="switch">
                        <input type="checkbox" name="registration_enabled" onchange="this.form.submit()" {{ $enabled ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                    <span class="ml-3 font-weight-bold">{{ $enabled ? 'Enabled' : 'Disabled' }}</span>
                </div>

                <span class="badge {{ $enabled ? 'badge-success' : 'badge-secondary' }} mt-3">
                    {{ $enabled ? 'Online Registration is ON' : 'Online Registration is OFF' }}
                </span>
            </form>
        </div>
    </div>
</div>

<!-- CSS for Toggle & Card -->
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        display: none;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0;
        right: 0; bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px; width: 26px;
        left: 4px; bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #28a745;
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }

    .toggle-container {
        display: flex;
        align-items: center;
    }

    .card {
        max-width: 500px;
        margin: auto;
    }

    .badge-success {
        background-color: #28a745;
    }

    .badge-secondary {
        background-color: #6c757d;
    }
</style>
@endsection
