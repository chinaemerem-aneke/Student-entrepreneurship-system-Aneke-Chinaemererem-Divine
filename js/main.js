document.getElementById('searchButton').addEventListener('click', function() {
    var searchInput = document.getElementById('searchInput').value.toLowerCase();
    var tableRows = document.querySelectorAll('#userTable tbody tr');

    tableRows.forEach(function(row) {
        var matchFound = false; // Flag to check if any match is found in the row
        var cells = row.querySelectorAll('td'); // Select all td elements in the row
        cells.forEach(function(cell) {
            var cellText = cell.innerText.toLowerCase();
            if (cellText.includes(searchInput)) {
                matchFound = true; // Set flag to true if match is found in any cell
            }
        });
        // Set display style based on matchFound flag
        row.style.display = matchFound ? '' : 'none';
    });
});
