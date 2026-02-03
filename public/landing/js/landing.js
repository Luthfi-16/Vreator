let selectedUserRole = '';

function selectRole(role) {
    selectedUserRole = role;

    // Hide step 1, show step 2
    document.getElementById('step1').classList.remove('active');
    document.getElementById('step2').classList.add('active');

    // Update icon and text based on role
    const iconElement = document.querySelector('#selectedRoleIcon i');
    const textElement = document.getElementById('selectedRoleText');

    if (role === 'creator') {
        iconElement.className = 'bi bi-camera-video-fill';
        textElement.textContent = 'Masuk sebagai Editor / Creator';
    } else {
        iconElement.className = 'bi bi-bag-fill';
        textElement.textContent = 'Masuk sebagai Buyer';
    }
}

function backToStep1() {
    document.getElementById('step2').classList.remove('active');
    document.getElementById('step1').classList.add('active');
    selectedUserRole = '';
}

// Reset modal when closed
document.getElementById('loginModal').addEventListener('hidden.bs.modal', function () {
    backToStep1();
});