document.addEventListener('DOMContentLoaded', () => {
    const backButton = document.querySelector('.back-btn');

    backButton.addEventListener('click', (e) => {
        e.preventDefault();

        // Add a subtle transition effect when navigating back
        document.body.style.opacity = 0;
        setTimeout(() => {
            window.location.href = backButton.href;
        }, 300);
    });
});