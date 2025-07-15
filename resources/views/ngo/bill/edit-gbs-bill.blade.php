@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="d-flex justify-content-between align-items-center mb-1 mt-3">
            <h5 class="mb-0">Edit GBS Bill/Voucher</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-1 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">GBS Bill/Voucher</li>
                </ol>
            </nav>
        </div>

        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div id="sansthaBillContainer" class="card border p-3 container mt-5">
            <form method="POST" action="{{ route('update-gbs-bill', $bill->id) }}">
                @csrf
                <div class="row">
                    {{-- Session --}}
                    <div class="col-md-4 mb-3">
                        <label for="academic_session" class="bold">Session <span class="text-danger">*</span></label>
                        <select class="form-control @error('academic_session') is-invalid @enderror" name="academic_session"
                            id="academic_session" required>
                            <option value="">Select Session</option>
                            @foreach ($data as $session)
                                <option value="{{ $session->session_date }}"
                                    {{ old('academic_session', $bill->academic_session) == $session->session_date ? 'selected' : '' }}>
                                    {{ $session->session_date }}
                                </option>
                            @endforeach
                        </select>
                        @error('academic_session')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Bill Date --}}
                    <div class="col-md-4 mb-3">
                        <label for="bill_date">Bill Date:</label>
                        <input type="date" id="bill_date" name="bill_date" class="form-control"
                            value="{{ old('bill_date', $bill->bill_date) }}" required>
                        @error('bill_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Name --}}
                    <div class="col-md-4 mb-3">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" class="form-control"
                            value="{{ old('name', $bill->name) }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Guardian Name --}}
                    <div class="col-md-4 mb-3">
                        <label for="guardian_name">Father/Husband Name:</label>
                        <input type="text" id="guardian_name" name="guardian_name" class="form-control"
                            value="{{ old('guardian_name', $bill->guardian_name) }}" required>
                        @error('guardian_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Village --}}
                    <div class="col-md-4 mb-3">
                        <label for="village">Village/Locality <span class="text-danger">*</span></label>
                        <input type="text" id="village" name="village"
                            class="form-control @error('village') is-invalid @enderror"
                            value="{{ old('village', $bill->village) }}">
                        @error('village')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Post --}}
                    <div class="col-md-4 mb-3">
                        <label for="post">Post/Town <span class="text-danger">*</span></label>
                        <input type="text" id="post" name="post"
                            class="form-control @error('post') is-invalid @enderror" value="{{ old('post', $bill->post) }}"
                            required>
                        @error('post')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Block --}}
                    <div class="col-md-4 mb-3">
                        <label for="block">Block <span class="text-danger">*</span></label>
                        <input type="text" id="block" name="block"
                            class="form-control @error('block') is-invalid @enderror"
                            value="{{ old('block', $bill->block) }}" required>
                        @error('block')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- State --}}
                    @php $districtsByState = config('districts'); @endphp
                    <div class="col-md-4 mb-3">
                        <label for="stateSelect">State <span class="text-danger">*</span></label>
                        <select class="form-control @error('state') is-invalid @enderror" name="state" id="stateSelect"
                            required>
                            <option value="">Select State</option>
                            @foreach ($districtsByState as $state => $districts)
                                <option value="{{ $state }}"
                                    {{ old('state', $bill->state) == $state ? 'selected' : '' }}>
                                    {{ $state }}
                                </option>
                            @endforeach
                        </select>
                        @error('state')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- District --}}
                    <div class="col-md-4 mb-3">
                        <label for="districtSelect">District <span class="text-danger">*</span></label>
                        <select class="form-control @error('district') is-invalid @enderror" name="district"
                            id="districtSelect" required>
                            <option value="{{ old('district', $bill->district) }}">{{ old('district', $bill->district) }}
                            </option>
                        </select>
                        @error('district')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Branch --}}
                    <div class="col-md-4 mb-3">
                        <label for="branch">Branch <span class="text-danger">*</span></label>
                        <input type="text" id="branch" name="branch"
                            class="form-control @error('branch') is-invalid @enderror"
                            value="{{ old('branch', $bill->branch) }}" required>
                        @error('branch')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Centre --}}
                    <div class="col-md-4 mb-3">
                        <label for="centre">Centre <span class="text-danger">*</span></label>
                        <input type="text" id="centre" name="centre"
                            class="form-control @error('centre') is-invalid @enderror"
                            value="{{ old('centre', $bill->centre) }}" required>
                        @error('centre')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Date --}}
                    <div class="col-md-4 mb-3">
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date" class="form-control"
                            value="{{ old('date', $bill->date) }}" required>
                        @error('date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Work --}}
                    <div class="col-md-4 mb-3">
                        <label for="work">Work <span class="text-danger">*</span></label>
                        <textarea id="work" name="work" class="form-control @error('work') is-invalid @enderror">{{ old('work', $bill->work) }}</textarea>
                        @error('work')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Amount --}}
                    <div class="col-md-4 mb-3">
                        <label>Amount (₹)</label>
                        <input type="number" class="form-control" name="amount" id="amountInput"
                            value="{{ old('amount', $bill->amount) }}" oninput="updateAmountInWords()" placeholder="₹">
                        @error('amount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Amount in Words --}}
                    {{-- <div class="col-md-4 mb-3">
                        <label>Amount in words</label>
                        <input type="text" class="form-control" id="amountWords" readonly
                            value="{{ \App\Helpers\AmountHelper::convertToWords($bill->amount) ?? '' }}">
                    </div> --}}

                    {{-- Payment Method --}}
                    <div class="col-md-4 mb-3">
                        <label>Payment Method</label>
                        <select class="form-control @error('payment_method') is-invalid @enderror" name="payment_method"
                            id="payment_method">
                            <option value="">Select...</option>
                            <option value="Cash"
                                {{ old('payment_method', $bill->payment_method) == 'Cash' ? 'selected' : '' }}>Cash
                            </option>
                            <option value="Cheque"
                                {{ old('payment_method', $bill->payment_method) == 'Cheque' ? 'selected' : '' }}>Cheque
                            </option>
                            <option value="UPI"
                                {{ old('payment_method', $bill->payment_method) == 'UPI' ? 'selected' : '' }}>UPI</option>
                            <option value="Other"
                                {{ old('payment_method', $bill->payment_method) == 'Other' ? 'selected' : '' }}>Other
                            </option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Conditional Cheque Fields --}}
                    {{-- <div id="chequeFields"
                        style="{{ old('payment_method', $bill->payment_method) == 'Cheque' ? '' : 'display: none;' }}">
                        @include('partials.cheque-fields', ['bill' => $bill])
                    </div> --}}

                    {{-- Conditional UPI Fields --}}
                    {{-- <div id="upiFields"
                        style="{{ old('payment_method', $bill->payment_method) == 'UPI' ? '' : 'display: none;' }}">
                        @include('partials.upi-fields', ['bill' => $bill])
                    </div> --}}

                    {{-- Bank Details --}}
                    <div class="col-md-4 mb-3">
                        <label>Account Number</label>
                        <input type="text" name="account_number" class="form-control"
                            value="{{ old('account_number', $bill->account_number) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Bank Name</label>
                        <input type="text" name="bank_name" class="form-control"
                            value="{{ old('bank_name', $bill->bank_name) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Bank Branch</label>
                        <input type="text" name="branch_name" class="form-control"
                            value="{{ old('branch_name', $bill->branch_name) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>IFSC Code</label>
                        <input type="text" name="ifsc_code" class="form-control"
                            value="{{ old('ifsc_code', $bill->ifsc_code) }}">
                    </div>

                    {{-- Place --}}
                    <div class="col-md-4 mb-3">
                        <label for="place">Place <span class="text-danger">*</span></label>
                        <textarea id="place" name="place" class="form-control @error('place') is-invalid @enderror">{{ old('place', $bill->place) }}</textarea>
                        @error('place')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <button type="submit" class="btn btn-warning">Update Voucher</button>
            </form>
        </div>

    </div>
@endsection
