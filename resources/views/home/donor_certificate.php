<?php
include("common/layout.php");
?>
<style>
    .certificate {
            width: 80%;
            height: 600px;
            background-image: url('assets/images/border.png');
            background-size: 100% 100%; /* Ensures full display of the border image */
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 50px;
            position: relative;
        }
        .content {
            background: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 10px;
            width: 80%;
        }

    .print-btn {
        margin-top: 20px;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
    }
    @media print {
            body {
                display: block;
                background: none;
            }
            .certificate {
                width: 100%;
                height: 100vh;
                background-image: url('assets/images/border.png');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                page-break-before: always;
            }
            .print-btn {
                display: none;
            }
        }
</style>
<div class="wrapper">
    <div class="container-fluid">
        <div class="card d-flex justify-content-center">
            <div class="card-header">
                <div class="card-title text-center">
                    Donor Certificate
                </div>
            </div>
            <div class="card-body m-2 text-center " id="certt">
                <div class="certificate" id="certificate">
                    <div class="content">
                        <h1>Certificate of Appreciation</h1>
                        <p>This certificate is proudly presented to</p>
                        <h2>[Recipient's Name]</h2>
                        <p>In recognition of outstanding dedication and contribution to our NGO.</p>
                        <p><strong>Date:</strong> [Date]</p>
                        <p><strong>Authorized Signatory:</strong> [Signature]</p>
                    </div>
                </div>
                <button class="print-btn" onclick="printCertificate()">Print Certificate</button>
            </div>
        </div>
    </div>
</div>
<script>
    function printCertificate() {
        let printContents = document.getElementById('certt').innerHTML;
        let originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
<?php
include("common/footer.php");
?>