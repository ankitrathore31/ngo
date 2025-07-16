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
                    <div class="col-md-4 mb-3">
                        <label for="bill_no">Bill/Voucher/Invoice No:</label>
                        <input type="text" id="bill_no" name="bill_no" class="form-control"
                            value="{{ old('bill_no') }}" required>
                        @error('bill_no')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class=" col-md-4 mb-3">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date" class="form-control" value="{{ old('date') }}"
                            required>
                        @error('date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="academic_session" class=" bold">Session <span class="login-danger">*</span></label>
                        <select class="form-control @error('academic_session') is-invalid @enderror" name="academic_session"
                            id="academic_session" required>
                            <option value="">Select Session</option>
                            @foreach ($data as $session)
                                <option value="{{ $session->session_date }}"
                                    {{ old('academic_session') == $session->session_date ? 'selected' : '' }}>
                                    {{ $session->session_date }}
                                </option>
                            @endforeach
                        </select>
                        @error('academic_session')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="row">
                    <h5 class="mb-2">- SELLER DEATILS</h5>
                    <div class=" col-sm-4 mb-3">
                        <label for="shop">Shop:</label>
                        <input type="text" id="shop" name="shop" class="form-control"
                            value="{{ old('shop') }}" required>
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
                        <input type="text" id="s_name" name="s_name" class="form-control"
                            value="{{ old('s_name') }}" required>
                        @error('s_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class=" col-sm-4 mb-3">
                        <label for="address">Address:</label>
                        <input type="text" id="s_address" name="s_address" class="form-control"
                            value="{{ old('s_address') }}" required>
                        @error('s_address')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class=" col-sm-4 mb-3">
                        <label for="mobile">Mobile:</label>
                        <input type="text" id="s_mobile" name="s_mobile" class="form-control"
                            value="{{ old('s_mobile') }}" required>
                        @error('s_mobile')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class=" col-sm-4 mb-3">
                        <label for="email">Email:</label>
                        <input type="text" id="s_email" name="s_email" class="form-control"
                            value="{{ old('s_email') }}" required>
                        @error('s_email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-sm-4 mb-3">
                        <label for="gst_type">Gst:</label>
                        <select id="gst_type" name="gst_type" class="form-select @error('gst_type') is-invalid @enderror"
                            onchange="toggleSingleGstInput()">
                            <option value="">Select</option>
                            <option value="Yes" {{ old('gst_type') == 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ old('gst_type') == 'No' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div id="gst_input_wrapper" class="col-sm-4 mb-3" style="display: none;">
                        <label for="gst">GST</label>
                        <input type="number" name="gst" id="gst" class="form-control"
                            value="{{ old('gst', 0) }}">
                    </div>

                    <div class="col-sm-4 mb-3">
                        <label for="pancard_type">PAN Card:</label>
                        <select id="pancard_type" name="pancard_type"
                            class="form-select @error('pancard_type') is-invalid @enderror" onchange="toggleGstInput()">
                            <option value="">Select</option>
                            <option value="Yes" {{ old('pancard_type') == 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ old('pancard_type') == 'No' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div id="pancard_input_wrapper" class="col-sm-4 mb-3" style="display: none;">
                        <label for="pancard">PAN Card Number:</label>
                        <input type="text" name="s_pan" id="pancard" class="form-control"
                            value="{{ old('pancard') }}">
                    </div>

                </div>

                <div class="row">
                    <h5 class="mb-2">- BUYER DETAILS</h5>
                    <div class=" col-sm-4 mb-3">
                        <label for="b_name">Name:</label>
                        <input type="text" id="b_name" name="b_name" class="form-control"
                            value="{{ old('b_name') }}" required>
                        @error('b_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class=" col-sm-4 mb-3">
                        <label for="b_mobile">Mobile:</label>
                        <input type="text" id="b_mobile" name="b_mobile" class="form-control"
                            value="{{ old('b_mobile') }}" required>
                        @error('b_mobile')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class=" col-sm-4 mb-3">
                        <label for="b_email">Email:</label>
                        <input type="text" id="b_email" name="b_email" class="form-control"
                            value="{{ old('b_email') }}" required>
                        @error('b_email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class=" col-sm-4 mb-3">
                        <label for="address">Address:</label>
                        <input type="text" id="b_address" name="b_address" class="form-control"
                            value="{{ old('b_address') }}" required>
                        @error('b_address')
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
                    <strong>Total Amount Before Tax: ₹<span id="total-amount">0.00</span></strong>
                </div>
                <div class="row mb-3">
                    <div class="col-md-2">
                        <label for="cgst">CGST (%)</label>
                        <input type="number" id="cgst" name="cgst" class="form-control" value="0"
                            onchange="updateTotal()">
                    </div>
                    <div class="col-md-2">
                        <label for="sgst">SGST (%)</label>
                        <input type="number" id="sgst" name="sgst" class="form-control" value="0"
                            onchange="updateTotal()">
                    </div>
                    <div class="col-md-2">
                        <label for="igst">IGST (%)</label>
                        <input type="number" id="igst" name="igst" class="form-control" value="0"
                            onchange="updateTotal()" readonly>
                    </div>
                </div>

                <div class="text-end mb-2">
                    <strong>CGST Amount: ₹<span id="cgst-amount">0.00</span></strong><br>
                    <strong>SGST Amount: ₹<span id="sgst-amount">0.00</span></strong><br>
                    <strong>IGST Amount: ₹<span id="igst-amount">0.00</span></strong><br>
                    <hr>
                    <strong>Grand Total (After Tax): ₹<span id="grand-total">0.00</span></strong>
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

            // Get GST percentage values
            const cgstPercent = parseFloat(document.getElementById('cgst').value) || 0;
            const sgstPercent = parseFloat(document.getElementById('sgst').value) || 0;
            const igstPercent = parseFloat(document.getElementById('igst').value) || 0;

            // Calculate GST amounts
            const cgstAmount = (total * cgstPercent) / 100;
            const sgstAmount = (total * sgstPercent) / 100;
            const igstAmount = (total * igstPercent) / 100;

            // Calculate grand total
            const Totaligst = cgstPercent + sgstPercent;
            const grandTotal = total + cgstAmount + sgstAmount;
            const TotaligstAmount =  cgstAmount + sgstAmount;

            // Update DOM
            document.getElementById('total-amount').textContent = total.toFixed(2);
            document.getElementById('cgst-amount').textContent = cgstAmount.toFixed(2);
            document.getElementById('sgst-amount').textContent = sgstAmount.toFixed(2);
            document.getElementById('igst-amount').textContent = TotaligstAmount.toFixed(2);
            document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
            document.getElementById('igst').value = Totaligst.toFixed(2);
        }


        function removeRow(btn) {
            btn.closest('tr').remove();
            updateSrNo();
            updateTotal();
        }
    </script>
    <script>
        function toggleSingleGstInput() {
            const gstType = document.getElementById('gst_type').value;
            const gstWrapper = document.getElementById('gst_input_wrapper');
            const gstInput = document.getElementById('gst');

            if (gstType === 'Yes') {
                gstWrapper.style.display = 'block';
            } else {
                gstWrapper.style.display = 'none';
                gstInput.value = 0;
            }
        }
    </script>
    <script>
        function toggleGstInput() {
            var selectBox = document.getElementById("pancard_type");
            var selectedValue = selectBox.options[selectBox.selectedIndex].value;
            var gstInputWrapper = document.getElementById("pancard_input_wrapper");

            if (selectedValue === "Yes") {
                gstInputWrapper.style.display = "block";
            } else {
                gstInputWrapper.style.display = "none";
            }
        }

        // Initial check on page load
        toggleGstInput();
    </script>
@endsection
