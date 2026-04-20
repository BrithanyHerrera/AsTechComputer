// ========================================================
// SCRIPT: panel_info.js (MÉTODO CLÁSICO SERVIDOR)
// ========================================================

function limpiarFiltrosPanelInfo() {
    // Tomamos la URL actual y le borramos todos los parámetros de búsqueda
    // Si estás usando un sistema de secciones (ej. ?seccion=panel_info), lo conservamos
    const urlParams = new URLSearchParams(window.location.search);
    const seccion = urlParams.get('seccion');
    
    if (seccion) {
        window.location.href = window.location.pathname + '?seccion=' + seccion;
    } else {
        window.location.href = window.location.pathname;
    }
}