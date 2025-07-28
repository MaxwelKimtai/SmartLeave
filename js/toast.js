document.addEventListener("DOMContentLoaded", () => {
    const toast = document.querySelector('.toast');
    if (toast) {
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100px)';
        }, 4000);
    }
});
