@extends('home.layout.MasterLayout')
@Section('content')

<div class="wrapper">
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h4>📌 नोटिस बोर्ड</h4>
            </div>
            <div class="card-body">
                <h5 class="text-danger">🔔 महत्वपूर्ण सूचना</h5>
                <p class="fs-5">
                    <strong>दिनांक:</strong> <span class="text-primary">31 मार्च 2025</span><br>
                    <strong>संस्था का नाम:</strong> <span class="text-success">ज्ञान भारती संस्था</span><br>
                    <strong>सूचना:</strong> ज्ञान भारती संस्था हेड ऑफिस में वार्षिक मीटिंग होना है जिसमें सभी पदाधिकारी और सदस्यों को उपस्थित होना अनिवार्य है।
                </p>
                <p class="text-muted">- संस्था प्रशासन</p>
            </div>
        </div>
    </div>
</div>

@endsection

