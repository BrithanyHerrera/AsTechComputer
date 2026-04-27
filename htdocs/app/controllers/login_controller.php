<?php
// ========================================================
// CONTROLADOR: login_controller.php
// UBICACIÓN: app/controllers/login_controller.php
// ========================================================
        require_once __DIR__ . "/../config/config.php"; 
// 1. Iniciamos la sesión
session_start();

// Si el usuario ya está logueado, lo mandamos directo al dashboard (AQUÍ ESTABA UN ERROR)
if (isset($_SESSION['id_empleado'])) {
    header("Location: administracion_controller.php");
    exit;
}

// 2. CARGAMOS VARIABLES DE ENTORNO PARA LA API DE META
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
try {
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
    $dotenv->load();
} catch (Exception $e) {
    // Silencioso
}

// 3. Requerimos la base de datos y el modelo
require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/login_model.php';

$modeloLogin = new LoginModel($conexion);
$mensaje_error = '';

// 4. Verificamos si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['usuario'])) {
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    if (!empty($usuario) && !empty($password)) {
        
        $empleado = $modeloLogin->buscarUsuario($usuario);

        if ($empleado) {
            if (password_verify($password, $empleado['contrasena']) || $password === $empleado['contrasena']) { 
                
                $puestos_permitidos = [1, 2, 3, 4]; 

                if (in_array($empleado['id_puesto'], $puestos_permitidos)) {
                    
                    // A. Generar código de 6 dígitos
                    $codigo_2fa = rand(100000, 999999);
                    
                    // B. Guardar datos en sesión TEMPORAL
                    $_SESSION['temp_empleado'] = $empleado;
                    $_SESSION['codigo_2fa'] = $codigo_2fa;
                    
                    // C. Enviar el código vía Meta API
                    try {
                        $token = $_ENV['META_WA_TOKEN'];
                        $phone_id = $_ENV['META_PHONE_ID'];
                        
                        $telefono_limpio = preg_replace('/[^0-9]/', '', $empleado['telefono']);
                        $telefono_destino = (strlen($telefono_limpio) == 10) ? "52" . $telefono_limpio : $telefono_limpio;

                        $url = "https://graph.facebook.com/v25.0/" . $phone_id . "/messages";

                        $data = [
                            "messaging_product" => "whatsapp",
                            "to" => $telefono_destino,
                            "type" => "template",
                            "template" => [
                                "name" => "codigo_verificacion_astech", 
                                "language" => [ "code" => "es_MX" ],
                                "components" => [
                                    [
                                        "type" => "body",
                                        "parameters" => [
                                            [ "type" => "text", "text" => (string)$codigo_2fa ]
                                        ]
                                    ]
                                ]
                            ]
                        ];

                        $options = [
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => json_encode($data),
                            CURLOPT_HTTPHEADER => [
                                "Authorization: Bearer " . $token,
                                "Content-Type: application/json"
                            ]
                        ];

                        $curl = curl_init();
                        curl_setopt_array($curl, $options);
                        curl_exec($curl);
                        curl_close($curl);

                    } catch (Exception $e) { /* Error silencioso */ }

                    // D. Redirigir a la pantalla para poner el código (AQUÍ ESTABA EL ERROR 404)
                    header("Location: ../views/acciones/verificar_2fa.php");
                    exit;

                } else {
                    $mensaje_error = "Tu puesto no tiene los permisos para acceder a esta área.";
                }
            } else {
                $mensaje_error = "Contraseña incorrecta.";
            }
        } else {
            $mensaje_error = "El usuario no existe.";
        }
    } else {
        $mensaje_error = "Por favor, llena todos los campos.";
    }
}

// Cargamos la vista del login principal
require_once dirname(__DIR__) . '/views/login_view.php';
?>