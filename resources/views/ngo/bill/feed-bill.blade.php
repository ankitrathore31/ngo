@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="d-flex justify-content-between align-items-center mb-1 mt-2">
            <h5 class="mb-0">Add Bill/Voucher</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-1 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Bill/Voucher</li>
                </ol>
            </nav>
        </div>

        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container mt-3">
            <form method="POST" action="{{ route('store-bill') }}">
                @csrf
                <div class="row">
                    <div class="col-sm-4 mb-3">
                        <label for="bill_no">Bill/Voucher No:</label>
                        <input type="text" id="bill_no" name="bill_no" class="form-control"
                            value="{{ old('bill_no') }}" required>
                        @error('bill_no')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-sm-4 mb-3">
                        <label for="invoice">Invoice:</label>
                        <input type="text" id="invoice" name="invoice" class="form-control"
                            value="{{ old('invoice') }}" required>
                        @error('invoice')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class=" col-sm-4 mb-3">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date" class="form-control" value="{{ old('date') }}"
                            required>
                        @error('date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <h5 class="mb-2">- SELLER DEATILS</h5>
                    <div class=" col-sm-4 mb-3">
                        <label for="shop">Shop:</label>
                        <input type="text" id="shop" name="shop" class="form-control" value="{{ old('shop') }}"
                            required>
                        @error('shop')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class=" col-sm-4 mb-3">
                        <label for="role" class="label">Seller Type</label>
                        <select name="role" id="role" class="form-select @error('role') is-invalid @enderror">
                            <option value="">Select Role</option>
                            <option value="Proprietor" {{ old('role') == 'Proprietor' ? 'selected' : '' }}>Proprietor
                            </option>
                            <option value="Owner" {{ old('role') == 'Owner' ? 'selected' : '' }}>Owner</option>
                            <option value="Partner" {{ old('role') == 'Partner' ? 'selected' : '' }}>Partner</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class=" col-sm-4 mb-3">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" class="form-control"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class=" col-sm-4 mb-3">
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" class="form-control"
                            value="{{ old('address') }}" required>
                        @error('address')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class=" col-sm-4 mb-3">
                        <label for="mobile">Mobile:</label>
                        <input type="text" id="mobile" name="mobile" class="form-control"
                            value="{{ old('mobile') }}" required>
                        @error('mobile')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class=" col-sm-4 mb-3">
                        <label for="email">Email:</label>
                        <input type="text" id="email" name="email" class="form-control"
                            value="{{ old('email') }}" required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class=" col-sm-4 mb-3">
                        <label for="gst">Gst:</label>
                        <select  id="gst" class="form-select @error('gst') is-invalid @enderror">
                            <option value="">Select </option>
                            <option value="Yes" {{ old('gst') == 'Yes' ? 'selected' : '' }}>Yes
                            </option>
                            <option value="Yes" {{ old('gst') == 'No' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                </div>

                <div class="row">
                    <h5 class="mb-2">- BUYER DETAILS</h5>
                    <div class=" col-sm-4 mb-3">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" class="form-control"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class=" col-sm-4 mb-3">
                        <label for="mobile">Mobile:</label>
                        <input type="text" id="mobile" name="mobile" class="form-control"
                            value="{{ old('mobile') }}" required>
                        @error('mobile')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class=" col-sm-4 mb-3">
                        <label for="email">Email:</label>
                        <input type="text" id="email" name="email" class="form-control"
                            value="{{ old('email') }}" required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class=" col-sm-4 mb-3">
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" class="form-control"
                            value="{{ old('address') }}" required>
                        @error('address')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>


                <table class="table table-bordered" id="items-table">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Product</th>
                            <th class="text-end">Qty</th>
                            <th class="text-end">Rate</th>
                            <th class="text-end">Amount</th>
                            <th>
                                <button type="button" class="btn btn-success btn-sm" onclick="addRow()">Add</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <div class="text-end mb-3">
                    <strong>Total: ₹<span id="total-amount">0.00</span></strong>
                </div>

                <button type="submit" class="btn btn-primary">Save Voucher</button>
            </form>
        </div>

    </div>
    <script>
        let index = 0;

        function addRow() {
            const tbody = document.querySelector("#items-table tbody");
            const row = document.createElement("tr");

            row.innerHTML = `
        <td class="sr-no">${index + 1}</td>
        <td><input type="text" name="items[${index}][product]" class="form-control" required></td>
        <td><input type="number" name="items[${index}][qty]" class="form-control text-end qty" step="1" value="0" onchange="updateAmount(this)"></td>
        <td><input type="number" name="items[${index}][rate]" class="form-control text-end rate" step="0.01" value="0.00" onchange="updateAmount(this)"></td>
        <td class="text-end amount">0.00</td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button></td>
    `;

            tbody.appendChild(row);
            index++;
            updateSrNo();
            updateTotal();
        }

        function updateSrNo() {
            document.querySelectorAll('#items-table tbody tr').forEach((row, i) => {
                row.querySelector('.sr-no').textContent = i + 1;
            });
        }

        function updateAmount(el) {
            const row = el.closest('tr');
            const qty = parseFloat(row.querySelector('.qty').value) || 0;
            const rate = parseFloat(row.querySelector('.rate').value) || 0;
            const amount = qty * rate;

            row.querySelector('.amount').textContent = amount.toFixed(2);
            updateTotal();
        }

        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.amount').forEach(cell => {
                total += parseFloat(cell.textContent);
            });
            document.getElementById('total-amount').textContent = total.toFixed(2);
        }

        function removeRow(btn) {
            btn.closest('tr').remove();
            updateSrNo();
            updateTotal();
        }
    </script>
    <script>
        const gst = getElementById = 'gst';
        if(gst){

        }
    </script>
@endsection
