<script>
/* REGISTRO_MARCA_VIEW.PHP */
/*
Este archivo representa la Vista (View) encargada de exhibir la información legal referente a la titularidad y los derechos de propiedad intelectual de la marca "AsTech Computer". Su objetivo principal es dotar de certeza jurídica a la empresa frente a clientes y socios, mostrando de forma estructurada los datos registrales emitidos por el IMPI. Adicionalmente, incorpora un botón para la descarga directa del título oficial en formato PDF y define las cláusulas restrictivas sobre el uso indebido de la identidad gráfica. Mantiene el diseño modular al incluir la barra de navegación y el pie de página del sistema.
*/
</script>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Marca - AsTech Computer</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="../../public/img/Astech%20ICO.ico" type="image/x-icon">    
    <link rel="stylesheet" href="../../public/css/static.css">    
    <link rel="stylesheet" href="../../public/css/toolbar.css">
    <link rel="stylesheet" href="../../public/css/footer.css">
    <link rel="stylesheet" href="../../public/css/info_legal.css">
</head>

<body style="background-color: #f4f4f4;">
    <?php
    $ruta_prefijo = "../../../"; 
    require_once __DIR__ . "/../config/config.php"; 
    include __DIR__ . "/../controllers/toolbar_controller.php";
    ?>

    <main>
        <section class="seccion-legal">
            <h1>Título de Registro de Marca</h1>
            <span class="fecha-actualizacion">Instituto Mexicano de la Propiedad Industrial (IMPI)</span>

            <p>En <strong>AsTech Computer</strong> operamos bajo los más estrictos estándares de legalidad y formalidad. Para brindar total certeza jurídica a nuestros clientes, socios comerciales y proveedores, presentamos los datos oficiales que acreditan la propiedad exclusiva de nuestra marca.</p>

            <div style="background: #ffffff; border: 2px solid var(--purpura-oscuro, #52073a); border-radius: 12px; padding: 45px 30px; margin: 40px 0; box-shadow: 0 15px 35px rgba(82, 7, 58, 0.08); text-align: center; position: relative; overflow: hidden;">
                
                <i class="fa-solid fa-shield-check" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 250px; color: rgba(225, 114, 3, 0.04); z-index: 0;"></i>

                <div style="position: relative; z-index: 1;">
                    <img src="../../public/img/logoATC.png" alt="Logo AsTech" style="max-width: 140px; margin-bottom: 15px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));">
                    <h2 style="color: var(--purpura-oscuro, #52073a); text-transform: uppercase; letter-spacing: 3px; margin-bottom: 35px; font-weight: 900;">AsTech Computer®</h2>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 25px; text-align: left; max-width: 600px; margin: 0 auto; background: #fbfbfd; padding: 30px; border-radius: 8px; border-left: 5px solid var(--naranja-principal, #e17203);">
                        
                        <div>
                            <p style="font-size: 0.85rem; color: #888; margin: 0; text-transform: uppercase; font-weight: 700;">Titular de la Marca:</p>
                            <p style="font-weight: bold; margin: 5px 0 0; color: #1d1d1f;">Ferdán Alejandro Garrigos Rojas</p>
                        </div>
                        
                        <div>
                            <p style="font-size: 0.85rem; color: #888; margin: 0; text-transform: uppercase; font-weight: 700;">Número de Registro:</p>
                            <p style="font-weight: bold; margin: 5px 0 0; color: #1d1d1f;">2934794</p>
                        </div>
                        
                        <div>
                            <p style="font-size: 0.85rem; color: #888; margin: 0; text-transform: uppercase; font-weight: 700;">Clase NIZA:</p>
                            <p style="font-weight: bold; margin: 5px 0 0; color: #1d1d1f;">Clase 37 - Mantenimiento y reparación de hardware</p>
                        </div>
                        
                        <div>
                            <p style="font-size: 0.85rem; color: #888; margin: 0; text-transform: uppercase; font-weight: 700;">Expediente:</p>
                            <p style="font-weight: bold; margin: 5px 0 0; color: #1d1d1f;">3228481</p>
                        </div>
                        
                        <div>
                            <p style="font-size: 0.85rem; color: #888; margin: 0; text-transform: uppercase; font-weight: 700;">Fecha de Presentación:</p>
                            <p style="font-weight: bold; margin: 5px 0 0; color: #1d1d1f;">03 de Septiembre de 2024</p>
                        </div>
                        
                        <div>
                            <p style="font-size: 0.85rem; color: #888; margin: 0; text-transform: uppercase; font-weight: 700;">Vigencia (10 Años):</p>
                            <p style="font-weight: bold; margin: 5px 0 0; color: #1d1d1f;">14 de Octubre de 2035</p>
                        </div>

                    </div>

                    <div style="margin-top: 35px;">
                        <a href="../../public/docs/M625 Título de registro.pdf" download="M625 Título de registro.pdf" class="btn-descargar-pdf">
                            <i class="fa-solid fa-file-pdf" style="font-size: 1.2rem;"></i> Descargar Título Oficial (PDF)
                        </a>
                    </div>

                    <p style="margin-top: 25px; font-size: 0.85rem; color: #86868b; font-style: italic;"><i class="fa-solid fa-circle-info" style="color: var(--naranja-principal, #e17203);"></i> Este documento es una representación digital informativa de los datos asentados en el título original expedido por las autoridades competentes.</p>
                </div>
            </div>

            <h3>Derechos de Uso y Restricciones</h3>
            <p>El logotipo, diseño, tipografía, paleta de colores (naranja y púrpura oscuro), nombre comercial y eslogan de <strong>AsTech Computer</strong> son propiedad exclusiva de su titular legal. Queda estrictamente prohibida la reproducción, copia, alteración, distribución o uso comercial no autorizado de esta identidad gráfica sin el consentimiento expreso y por escrito del propietario.</p>
            <p>Cualquier violación o uso indebido de estos derechos será sujeta a las medidas cautelares y sanciones civiles, administrativas y penales correspondientes estipuladas en la Ley Federal de Protección a la Propiedad Industrial.</p>
        </section>
    </main>

    <?php
    $ruta_prefijo = "../../../"; 
    include __DIR__ . "/../controllers/footer_controller.php";
    ?>

</body>
</html>