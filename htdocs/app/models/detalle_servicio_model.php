
<?php
// ========================================================
//MODELO DE SETALLE SERVICIO
//VIEW:detalle_servicio_view.php
// CONTROLADOR: detalle_servicio_controller.php (Página de detalle servicio)
// pagina que muestra informacion especifica de cada servicio en la pagina servicios_view.php
// ========================================================

require_once(__DIR__ . '/../config/conexion.db.php');

class ServicioModel {

    public static function obtenerServicioPorId($id) {
        global $conexion;

        $query = "SELECT * FROM servicios 
                  WHERE id_servicio = $id AND estado = 'activo'";

        $resultado = mysqli_query($conexion, $query);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_assoc($resultado);
        }

        return null;
    }

    public static function obtenerMetodosPago() {
        global $conexion;

        $query = "SELECT nombre_metodo, detalles 
                  FROM metodos_pago 
                  WHERE estado = 'activo'";

        return mysqli_query($conexion, $query);
    }
}