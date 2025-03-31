function updateRecordsPerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    url.searchParams.set('page', 1); // Reset to first page
    window.location.href = url.toString();
}

// Add animation to table rows on load
document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('.employee-table tbody tr');
    rows.forEach((row, index) => {
        setTimeout(() => {
            row.classList.add('animate__fadeIn');
        }, 100 * index);
    });
});
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        if (!confirm('Are you sure you want to delete this employee?')) {
            e.preventDefault();
        }
    });
});

// Records per page change handler
// document.getElementById('recordsPerPage').addEventListener('change', function() {
//     const recordsPerPage = this.value;
//     // You'll need to implement the logic to reload with new page size
//     // This would typically involve a page reload with a parameter
//     window.location.href = `?per_page=${recordsPerPage}`;
// });