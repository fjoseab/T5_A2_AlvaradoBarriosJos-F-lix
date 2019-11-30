<?php

    if ( $conexion=mysqli_connect('localhost','root','','usuarios_escuela_web') ) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            //recibir info a travez de HTTP, uuna cadena JSON
            $cadena_JSON = file_get_contents('php://input');
            
            //Retorna un vector asociativo.
            $datos = json_decode($cadena_JSON, true);

            $user = $datos['user'];
            $password = $datos['password'];

            $u = sha1($user);
            $p = sha1($password);

            $sql = "SELECT * FROM usuarios WHERE nombre_usuario='$u' AND contrasena='$p'";
            $res = mysqli_query($conexion, $sql);

            $respuesta = array();

            if (mysqli_num_rows($res)==1) {
                $respuesta['exito'] = 1;
                $respuesta['mensaje'] = "Acceso conseguido";
                echo json_encode($respuesta);
            } else {
                $respuesta['exito'] = 0;
                $respuesta['mensaje'] = "Acceso Denegado.";
                echo json_encode($respuesta);
            }

        }
    } else {
        die("Error en conexion: ".mysqli_connect_errno());
    }

?>