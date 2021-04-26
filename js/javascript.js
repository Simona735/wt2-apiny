$(document).ready(function () {
    if (!checkCookie()){
        $("#acceptModal").modal("toggle");
    }else{
        initPageContent();
    }

    $('#acceptModal').on('hidden.bs.modal', function () {
        setCookie();
    })

    $('#stateDetail').on('show.bs.modal', function(e) {
        var stateId = $(e.relatedTarget).data('state');
        $.post(
            "modal.php",
            {stateId: stateId.toString()},
            function(result){
                let json = $.parseJSON(result);

                $('#stateDetailLabel').html(json[0][0]);
                var tableModal = $('#modalTableBody');
                tableModal.empty();
                $.each( json, function( key, value ) {
                    tableModal.append(modalTableRow(value[1], value[2]));
                });
            }
        );
    });
});

function getPageLocation(){

    let str = window.location.pathname;
    let res = str.split("/");
    let item = (res[2]).split(".");
    console.log(item[0]);
    return item[0];
}

function initPageContent(){
    //set timezone and increment page visit counter
    ajaxPost({function: "timezone", page: getPageLocation()}, null);


    if(!getPageLocation().localeCompare("index"))    //load index page elements
        ajaxPost({function: "weatherInfo"}, buildWeather);
    if(!getPageLocation().localeCompare("info"))     //load info page elements
        ajaxPost({function: "infoData"}, buildInfoTable);
    if(!getPageLocation().localeCompare("statistics"))initStatistics();  //load statistics page elements
}

function initStatistics(){
    //init states table
    ajaxPost({function: "statesData"}, buildStatesTable);
    //fill subpages count table
    ajaxPost({function: "subpagesData"}, buildSubpagesTable);
    //fill interval table
    ajaxPost({function: "intervalData"}, buildIntervalTable);
    //fill Map
    ajaxPost({function: "coordinatesData"}, buildMap);
}

function buildWeather(response){
    var weatherData = JSON.parse(response);
    initWeather(weatherData["city"]["id"]);
}

function buildInfoTable(response){
    var tableInfo = $('#infoTableBody');
    tableInfo.empty();
    var infoData = JSON.parse(response);
    infoTableFill(tableInfo, infoData);
}

function infoTableFill(tableInfo, infoData){
    tableInfo.append(infoRow("IP address:", infoData["ip"]));
    tableInfo.append(infoRow("GPS coordinates:", "lat: "+infoData["latitude"]+"\nlong: "+infoData["longitude"]));
    tableInfo.append(infoRow("City:", infoData["city"]));
    tableInfo.append(infoRow("State:", infoData["country_name"]));
    tableInfo.append(infoRow("Capital:", infoData["location"]["capital"]));
}

function buildStatesTable(response){
    var tableStates = $('#statesBody');
    tableStates.empty();
    var statesData = JSON.parse(response);

    $.each( statesData, function( key, value ) {
        tableStates.append(rowDraw(value));
    });
}

function buildMap(response){
    initMap(JSON.parse(response));
}

function buildSubpagesTable(response){
    var tableSubpages = $('#pagesVisitsBody');
    tableSubpages.empty();
    var subpagesData = JSON.parse(response);
    $.each( subpagesData, function( key, value ) {
        tableSubpages.append(infoRow(value[0], value[1]));
    });
}

function buildIntervalTable(response){
    var tableInterval = $('#intervalsBody');
    tableInterval.empty();
    var intervalData = JSON.parse(response);
    $.each( intervalData, function( key, value ) {
        tableInterval.append(infoRow(value[0], value[1]));
    });
}

function ajaxPost(data, functionName){
    $.ajax({
        url: "APIController.php",
        type: "post",
        data: data,
        success: functionName
    });
}







