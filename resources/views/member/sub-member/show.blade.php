@extends('member.layout.master')
@section('content')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .print-card,
        .print-card * {
            visibility: visible;
        }
        .print-card {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        button, .btn, .no-print, .breadcrumb {
            display: none !important;
        }
    }
</style>

<div class="wrapper">
    <div class="container-fluid mt-4">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3 no-print">
            <h5 class="mb-0">Sub Member</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ route('member') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('member.sub-member.list') }}">Sub Members</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View Sub Member</li>
                </ol>
            </nav>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show no-print" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="container my-4">

            {{-- Action Buttons --}}
            <div class="d-flex justify-content-between align-items-center mb-4 no-print">
                <h2 class="fw-bold">Sub Member Profile</h2>
                <div class="d-flex gap-2">
                    <a href="{{ route('member.sub-member.list') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="bi bi-printer me-1"></i> Print / Download
                    </button>
                </div>
            </div>

            {{-- PRINT CARD --}}
            <div class="card p-4 shadow rounded print-card">

                {{-- Letterhead --}}
                <div class="text-center mb-4 border-bottom pb-3">
                    <div class="row align-items-center">
                        <div class="col-sm-2 text-center text-md-start">
                            <a href="https://gyanbhartingo.org">
                                <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="80" height="80">
                            </a>
                        </div>
                        <div class="col-sm-10 text-center">
                            <h4 style="color: red; font-weight:500; font-size:25px;"><b>GYAN BHARTI SANSTHA</b></h4>
                            <h6 style="color: blue;"><b>Head Office: Kainchu Tanda Amaria Pilibhit UP 262121</b></h6>
                            <p><b>Website : www.gyanbhartingo.org &nbsp; Email : gyanbhartingo600@gmail.com &nbsp; Mob- 9411484111</b></p>
                        </div>
                    </div>
                </div>

                {{-- Application Info --}}
                <div class="row mb-3">
                    <div class="col-sm-4 mb-3">
                        <strong>Application Date:</strong>
                        {{ \Carbon\Carbon::parse($member->application_date)->format('d-m-Y') }}
                    </div>
                    <div class="col-sm-4 mb-3">
                        <strong>Application No:</strong> {{ $member->application_no }}
                    </div>
                    <div class="col-sm-4 mb-3">
                        <strong>Registration Type:</strong> {{ $member->reg_type }}
                    </div>
                    <div class="col-sm-4 mb-3">
                        <strong>Session:</strong> {{ $member->academic_session }}
                    </div>
                    <div class="col-sm-8 mb-3">
                        <strong>Added By:</strong> {{ $authMember->name }} ({{ $authMember->application_no }})({{ $authMember->position }})
                    </div>
                </div>

                {{-- Position Info --}}
                @if($member->position)
                <div class="row mb-3 p-2 rounded" style="background:#f0f4ff; border-left: 4px solid #0d6efd;">
                    <div class="col-sm-4 mb-2">
                        <strong>Position Level:</strong>
                        @php $level = \App\Helpers\PositionHierarchy::getLevelByPosition($member->position); @endphp
                        {{ $level ? \App\Helpers\PositionHierarchy::getLevelLabel($level) : '—' }}
                    </div>
                    <div class="col-sm-4 mb-2">
                        <strong>Position:</strong>
                        <span class="badge bg-{{ \App\Helpers\PositionHierarchy::getLevelColor($level ?? '') }}">
                            {{ $member->position }}
                        </span>
                    </div>
                    <div class="col-sm-4 mb-2">
                        <strong>Working Area:</strong> {{ $member->working_area ?? '—' }}
                    </div>
                </div>
                @endif

                <hr>

                {{-- Personal Info + Photo --}}
                <div class="row">
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <strong>Name:</strong> {{ $member->name }}
                            </div>
                            <div class="col-sm-6 mb-3">
                                <strong>Guardian's Name:</strong> {{ $member->gurdian_name }}
                            </div>
                            <div class="col-sm-6 mb-3">
                                <strong>Mother's Name:</strong> {{ $member->mother_name }}
                            </div>
                            <div class="col-sm-6 mb-3">
                                <strong>Date of Birth:</strong>
                                {{ \Carbon\Carbon::parse($member->dob)->format('d-m-Y') }}
                            </div>
                            <div class="col-sm-6 mb-3">
                                <strong>Gender:</strong> {{ $member->gender }}
                            </div>
                            <div class="col-sm-6 mb-3">
                                <strong>Marital Status:</strong> {{ $member->marital_status }}
                            </div>
                            <div class="col-sm-6 mb-3">
                                <strong>Area Type:</strong> {{ $member->area_type }}
                            </div>
                            <div class="col-sm-6 mb-3">
                                <strong>Village/Locality:</strong> {{ $member->village ?? 'N/A' }}
                            </div>
                            <div class="col-sm-6 mb-3">
                                <strong>Post/Town:</strong> {{ $member->post }}
                            </div>
                            <div class="col-sm-6 mb-3">
                                <strong>Block:</strong> {{ $member->block }}
                            </div>
                            <div class="col-sm-6 mb-3">
                                <strong>District:</strong> {{ $member->district }}
                            </div>
                            <div class="col-sm-6 mb-3">
                                <strong>State:</strong> {{ $member->state }}
                            </div>
                            <div class="col-sm-6 mb-3">
                                <strong>Pincode:</strong> {{ $member->pincode ?? 'N/A' }}
                            </div>
                            <div class="col-sm-6 mb-3">
                                <strong>Country:</strong> {{ $member->country }}
                            </div>
                        </div>
                    </div>

                    {{-- Photo --}}
                    <div class="col-sm-4 text-center">
                        <div class="mb-3">
                            @if($member->image)
                                <img src="{{ asset('member_images/' . $member->image) }}"
                                    alt="Member Photo" class="img-thumbnail"
                                    width="150" height="150" style="object-fit:cover;">
                            @else
                                <div class="border d-flex align-items-center justify-content-center bg-light"
                                    style="width:150px;height:180px;margin:auto;">
                                    <i class="bi bi-person fs-1 text-secondary"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Contact & Other Details --}}
                <div class="row">
                    <div class="col-sm-4 mb-3">
                        <strong>Phone:</strong> {{ $member->phone }}
                    </div>
                    <div class="col-sm-4 mb-3">
                        <strong>Email:</strong> {{ $member->email ?? 'N/A' }}
                    </div>
                    <div class="col-sm-4 mb-3">
                        <strong>Occupation:</strong> {{ $member->occupation }}
                    </div>
                    <div class="col-sm-4 mb-3">
                        <strong>Eligibility:</strong> {{ $member->eligibility ?? 'N/A' }}
                    </div>
                    <div class="col-sm-4 mb-3">
                        <strong>Caste:</strong> {{ $member->caste }}
                    </div>
                    <div class="col-sm-4 mb-3">
                        <strong>Religion Category:</strong> {{ $member->religion_category }}
                    </div>
                    <div class="col-sm-4 mb-3">
                        <strong>Religion:</strong> {{ $member->religion }}
                    </div>
                    <div class="col-sm-4 mb-3">
                        <strong>Identity Type:</strong> {{ $member->identity_type }}
                    </div>
                    <div class="col-sm-4 mb-3">
                        <strong>Identity Number:</strong> {{ $member->identity_no }}
                    </div>
                    @if($member->id_document)
                    <div class="col-sm-4 mb-3">
                        <strong>ID Document:</strong>
                        @php $ext = strtolower(pathinfo($member->id_document, PATHINFO_EXTENSION)); @endphp
                        @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                            <a href="{{ asset('member_images/' . $member->id_document) }}" target="_blank">View Image</a>
                        @else
                            <a href="{{ asset('member_images/' . $member->id_document) }}" target="_blank">View Document</a>
                        @endif
                    </div>
                    @endif
                </div>

                <hr>

                {{-- Signature Row --}}
                <div class="row d-flex justify-content-between mt-2">
                    <div class="col-sm-4 mb-5">
                        <label class="form-label"><b>Sub Member Signature</b></label><br>
                        {{$member->name}}
                    </div>
                    <div class="col-sm-4 mb-5 text-end">
                        <label class="form-label"><b>Member Signature</b></label><br>
                        {{ $authMember->name }}
                    </div>
                </div>

            </div>{{-- end .print-card --}}
        </div>
    </div>
</div>
@endsection