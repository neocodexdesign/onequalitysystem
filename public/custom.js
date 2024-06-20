var currentScale = 1.0; // Escala inicial de 100%                

function zoomIn() {
    currentScale *= 1.1; // Aumenta a escala em 10%
    Filament.getComponent('zoomContainer').mutate('transform', `scale(${currentScale})`);
    //applyZoom();
}
function zoomOut() {
    currentScale = Math.max(0.5, currentScale - 0.1); // Diminui a escala, mínimo de 50%
    applyZoom();
}
function applyZoom() {
    var zoomContainer = document.getElementById('zoomContainer');
    zoomContainer.style.transform = `scale(${currentScale})`;
    zoomContainer.style.transformOrigin = 'left top'; // Mantém o ponto de origem à esquerda no topo
}
window.addEventListener('resize', adjustZoomToFit);
function adjustZoomToFit() {
    var zoomContainer = document.getElementById('zoomContainer');
    var scaleWidth = window.innerWidth / zoomContainer.offsetWidth;
    zoomContainer.style.transform = `scale(${scaleWidth})`;
    zoomContainer.style.transformOrigin = 'left top'; // Mantém a tabela ancorada no canto esquerdo superior
}            
document.addEventListener('DOMContentLoaded', function () {
    // Adicionar listeners para botões, etc.
    Array.from(document.querySelectorAll('.edit-order-button')).forEach(button => {
        button.addEventListener('click', () => {
            window.location.href = button.getAttribute('data-url');
        });
    });
});                    

