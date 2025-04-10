<?php
    include("common/connection.php");
    // connecttion lagao
    $donor_name        = !empty($_POST['donor_name']) ? $_POST['donor_name'] : '';
    $donor_email       = !empty($_POST['donor_email']) ? $_POST['donor_email'] : '';
    $donor_number      = !empty($_POST['donor_number']) ? $_POST['donor_number'] : '';
    $donor_country     = !empty($_POST['donor_country']) ? $_POST['donor_country'] : '';
    $donor_state       = !empty($_POST['donor_state']) ? $_POST['donor_state'] : '';
    $donor_district    = !empty($_POST['donor_district']) ? $_POST['donor_district'] : '';
    $donor_post        = !empty($_POST['donor_post']) ? $_POST['donor_post'] : '';
    $donor_pincode     = !empty($_POST['donor_pincode']) ? $_POST['donor_pincode'] : '';
    $donor_village     = !empty($_POST['donor_village']) ? $_POST['donor_village'] : '';
    $donation_category = !empty($_POST['donation_category']) ? $_POST['donation_category'] : '';
    $donor_remark      = !empty($_POST['donor_remark']) ? $_POST['donor_remark'] : '';
    $donation_amount   = !empty($_POST['donation_amount']) ? $_POST['donation_amount'] : '';
    $donation_date     = date('Y-m-d');
    

    
    $donate_date = date('Y-m-d');

    // Prepare SQL query
    $query = "INSERT INTO donor_data 
        (donor_name, donor_email, donor_number, donor_country, donor_state, 
        donor_district, donor_post, donor_pincode, donor_village, donation_category, 
        donation_remark, donation_amount, donate_date) 
        VALUES (
            '$donor_name', '$donor_email', '$donor_number', '$donor_country',
            '$donor_state', '$donor_district', '$donor_post', '$donor_pincode',
            '$donor_village', '$donation_category', '$donation_remark', '$donation_amount',
            '$donate_date'
        )";
       
    // Run query chal gaya code h 
    $result = mysqli_query($db, $query);
    $inserted_id = mysqli_insert_id($db);
   


// Cashfree Sandbox Credentials
$apiKey = "94308161032e16f494fbf7e96a180349";         // Replace with your TEST Client ID
$secretKey = "cfsk_ma_prod_364ee546c89ef58263a4c205b60bf681_76335508";   // Replace with your TEST Client Secret
$apiVersion = "2025-01-01";            // Recommended stable version yaha change hoga version

// API Endpoint (Test) url hi dund rah tha mil nahi raha tha production ka
$url = "https://api.cashfree.com/pg/orders";

function randomAlphaString($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

$data = [
    "order_currency" => "INR",
    "order_amount" => $donation_amount,
    "customer_details" => [
        "customer_id" => randomAlphaString(12), 
        "customer_phone" => $donor_number,
        "customer_name" => $donor_name,
        "customer_email" => $donor_email,
    ],
    "order_meta" => [ 
        "return_url" => "https://gyanbhartingo.org/payment-success.php?id=" . $inserted_id,
    ]
];


$payload = json_encode($data);

$headers = [
    "Content-Type: application/json",
    "x-api-version: $apiVersion",
    "x-client-id: $apiKey",
    "x-client-secret: $secretKey"
];

// cURL call
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);

// Execute request
$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);
// var_dump($response);
// exit();
$res = json_decode($response, true);


if($response){
    $res = json_decode($response, true);
    $orderId = $res['order_id'];
    $sessionId = $res['payment_session_id'];

    $updateQuery = "UPDATE donor_data SET order_id = '$orderId' WHERE id = $inserted_id";
    $updateResult = mysqli_query($db, $updateQuery);
    header("Location: checkout.php?session_id=$sessionId");
    exit;
}

