<?php

include("common/connection.php");
// Cashfree Sandbox Credentials
$apiKey = "94308161032e16f494fbf7e96a180349";         // Replace with your TEST Client ID
$secretKey = "cfsk_ma_prod_364ee546c89ef58263a4c205b60bf681_76335508";   // Replace with your TEST Client Secret
$apiVersion = "2025-01-01";            // Recommended stable version

$id = $_GET['id'] ?? null;

$selectQuery = "SELECT * FROM donor_data WHERE id = $id";
$result = mysqli_query($db, $selectQuery);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    $order_id = $row['order_id'];

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.cashfree.com/pg/orders/$order_id",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "x-api-version: $apiVersion",
            "x-client-id: $apiKey",
            "x-client-secret: $secretKey",
            "Content-Type: application/json",
            "Accept: application/json"
        ],
    ]);

    $response = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);

    if ($error) {
        echo "cURL Error: $error";
    } else {
        // Decode JSON response
        $data = json_decode($response, true);
        $order_status = $data['order_status'];

        $updateQuery = "UPDATE donor_data SET payment_status = '$order_status' WHERE id = '$id'";
        $updateResult = mysqli_query($db, $updateQuery);
        
        if ($order_status == 'PAID') {
            header("Location: pay.php?status=success"); 
        
            exit();
        } else {
            header("Location: pay.php?status=error");
            exit();
        }
    }
}

//  Baaki page sahi kr lena bas th  live par check karna hai ha

?>
