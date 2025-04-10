
    document.addEventListener('DOMContentLoaded', function () {
    const modalBackdrop = document.getElementById('modalBackdrop');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const sendMessageForm = document.getElementById('sendMessageForm');
    const receiverInput = document.getElementById('receiver_id');

    // Ouvrir le modal
    document.querySelectorAll('.openModalBtn').forEach(button => {
    button.addEventListener('click', () => {
    const receiverId = button.dataset.receiverId;
    receiverInput.value = receiverId;
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

    // Envoi du message via fetch
    sendMessageForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(sendMessageForm);

    fetch("{{ route('messages.create') }}", {
    method: "POST",
    headers: {
    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
},
    body: formData
})
    .then(response => response.json())
    .then(data => {
    if (data.success) {
    alert("Message envoyé !");
    modalBackdrop.classList.add('hidden');
    document.body.style.overflow = '';
    sendMessageForm.reset();
} else {
    alert("Erreur lors de l'envoi.");
}
})
    .catch(error => {
    console.error(error);
    alert("Erreur inattendue.");
});
});
});
