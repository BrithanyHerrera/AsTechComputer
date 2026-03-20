<?php
// 1. INCLUIR CONEXIÓN Y MODELO (Ajusta la ruta si es necesario)
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/config/conexion.db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/models/dashboard_model.php';

// Iniciar sesión para saber quién está conectado (si no está iniciada ya)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. PREPARAR EL MODELO
$modeloDashboard = new DashboardModel($conexion);

// 3. OBTENER EL USUARIO CONECTADO
// Por ahora forzamos el ID 1 (Carlos López) para pruebas. 
// En el futuro, esto será: $_SESSION['id_empleado']
$id_empleado_actual = $_SESSION['id_empleado'] ?? 1; 

// 4. EXTRAER LOS DATOS PARA LA VISTA
$usuario = $modeloDashboard->obtenerInfoUsuario($id_empleado_actual);

// Si el usuario no existe o falló la consulta, evitamos que la página colapse
if (!$usuario) {
    $usuario = [
        'nombre' => 'Usuario',
        'apellido' => 'Desconocido',
        'nombre_puesto' => 'Sin Rol',
        'id_puesto' => 0
    ];
}

// 5. VALIDAR SI ES ADMIN (Gerente = ID 3 en tu BD)
$es_admin = ($usuario['id_puesto'] == 3);

$actividad_reciente = [];
if ($es_admin) {
    $actividad_reciente = $modeloDashboard->obtenerConexiones();
}
?>

<div class="contenedor-dashboard">
    
    <div class="pildora-usuario">
        <div class="icono-usuario">
            <i class="fa-solid fa-user"></i>
        </div>
        <span class="texto-usuario">
            <?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']); ?> - 
            <?php echo htmlspecialchars($usuario['nombre_puesto']); ?>
        </span>
    </div>

    <?php if ($es_admin): ?>
        <div class="seccion-actividad">
            <h3 class="subtitulo-actividad">Actividad Reciente en el Sistema</h3>
            
            <div class="lista-movimientos">
                <?php if (!empty($actividad_reciente)): ?>
                    <?php foreach ($actividad_reciente as $log): ?>
                        <div class="tarjeta-movimiento log-conexion">
                            <i class="fa-solid fa-right-to-bracket" style="color: #656464b2; margin-right: 10px;"></i>
                            <span>
                                <strong><?php echo htmlspecialchars($log['nombre'] . ' ' . $log['apellido']); ?></strong> 
                                (<?php echo htmlspecialchars($log['nombre_puesto']); ?>) 
                                inició sesión el <?php echo date('d/m/Y H:i:s', strtotime($log['fecha_hora'])); ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #666; font-style: italic;">No hay conexiones recientes.</p>
                <?php endif; ?>

            </div>
        </div>
    <?php endif; ?>

</div>

<style>
.contenedor-dashboard {
    padding: 30px;
    background-color: #f7f7f7;
    min-height: 100vh;
    font-family: 'Lato', sans-serif;
}

.titulo-dashboard {
    color: #52073a;
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 20px;
}

.pildora-usuario {
    display: inline-flex;
    align-items: center;
    background-color: #bba8b4;
    border-radius: 30px;
    padding: 5px 20px 5px 5px;
    margin-bottom: 40px;
}

.icono-usuario {
    background-color: #52073a;
    color: #ffffff;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-right: 10px;
    font-size: 16px;
}

.texto-usuario {
    color: #000000;
    font-weight: 600;
    font-size: 16px;
}

.subtitulo-actividad {
    color: #555;
    font-size: 16px;
    margin-bottom: 15px;
    border-bottom: 1px solid #ddd;
    padding-bottom: 5px;
}

.lista-movimientos {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.tarjeta-movimiento {
    background-color: #ffffff;
    padding: 15px 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    color: #333;
    font-size: 14px;
    border: 1px solid #eaeaea;
}

.log-conexion {
    border-left: 4px solid #e17203;
}
</style>