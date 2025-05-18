<?php
include("common/connection.php");

?>

<!DOCTYPE html>
<html lang="en">
<!-- Koi value input krne se rh gayi mujhse tum input klaro aur aage se jo bhi value db ke liye jkarurui ho unme fronted se hi required laga diya karo
     required mana kr diya hai lagane ko without info pay kr skta donor theek hai amount to bharega hi agar required nahi hai to db mein saari value null kar do nahi to eeror aata rahega -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashfree Checkout Integration</title>
    <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
</head>

<body>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const cashfree = Cashfree({
                mode: "production",
            });

            const urlParams = new URLSearchParams(window.location.search);
            const paymentSessionId = urlParams.get("session_id");

            if (paymentSessionId) {
                cashfree.checkout({
                    paymentSessionId: paymentSessionId,
                    redirectTarget: "_self"
                });
            }
        });
    </script>

</body>

</html>