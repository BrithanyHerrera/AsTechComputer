<header class="barra-herramientas">
    <div class="contenedor-logo">
          <a href="<?php echo $ruta_prefijo; ?>index.php">
    <img src="<?php echo $ruta_prefijo; ?>public/img/Iso.png" class="logo-superior">
        </div>
    </a>
    <nav class="navegacion-principal">
        <ul class="lista-opciones-serv">
            <li><a href="<?php echo $ruta_prefijo; ?>app/views/servicios.php?id_tipo_servicio=1" class="enlace-opcion-serv">Reparación y reemplazo</a></li>
        <li><a href="<?php echo $ruta_prefijo; ?>app/views/servicios.php?id_tipo_servicio=2" class="enlace-opcion-serv">Mantenimiento preventivo</a></li>
        <li><a href="<?php echo $ruta_prefijo; ?>app/views/servicios.php?id_tipo_servicio=3" class="enlace-opcion-serv">Instalación de software</a></li>
        <li><a href="<?php echo $ruta_prefijo; ?>app/views/servicios.php?id_tipo_servicio=4" class="enlace-opcion-serv">Servicios especializados</a></li>
        <li><a href="<?php echo $ruta_prefijo; ?>app/views/servicios.php?id_tipo_servicio=5" class="enlace-opcion-serv">Servicios a domicilio</a></li>
        <li><a href="<?php echo $ruta_prefijo; ?>app/views/servicios.php?servicios.php" class="enlace-opcion-serv">Todos los servicios</a></li>

      <li>
     <a href="#" id="btnBuscador" class="enlace-opcion-serv" onclick="abrirBuscador()">
    <i class="fa-solid fa-magnifying-glass"></i>
</a>
</li>
        <li><a href="" class="enlace-opcion-serv"><i class="fa-solid fa-calendar"></i></a></li>
        
        </ul>
    </nav>
</header>