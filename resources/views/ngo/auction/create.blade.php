@extends('ngo.layout.master')
@section('title', isset($item) ? 'Edit Auction' : 'Create New Auction')

<style>
    :root {
        --gold: #C9A84C;
        --deep: #1A1208;
        --cream: #F7F3EC;
        --rust: #8B3A1A;
        --jade: #2C5F4A;
    }

    .form-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid rgba(0, 0, 0, .07);
        margin-bottom: 22px;
        overflow: hidden;
    }

    .form-card-header {
        background: var(--cream);
        padding: 14px 22px;
        border-bottom: 1px solid rgba(0, 0, 0, .06);
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.45em;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--deep);
    }

    .form-card-header i {
        color: var(--gold);
        font-size: .9rem;
    }

    .form-card-body {
        padding: 22px;
    }

    .form-lbl {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--deep);
        margin-bottom: 6px;
        display: block;
    }

    .form-lbl .req {
        color: #C0392B;
    }

    .ctrl {
        border: 1.5px solid rgba(0, 0, 0, .1);
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 1rem;
        color: var(--deep);
        width: 100%;
        transition: border-color .2s, box-shadow .2s;
        background: #fff;
    }

    .ctrl:focus {
        outline: none;
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(201, 168, 76, .12);
    }

    .ctrl.is-invalid {
        border-color: #C0392B;
    }

    .err-msg {
        font-size: .72rem;
        color: #C0392B;
        margin-top: 4px;
    }

    .rarity-radio-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .rarity-radio-option {
        border: 2px solid rgba(0, 0, 0, .08);
        border-radius: 10px;
        padding: 12px 14px;
        cursor: pointer;
        transition: all .2s;
        position: relative;
    }

    .rarity-radio-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .rarity-radio-option:has(input:checked) {
        border-color: var(--gold);
        background: rgba(201, 168, 76, .06);
    }

    .rarity-radio-label {
        font-size: .82rem;
        font-weight: 700;
        color: var(--deep);
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .rarity-radio-sub {
        font-size: .7rem;
        font-weight: 400;
        color: #999;
        margin-top: 2px;
    }

    /* Image upload */
    .img-upload-zone {
        border: 2px dashed rgba(0, 0, 0, .12);
        border-radius: 10px;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        transition: border-color .2s, background .2s;
        background: var(--cream);
    }

    .img-upload-zone:hover,
    .img-upload-zone.dragover {
        border-color: var(--gold);
        background: rgba(201, 168, 76, .04);
    }

    .img-preview-grid {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 14px;
    }

    .img-preview-item {
        position: relative;
        width: 90px;
        height: 90px;
    }

    .img-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid rgba(0, 0, 0, .1);
    }

    .img-preview-item .remove-img {
        position: absolute;
        top: -6px;
        right: -6px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: #C0392B;
        color: #fff;
        border: none;
        font-size: .65rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .existing-img-wrap {
        position: relative;
        display: inline-block;
    }

    .existing-img-wrap img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
    }

    .existing-img-wrap form {
        position: absolute;
        top: -6px;
        right: -6px;
    }

    .existing-img-wrap .del-img-btn {
        width: 22px;
        height: 22px;
        background: #C0392B;
        border: none;
        color: #fff;
        border-radius: 50%;
        font-size: .6rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-submit-auction {
        background: linear-gradient(135deg, var(--rust), #A0471F);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 14px 40px;
        font-size: .95rem;
        font-weight: 700;
        cursor: pointer;
        transition: all .3s;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-submit-auction:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(139, 58, 26, .4);
    }
</style>

@section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">

            {{-- Page header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-gavel me-2 text-warning"></i>
                        {{ isset($item) ? 'Edit Auction Item' : 'Create New Auction' }}
                    </h5>
                    <small
                        class="text-muted">{{ isset($item) ? 'Update details for this auction' : 'Add a new rare material to auction' }}</small>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded-pill small">
                        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('ngo.auction.index') }}">Auctions</a></li>
                        <li class="breadcrumb-item active">{{ isset($item) ? 'Edit' : 'Create' }}</li>
                    </ol>
                </nav>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger py-2 small mb-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ isset($item) ? route('ngo.auction.update', $item->id) : route('ngo.auction.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($item))
                    @method('PUT')
                @endif
 
                <div class="row g-4">

                    {{-- Left column --}}
                    <div class="col-lg-8">

                        {{-- Basic info --}}
                        <div class="form-card">
                            <div class="form-card-header"><i class="fas fa-info-circle"></i> Item Information</div>
                            <div class="form-card-body">
                                <div class="mb-3">
                                    <label class="form-lbl">Item Title <span class="req">*</span></label>
                                    <input type="text" name="title" class="ctrl @error('title') is-invalid @enderror"
                                        value="{{ old('title', $item->title ?? '') }}"
                                        placeholder="e.g. 19th Century Bronze Shiva Nataraja">
                                    @error('title')
                                        <div class="err-msg">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-lbl">Short Description <span class="req">*</span></label>
                                    <textarea name="description" class="ctrl @error('description') is-invalid @enderror" rows="3"
                                        placeholder="Brief description shown on listing cards...">{{ old('description', $item->description ?? '') }}</textarea>
                                    @error('description')
                                        <div class="err-msg">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-0">
                                    <label class="form-lbl">About This Material <span class="text-muted fw-normal">(detailed
                                            section)</span></label>
                                    <textarea name="about_material" class="ctrl" rows="5"
                                        placeholder="Detailed history, cultural significance, craftsmanship details, scientific facts about the material...">{{ old('about_material', $item->about_material ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Material specs --}}
                        <div class="form-card">
                            <div class="form-card-header"><i class="fas fa-microscope"></i> Material Specifications</div>
                            <div class="form-card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-lbl">Material Type</label>
                                        <input type="text" name="material_type" class="ctrl"
                                            value="{{ old('material_type', $item->material_type ?? '') }}"
                                            placeholder="e.g. Bronze, Stone, Wood, Textile">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-lbl">Origin / Region</label>
                                        <input type="text" name="origin" class="ctrl"
                                            value="{{ old('origin', $item->origin ?? '') }}"
                                            placeholder="e.g. South India, Rajasthan">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-lbl">Age / Period</label>
                                        <input type="text" name="age_period" class="ctrl"
                                            value="{{ old('age_period', $item->age_period ?? '') }}"
                                            placeholder="e.g. 12th Century CE, Chola Period">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-lbl">Condition</label>
                                        <select name="condition" class="ctrl">
                                            <option value="">Select Condition</option>
                                            @foreach (['Mint', 'Excellent', 'Very Good', 'Good', 'Fair', 'Poor'] as $c)
                                                <option value="{{ $c }}"
                                                    {{ old('condition', $item->condition ?? '') === $c ? 'selected' : '' }}>
                                                    {{ $c }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-lbl">Dimensions</label>
                                        <input type="text" name="dimensions" class="ctrl"
                                            value="{{ old('dimensions', $item->dimensions ?? '') }}"
                                            placeholder="e.g. 45cm × 30cm × 20cm">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-lbl">Weight</label>
                                        <input type="text" name="weight" class="ctrl"
                                            value="{{ old('weight', $item->weight ?? '') }}" placeholder="e.g. 2.4 kg">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-lbl">Certificate No.</label>
                                        <input type="text" name="certificate_number" class="ctrl"
                                            value="{{ old('certificate_number', $item->certificate_number ?? '') }}"
                                            placeholder="e.g. ASI-2024-0081">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-lbl">Provenance (Ownership History)</label>
                                        <textarea name="provenance" class="ctrl" rows="2"
                                            placeholder="e.g. Acquired from a private estate in Jaipur, documented since 1952...">{{ old('provenance', $item->provenance ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Images --}}
                        <div class="form-card">
                            <div class="form-card-header"><i class="fas fa-images"></i> Item Images (4–5 recommended)
                            </div>
                            <div class="form-card-body">
                                @if (isset($item) && $item->images->isNotEmpty())
                                    <p class="form-lbl mb-2">Existing Images</p>
                                    <div class="d-flex gap-2 flex-wrap mb-4">
                                        @foreach ($item->images as $img)
                                            <div class="existing-img-wrap">
                                                <img src="{{ asset('storage/' . $img->image_path) }}" alt="">
                                                <form method="POST"
                                                    action="{{ route('ngo.auction.image.delete', $img->id) }}"
                                                    onsubmit="return confirm('Remove this image?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="del-img-btn">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                    <p class="form-lbl mb-2">Add More Images</p>
                                @endif

                                <div class="img-upload-zone" id="imgDropZone"
                                    onclick="document.getElementById('imagesInput').click()">
                                    <i class="fas fa-cloud-upload-alt fa-2x mb-2"
                                        style="color:var(--gold);opacity:.6;"></i>
                                    <p class="mb-1 fw-semibold" style="font-size:.9rem;">Drag & drop or click to upload
                                    </p>
                                    <p class="text-muted mb-0" style="font-size:.75rem;">JPG, PNG, WebP · Max 5MB each ·
                                        Up to 10 images</p>
                                </div>
                                <input type="file" id="imagesInput" name="images[]" accept="image/*" multiple
                                    class="d-none">
                                <div class="img-preview-grid" id="imgPreviewGrid"></div>
                            </div>
                        </div>

                        {{-- 3D model --}}
                        <div class="form-card">
                            <div class="form-card-header"><i class="fas fa-cube"></i> 3D Model (Optional)</div>
                            <div class="form-card-body">
                                <label class="form-lbl">3D Viewer Embed URL</label>
                                <input type="url" name="model_3d_url" class="ctrl"
                                    value="{{ old('model_3d_url', $item->model_3d_url ?? '') }}"
                                    placeholder="https://sketchfab.com/models/... or similar embed URL">
                                <div style="font-size:.72rem;color:#999;margin-top:6px;">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Supports Sketchfab, Google Model Viewer, or any iframe-embeddable 3D viewer URL.
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Right column --}}
                    <div class="col-lg-4">

                        {{-- Rarity --}}
                        <div class="form-card">
                            <div class="form-card-header"><i class="fas fa-star"></i> Rarity Classification</div>
                            <div class="form-card-body">
                                <div class="rarity-radio-grid">
                                    @foreach ([['value' => 'unique', 'label' => 'Unique', 'color' => '#FFD700', 'desc' => 'One of a kind'], ['value' => 'very_rare', 'label' => 'Very Rare', 'color' => '#C0392B', 'desc' => 'Extremely scarce'], ['value' => 'rare', 'label' => 'Rare', 'color' => '#8E44AD', 'desc' => 'Hard to find'], ['value' => 'common', 'label' => 'Common', 'color' => '#27AE60', 'desc' => 'Occasional finds']] as $r)
                                        <label class="rarity-radio-option">
                                            <input type="radio" name="rarity_level" value="{{ $r['value'] }}"
                                                {{ old('rarity_level', $item->rarity_level ?? 'rare') === $r['value'] ? 'checked' : '' }}>
                                            <div class="rarity-radio-label">
                                                <span
                                                    style="width:10px;height:10px;border-radius:50%;background:{{ $r['color'] }};display:inline-block;flex-shrink:0;"></span>
                                                {{ $r['label'] }}
                                            </div>
                                            <div class="rarity-radio-sub">{{ $r['desc'] }}</div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Auction schedule --}}
                        <div class="form-card">
                            <div class="form-card-header"><i class="fas fa-calendar-days"></i> Auction Schedule</div>
                            <div class="form-card-body">
                                <div class="mb-3">
                                    <label class="form-lbl">Auction Start <span class="req">*</span></label>
                                    <input type="datetime-local" name="auction_start"
                                        class="ctrl @error('auction_start') is-invalid @enderror"
                                        value="{{ old('auction_start', isset($item) ? $item->auction_start->format('Y-m-d\TH:i') : '') }}">
                                    @error('auction_start')
                                        <div class="err-msg">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-lbl">Auction End <span class="req">*</span></label>
                                    <input type="datetime-local" name="auction_end"
                                        class="ctrl @error('auction_end') is-invalid @enderror"
                                        value="{{ old('auction_end', isset($item) ? $item->auction_end->format('Y-m-d\TH:i') : '') }}">
                                    @error('auction_end')
                                        <div class="err-msg">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach ([1, 3, 7, 14, 30] as $days)
                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                            onclick="setDuration({{ $days }})">+{{ $days }}d</button>
                                    @endforeach
                                </div>
                                <small class="text-muted d-block mt-2">Quick duration from start date</small>
                            </div>
                        </div>

                        {{-- Pricing --}}
                        <div class="form-card">
                            <div class="form-card-header"><i class="fas fa-indian-rupee-sign"></i> Bid Configuration</div>
                            <div class="form-card-body">
                                <div class="mb-3">
                                    <label class="form-lbl">Starting Bid (₹) <span class="req">*</span></label>
                                    <input type="number" name="starting_bid"
                                        class="ctrl @error('starting_bid') is-invalid @enderror"
                                        value="{{ old('starting_bid', $item->starting_bid ?? '') }}" min="1"
                                        placeholder="e.g. 5000">
                                    @error('starting_bid')
                                        <div class="err-msg">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-0">
                                    <label class="form-lbl">Reserve Price (₹) <span
                                            class="text-muted fw-normal">(optional)</span></label>
                                    <input type="number" name="reserve_price" class="ctrl"
                                        value="{{ old('reserve_price', $item->reserve_price ?? '') }}" min="0"
                                        placeholder="Minimum to accept (hidden)">
                                    <small class="text-muted d-block mt-1" style="font-size:.7rem;">
                                        If set, winning bid must meet this to finalize.
                                    </small>
                                </div>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="form-card">
                            <div class="form-card-header"><i class="fas fa-toggle-on"></i> Publication Status</div>
                            <div class="form-card-body">
                                <label class="form-lbl">Status <span class="req">*</span></label>
                                <select name="status" class="ctrl">
                                    @foreach (['draft' => 'Save as Draft', 'active' => 'Publish (Active)'] as $val => $lbl)
                                        @if (!isset($item) || in_array($item->status, ['draft', 'active']))
                                            <option value="{{ $val }}"
                                                {{ old('status', $item->status ?? 'draft') === $val ? 'selected' : '' }}>
                                                {{ $lbl }}
                                            </option>
                                        @endif
                                    @endforeach
                                    @if (isset($item))
                                        @foreach (['closed' => 'Closed', 'winner_selected' => 'Winner Selected', 'completed' => 'Completed'] as $val => $lbl)
                                            <option value="{{ $val }}"
                                                {{ $item->status === $val ? 'selected' : '' }}>{{ $lbl }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn-submit-auction">
                                <i class="fas fa-{{ isset($item) ? 'floppy-disk' : 'plus' }}"></i>
                                {{ isset($item) ? 'Update Auction' : 'Create Auction' }}
                            </button>
                            <a href="{{ route('ngo.auction.index') }}" class="btn btn-outline-secondary px-3">Cancel</a>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>


    <script>
        // ── Image previews ─────────────────────────────
        const imgInput = document.getElementById('imagesInput');
        const grid = document.getElementById('imgPreviewGrid');
        const dropZone = document.getElementById('imgDropZone');
        let selectedFiles = [];

        imgInput.addEventListener('change', handleFiles);

        ['dragenter', 'dragover'].forEach(ev =>
            dropZone.addEventListener(ev, e => {
                e.preventDefault();
                dropZone.classList.add('dragover');
            }));
        ['dragleave', 'drop'].forEach(ev =>
            dropZone.addEventListener(ev, e => {
                e.preventDefault();
                dropZone.classList.remove('dragover');
            }));
        dropZone.addEventListener('drop', e => {
            const dt = new DataTransfer();

            [...imgInput.files].forEach(file => dt.items.add(file));
            [...e.dataTransfer.files].forEach(file => dt.items.add(file));

            imgInput.files = dt.files;
            handleFiles();
        });

        function handleFiles() {
            selectedFiles = Array.from(imgInput.files);
            grid.innerHTML = '';
            selectedFiles.forEach((file, i) => {
                const reader = new FileReader();
                reader.onload = ev => {
                    const div = document.createElement('div');
                    div.className = 'img-preview-item';
                    div.innerHTML = `<img src="${ev.target.result}" alt="Preview">
                             <button type="button" class="remove-img" onclick="removePreview(${i})">
                                 <i class="fas fa-times"></i>
                             </button>`;
                    grid.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }

        function removePreview(i) {
            const dt = new DataTransfer();
            selectedFiles.splice(i, 1);
            selectedFiles.forEach(f => dt.items.add(f));
            imgInput.files = dt.files;
            handleFiles();
        }

        // ── Quick duration setter ──────────────────────
        function setDuration(days) {
            const startEl = document.querySelector('[name="auction_start"]');
            const endEl = document.querySelector('[name="auction_end"]');
            const startVal = startEl.value;
            if (!startVal) {
                alert('Please set the start date first.');
                return;
            }
            const start = new Date(startVal);
            start.setDate(start.getDate() + days);
            const pad = n => String(n).padStart(2, '0');
            const fmt = d =>
                `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
            endEl.value = fmt(start);
        }
    </script>
@endsection
