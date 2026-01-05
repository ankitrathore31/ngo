@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="d-flex justify-content-between align-record-centre mb-0 mt-4">
            <h5 class="mb-0">Add disease</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-record"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-record active" aria-current="page">Health Card</li>
                </ol>
            </nav>
        </div>
        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container mt-3">
            <div class="card shadow-sm p-3">

                <form action="{{ route('store.disease') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Health Facility / Disease Name</label>
                            <input type="text" name="disease" class="form-control @error('disease') is-invalid @enderror"
                                value="{{ old('disease') }}">
                            @error('disease')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-3 mt-4">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </form>

                <hr>

                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Disease Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($diseases as $key => $disease)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $disease->disease }}</td>
                                <td>
                                    <a href="{{ route('delete.disease', $disease->id) }}"
                                                onclick="return confirm('Are sure want to delete disease')"
                                                class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No data found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>

    </div>
@endsection
