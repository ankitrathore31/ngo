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
        <div class="container mt-5 mb-5">
            <form id="searchForm" method="GET" action="{{ route('add-bill') }}">
                <div class="row">
                    <div class="col-md-12">
                        <label class="form-label">Search Person/Farm</label>
                        <input type="text" class="form-control" name="search" id="searchInput"
                            placeholder="Search By Shop/Farm/Seller Name" value="{{ request('search') }}">
                    </div>
                </div>
            </form>
            <!-- Show matched results if any -->
            @if (!empty($searchResults))
                <div id="searchBox">
                    <ul class="list-group mt-2">
                        @foreach ($searchResults as $item)
                            <li class="list-group-item" style="cursor: pointer;"
                                onclick="fillData({{ json_encode($item) }})">
                                {{ $item->name }} ({{ $item->shop }})
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="container-fluid mt-5 mb-5">
            <div class="card-body shadow-lg p-4">
                <form method="POST" action="{{ route('store-bill') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Category Dropdown -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Project / Work Category <span class="text-danger">*</span></label>
                            <select name="work_category" id="work_category" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Work Name Dropdown -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Project / Work Name <span class="text-danger">*</span></label>
                            <select name="work_name" id="work_name" class="form-control" required>
                                <option value="">Select Work Name</option>
                            </select>
                        </div>

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
                            <input type="date" id="date" name="date" class="form-control"
                                value="{{ old('date') }}" required>
                            @error('date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="academic_session" class=" bold">Session <span class="login-danger">*</span></label>
                            <select class="form-control @error('academic_session') is-invalid @enderror"
                                name="academic_session" id="academic_session" required>
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
                                value="{{ old('shop') }}" readonly required>
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
                                value="{{ old('s_name') }}" readonly required>
                            @error('s_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class=" col-sm-4 mb-3">
                            <label for="address">Address:</label>
                            <input type="text" id="s_address" readonly name="s_address" class="form-control"
                                value="{{ old('s_address') }}" required>
                            @error('s_address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class=" col-sm-4 mb-3">
                            <label for="mobile">Mobile:</label>
                            <input type="text" id="s_mobile" name="s_mobile" class="form-control"
                                value="{{ old('s_mobile') }}" readonly required>
                            @error('s_mobile')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class=" col-sm-4 mb-3">
                            <label for="email">Email:</label>
                            <input type="text" id="s_email" name="s_email" class="form-control"
                                value="{{ old('s_email') }}" readonly required>
                            @error('s_email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-sm-4 mb-3">
                            <label for="gst_type">Gst:</label>
                            <select id="gst_type" name="gst_type"
                                class="form-select @error('gst_type') is-invalid @enderror"
                                onchange="toggleSingleGstInput()">
                                <option value="">Select</option>
                                <option value="Yes" {{ old('gst_type') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ old('gst_type') == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <div id="gst_input_wrapper" class="col-sm-4 mb-3" style="display: none;">
                            <label for="gst">GST</label>
                            <input type="number" name="gst" id="gst" class="form-control"
                                value="{{ old('gst', 0) }}" readonly>
                        </div>

                        <div class="col-sm-4 mb-3">
                            <label for="pancard_type">PAN Card:</label>
                            <select id="pancard_type" name="pancard_type"
                                class="form-select @error('pancard_type') is-invalid @enderror"
                                onchange="toggleGstInput()">
                                <option value="">Select</option>
                                <option value="Yes" {{ old('pancard_type') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ old('pancard_type') == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <div id="pancard_input_wrapper" class="col-sm-4 mb-3" style="display: none;">
                            <label for="pancard">PAN Card Number:</label>
                            <input type="text" name="s_pan" id="pancard" class="form-control"
                                value="{{ old('pancard') }}" readonly>
                        </div>

                    </div>

                    <div class="row mb-2">
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

                    <div class="row mb-2">
                        <!-- Upload Input -->
                        <div class="col-md-6 mb-3">
                            <label for="fileInput" class="form-label">Upload Evidence Image/PDF</label>
                            <input type="file" name="image" class="form-control" id="fileInput"
                                accept="image/*,application/pdf" capture="environment">
                            <small class="text-muted">Supports image, PDF, or mobile camera capture.</small>
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Preview -->
                        <div class="col-md-6">
                            <div id="preview" class="border p-2 text-center">
                                <p class="text-muted">No file selected</p>
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
                            <input type="number" id="cgst" name="cgst" step="any" class="form-control"
                                value="0" onchange="updateTotal()">
                        </div>
                        <div class="col-md-2">
                            <label for="sgst">SGST (%)</label>
                            <input type="number" id="sgst" name="sgst" step="any" class="form-control"
                                value="0" onchange="updateTotal()">
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
                total += parseFloat(cell.textContent) || 0;
            });

            // Read GST %
            let cgstPercent = parseFloat(document.getElementById('cgst').value) || 0;
            let sgstPercent = parseFloat(document.getElementById('sgst').value) || 0;

            // ✅ Auto IGST = CGST + SGST
            let igstPercent = cgstPercent + sgstPercent;

            // Calculate amounts
            let cgstAmount = (total * cgstPercent) / 100;
            let sgstAmount = (total * sgstPercent) / 100;
            let igstAmount = cgstAmount + sgstAmount;

            let grandTotal = total + igstAmount;

            // Update DOM
            document.getElementById('igst').value = igstPercent.toFixed(2);

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
    <script>
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        const searchBox = document.getElementById('searchBox');

        // Submit search only on Enter
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (this.value.trim() !== '') {
                    searchForm.submit();
                } else {
                    // Empty input → hide box & reload page
                    if (searchBox) searchBox.style.display = 'none';
                    window.location.reload();
                }
            }
        });

        // Fill input fields from clicked search result
        function fillData(data) {
            document.getElementById('shop').value = data.shop || '';
            document.getElementById('s_name').value = data.name || '';

            // Combine address fields into one string
            let addressParts = [];
            if (data.village) addressParts.push(data.village);
            if (data.post) addressParts.push(data.post);
            if (data.town) addressParts.push(data.town);
            if (data.district) addressParts.push(data.district);
            if (data.state) addressParts.push(data.state);

            document.getElementById('s_address').value = addressParts.join(', ');

            document.getElementById('s_mobile').value = data.mobile || '';
            document.getElementById('s_email').value = data.email || '';
            document.getElementById('gst').value = data.shop_gst_no || '';
            document.getElementById('role').value = data.vendor_type || '';
            document.getElementById('pancard').value = data.vendor_pan_no || '';

            document.getElementById('b_name').value = data.b_name || '';
            document.getElementById('b_mobile').value = data.b_mobile || '';
            document.getElementById('b_email').value = data.b_email || '';
            document.getElementById('b_address').value = data.b_address || '';

            // Hide result list after selecting
            if (searchBox) {
                searchBox.style.display = 'none';
            }

            // Clear search input
            searchInput.value = '';
        }
    </script>
    <script>
        const allProjects = @json($allProjects);

        document.getElementById('work_category').addEventListener('change', function() {
            const selectedCategory = this.value;
            const workNameSelect = document.getElementById('work_name');

            // Clear current options
            workNameSelect.innerHTML = '<option value="">Select Work Name</option>';

            // Filter projects by selected category
            const filteredProjects = allProjects.filter(p => p.category === selectedCategory);

            // Add options to Work Name dropdown
            filteredProjects.forEach(project => {
                const option = document.createElement('option');
                option.value = project.name;
                option.text = project.name;
                workNameSelect.appendChild(option);
            });
        });
    </script>
    <script>
        document.getElementById('fileInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('preview');
            previewContainer.innerHTML = '';

            if (!file) {
                previewContainer.innerHTML = '<p class="text-muted">No file selected</p>';
                return;
            }

            if (file.type.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.className = 'img-fluid';
                previewContainer.appendChild(img);
            } else if (file.type === 'application/pdf') {
                const iframe = document.createElement('iframe');
                iframe.src = URL.createObjectURL(file);
                iframe.width = '100%';
                iframe.height = '500px';
                previewContainer.appendChild(iframe);
            } else {
                previewContainer.innerHTML = '<p class="text-danger">Unsupported file type.</p>';
            }
        });
    </script>

@endsection
