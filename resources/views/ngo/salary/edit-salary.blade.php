@extends('ngo.layout.master')
@section('content')
    <style>
        /* ::placeholder {
                                                                font-size: 8px;
                                                            } */

        .upload-container {
            text-align: center;
            margin-top: 15px;
            padding: 10px 20px;
            margin-left: 50px;
        }

        .image-placeholder {
            width: 150px;
            height: 150px;
            /* border: 2px dashed #ccc; */
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            background-color: rgb(223, 226, 228);
        }

        .image-placeholder img {
            max-width: 100%;
            max-height: 100%;
            display: none;
        }

        .upload-btn {
            display: inline-block;
            background-color: #343a40;
            color: #fff;
            padding: 10px 15px;
            margin-right: 100px;
            font-size: 16px;
            width: auto;
            border-radius: 5px;
            cursor: pointer;
            border: none;
        }

        .upload-btn:hover {
            background-color: #495057;
        }

        #uploadInput {
            display: none;
        }
    </style>
    <div class="wrapper">
        <div class="d-flex justify-content-between aligin-item-center mb-3 mt-2">
            <h5 class="mb-0">Edit Staff Sallary</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Sallary</li>
                </ol>
            </nav>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container mt-5">
            <form action="{{ route('update.salary',$salary->id) }}" method="POST" enctype="multipart/form-data"
                class="border p-4 bg-light rounded">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="position" class="form-label">Position <span class="text-danger">*</span></label>
                                <select name="position" id="position"
                                    class="form-control @error('position') is-invalid @enderror" required>
                                    <option value="">Select Position</option>
                                    @foreach (['Director', 'Consultant/Adviser', 'NGO Manager', 'Finance Manager', 'Project Coordinator', 'Master Trainer', 'Trainer', 'Program Officer', 'Project Manager', 'Area Manager', 'Human Resource Management', 'Supervisor', 'Coordinator', 'Computer Operator', 'Head Clerk', 'Assistant Clerk', 'Surveyor', 'Peon', 'Guard', 'Driver', 'Gardener', 'सुबिधा दाता', 'कृषि सखी', 'समूह सखी', 'विकास सखी', 'पशु सखी', 'सवास्थ्य सखी', 'सहयोगी सखी', 'Animator', 'Volunteer'] as $role)
                                        <option value="{{ $role }}"
                                            {{ old('position',$salary->position) == $role ? 'selected' : '' }}>
                                            {{ $role }}</option>
                                    @endforeach
                                </select>
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Sallary</label>
                                <input type="number" name="salary"
                                    class="form-control @error('salary') is in-valid @enderror" placeholder="Enter Salary"
                                    value="{{ old('salary',$salary->salary) }}" required>
                                @error('salary')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-12">
                                <input type="submit" class="btn btn-success" value="Update Sallary">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
