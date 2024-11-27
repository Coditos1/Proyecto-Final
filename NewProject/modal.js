// Selecciona los elementos
const openModalButton = document.getElementById('openModal');
const closeModalButton = document.getElementById('closeModal');
const modal = document.getElementById('modal');

// Abrir el modal
openModalButton.addEventListener('click', () => {
    modal.style.display = 'flex';
});

// Cerrar el modal
closeModalButton.addEventListener('click', () => {
    modal.style.display = 'none';
});

// Cerrar el modal haciendo clic fuera del contenido
window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});