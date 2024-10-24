<?php
require 'database_connection.php';
$event_name = $_POST['event_name'];
$customer_id = $_POST['customer_id'];
$event_start_date = date("y-m-d", strtotime($_POST['event_start_date']));
$event_end_date = date("y-m-d", strtotime($_POST['event_end_date']));

$insert_query = "INSERT INTO `event_calendar`(`event_name`, `customer_id`,`event_start_date`,`event_end_date`) VALUES ('{$event_name}', '{$customer_id}', '{$event_start_date}', '{$event_end_date}')";

$query_result = mysqli_query($con, $insert_query);
$last_inserted_id = mysqli_insert_id($con);

$data = [
    'status' => $query_result ? true : false,
    'msg' => $query_result ? 'Event added successfully!' : 'Sorry, Event not added.',
    'id' => $query_result ? $last_inserted_id : null // Return the inserted ID if successful
];

echo json_encode($data);

