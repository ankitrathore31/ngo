@extends('admin.layout.AdminLayout')
@section('content')

    <div class="main-wrapper">

        <div class="page-wrapper">
            <div class="content container-fluid">

                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Add Session</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{-- route('home') --}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Add Session</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('save-session') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="form-title"><span>Session Information</span></h5>
                                        </div>
                                        {{-- <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Subject ID <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Subject Name <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div> --}}
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Session Date <span class="login-danger">*</span></label>
                                                <input type="text" class="form-control @error('session') is-invalid @enderror" name="session">
                                                @error('session')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="student-submit">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@section('script')

<script>
    @if (Session::has('Success'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.success("{{ session('Success') }}");
    @endif

    @if (Session::has('Error'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.error("{{ session('Error') }}");
    @endif
</script>

@endsection

@endsection