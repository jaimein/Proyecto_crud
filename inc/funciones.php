<?php

function sec_session_start() {
    $session_name = 'sec_session_id';   //Asignamos un nombre de sesión
    $secure = false; //mejor en config.php  Lo ideal sería true para trabajar con https
    $httponly = true;
    // Obliga a la sesión a utilizar solo cookies.
    // Habilitar este ajuste previene ataques que impican pasar el id de sesión en la URL.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        $accion = "error";
        $error="No puedo iniciar una sesion segura (ini_set)";
    }
    // Obtener los parámetros de la cookie de sesión
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"],
            $cookieParams["domain"],
            $secure, //si es true la cookie sólo se enviará sobre conexiones seguras
            $httponly);  //Marca la cookie como accesible sólo a través del protocolo HTTP. 
    //Esto siginifica que la cookie no será accesible por lenguajes de script, tales como JavaScript. 
    //Este ajuste puede ayudar de manera efectiva //a reducir robos de indentidad a través de ataques
    session_name($session_name);
    session_start();            // Incia la sesión PHP
    session_regenerate_id(true);  // Actualiza el id de sesión actual con uno generado más reciente  
    //Ayuda a evitar ataques de fijación de sesión
}
                                //Ayuda a evitar ataques de fijación de sesión
}
