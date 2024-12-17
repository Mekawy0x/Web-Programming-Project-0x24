document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const inputs = document.querySelectorAll('input');
    
    // Add hover effect to inputs
    inputs.forEach(input => {
        input.addEventListener('mouseover', () => {
            input.style.backgroundColor = '#EBD9B4';
        });

        input.addEventListener('mouseout', () => {
            input.style.backgroundColor = 'white';
        });
    });

    // Add a submit animation
    form.addEventListener('submit', (event) => {
        const button = document.querySelector('button');
        button.style.transform = 'scale(0.95)';
        setTimeout(() => {
            button.style.transform = 'scale(1)';
        }, 100);
    });
});