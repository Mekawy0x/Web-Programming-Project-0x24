document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('registrationForm');

    form.addEventListener('submit', (e) => {
        const password = document.getElementById('password').value;

        if (password.length < 8) {
            e.preventDefault();
            alert('Password must be at least 6 characters long.');
        }
    });
});