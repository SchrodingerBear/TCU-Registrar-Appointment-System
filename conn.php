<?php

function connect()
{
    $conn = new mysqli("localhost", "u467106394_tcu", "p+o|Jh7T", "u467106394_tcu");
    if (!$conn) die("Database is being upgrade!");
    return $conn;
}
$conn = connect();
if (!$conn) die("Under Construction!");

