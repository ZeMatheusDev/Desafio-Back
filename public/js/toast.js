document.addEventListener('DOMContentLoaded', function() {
    const toasts = document.querySelectorAll('.alerta');
    
    toasts.forEach(toast => {
        const bootstrapToast = new bootstrap.Toast(toast, {
            autohide: true,
            delay: 5000
        });
        bootstrapToast.show();
    });
});