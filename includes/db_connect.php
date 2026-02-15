<?php
// includes/db_connect.php

$serverName = "SARMAD";
$database = "HospitalDB";


try {
    if (empty($username)) {
        $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;TrustServerCertificate=true");
    } else {
        $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;TrustServerCertificate=true", $username, $password);
    }
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    try {
        $connectionString = "Driver={SQL Server};Server=$serverName;Database=$database;";
        if (!empty($username)) {
            $connectionString .= "Uid=$username;Pwd=$password;";
        }
        $conn = new PDO("odbc:$connectionString");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e2) {
        die("Connection failed: " . $e->getMessage());
    }
}
?>
