<?php

include "database.php";

$obj = new Database();

$event_name = $_POST['event_name'];
$event_start_date = date("y-m-d", strtotime($_POST['event_start_date']));
$event_end_date = date("y-m-d", strtotime($_POST['event_end_date']));

// $insert_query = "insert into `calendar_event_master` (` event_name`, `event_start_date`, `event_end_date`) values ('".$event_name."','".
// $event_start_date. $event_end_date."')";

$insert_query1 = $obj->insert('calendar_event_master', array('event_name' => $event_name, 'event_start_date' => $event_start_date, 'event_end_date' => $event_end_date));

if (mysqli_query($con, $insert_query)) {
    $data = [
        'status' => true,
        'msg' => 'Event added successfully!'
    ];
} else {
    $data = [
        'status' => false,
        'msg' => 'Sorry, Event not added. '
    ];
    echo json_encode($data);
}