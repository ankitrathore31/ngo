@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="d-flex justify-content-between align-items-center mb-1 mt-2">
            <h5 class="mb-0">Edit Sanstha Bill</h5>
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
            <form method="POST" action="{{ route('update-gbs-gbs', $gbsBill->id) }}">
                @csrf
                @method('POST') {{-- or PUT if you change your route to use PUT --}}
                <div class="row mt-3">
                    <!-- Category Dropdown -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Project / Work Category <span class="text-danger">*</span></label>
                        <select name="work_category" id="work_category" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category }}"
                                    {{ isset($gbsBill) && $gbsBill->work_category === $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Work Name Dropdown -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Project / Work Name <span class="text-danger">*</span></label>
                        <select name="work_name" id="work_name" class="form-control" required>
                            <option value="">Select Work Name</option>
                            <!-- Options will be populated by JS based on selected category -->
                        </select>
                    </div>

                    <div class="col-sm-4 mb-3">
                        <label for="bill_no">Bill/Voucher No:</label>
                        <input type="text" id="bill_no" name="bill_no" class="form-control"
                            value="{{ old('bill_no', $gbsBill->bill_no) }}" required>
                        @error('bill_no')
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
                                    {{ old('academic_session', $gbsBill->academic_session) == $session->session_date ? 'selected' : '' }}>
                                    {{ $session->session_date }}
                                </option>
                            @endforeach
                        </select>
                        @error('academic_session')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class=" col-sm-4 mb-3">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date" class="form-control"
                            value="{{ old('date', $gbsBill->date) }}" required>
                        @error('date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="mb-3">
                            <label for="shop">Shop:</label>
                            <input type="text" id="shop" name="shop" class="form-control"
                                value="{{ old('shop', $gbsBill->shop) }}" required>
                            @error('shop')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ old('name', $gbsBill->name) }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="mobile">Mobile:</label>
                            <input type="text" id="mobile" name="mobile" class="form-control"
                                value="{{ old('mobile', $gbsBill->mobile) }}" required>
                            @error('mobile')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email">Email:</label>
                            <input type="text" id="email" name="email" class="form-control"
                                value="{{ old('email', $gbsBill->email) }}" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address">Address:</label>
                            <input type="text" id="address" name="address" class="form-control"
                                value="{{ old('address', $gbsBill->address) }}" required>
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class=" form-group mb-3">
                            <label for="block" class="form-label">Block: <span class="text-danger">*</span></label>
                            <input type="text" name="block" id="block"
                                class="form-control @error('block') is-invalid @enderror"
                                value="{{ old('block', $gbsBill->block) }}" required>
                            @error('block')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        @php
                            $districtsByState = config('districts');
                        @endphp
                        <div class=" form-group mb-3">
                            <label for="stateSelect" class="form-label">State: <span class="text-danger">*</span></label>
                            <select class="form-control @error('state') is-invalid @enderror" name="state"
                                id="stateSelect" required>
                                <option value="">Select State</option>
                                @foreach ($districtsByState as $state => $districts)
                                    <option value="{{ $state }}"
                                        {{ old('state', $gbsBill->state) == $state ? 'selected' : '' }}>
                                        {{ $state }}
                                    </option>
                                @endforeach
                            </select>
                            @error('state')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class=" form-group mb-3">
                            <label for="districtSelect" class="form-label">District: <span
                                    class="text-danger">*</span></label>
                            <select class="form-control @error('district') is-invalid @enderror" name="district"
                                id="districtSelect" required>
                                <option value="{{ $gbsBill->district }}">{{ $gbsBill->district }}</option>
                            </select>
                            @error('district')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
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
                        <input type="number" id="cgst" name="cgst" class="form-control"
                            value="{{ old('cgst', $gbsBill->cgst) }}" onchange="updateTotal()">
                    </div>
                    <div class="col-md-2">
                        <label for="sgst">SGST (%)</label>
                        <input type="number" id="sgst" name="sgst" class="form-control"
                            value="{{ old('sgst', $gbsBill->sgst) }}" onchange="updateTotal()">
                    </div>
                    <div class="col-md-2">
                        <label for="igst">IGST (%)</label>
                        <input type="number" id="igst" class="form-control" value="0" readonly>
                    </div>
                </div>

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
            let index = 0;

            function addRow(product = '', qty = 0, rate = 0) {
                const tbody = document.querySelector("#items-table tbody");
                const row = document.createElement("tr");

                const amount = parseFloat(qty) * parseFloat(rate);

                row.innerHTML = `
        <td class="sr-no">${index + 1}</td>
        <td><input type="text" name="items[${index}][product]" class="form-control" value="${product}" required></td>
<td>
    <div class="d-flex gap-1">
        <input type="number"
               name="items[${index}][qty]"
               class="form-control text-end qty"
               step="0.01"
               value="0"
               onchange="updateAmount(this)">

        <select name="items[${index}][unit]" class="form-select form-select-sm"">
            <option value="Nos">Nos</option>
            <option value="Kg">Kg</option>
            <option value="Gram">Gram</option>
            <option value="Litre">Litre</option>
            <option value="ML">ML</option>
            <option value="Meter">Meter</option>
            <option value="Feet">Feet</option>
            <option value="Box">Box</option>
            <option value="Pack">Pack</option>
            <option value="Piece">Piece</option>
        </select>
    </div>
</td>        <td><input type="number" name="items[${index}][rate]" class="form-control text-end rate" step="0.01" value="${rate}" onchange="updateAmount(this)"></td>
        <td class="text-end amount">${amount.toFixed(2)}</td>
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

                // Get CGST and SGST percentage values
                const cgstPercent = parseFloat(document.getElementById('cgst').value) || 0;
                const sgstPercent = parseFloat(document.getElementById('sgst').value) || 0;

                // IGST is the sum of CGST and SGST
                const igstPercent = cgstPercent + sgstPercent;
                document.getElementById('igst').value = igstPercent.toFixed(2);

                // Calculate GST amounts
                const cgstAmount = (total * cgstPercent) / 100;
                const sgstAmount = (total * sgstPercent) / 100;
                const igstAmount = cgstAmount + sgstAmount;

                // Calculate grand total
                const grandTotal = total + igstAmount;

                // Update DOM
                document.getElementById('total-amount').textContent = total.toFixed(2);
                document.getElementById('cgst-amount').textContent = cgstAmount.toFixed(2);
                document.getElementById('sgst-amount').textContent = sgstAmount.toFixed(2);
                document.getElementById('igst-amount').textContent = igstAmount.toFixed(2);
                document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
            }

            function removeRow(btn) {
                btn.closest('tr').remove();
                updateSrNo();
                updateTotal();
            }

            document.addEventListener("DOMContentLoaded", function() {
                // Load existing items
                @if (isset($gbsBill->items) && count($gbsBill->items) > 0)
                    @foreach ($gbsBill->items as $item)
                        addRow("{{ $item->product }}", "{{ $item->qty }}", "{{ $item->rate }}");
                    @endforeach
                @endif

                updateTotal();
            });
        </script>
        <script>
            const allDistricts = @json($districtsByState);

            // Use old values if they exist, otherwise fallback to $beneficiarie
            const oldState = "{{ old('state', $gbsBill->state) }}";
            const oldDistrict = "{{ old('district', $gbsBill->district) }}";

            function populateDistricts(state) {
                const districtSelect = document.getElementById('districtSelect');
                districtSelect.innerHTML = '<option value="">Select District</option>';

                if (allDistricts[state]) {
                    allDistricts[state].forEach(function(district) {
                        const selected = (district === oldDistrict) ? 'selected' : '';
                        districtSelect.innerHTML += `<option value="${district}" ${selected}>${district}</option>`;
                    });
                }
            }

            // Initial load
            if (oldState) {
                populateDistricts(oldState);
            }

            // On state change
            document.getElementById('stateSelect').addEventListener('change', function() {
                populateDistricts(this.value);
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const allProjects = @json($allProjects);
                const selectedCategory = @json($gbsBill->work_category ?? '');
                const selectedWorkName = @json($gbsBill->work_name ?? '');

                const categorySelect = document.getElementById('work_category');
                const workNameSelect = document.getElementById('work_name');

                function populateWorkNames(category) {
                    // Clear existing options
                    workNameSelect.innerHTML = '<option value="">Select Work Name</option>';

                    // Filter by category
                    const filteredProjects = allProjects.filter(project => project.category === category);

                    filteredProjects.forEach(project => {
                        const option = document.createElement('option');
                        option.value = project.name;
                        option.text = project.name;

                        if (project.name === selectedWorkName) {
                            option.selected = true;
                        }

                        workNameSelect.appendChild(option);
                    });
                }

                // If editing, pre-populate work name dropdown
                if (selectedCategory) {
                    populateWorkNames(selectedCategory);
                }

                // When user changes category
                categorySelect.addEventListener('change', function() {
                    populateWorkNames(this.value);
                });
            });
        </script>
    @endsection
