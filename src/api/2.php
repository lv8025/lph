<?php
    $servername = "120.53.84.119";
    $username = "root";
    $password = "123456";
    $dbname = "lvpenghui";
    $title = $_POST["title"];
     
    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "SELECT * FROM deal where moves='$title'";

    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
      $arr[]= $row;
      
    }
    echo json_encode($arr);
    ?>  