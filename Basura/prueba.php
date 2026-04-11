/*-- COOKIES --*/
/*.bloquear-scroll {
    overflow: hidden;
}*/

/* --- ESTILOS DEL MODAL ESTILO XIAOMI --- */
.modal-ajustes {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 95%;
    max-width: 650px;
    height: 85vh;
    background-color: #f7f7f7;
    border-radius: 12px;
    z-index: 999999;
    display: flex;
    flex-direction: column;
    box-shadow: 0px 20px 60px rgba(0, 0, 0, 0.3);
    overflow: hidden;
    font-family: 'Lato', sans-serif;
}

.modal-header-ajustes {
    padding: 20px 30px;
    background: #fff;
    border-bottom: 1px solid #e0e0e0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 10;
}

.modal-header-ajustes h2 {
    font-size: 1.3rem;
    font-weight: 900;
    color: #000;
    margin: 0;
}

.btn-cerrar {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #000;
    cursor: pointer;
    font-weight: bold;
}

.modal-body-ajustes {
    padding: 25px 30px;
    overflow-y: auto;
    text-align: left;
    flex: 1;
}

.intro-ajustes {
    font-size: 0.9rem;
    color: #444;
    margin-bottom: 25px;
    line-height: 1.6;
}

.intro-ajustes a {
    color: #e06c00;
    font-weight: bold;
    text-decoration: none;
}

/* Tarjetas de Cookies */
.cookie-card {
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    margin-bottom: 15px;
    padding: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
}

.cookie-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.cookie-card-header h3 {
    font-size: 1.05rem;
    color: #000;
    margin: 0;
    font-weight: 900;
    letter-spacing: 0.5px;
}

.badge-fijo {
    font-size: 0.8rem;
    color: #888;
    font-weight: 700;
    background: #f0f0f0;
    padding: 4px 10px;
    border-radius: 4px;
}

.cookie-card-body p {
    font-size: 0.85rem;
    color: #555;
    margin: 0 0 15px 0;
    line-height: 1.5;
}

/* Desplegable estilo Xiaomi */
details {
    border-top: 1px solid #eee;
    padding-top: 12px;
}

details summary {
    cursor: pointer;
    color: #e06c00;
    font-size: 0.85rem;
    list-style: none;
    display: flex;
    align-items: center;
    gap: 8px;
    outline: none;
}

details summary::-webkit-details-marker {
    display: none;
}

details[open] summary i {
    transform: rotate(90deg);
    transition: transform 0.2s;
}

.texto-oculto {
    margin-top: 15px !important;
    padding: 15px;
    background: #f9f9f9;
    border-radius: 6px;
    border-left: 3px solid #e06c00;
}

/* Botones del Footer apilados */
.modal-footer-xiaomi {
    padding: 20px 30px;
    border-top: 1px solid #e0e0e0;
    background: #fff;
    display: flex;
    flex-direction: column;
    gap: 12px;
    z-index: 10;
}

.btn-x-outline {
    background: white;
    border: 1px solid #e06c00;
    color: #e06c00;
    padding: 14px;
    border-radius: 6px;
    font-weight: 900;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.9rem;
}

.btn-x-outline:hover {
    background: #fff3e0;
}

.btn-x-solid {
    background: #e06c00;
    border: 1px solid #e06c00;
    color: white;
    padding: 14px;
    border-radius: 6px;
    font-weight: 900;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.9rem;
}

.btn-x-solid:hover {
    background: #cc6200;
}