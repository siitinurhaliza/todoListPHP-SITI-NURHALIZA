// assets/js/scripts.js

// Menutup alert secara otomatis setelah 3 detik
window.addEventListener('load', function() {
    const alert = document.querySelector('.alert');
    if (alert) {
        setTimeout(() => {
            alert.classList.remove('show');
            alert.classList.add('hide');
        }, 3000);
    }
});
