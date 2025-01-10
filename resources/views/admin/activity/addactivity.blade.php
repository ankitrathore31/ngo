@extends('admin.layout.AdminLayout')
@Section('content')
    <div class="container mt-5">
        <div class="row card m-2">
            <div class="col m-3 d-flex justify-content-center">
                <h3><u><b>ADD ACTIVITY</b></u></h3>
            </div>
        </div>
        <form action="{{ route ('saveactivity') }}" method="POST" enctype="multipart/form-data" class="mt-4">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="programName">Program Name</label>
                    <input type="text" class="form-control" id="programName" name="programName" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="programCategory">Program Category</label>
                    <select class="form-control" id="programCategory" name="programCategory" required>
                        <option value="">Select Category</option>
                        <option value="Education">Public Program</option>
                        <option value="Entertainment">Goverment Program</option>
                       
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="programDate">Program Date</label>
                    <input type="date" class="form-control" id="programDate" name="programDate" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="programTime">Program Time</label>
                    <input type="time" class="form-control" id="programTime" name="programTime" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="programAddress">Program Address</label>
                    <textarea class="form-control" id="programAddress" name="programAddress" rows="3" required></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="programImage">Program Image</label>
                    <input type="file" class="form-control-file" id="programImage" name="programImage" required>
                </div>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
