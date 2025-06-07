@extends('home.layout.MasterLayout')
@Section('content')
    <div class="wrapper">
        <div class="row d-flex justify-content-end">
            <div class="col-auto  mb-3">
                <nav aria-label="breadcrumb  bg-white">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Notice Board</li>
                    </ol>
                </nav>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
            </div>
        @endif
        <div class="container mt-5">
            <div class="text-end mb-2">
                <button onclick="printNotice()" class="btn btn-outline-dark me-2">🖨️ Print</button>
                <button onclick="shareNotice()" class="btn btn-outline-primary">📤 Share</button>
            </div>

            <div class="card shadow-lg" id="printArea">
                <div class="card border-danger border-2">
                    <div class="card-header bg-info text-white d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                        <h5 class="mb-0">Important Notice</h5>
                    </div>

                    <div class="card-body">
                        <p><strong>Date:</strong>
                            <span class="text-primary" id="noticeDate">
                                {{ $notice && $notice->date ? \Carbon\Carbon::parse($notice->date)->format('d-m-Y') : 'N/A' }}
                            </span>
                        </p>
                        <p><strong>Sanstha Name:</strong> <span class="text-danger" id="orgName">Gyan Bharti
                                Sanstha</span></p>
                        <p class="text-info"><i class="bi bi-geo-alt-fill me-1"></i><strong>Head Office:</strong> <span
                                id="officeAddress">Kainchu Tanda, Amaria, Pilibhit, UP 262121</span></p>
                        <hr>
                        <p class="fs-5"><strong>📝 Notice:</strong>
                            <br>
                            <span id="noticeText">{{ $notice->notice }}</span>
                        </p>
                        <p class="text-muted text-end fst-italic mb-0">– Gyan Bharti Sanstha</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        function printNotice() {
            const printContent = document.getElementById('printArea').innerHTML;
            const originalContent = document.body.innerHTML;

            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
            location.reload(); // Ensures styles and scripts reload
        }

        function shareNotice() {
            const date = document.getElementById('noticeDate').innerText;
            const org = document.getElementById('orgName').innerText;
            const address = document.getElementById('officeAddress').innerText;
            const notice = document.getElementById('noticeText').innerText;

            const message =
                `📌 *Important Notice*\n\n📅 Date: ${date}\n🏢 Sanstha Name: ${org}\n📍 Head Office: ${address}\n📝 Notice: ${notice}\n\n- ${org}`;

            // Encode for URL
            const encodedMessage = encodeURIComponent(message);

            // WhatsApp share (as example)
            const whatsappURL = `https://wa.me/?text=${encodedMessage}`;
            window.open(whatsappURL, '_blank');
        }
    </script>
@endsection
