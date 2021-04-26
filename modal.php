<?php
require_once "Database.php";

$conn = (new Database())->getConnection();

if (isset($_POST["stateId"])){
    $state_id = intval($_POST["stateId"]);

    $stmt = $conn->query("SELECT title, `city`, COUNT(*) as count FROM `visits` JOIN state ON visits.state_id=state.id WHERE state_id=".$state_id." GROUP BY city");
    $cities = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($cities, [$row["title"], $row["city"],  $row["count"]]);
    }

    echo json_encode($cities);
}else{
    echo "error";
}
