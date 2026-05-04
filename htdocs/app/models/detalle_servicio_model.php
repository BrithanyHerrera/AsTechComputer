
<?php
// ========================================================
//MODELO DE SETALLE SERVICIO
//VIEW:detalle_servicio_view.php
// CONTROLADOR: detalle_servicio_controller.php (Página de detalle servicio)
// pagina que modela el uso de la pagina detalle sevricio, la cual muestra informacion 
//acerca de los servicios (informacion especifica)
// ========================================================

require_once(__DIR__ . '/../config/conexion.db.php');

class ServicioModel {
    //funcion para obtener servicio segun su tipo o nombre, para poderse mostrar en la pagina
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
//funcion para obtener los metodos de pago desde la base de datos 
    public static function obtenerMetodosPago() {
        global $conexion;

        $query = "SELECT nombre_metodo, detalles 
                  FROM metodos_pago 
                  WHERE estado = 'activo'";

        return mysqli_query($conexion, $query);
    }
}