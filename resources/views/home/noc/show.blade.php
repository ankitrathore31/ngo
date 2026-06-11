@extends('home.layout.MasterLayout')

@section('content')
<div class="wrapper">
    <div class="container-fluid mt-4">

        {{-- ── Page header ────────────────────────────────────────────────── --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="mb-0 fw-semibold text-dark">
                    <i class="fas fa-file-magnifying-glass me-2 text-info"></i>View NOC
                </h5>
                <small class="text-muted">NOC Certificate Details</small>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded-pill small">
                        <li class="breadcrumb-item"><a href="{{ url('welcome') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('home.noc.index') }}">NOC List</a></li>
                        <li class="breadcrumb-item active">View NOC</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10">

                {{-- ── Detail Card ─────────────────────────────────────────── --}}
                <div class="card border-0 shadow-sm mb-4">
                    {{-- Header with NOC badge --}}
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <div class="noc-id-badge">NOC<br><span>#{{ $noc->id }}</span></div>
                            <div>
                                <h6 class="mb-0 fw-semibold">{{ $noc->noc_area }}</h6>
                                <small class="text-muted">
                                    Issued on {{ \Carbon\Carbon::parse($noc->noc_date)->format('d F Y') }}
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-4">

                            {{-- Detail rows --}}
                            <div class="col-md-6">
                                <div class="detail-block">
                                    <label class="detail-label">
                                        <i class="fas fa-calendar-days me-2 text-primary"></i>NOC Date
                                    </label>
                                    <p class="detail-value">
                                        {{ \Carbon\Carbon::parse($noc->noc_date)->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-block">
                                    <label class="detail-label">
                                        <i class="fas fa-map-location-dot me-2 text-primary"></i>NOC Area
                                    </label>
                                    <p class="detail-value">{{ $noc->noc_area }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-block">
                                    <label class="detail-label">
                                        <i class="fas fa-user me-2 text-primary"></i>Name Of The Person Issuing NOC
                                    </label>
                                    <p class="detail-value">{{ $noc->issuer_name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-block">
                                    <label class="detail-label">
                                        <i class="fas fa-id-badge me-2 text-primary"></i>Designation Of The Person Issuing NOC
                                    </label>
                                    <p class="detail-value">{{ $noc->issuer_designation }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-block">
                                    <label class="detail-label">
                                        <i class="fas fa-clock me-2 text-primary"></i>Uploaded On
                                    </label>
                                    <p class="detail-value">{{ $noc->created_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-block">
                                    <label class="detail-label">
                                        <i class="fas fa-file me-2 text-primary"></i>File Type
                                    </label>
                                    <p class="detail-value">
                                        @if($noc->file_type === 'image')
                                            <span class="badge bg-opacity-10 text-success fs-6 fw-normal px-3 py-2">
                                                <i class="fas fa-image me-1"></i>Image
                                            </span>
                                        @elseif($noc->file_type === 'pdf')
                                            <span class="badge  bg-opacity-10 text-danger fs-6 fw-normal px-3 py-2">
                                                <i class="fas fa-file-pdf me-1"></i>PDF
                                            </span>
                                        @else
                                            <span class="badge bg-opacity-10 text-warning fs-6 fw-normal px-3 py-2">
                                                <i class="fas fa-paperclip me-1"></i>Other
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ── NOC File Preview Card ────────────────────────────────── --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <span class="fw-semibold"><i class="fas fa-file-lines me-2 text-muted"></i>NOC Document</span>
                        <a href="{{ asset('noc_files/' . $noc->file_path) }}" target="_blank"
                           class="btn btn-outline-primary btn-sm px-3" download="{{ $noc->file_original_name }}">
                            <i class="fas fa-download me-1"></i>Download
                        </a>
                    </div>
                    <div class="card-body p-4 text-center">
                        @if($noc->file_type === 'image')
                            <img src="{{ asset('noc_files/' . $noc->file_path) }}"
                                 alt="NOC Document"
                                 class="img-fluid rounded-3 shadow-sm"
                                 style="max-height: 500px; cursor: zoom-in;"
                                 onclick="window.open(this.src,'_blank')">
                            <p class="text-muted small mt-2">
                                <i class="fas fa-cursor me-1"></i>Click to open full size
                            </p>
                        @elseif($noc->file_type === 'pdf')
                            <iframe src="{{ asset('noc_files/' . $noc->file_path) }}"
                                    class="rounded-3 border w-100"
                                    style="height: 500px;"
                                    title="NOC PDF">
                            </iframe>
                        @else
                            <div class="py-5">
                                <i class="fas fa-file-lines fa-4x text-muted mb-3 d-block"></i>
                                <p class="fw-medium mb-1">{{ $noc->file_original_name }}</p>
                                <p class="text-muted small mb-3">Preview not available for this file type.</p>
                                <a href="{{ asset('noc_files/' . $noc->file_path) }}" target="_blank"
                                   class="btn btn-primary px-4" download="{{ $noc->file_original_name }}">
                                    <i class="fas fa-download me-2"></i>Download File
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- ══════════════════════════════════════════════════════════════
                     ── Single Share Button
                ══════════════════════════════════════════════════════════════ --}}
                <div class="d-flex gap-2 align-items-center mb-4">
                    <button type="button" id="shareBtn" class="btn btn-success px-4">
                        <i class="fas fa-share-nodes me-2"></i>Share NOC
                    </button>
                </div>

                {{-- ── Fallback modal (shown only when Web Share API unavailable) --}}
                <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header border-0 pb-0">
                                <h6 class="modal-title fw-semibold" id="shareModalLabel">
                                    <i class="fas fa-share-nodes me-2 text-primary"></i>Share This NOC
                                </h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body px-4 pb-4">

                                {{-- Copy link --}}
                                <div class="mb-4">
                                    <label class="form-label small fw-semibold text-muted text-uppercase" style="letter-spacing:.5px;">
                                        <i class="fas fa-link me-1"></i>Page Link
                                    </label>
                                    <div class="input-group">
                                        <input type="text" id="shareLink"
                                               class="form-control bg-light border-end-0 text-muted small"
                                               value="{{ route('noc.show', $noc->id) }}" readonly>
                                        <button class="btn btn-outline-secondary border-start-0 px-3"
                                                type="button" id="copyLinkBtn">
                                            <i class="fas fa-copy" id="copyIcon"></i>
                                        </button>
                                    </div>
                                    <div id="copyFeedback" class="text-success small mt-1 d-none">
                                        <i class="fas fa-circle-check me-1"></i>Link copied!
                                    </div>
                                </div>

                                {{-- Platform buttons --}}
                                <label class="form-label small fw-semibold text-muted text-uppercase mb-3" style="letter-spacing:.5px;">
                                    <i class="fas fa-arrow-up-from-bracket me-1"></i>Share Via
                                </label>
                                <div class="share-grid">
                                    <a id="whatsappBtn" href="#" target="_blank" rel="noopener" class="share-btn share-whatsapp">
                                        <i class="fab fa-whatsapp share-icon"></i><span>WhatsApp</span>
                                    </a>
                                    <a id="emailBtn" href="#" class="share-btn share-email">
                                        <i class="fas fa-envelope share-icon"></i><span>Email</span>
                                    </a>
                                    <a id="facebookBtn" href="#" target="_blank" rel="noopener" class="share-btn share-facebook">
                                        <i class="fab fa-facebook-f share-icon"></i><span>Facebook</span>
                                    </a>
                                    <a id="twitterBtn" href="#" target="_blank" rel="noopener" class="share-btn share-twitter">
                                        <i class="fab fa-x-twitter share-icon"></i><span>X / Twitter</span>
                                    </a>
                                    <a id="telegramBtn" href="#" target="_blank" rel="noopener" class="share-btn share-telegram">
                                        <i class="fab fa-telegram-plane share-icon"></i><span>Telegram</span>
                                    </a>
                                    <a id="linkedinBtn" href="#" target="_blank" rel="noopener" class="share-btn share-linkedin">
                                        <i class="fab fa-linkedin-in share-icon"></i><span>LinkedIn</span>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                {{-- ── END Share ────────────────────────────────────────────── --}}

                {{-- Back button --}}
                <div class="mt-1 mb-4">
                    <a href="{{ route('noc.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════
     Styles
══════════════════════════════════════════════════════════════════════════ --}}
<style>
    /* ── existing styles ──────────────────────────────────── */
    .noc-id-badge {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        color: #fff;
        border-radius: 10px;
        padding: 6px 12px;
        font-size: 10px;
        font-weight: 700;
        text-align: center;
        line-height: 1.4;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .noc-id-badge span { font-size: 15px; }
    .detail-block { padding: 12px 16px; background: #f8f9ff; border-radius: 10px; }
    .detail-label  { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; color: #6c757d; display: block; margin-bottom: 4px; }
    .detail-value  { margin: 0; font-weight: 500; color: #212529; }

    /* ── share modal grid ─────────────────────────────────── */
    .share-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
    }
    .share-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 9px 10px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: transform .15s, box-shadow .15s, filter .15s;
        color: #fff !important;
    }
    .share-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 16px rgba(0,0,0,.2);
        filter: brightness(1.08);
        color: #fff !important;
    }
    .share-btn:active { transform: translateY(0); }
    .share-icon { font-size: 15px; flex-shrink: 0; }

    .share-whatsapp { background: #25d366; }
    .share-email    { background: #ea4335; }
    .share-facebook { background: #1877f2; }
    .share-twitter  { background: #000; }
    .share-telegram { background: #229ed9; }
    .share-linkedin { background: #0a66c2; }

    /* copy input */
    #shareLink:focus { box-shadow: none; }
</style>

{{-- ══════════════════════════════════════════════════════════════════════════
     Share Logic
══════════════════════════════════════════════════════════════════════════ --}}
<script>
(function () {
    // ── Data from Blade ────────────────────────────────────────────────────
    const pageUrl     = @json(route('noc.show', $noc->id));
    const fileUrl     = @json(asset('noc_files/' . $noc->file_path));
    const nocDate     = @json(\Carbon\Carbon::parse($noc->noc_date)->format('d M Y'));
    const nocArea     = @json($noc->noc_area);
    const issuerName  = @json($noc->issuer_name);
    const issuerDesig = @json($noc->issuer_designation);

    // ── Share text ─────────────────────────────────────────────────────────
    const shareTitle = `NOC – ${nocArea}`;
    const shareText  =
        `📄 No Objection Certificate (NOC)\n\n` +
        `📅 Date        : ${nocDate}\n` +
        `📍 Area        : ${nocArea}\n` +
        `👤 Issued By   : ${issuerName}\n` +
        `🏷️ Designation : ${issuerDesig}\n\n` +
        `🔗 View NOC    : ${pageUrl}\n` +
        `📎 File        : ${fileUrl}`;

    // ── Main Share button ──────────────────────────────────────────────────
    document.getElementById('shareBtn').addEventListener('click', async () => {
        // Use native OS share sheet if available (mobile / modern desktop)
        if (navigator.share) {
            try {
                await navigator.share({ title: shareTitle, text: shareText, url: pageUrl });
            } catch (e) { /* user cancelled */ }
        } else {
            // Desktop fallback: show modal with platform links
            buildFallbackLinks();
            new bootstrap.Modal(document.getElementById('shareModal')).show();
        }
    });

    // ── Build fallback modal links (only when modal is needed) ─────────────
    function buildFallbackLinks() {
        const plain = shareText.replace(/[*_]/g, '');

        document.getElementById('whatsappBtn').href =
            `https://wa.me/?text=${encodeURIComponent(shareText)}`;

        const emailSubject = `NOC Details – ${nocArea} (${nocDate})`;
        const emailBody =
            `No Objection Certificate (NOC) Details\n\n` +
            `Date        : ${nocDate}\n` +
            `Area        : ${nocArea}\n` +
            `Issued By   : ${issuerName}\n` +
            `Designation : ${issuerDesig}\n\n` +
            `View NOC Online : ${pageUrl}\n` +
            `Direct File     : ${fileUrl}`;
        document.getElementById('emailBtn').href =
            `mailto:?subject=${encodeURIComponent(emailSubject)}&body=${encodeURIComponent(emailBody)}`;

        document.getElementById('facebookBtn').href =
            `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(pageUrl)}&quote=${encodeURIComponent(plain)}`;

        const tweet = `NOC – ${nocArea} | ${issuerName} (${issuerDesig}) | ${nocDate}`;
        document.getElementById('twitterBtn').href =
            `https://x.com/intent/tweet?text=${encodeURIComponent(tweet)}&url=${encodeURIComponent(pageUrl)}`;

        document.getElementById('telegramBtn').href =
            `https://t.me/share/url?url=${encodeURIComponent(pageUrl)}&text=${encodeURIComponent(plain)}`;

        document.getElementById('linkedinBtn').href =
            `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(pageUrl)}`;
    }

    // ── Copy link (inside modal) ───────────────────────────────────────────
    document.getElementById('copyLinkBtn').addEventListener('click', function () {
        navigator.clipboard.writeText(pageUrl).then(() => {
            const icon = document.getElementById('copyIcon');
            const fb   = document.getElementById('copyFeedback');
            icon.classList.replace('fa-copy', 'fa-check');
            this.classList.replace('btn-outline-secondary', 'btn-outline-success');
            fb.classList.remove('d-none');
            setTimeout(() => {
                icon.classList.replace('fa-check', 'fa-copy');
                this.classList.replace('btn-outline-success', 'btn-outline-secondary');
                fb.classList.add('d-none');
            }, 2500);
        });
    });

    // ── Delete confirm ─────────────────────────────────────────────────────
    document.querySelector('.delete-form')?.addEventListener('submit', function (e) {
        e.preventDefault();
        if (confirm('Delete this NOC? This cannot be undone.')) this.submit();
    });
})();
</script>
@endsection