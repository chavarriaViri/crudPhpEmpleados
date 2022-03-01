//Variable donde almacena el archivo de rutas para la peticion ajax
switch (location.hostname){
    case 'empleadossoftura.000webhostapp.com':
        var URL_BACKEND = 'https://empleadossoftura.000webhostapp.com/softura_solution/mvc/backend/rutas.php?';
        break;
    default:
        var URL_BACKEND = 'http://localhost/softura_solution/mvc/backend/rutas.php?';       
         break;
}
