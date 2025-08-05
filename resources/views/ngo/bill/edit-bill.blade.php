@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="d-flex justify-content-between align-items-center mb-1 mt-2">
            <h5 class="mb-0">Edit Bill/Voucher</h5>
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
            <form method="POST" action="{{ route('update-bill', $bill->id) }}">
                @csrf
                <!-- Category Dropdown -->
                <div class="mb-3">
                    <label class="form-label">Project / Work Category <span class="text-danger">*</span></label>
                    <select name="work_category" id="work_category" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" {{ $bill->work_category === $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Work Name Dropdown -->
                <div class=" mb-3">
                    <label class="form-label">Project / Work Name <span class="text-danger">*</span></label>
                    <select name="work_name" id="work_name" class="form-control" required>
                        <option value="">Select Work Name</option>
                    </select>
                </div>
                <!-- BILL INFO -->
                <div class="mb-3">
                    <label for="bill_no">Bill/Voucher/Invoice No:</label>
                    <input type="text" id="bill_no" name="bill_no" class="form-control"
                        value="{{ old('bill_no', $bill->bill_no) }}" required>
                </div>

                <div class="mb-3">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" class="form-control"
                        value="{{ old('date', $bill->date) }}" required>
                </div>

                <!-- SELLER DETAILS -->
                <h5 class="mt-4">- SELLER DETAILS</h5>

                <div class="mb-3">
                    <label for="shop">Shop/Farm:</label>
                    <input type="text" id="shop" name="shop" class="form-control"
                        value="{{ old('shop', $bill->shop) }}" required>
                </div>

                <div class="mb-3">
                    <label for="role">Seller Type:</label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="">Select Role</option>
                        <option value="Proprietor" {{ old('role', $bill->role) == 'Proprietor' ? 'selected' : '' }}>
                            Proprietor</option>
                        <option value="Owner" {{ old('role', $bill->role) == 'Owner' ? 'selected' : '' }}>Owner</option>
                        <option value="Partner" {{ old('role', $bill->role) == 'Partner' ? 'selected' : '' }}>Partner
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="s_name">Name:</label>
                    <input type="text" id="s_name" name="s_name" class="form-control"
                        value="{{ old('s_name', $bill->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="s_address">Address:</label>
                    <input type="text" id="s_address" name="s_address" class="form-control"
                        value="{{ old('s_address', $bill->address) }}" required>
                </div>

                <div class="mb-3">
                    <label for="s_mobile">Mobile:</label>
                    <input type="text" id="s_mobile" name="s_mobile" class="form-control"
                        value="{{ old('s_mobile', $bill->mobile) }}" required>
                </div>

                <div class="mb-3">
                    <label for="s_email">Email:</label>
                    <input type="text" id="s_email" name="s_email" class="form-control"
                        value="{{ old('s_email', $bill->email) }}" required>
                </div>

                <!-- GST -->
                {{-- <div class="mb-3">
                    <label for="gst_type">GST Applicable?</label>
                    <select id="gst_type" name="gst_type" class="form-select" onchange="toggleGstInput()">
                        <option value="">Select</option>
                        <option value="Yes" {{ old('gst_type', $bill->gst_type) == 'Yes' ? 'selected' : '' }}>Yes
                        </option>
                        <option value="No" {{ old('gst_type', $bill->gst_type) == 'No' ? 'selected' : '' }}>No</option>
                    </select>
                </div> --}}

                <div id="gst_input_wrapper" class="mb-3">
                    <label for="gst">GST Percentage</label>
                    <input type="number" name="gst" id="gst" class="form-control"
                        value="{{ old('gst', $bill->gst ?? 0) }}">
                </div>

                <div id="pancard_input_wrapper" class=" mb-3">
                    <label for="pancard">PAN Card Number:</label>
                    <input type="text" name="s_pan" id="pancard" class="form-control"
                        value="{{ old('pancard', $bill->s_pan ?? 0) }}">
                </div>

                <!-- BUYER DETAILS -->
                <h5 class="mt-4">- BUYER DETAILS</h5>

                <div class="mb-3">
                    <label for="b_name">Name:</label>
                    <input type="text" id="b_name" name="b_name" class="form-control"
                        value="{{ old('b_name', $bill->b_name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="b_mobile">Mobile:</label>
                    <input type="text" id="b_mobile" name="b_mobile" class="form-control"
                        value="{{ old('b_mobile', $bill->b_mobile) }}" required>
                </div>

                <div class="mb-3">
                    <label for="b_email">Email:</label>
                    <input type="text" id="b_email" name="b_email" class="form-control"
                        value="{{ old('b_email', $bill->b_email) }}" required>
                </div>

                <div class="mb-3">
                    <label for="b_address">Address:</label>
                    <input type="text" id="b_address" name="b_address" class="form-control"
                        value="{{ old('b_address', $bill->b_address) }}" required>
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
                    <tbody>
                        @foreach ($bill_items as $i => $item)
                            <tr>
                                <td class="sr-no">{{ $i + 1 }}</td>
                                <td><input type="text" name="items[{{ $i }}][product]"
                                        class="form-control" value="{{ $item->product }}" required></td>
                                <td><input type="number" name="items[{{ $i }}][qty]"
                                        class="form-control text-end qty" step="1" value="{{ $item->qty }}"
                                        onchange="updateAmount(this)"></td>
                                <td><input type="number" name="items[{{ $i }}][rate]"
                                        class="form-control text-end rate" step="0.01" value="{{ $item->rate }}"
                                        onchange="updateAmount(this)"></td>
                                <td class="text-end amount">{{ number_format($item->qty * $item->rate, 2) }}</td>
                                <td><button type="button" class="btn btn-danger btn-sm"
                                        onclick="removeRow(this)">X</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Amount Before Tax -->
                <div class="text-end mb-3">
                    <strong>Total Amount Before Tax: ₹<span id="total-amount">0.00</span></strong>
                </div>

                <!-- Tax Inputs -->
                <div class="row mb-3">
                    <div class="col-md-2">
                        <label for="cgst">CGST (%)</label>
                        <input type="number" id="cgst" name="cgst" class="form-control"
                            value="{{ old('cgst', $bill->cgst ?? 0) }}" onchange="updateTotal()">
                    </div>
                    <div class="col-md-2">
                        <label for="sgst">SGST (%)</label>
                        <input type="number" id="sgst" name="sgst" class="form-control"
                            value="{{ old('sgst', $bill->sgst ?? 0) }}" onchange="updateTotal()">
                    </div>
                    <div class="col-md-2">
                        <label for="igst">IGST (%)</label>
                        <input type="number" id="igst" name="igst" class="form-control"
                            value="{{ old('igst', $bill->igst ?? 0) }}" onchange="updateTotal()" readonly>
                    </div>
                </div>

                <!-- Tax Amounts & Grand Total -->
                <div class="text-end mb-2">
                    <strong>CGST Amount: ₹<span id="cgst-amount">0.00</span></strong><br>
                    <strong>SGST Amount: ₹<span id="sgst-amount">0.00</span></strong><br>
                    <strong>IGST Amount: ₹<span id="igst-amount">0.00</span></strong><br>
                    <hr>
                    <strong>Grand Total (After Tax): ₹<span id="grand-total">0.00</span></strong>
                </div>


                <button type="submit" class="btn btn-primary">Update Voucher</button>
            </form>
        </div>

        <script>
            let index = {{ count($bill_items) }};

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
                let baseAmount = 0;

                // Sum all item amounts
                document.querySelectorAll('#items-table .amount').forEach(cell => {
                    baseAmount += parseFloat(cell.textContent) || 0;
                });

                // Update total-amount before tax
                document.getElementById('total-amount').innerText = baseAmount.toFixed(2);

                // Get GST rates
                const cgstRate = parseFloat(document.getElementById('cgst').value) || 0;
                const sgstRate = parseFloat(document.getElementById('sgst').value) || 0;
                const igstRate = parseFloat(document.getElementById('igst').value) || 0;

                // Calculate tax amounts
                const cgstAmount = (baseAmount * cgstRate) / 100;
                const sgstAmount = (baseAmount * sgstRate) / 100;
                const igstAmount = (baseAmount * igstRate) / 100;

                // Calculate grand total
                const Totaligst = cgstPercent + sgstPercent;
                const grandTotal = total + cgstAmount + sgstAmount;
                const TotaligstAmount = cgstAmount + sgstAmount;

                // Update DOM
                document.getElementById('total-amount').textContent = total.toFixed(2);
                document.getElementById('cgst-amount').textContent = cgstAmount.toFixed(2);
                document.getElementById('sgst-amount').textContent = sgstAmount.toFixed(2);
                document.getElementById('igst-amount').textContent = TotaligstAmount.toFixed(2);
                document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
                document.getElementById('igst').value = Totaligst.toFixed(2);
            }


            // Trigger once in case of old values
            updateTotal();

            function removeRow(btn) {
                btn.closest('tr').remove();
                updateSrNo();
                updateTotal();
            }

            // Initial total calculation
            updateTotal();
        </script>
        <script>
            const allProjects = @json($allProjects);
            const selectedCategory = @json($bill->work_category);
            const selectedProject = @json($bill->work_name);

            const workCategorySelect = document.getElementById('work_category');
            const workNameSelect = document.getElementById('work_name');

            function populateWorkNames(category, selectedName = null) {
                // Clear current options
                workNameSelect.innerHTML = '<option value="">Select Work Name</option>';

                // Filter and populate
                const filtered = allProjects.filter(p => p.category === category);
                filtered.forEach(project => {
                    const option = document.createElement('option');
                    option.value = project.name;
                    option.text = project.name;
                    if (project.name === selectedName) {
                        option.selected = true;
                    }
                    workNameSelect.appendChild(option);
                });
            }

            // Initial load
            if (selectedCategory) {
                populateWorkNames(selectedCategory, selectedProject);
            }

            // On change
            workCategorySelect.addEventListener('change', function() {
                populateWorkNames(this.value);
            });
        </script>
    @endsection
