<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        
        $router->render('auth/login');
        
    }
    public static function logout() {
        echo "Desde logout...";
    }
    public static function olvide(Router $router) {
        
        $router->render('auth/olvide-password', [
            
        ]);
        
    }
    public static function recuperar() {
        echo "Desde recuperar...";
    }
    public static function crear(Router $router) {

        $usuario = new Usuario;
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            //Revisar que el alertas está vacío
            if(empty($alertas)) {
                //Verificar que el usuario no esté registrado
                $resultado = $usuario->existeUsuario();

                if($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    //No está registrado, crear cuenta
                    $usuario->hashPassword();

                    //Generar un token único
                    $usuario->crearToken();

                    //Enviar el email
                    $email = new Email( $usuario->nombre,$usuario->email, $usuario->token);
                    $email->enviarConfirmacion();

                    //Crear el usuario
                    $resultado = $usuario->guardar();
                    if($resultado) {
                        header('Location: /mensaje');
                    } else {
                        $alertas = Usuario::getAlertas();
                    }
                }
            }
        }   
        $router->render('auth/crear-cuenta', [
           'usuario' => $usuario,
           'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router) {
        $router->render('auth/mensaje');
    }
}   