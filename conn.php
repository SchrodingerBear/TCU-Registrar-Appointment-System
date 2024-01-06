<?php

function connect()
{
    $conn = new mysqli("localhost", "root", "", "tcuregistrar");
    if (!$conn) die("Database is being upgrade!");
    return $conn;
}
$conn = connect();
if (!$conn) die("Under Construction!");

