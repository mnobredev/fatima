<?php
    $conn = mysqli_connect("localhost", "jp1tz980_mnobre", "01IqX8r19wXH");
    if(!$conn)
    {
            die("Erro".mysqli_connect_error());
    }
    mysqli_select_db($conn, "jp1tz980_fatima");
?>