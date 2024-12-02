const openModalButton = document.getElementById('openModal');
const closeModalButton = document.getElementById('closeModal');
const modal = document.getElementById('modal');
const editProfileButton = document.getElementById('editProfileButton');
const editProfileForm = document.getElementById('editProfileForm');
const profileInfo = document.getElementById('profile-info');

// Abrir el modal
openModalButton.addEventListener('click', () => {
    modal.style.display = 'flex'; // Cambiar display a flex para mostrar el modal
});

// Cerrar el modal al hacer clic en el botón de cierre
closeModalButton.addEventListener('click', () => {
    modal.style.display = 'none'; // Cambiar display a none para ocultarlo
});

// Cerrar el modal haciendo clic fuera del contenido
window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'none'; // Si haces clic fuera del modal, se cierra
    }
});

// Mostrar el formulario al hacer clic en "Editar Información"
editProfileButton.addEventListener('click', () => {
    profileInfo.style.display = 'none'; // Ocultar la información
    editProfileForm.style.display = 'block'; // Mostrar el formulario
});