function setCookie() {
    var d = new Date();
    d.setTime(d.getTime() + timeUntilMidnight());
    var expires = "expires="+d.toUTCString();
    document.cookie = "dataApproval=accepted;" + expires + ";path=/";
    initPageContent();
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie() {
    var approval = getCookie("dataApproval");
    return approval !== "";
}

function timeUntilMidnight() {
    var now = new Date();
    var then = new Date(now);
    then.setHours(24, 0, 0, 0);
    return then - now;
}

function infoRow(title, data){
    let tr = document.createElement("tr");
    let th = document.createElement("th");
    th.append(title);

    tr.append(th);
    tr.append(getCellTD(data));
    return tr;
}

function rowDraw(value){
    let tr = tableRow(value[0]);

    tr.append(getImgCell(value[1], value[2]));
    tr.append(getCellTD(value[2]));
    tr.append(getCellTD(value[3]));
    tr.append(getCellTD(value[4]));
    return tr;
}

function getCellTD(infoData){
    let td = document.createElement("td");
    td.append(infoData);
    return td;
}

function getImgCell(url, data){
    let td = document.createElement("td");
    let img = document.createElement("img");
    img.setAttribute("src", url);
    img.setAttribute("alt", data + " flag");
    img.setAttribute("height", "20px");

    td.append(img);
    return td;
}


function tableRow(linkData){
    let tr = document.createElement("tr");
    tr.setAttribute("data-state", linkData );
    tr.setAttribute("data-bs-toggle", "modal");
    tr.setAttribute("data-bs-target", "#stateDetail");
    return tr;
}

function modalTableRow(value1, value2){
    let tr = document.createElement("tr");
    let td1 = document.createElement("td");
    let td2 = document.createElement("td");
    td1.append(value1);
    td2.append(value2);
    tr.append(td1);
    tr.append(td2);
    return tr;
}