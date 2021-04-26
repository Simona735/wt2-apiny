function initWeather(city_id){
    window.myWidgetParam ? window.myWidgetParam : window.myWidgetParam = [];

    window.myWidgetParam.push({
        id: 11,
        cityid: city_id,
        appid: '6beb70f1ae5e7650aa1a45fa4580d902',
        units: 'metric',
        containerid: 'openweathermap-widget-11',
    });

    (function() {
        var script = document.createElement('script');
        script.async = true;
        script.charset = "utf-8";
        script.src = "//openweathermap.org/themes/openweathermap/assets/vendor/owm/js/weather-widget-generator.js";
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(script, s);
    })();
}