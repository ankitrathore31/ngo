@extends('home.layout.MasterLayout')

@section('content')
    <!-- Include Animate.css (via CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <div class="wrapper mt-4">
        <!-- Breadcrumb -->
        <div class="row d-flex justify-content-end">
            <div class="col-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Registration</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if (session('success'))
            <div id="printCard" class="card shadow-lg p-4 animate__animated animate__fadeInUp">
                <div class="card-body">
                    <h4 class="card-title text-success mb-3">✅ Registration Successful</h4>
                    <p class="card-text">{{ session('success') }}</p>

                    <div class="mt-3">
                        <p><strong>📅 Date of Submission:</strong> {{ now()->format('d M Y, h:i A') }}</p>
                        <p><strong>📥 Next Steps:</strong> Please wait while we review your application. You will receive a confirmation once approved.</p>

                        @if (session('application_number'))
                            <p><strong>📄 Application Number:</strong>
                                <span class="text-primary h5">{{ session('application_number') }}</span>
                            </p>
                        @endif
                    </div>

                    <div class="mt-4 text-end">
                        <button class="btn btn-outline-primary" onclick="printCard()">🖨 Print This Confirmation</button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- JavaScript to print only the card -->
    <script>
        function printCard() {
            const printContents = document.getElementById('printCard').innerHTML;
            const originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload(); // Reload to restore JS behavior
        }
    </script>
@endsection

