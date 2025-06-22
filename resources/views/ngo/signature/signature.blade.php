@extends('ngo.layout.master')

@section('content')
    <div class="wrapper">
        <div class="d-flex justify-content-between align-items-center mb-2 mt-3">
            <h5 class="mb-0">Signature</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Signature</li>
                </ol>
            </nav>
        </div>

        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="container mt-4">
            <!-- Upload Form -->
            <div class="card p-3 rounded mb-4">
                <form action="{{ route('save-signature') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="signature_pm" class="form-label">Program Manager Signature:</label>
                        <input type="file" name="signature_pm" class="form-control" id="signature_pm" accept="image/*">
                        <img id="preview_pm" src="#" alt="Preview" class="img-thumbnail mt-2"
                            style="max-width: 200px; display: none;">
                    </div>

                    <div class="mb-3">
                        <label for="signature_director" class="form-label">Director Signature:</label>
                        <input type="file" name="signature_director" class="form-control" id="signature_director"
                            accept="image/*">
                        <img id="preview_director" src="#" alt="Preview" class="img-thumbnail mt-2"
                            style="max-width: 200px; display: none;">
                    </div>

                    <button type="submit" class="btn btn-success">Save Signatures</button>
                </form>
            </div>

            <!-- Preview of Saved Signatures -->
            @if ($signatures->count())
                <div class="card p-3 rounded mb-4">
                    <h5 class="mb-3">Uploaded Signatures</h5>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 fw-bold">Program Manager:</p>
                            @if (!empty($signatures['program_manager']))
                                <img src="{{ asset($signatures['program_manager']) }}" alt="Program Manager Signature"
                                    class="img-thumbnail" style="max-width: 200px;">
                            @else
                                <p class="text-muted">No signature uploaded.</p>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <p class="mb-1 fw-bold">Director:</p>
                            @if (!empty($signatures['director']))
                                <img src="{{ asset($signatures['director']) }}" alt="Director Signature"
                                    class="img-thumbnail" style="max-width: 200px;">
                            @else
                                <p class="text-muted">No signature uploaded.</p>
                            @endif
                        </div>
                    </div>

                </div>
            @endif
        </div>
    </div>
@endsection


<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = () => {
                preview.src = reader.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    }

    document.getElementById('signature_pm').addEventListener('change', function() {
        previewImage(this, 'preview_pm');
    });

    document.getElementById('signature_director').addEventListener('change', function() {
        previewImage(this, 'preview_director');
    });
</script>
