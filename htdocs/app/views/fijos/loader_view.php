<div id="pantalla-carga">
    <div class="loader-astech">
        <div class="circulo"></div>
        <img src="<?php echo BASE_URL; ?>public/img/Iso.png" alt="Cargando..." class="logo-loader">
    </div>
    <p class="texto-carga">Cargando sistema...</p>
</div>

<style>
/* ========================================== */
/* ESTILOS RESPONSIVOS DEL LOADER AS TECH     */
/* ========================================== */
#pantalla-carga {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%; /* Cambiado a 100% para evitar el bug del scroll horizontal en Windows */
    height: 100dvh; /* dvh (Dynamic Viewport Height): Se adapta si aparece la barra de direcciones en el celular */
    background-color: #ffffff;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 99999; /* Un 9 extra por si acaso */
    transition: opacity 0.5s ease, visibility 0.5s ease;
}

.loader-astech {
    position: relative;
    /* La magia de clamp: Tamaño ideal 15vmin, mínimo 80px, máximo 120px */
    width: clamp(80px, 15vmin, 120px);
    height: clamp(80px, 15vmin, 120px);
    display: flex;
    justify-content: center;
    align-items: center;
}

.loader-astech .circulo {
    position: absolute;
    width: 100%;
    height: 100%;
    /* Borde dinámico para que no se vea tosco en celulares ni muy delgado en monitores 4K */
    border: clamp(3px, 0.8vmin, 5px) solid #f3f3f3;
    border-top: clamp(3px, 0.8vmin, 5px) solid #e17203;
    border-bottom: clamp(3px, 0.8vmin, 5px) solid #4a148c;
    border-radius: 50%;
    animation: girar 1.5s linear infinite;
}

.loader-astech .logo-loader {
    width: 50%; /* Ahora la imagen usa porcentaje, siempre será la mitad del círculo */
    height: auto;
    animation: latir 2s ease-in-out infinite;
}

.texto-carga {
    margin-top: clamp(15px, 4vh, 25px); /* Margen que respira según el alto de la pantalla */
    font-weight: 700;
    color: #4a148c;
    letter-spacing: 2px;
    text-align: center;
    padding: 0 20px; /* Margen de seguridad lateral para celulares muy estrechos */
    /* Texto dinámico: mínimo 14px, ideal 3vw, máximo 18px */
    font-size: clamp(14px, 3vw, 18px); 
    animation: parpadeo 1.5s infinite;
}

/* Animaciones */
@keyframes girar { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
@keyframes latir { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.1); } }
@keyframes parpadeo { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
</style>

<script>
    window.addEventListener('load', function() {
        const loader = document.getElementById('pantalla-carga');
        if(loader) {
            loader.style.opacity = '0';
            setTimeout(() => {
                loader.style.visibility = 'hidden';
                loader.style.display = 'none';
            }, 500);
        }
    });
</script>