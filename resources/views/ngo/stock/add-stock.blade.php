@extends('ngo.layout.master')
@section('content')
<div class="container mt-4">
    <h5 class="mb-3">Add Stock</h5>
    <div class="card p-4 shadow bg-light">
        <form action="{{ route('add-stocks.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Stock Date</label>
                    <input type="date" name="stock_date" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Stock Name</label>
                    <input type="text" name="stock_name" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Quantity</label>
                    <input type="number" name="stock_quantity" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Place</label>
                    <input type="text" name="stock_place" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Officer Name</label>
                    <input type="text" name="officer_name" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Officer Position</label>
                    <input type="text" name="officer_position" class="form-control" required>
                </div>
            </div>
            <button class="btn btn-success">Save</button>
        </form>
    </div>
</div>
@endsection
 