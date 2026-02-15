document.addEventListener('DOMContentLoaded', () => {
    // Add simple animation for cards on load
    const cards = document.querySelectorAll('.glass-card, .btn');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = `all 0.6s cubic-bezier(0.16, 1, 0.3, 1) ${index * 0.1}s`;
        observer.observe(card);
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
    
    // Simple validation feedback for password match
    const passwordInput = document.querySelector('input[name="password"]');
    const confirmInput = document.querySelector('input[name="confirm_password"]');
    
    if(passwordInput && confirmInput) {
        confirmInput.addEventListener('input', () => {
            if(confirmInput.value !== passwordInput.value) {
                confirmInput.style.borderColor = '#ef4444';
            } else {
                confirmInput.style.borderColor = '#10b981';
            }
        });
    }
});
