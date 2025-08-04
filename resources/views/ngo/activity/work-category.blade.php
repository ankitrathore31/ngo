@extends('ngo.layout.master')
@Section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Add Category</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ route('category.list') }}">Category List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Work Category</li>
                </ol>
            </nav>
        </div>
        <div class="card m-1">
            <div class="card-body">
                <form action="{{ route('store.category') }}" method="POST" enctype="multipart/form-data" class="m-3">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3 form-group local-from">
                            <label class="form-label">Program/Work Category <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('category') is-invalid @enderror"
                                name="category" placeholder="Category Name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-success"> + Add</button>
                        </div>

                </form>
            </div>
        </div>
    </div>
@endsection
