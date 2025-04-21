
    document.addEventListener('DOMContentLoaded', function () {
    const modalBackdrop = document.getElementById('modalBackdrop');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const sendMessageForm = document.getElementById('sendMessageForm');
    const receiverInput = document.getElementById('receiver_id');
    const serviceInput = document.getElementById('service_id');

    // Ouvrir le modal
    document.querySelectorAll('.openModalBtn').forEach(button => {
    button.addEventListener('click', () => {


        if (!isAuthenticated) {
            alert("Vous devez être connecté pour envoyer un message.");
            window.location.href = "/login"; // rediriger vers login si tu veux
            return;
        }

        const receiverId = button.dataset.receiverId;
    const serviceId = button.dataset.serviceId;
    console.log(serviceId) ;
    receiverInput.value = receiverId;
    serviceInput.value = serviceId;
    modalBackdrop.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
});
});

    // Fermer le modal
    closeModalBtn.addEventListener('click', () => {
    modalBackdrop.classList.add('hidden');
    document.body.style.overflow = '';
});

    modalBackdrop.addEventListener('click', (e) => {
    if (e.target === modalBackdrop) {
    modalBackdrop.classList.add('hidden');
    document.body.style.overflow = '';
}
});


});
