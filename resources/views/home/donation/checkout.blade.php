<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashfree Checkout Integration</title>
    <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
</head>
<body>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const cashfree = Cashfree({ mode: "production" });
    
            const paymentSessionId = "{{ $sessionId ?? '' }}";
    
            if (paymentSessionId) {
                cashfree.checkout({
                    paymentSessionId: paymentSessionId,
                    redirectTarget: "_self"
                });
            } else {
                alert("No session ID found.");
            }
        });
    </script>
</body>
</html>
