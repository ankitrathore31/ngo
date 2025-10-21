@extends('ngo.layout.master')
@section('content')
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                margin: 0;
                padding: 0;
                background: white !important;
            }

            .container-fluid {
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
            }

            .form-container {
                box-shadow: none !important;
                border: 2px solid #000 !important;
                margin: 10mm !important;
                padding: 15mm !important;
                page-break-after: auto;
            }

            * {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            @page {
                size: A4;
                margin: 0;
            }
             html,
            body {
                margin: 0 !important;
                padding: 0 !important;
                height: 100% !important;
                width: 100% !important;
            }

            body * {
                visibility: hidden;
            }

            .printarea,
            .printarea * {
                visibility: visible;
            }
        }

        body {
            background: #f5f5f5;
        }



        .form-header {
            text-align: center;
            border: 2px solid #000;
            padding: 15px;
            margin-bottom: 20px;
        }

        .form-header img {
            max-height: 80px;
            margin-bottom: 10px;
        }

        .form-header h4 {
            margin: 5px 0;
            font-size: 18pt;
            font-weight: bold;
        }

        .form-header h6 {
            margin: 3px 0;
            font-size: 11pt;
        }

        .form-header p {
            margin: 3px 0;
            font-size: 10pt;
        }

        .form-title {
            text-align: center;
            font-size: 16pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 20px 0;
            text-transform: uppercase;
        }

        .form-reference {
            text-align: right;
            margin-bottom: 15px;
            font-size: 11pt;
        }

        table.form-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.form-table th {
            background: #f0f0f0;
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11pt;
        }

        table.form-table td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 11pt;
        }

        table.form-table td.label {
            width: 35%;
            font-weight: 600;
            background: #fafafa;
        }

        table.form-table td.value {
            width: 65%;
        }

        .section-heading {
            background: #000;
            color: white;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 12pt;
            margin-top: 15px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .declaration-box {
            border: 1px solid #000;
            padding: 12px;
            margin: 20px 0;
            font-size: 10pt;
            background: #f9f9f9;
        }

        .declaration-box strong {
            display: block;
            margin-bottom: 8px;
            font-size: 11pt;
        }

        .signature-section {
            margin-top: 40px;
            display: table;
            width: 100%;
        }

        .signature-box {
            display: table-cell;
            text-align: center;
            vertical-align: bottom;
            padding: 10px;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 60px;
            padding-top: 5px;
            font-weight: bold;
            font-size: 10pt;
        }

        .signature-box small {
            display: block;
            font-size: 9pt;
            color: #666;
            margin-top: 3px;
        }

        .footer-note {
            text-align: center;
            font-size: 9pt;
            color: #666;
            border-top: 1px solid #000;
            padding-top: 10px;
            margin-top: 20px;
        }

        .badge-info {
            display: inline-block;
            margin: 2px 5px;
            font-size: 9pt;
        }

        @media screen {
            .btn-actions {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 1000;
                background: white;
                padding: 10px;
                border-radius: 5px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            }
        }

        .btn-print-simple {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 25px;
            margin: 5px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-print-simple:hover {
            background: #218838;
        }

        .btn-back-simple {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 25px;
            margin: 5px;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
        }

        .btn-back-simple:hover {
            background: #5a6268;
            color: white;
        }
    </style>

    <div class="container-fluid">
        <!-- Print Buttons -->
        <div class="no-print ">
            <button onclick="window.print()" class="btn-print-simple">
                <i class="fa fa-print"></i> Print
            </button>
            <a href="{{ route('survey.list') }}" class="btn-back-simple">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="form-container m-3 printarea">
           

            <!-- Form Title -->
            <div class="form-title">Beneficiary Survey Form</div>

            <!-- Reference Number -->
            <div class="form-reference">
                <strong>Survey ID:</strong> {{ $survey->survey_id }} |
                <strong>Date:</strong> {{ \Carbon\Carbon::parse($survey->date)->format('d/m/Y') }}
            </div>

            <!-- Survey Information -->
            <div class="section-heading">1. Animator/Survey Information</div>
            <table class="form-table">
                <tr>
                    <td class="label">Survey ID</td>
                    <td class="value">{{ $survey->survey_id }}</td>
                </tr>
                <tr>
                    <td class="label">Survey Date</td>
                    <td class="value">{{ \Carbon\Carbon::parse($survey->date)->format('d F, Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Project Code</td>
                    <td class="value">{{ $survey->project_code ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Project Name</td>
                    <td class="value">{{ $survey->project_name ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Center Name</td>
                    <td class="value">{{ $survey->center ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Session</td>
                    <td class="value">{{ $survey->session ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Animator Code</td>
                    <td class="value">{{ $survey->animator_code ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Animator Name</td>
                    <td class="value">{{ $survey->animator_name ?? '-' }}</td>
                </tr>
            </table>

            <!-- Personal Information -->
            <div class="section-heading">2. Beneficiary Personal Information</div>
            <table class="form-table">
                <tr>
                    <td class="label">Name</td>
                    <td class="value">{{ $survey->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Father/Husband Name</td>
                    <td class="value">{{ $survey->father_husband_name ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Age</td>
                    <td class="value">{{ \Carbon\Carbon::parse($survey->age)->age ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Mobile Number</td>
                    <td class="value">{{ $survey->mobile_no ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Caste</td>
                    <td class="value">{{ $survey->caste ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Caste Category</td>
                    <td class="value">{{ $survey->caste_category ?? '-' }}</td>
                </tr>
            </table>

            <!-- Identity Information -->
            <div class="section-heading">3. Beneficiary Identity Information</div>
            <table class="form-table">
                <tr>
                    <td class="label">Identity Type</td>
                    <td class="value">{{ $survey->identity_type ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Identity Card Number</td>
                    <td class="value">{{ $survey->identity_no ?? '-' }}</td>
                </tr>
            </table>

            <!-- Address Information -->
            <div class="section-heading">4.Beneficiary Address Information</div>
            <table class="form-table">
                <tr>
                    <td class="label">Village/Locality</td>
                    <td class="value">{{ $survey->address ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Post/Town</td>
                    <td class="value">{{ $survey->post_town ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Block</td>
                    <td class="value">{{ $survey->block ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">District</td>
                    <td class="value">{{ $survey->district ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">State</td>
                    <td class="value">{{ $survey->state ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Area Type</td>
                    <td class="value">{{ $survey->area_type ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Place Identification Mark</td>
                    <td class="value">{{ $survey->place_identification_mark ?? '-' }}</td>
                </tr>
            </table>

            <!-- Scheme Information -->
            <div class="section-heading">5. Beneficiary Scheme Information</div>
            <table class="form-table">
                <tr>
                    <td class="label">Scheme Type</td>
                    <td class="value"><strong>{{ $survey->beneficiaries_type ?? '-' }}</strong></td>
                </tr>

                @php
                    $schemeType = strtolower($survey->beneficiaries_type ?? '');
                @endphp

                @if (str_contains($schemeType, 'baal seva'))
                    <tr>
                        <td class="label">Class</td>
                        <td class="value">{{ $survey->class_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Person Death Date</td>
                        <td class="value">
                            {{ $survey->death_date ? \Carbon\Carbon::parse($survey->death_date)->format('d F, Y') : '-' }}
                        </td>
                    </tr>
                @elseif(str_contains($schemeType, 'sumangla'))
                    <tr>
                        <td class="label">Class</td>
                        <td class="value">{{ $survey->class_name ?? '-' }}</td>
                    </tr>
                @elseif(str_contains($schemeType, 'widow'))
                    <tr>
                        <td class="label">Widow Since</td>
                        <td class="value">{{ $survey->widow_since ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Type of Victim</td>
                        <td class="value">{{ $survey->type_of_victim ?? '-' }}</td>
                    </tr>
                @elseif(str_contains($schemeType, 'victim') || str_contains($schemeType, 'pidit'))
                    <tr>
                        <td class="label">Type of Victim</td>
                        <td class="value">{{ $survey->type_of_victim ?? '-' }}</td>
                    </tr>
                @elseif(str_contains($schemeType, 'disabilities') || str_contains($schemeType, 'viklang'))
                    <tr>
                        <td class="label">Disability Percentage</td>
                        <td class="value">{{ $survey->disability_percentage ?? '-' }}%</td>
                    </tr>
                @elseif(str_contains($schemeType, 'labour card'))
                    <tr>
                        <td class="label">Labour Card Number</td>
                        <td class="value">{{ $survey->labour_card_no ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Labour Card Date</td>
                        <td class="value">
                            {{ $survey->labour_card_date ? \Carbon\Carbon::parse($survey->labour_card_date)->format('d F, Y') : '-' }}
                        </td>
                    </tr>
                @elseif(str_contains($schemeType, 'farmer'))
                    <tr>
                        <td class="label">Land (in Beegah)</td>
                        <td class="value">{{ $survey->land ?? '-' }}</td>
                    </tr>
                @else
                    <tr>
                        <td class="label">Remark</td>
                        <td class="value">{{ $survey->remark ?? '-' }}</td>
                    </tr>
                @endif
            </table>

            <!-- Declaration -->
            <div class="declaration-box">
                <strong>Declaration:</strong>
                I hereby declare that all the information provided above is true and correct to the best of my knowledge and
                belief.
                I understand that any false information may lead to cancellation of benefits under the scheme.
            </div>

            <!-- Signatures -->
            <div class="signature-section">
                <div class="signature-box">
                    <div class="signature-line">Beneficiary Signature</div>
                    <small>Date: __________</small>
                </div>
                <div class="signature-box">
                    <div class="signature-line">Animator Signature</div>
                    <small>{{ $survey->animator_name }}</small>
                </div>
                <div class="signature-box">
                    <div class="signature-line">Authorized Officer</div>
                    <small>(Stamp & Signature)</small>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer-note">
                This is a computer-generated document. Generated on {{ now()->format('d/m/Y h:i A') }}
            </div>
        </div>
    </div>
@endsection
