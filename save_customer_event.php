<?php
require 'database_connection.php';

class Str
{
    public static function random($length)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$figma = $_POST['figma'];
$price = $_POST['price'];

$figma_file = null;
if (!empty($_FILES['figma_file']['name'])) {
    $file = $_FILES['figma_file'];
    $randomSTR = Str::random(30);
    $filename = $randomSTR . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
    move_uploaded_file($file['tmp_name'], 'uploads/images/' . $filename);
    $figma_file = $filename;
}

$created_at = new DateTime('now', new DateTimeZone('Asia/Karachi'));
$created_at = $created_at->format('Y-m-d H:i:s');

$insert_query = "INSERT INTO `event_customer`(`name`,`email`,`phone`,`figma`, `price`, `figma_file`,`created_at`) VALUES ('$name','$email','$phone','$figma', '$price', '$figma_file','$created_at')";
$query_result = mysqli_query($con, $insert_query);

// Fetch the last inserted ID if the query was successful
$last_inserted_id = mysqli_insert_id($con);

$data = [
    'status' => $query_result ? true : false,
    'msg' => $query_result ? 'Event added successfully!' : 'Sorry, Event not added.',
    'id' => $query_result ? $last_inserted_id : null // Return the inserted ID if successful
];

echo json_encode($data);
