@extends('member.layout.master')
@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">My Sub Members</h4>
            <small class="text-muted">Members registered under: <strong>{{ $authMember->name }}</strong> ({{ $authMember->position ?? '—' }})</small>
        </div>
        @if($authMember->position && \App\Helpers\PositionHierarchy::canAddSubMembers($authMember->position))
        <a href="{{ route('add.submember') }}" class="btn btn-primary">
            <i class="bi bi-person-plus-fill me-2"></i>Add Sub Member
        </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Stats Row --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <div class="fs-2 fw-bold text-primary">{{ $subMembers->total() }}</div>
                <div class="text-muted small">Total Sub Members</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <div class="fs-2 fw-bold text-success">{{ $subMembers->where('status', 1)->count() }}</div>
                <div class="text-muted small">Active</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <div class="fs-2 fw-bold text-warning">{{ $subMembers->where('status', 0)->count() }}</div>
                <div class="text-muted small">Pending</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <div class="fs-2 fw-bold text-info">{{ $subMembers->where('status', 2)->count() }}</div>
                <div class="text-muted small">Rejected</div>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="card shadow-sm mb-3">
        <div class="card-body py-2">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-auto">
                    <input type="text" class="form-control form-control-sm" name="search" placeholder="Search name/phone/app no..." value="{{ request('search') }}">
                </div>
                <div class="col-auto">
                    <select class="form-select form-select-sm" name="status">
                        <option value="">All Status</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Pending</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="2" {{ request('status') === '2' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button class="btn btn-sm btn-primary" type="submit">Filter</button>
                    <a href="{{ route('member.sub-member.list') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Sr. No.</th>
                            <th>Photo</th>
                            <th>Application No.</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Working Area</th>
                            <th>Phone</th>
                            <th>State / District</th>
                            <th>Status</th>
                            <th>Registered</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subMembers as $i => $member)
                        <tr>
                            <td>{{ $subMembers->firstItem() + $i }}</td>
                            <td>
                                @if($member->image)
                                    <img src="{{ asset('member_images/'.$member->image) }}" class="rounded-circle" width="40" height="40" style="object-fit:cover;">
                                @else
                                    <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center text-white fw-bold" style="width:40px;height:40px;">
                                        {{ strtoupper(substr($member->name,0,1)) }}
                                    </div>
                                @endif
                            </td>
                            <td><code>{{ $member->application_no }}</code></td>
                            <td>
                                <div class="fw-semibold">{{ $member->name }}</div>
                                <small class="text-muted">{{ $member->gender }}, {{ $member->dob ? \Carbon\Carbon::parse($member->dob)->age.' yrs' : '—' }}</small>
                            </td>
                            <td>
                                @if($member->position)
                                    @php $level = \App\Helpers\PositionHierarchy::getLevelByPosition($member->position); @endphp
                                    <span class="badge bg-{{ \App\Helpers\PositionHierarchy::getLevelColor($level ?? '') }}">{{ $member->position }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $member->working_area ?? '—' }}</td>
                            <td>{{ $member->phone }}</td>
                            <td>{{ $member->state }}<br><small class="text-muted">{{ $member->district }}</small></td>
                            <td>
                                @if($member->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @elseif($member->status == 2)
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td><small>{{ $member->created_at->format('d M Y') }}</small></td>
                            <td>
                                <a href="{{ route('member.sub-member.show', $member->id) }}" class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-1 d-block mb-2 opacity-25"></i>
                                No sub members found.
                                @if($authMember->position && \App\Helpers\PositionHierarchy::canAddSubMembers($authMember->position))
                                    <a href="{{ route('add.submember') }}" class="btn btn-sm btn-primary mt-2">Add First Sub Member</a>
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($subMembers->hasPages())
        <div class="card-footer">
            {{ $subMembers->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection