document.addEventListener("DOMContentLoaded", function() {
    setTimeout(function() {
        var notification = document.querySelector('.notification');
        if (notification) {
            notification.style.display = 'none';
        }
    }, 5000);
});