<?php
require_once 'config.php';
require_once 'Database.php';

$ip_addr = $_SERVER['REMOTE_ADDR'];
$conn = (new Database())->getConnection();

if (isset($_POST["function"])){
    if($_POST["function"] === "timezone"){
        setTimezone();
        if (isset($_POST["page"])){
            addSubpageCountByName($_POST["page"]);
        }
        echo "success";
    }
    if($_POST["function"] === "weatherInfo"){
        echo json_encode(getWeatherData());
    }

    if($_POST["function"] === "infoData"){
        echo json_encode(getInfoData());
    }

    if($_POST["function"] === "statesData"){
        echo json_encode(getStates());
    }

    if($_POST["function"] === "intervalData"){
        echo json_encode(getIntervals());
    }

    if($_POST["function"] === "subpagesData"){
        echo json_encode(getSubpagesVisits());
    }
    if($_POST["function"] === "coordinatesData"){
        echo json_encode(getAllCoordinates());
    }
}



function curlCall($url){
    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($curl);
    curl_close($curl);
    return json_decode($output);
}

function setTimezone(){
    global $ip_addr;
    $ip_api = curlCall("http://ip-api.com/json/".$ip_addr);
    date_default_timezone_set($ip_api->timezone);
}


function getInfoData(){
    global $ip_addr;
    return curlCall("http://api.ipstack.com/".$ip_addr."?access_key=".IPSTACK_API);
}

function getWeatherData(){
    $infoData = getInfoData();
    return curlCall("api.openweathermap.org/data/2.5/forecast?q=".$infoData->city.",".$infoData->country_code."&appid=".WEATHER_API);;
}

function addSubpageCountByName($page){
    global $conn;
    $conn->query("INSERT INTO `subpages_visit`(`title`) VALUES ('".$page."')");
    insertVisit();
}

function insertVisit(){
    global $conn;
    $infoData = getInfoData();

    $code = $infoData->country_code;
    $title = $infoData->country_name;
    $flag = $infoData->location->country_flag;
    $conn->query("INSERT IGNORE INTO `state`(`code`, `title`, `flag_url`) VALUES ('".$code."','".$title."','".$flag."')");

    $stmt = $conn->query("SELECT `id` FROM `state` WHERE state.code='".$code."'");
    $state_id = ($stmt->fetch(PDO::FETCH_ASSOC))["id"];
    $conn->query("INSERT IGNORE INTO `visits`(`state_id`, `ip`, `city`, `latitude`, `longitude`, `day`) VALUES (".$state_id.",'".$infoData->ip."','".$infoData->city."','".$infoData->latitude."','".$infoData->longitude."','".date("Y-m-d")."')");
}

function getAllCoordinates(){
    $query = "SELECT `latitude`, `longitude` FROM `visits`";
    return query2Param($query, "latitude", "longitude");
}

function getIntervals(){
    $intervalCase = "CASE 
        WHEN hour_table.hours>=0 AND hour_table.hours<6 THEN '0:00-6:00'
        WHEN hour_table.hours>=6 AND hour_table.hours<15 THEN '6:00-15:00'
        WHEN hour_table.hours>=15 AND hour_table.hours<21 THEN '15:00-21:00'
        ELSE '21:00-24:00' END";
    $query = "SELECT ".$intervalCase." AS time_interval, 
                        count(*) as count
    FROM 
	    (SELECT id, 
  			EXTRACT(HOUR FROM timestamp) AS hours
	    FROM subpages_visit) hour_table 
    WHERE 1=1  
    GROUP BY 
    ".$intervalCase;
    return query2Param( $query,"time_interval","count" );
}

function getSubpagesVisits(){
    $query = "SELECT title, COUNT(*) as count FROM `subpages_visit` GROUP BY title";
    return query2Param($query,"title","count");
}

function query2Param( $query, $param1, $param2){
    global $conn;
    $stmt = $conn->query($query);
    $records = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        array_push($records, [$row[$param1],$row[$param2]]);
    }
    return $records;
}

function getStates(){
    global $conn;
    $stmt = $conn->query("SELECT state.id, state.flag_url, state.code, state.title, COUNT(*) as count FROM visits JOIN state ON visits.state_id=state.id GROUP BY state.id");
    $states = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        array_push($states, [$row["id"], $row["flag_url"],$row["code"], $row["title"], $row["count"]]);
    }
    return $states;
}


