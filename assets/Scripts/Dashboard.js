function updateRecordsPerPage(value) {
    window.location.href = `?page=1&per_page=${value}`;
}
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        if (!confirm('Are you sure you want to delete this employee?')) {
            e.preventDefault();
        }
    });
});

// Records per page change handler
document.getElementById('recordsPerPage').addEventListener('change', function() {
    const recordsPerPage = this.value;
    // You'll need to implement the logic to reload with new page size
    // This would typically involve a page reload with a parameter
    window.location.href = `?per_page=${recordsPerPage}`;
});