@extends('ngo.layout.master')
@section('content')
<div class="container my-5">
    <div class="card p-4">
        <form action="{{ $ngo ? route('profile.update', $ngo->id) : route('profile.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $ngo->title ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label>Sub Title</label>
                <input type="text" name="sub_title" class="form-control" value="{{ old('sub_title', $ngo->sub_title ?? '') }}">
            </div>

            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $ngo->phone ?? '') }}">
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $ngo->email ?? '') }}">
            </div>

            <div class="mb-3">
                <label>Address</label>
                <textarea name="address" class="form-control">{{ old('address', $ngo->address ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label>Website</label>
                <input type="url" name="website" class="form-control" value="{{ old('website', $ngo->website ?? '') }}">
            </div>

            <div class="mb-3">
                <label>Logo</label>
                <input type="file" name="logo" class="form-control">
                @if(!empty($ngo->logo))
                    <img src="{{ asset($ngo->logo) }}" alt="Logo" height="80" class="mt-2">
                @endif
            </div>

            <button class="btn btn-success">{{ $ngo ? 'Update' : 'Save' }}</button>
        </form>
    </div>
</div>
@endsection
