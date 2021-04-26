function initMap(coordinates) {
    const center = { lat: 48.14, lng: 17.10 };
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 3,
        center: center,
    });
    coordinates.forEach(item => {
        new google.maps.Marker({
            position: {
                lat: parseFloat(item[0]),
                lng: parseFloat(item[1])
            },
            map: map,
        });
    });
}