<?php
// 1. INCLUIR CONEXIÓN Y MODELO (Usamos dirname para rutas invencibles en la nube)
require_once dirname(__DIR__, 2) . '/config/conexion.db.php';
require_once dirname(__DIR__, 2) . '/models/panel_info_model.php';

// Iniciar sesión para saber quién está conectado (si no está iniciada ya)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. PREPARAR EL MODELO
$modeloDashboard = new DashboardModel($conexion);

// 3. OBTENER EL USUARIO CONECTADO
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

// 5. VALIDAR SI ES ADMIN (Gerente = 3, Administrador = 4)
$es_admin = ($usuario['id_puesto'] == 3 || $usuario['id_puesto'] == 4);

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
        <div class="bitacora-panel" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <h2 style="color: #52073a; border-bottom: 2px solid #e17203; padding-bottom: 10px; margin-bottom: 20px;">
                <i class="fa-solid fa-clock-rotate-left"></i> Auditoría de Movimientos
            </h2>
            
            <?php if (!empty($actividad_reciente)): ?>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 14px; text-align: left;">
                    <thead>
                        <tr style="background-color: #52073a; color: white;">
                            <th style="padding: 12px; border-radius: 5px 0 0 0;">Empleado</th>
                            <th style="padding: 12px;">Puesto</th>
                            <th style="padding: 12px;">Acción</th>
                            <th style="padding: 12px;">Detalle</th>
                            <th style="padding: 12px; border-radius: 0 5px 0 0;">Fecha y Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($actividad_reciente as $act): ?>
                        <tr style="border-bottom: 1px solid #eaeaea; transition: background 0.2s;">
                            <td style="padding: 12px;"><strong><?= htmlspecialchars($act['nombre'] . ' ' . $act['apellido']) ?></strong></td>
                            <td style="padding: 12px; color: #555;"><?= htmlspecialchars($act['nombre_puesto']) ?></td>
                            <td style="padding: 12px;">
                                <span style="background-color: #f0f0f0; border: 1px solid #ddd; padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 0.85em; color: #333;">
                                    <?= htmlspecialchars($act['accion']) ?>
                                </span>
                            </td>
                            <td style="padding: 12px; color: #444;"><?= htmlspecialchars($act['detalle']) ?></td>
                            <td style="padding: 12px; color: #666;"><i class="fa-regular fa-calendar" style="margin-right: 5px;"></i> <?= date('d/m/Y H:i', strtotime($act['fecha_hora'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <div style="padding: 20px; text-align: center; color: #666; font-style: italic; background: #f9f9f9; border-radius: 5px;">
                    <i class="fa-solid fa-folder-open" style="font-size: 24px; color: #ccc; margin-bottom: 10px; display: block;"></i>
                    No hay movimientos registrados en el sistema todavía.
                </div>
            <?php endif; ?>
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

.pildora-usuario {
    display: inline-flex;
    align-items: center;
    background-color: #bba8b4;
    border-radius: 30px;
    padding: 5px 20px 5px 5px;
    margin-bottom: 30px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
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

/* Efecto hover (iluminar la fila al pasar el mouse) */
tbody tr:hover {
    background-color: #fdfafc !important;
}
</style>