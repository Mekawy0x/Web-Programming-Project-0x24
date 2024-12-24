document.addEventListener('DOMContentLoaded', () => {
    const image = document.querySelector('.hotel-details-container img');

    // Smooth image scaling on click
    image.addEventListener('click', () => {
        if (!image.classList.contains('zoomed')) {
            image.style.transform = 'scale(1.1)';
            image.style.transition = 'transform 0.5s ease-in-out';
            image.classList.add('zoomed');
        } else {
            image.style.transform = 'scale(1)';
            image.classList.remove('zoomed');
        }
    });
});