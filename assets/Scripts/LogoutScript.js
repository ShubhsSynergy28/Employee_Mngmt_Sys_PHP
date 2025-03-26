document.getElementById('logoutBtn').addEventListener('click', async function() {
    try {
        const response = await fetch('../../controllers/AuthController.php?action=logout');
        const result = await response.json();
        
        if (result.success) {
            window.location.href = result.redirect;
        } else {
            alert(result.message || 'Logout failed');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Network error during logout');
    }
});