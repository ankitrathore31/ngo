@extends('home.layout.MasterLayout')
@Section('content')
    <style>
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            border-radius: 16px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .header-title {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .language-switcher {
            max-width: 200px;
        }
    </style>

    <div class="container py-5">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="header-title" id="page-title">पात्रता श्रेणियाँ</h1>
                <select id="languageSelect" class="form-select language-switcher" onchange="changeLanguage(this.value)">
                    <option value="hindi" selected>हिंदी</option>
                    <option value="english">English</option>
                </select>
            </div>

            <ul id="categoriesList" class="list-group list-group-flush">
                <!-- Categories will appear here -->
            </ul>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->

    <!-- Language Switch Script -->
    <script>
        const categories = {
            hindi: [
                "1. बेघर परिवार",
                "2. कच्चे या एक कमरे वाले मकानों में रहने वाले लोग",
                "3. विधवा",
                "4. विकलांग",
                "5. तलाकशुदा",
                "6. भूमिहीन",
                "7. आर्थिक रूप से कमजोर लोग",
                "8. मजदूर",
                "9. अनुसूचित जन जाति",
                "10. अनुसूचित जाति",
                "11. निम्न आय के आधार पर",
                "12. पीड़ित लोग",
                "13. सीमांत किसान",
                "14. लघु किसान",
                "15. बड़े किसान",
                "16. बुजुर्ग व्यक्ति"
            ],
            english: [
                "1. Homeless Families",
                "2. People living in kutcha or one-room houses",
                "3. Widow",
                "4. Handicapped",
                "5. Divorced",
                "6. Landless",
                "7. Economically Weaker Section",
                "8. Laborers",
                "9. Scheduled Tribes",
                "10. Scheduled Castes",
                "11. Based on Low Income",
                "12. Affected People",
                "13. Marginal Farmers",
                "14. Small Farmers",
                "15. Large Farmers",
                "16. Old Age Person"
            ]
        };

        const pageTitles = {
            hindi: "पात्रता श्रेणियाँ",
            english: "Beneficiarie Eligibility Categories"
        };

        function changeLanguage(lang) {
            const list = document.getElementById('categoriesList');
            const title = document.getElementById('page-title');

            list.innerHTML = ''; // Clear current list
            title.textContent = pageTitles[lang]; // Set heading

            categories[lang].forEach(text => {
                const li = document.createElement('li');
                li.className = "list-group-item";
                li.textContent = text;
                list.appendChild(li);
            });
        }

        // Load default language
        window.onload = () => {
            changeLanguage('hindi');
        };
    </script>
@endsection
