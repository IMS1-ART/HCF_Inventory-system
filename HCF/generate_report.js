// generate_report.js

// Function to fetch data from generate_report.php
function fetchData() {
    // Make AJAX request to generate_report.php
    fetch('generate_report.php')
        .then(response => response.json()) // Parse response as JSON
        .then(data => {
            // Call function to render chart with fetched data
            renderChart(data);
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}

// Function to render the chart with fetched data
function renderChart(data) {
    // Get the canvas element
    const ctx = document.getElementById('salesChart').getContext('2d');

    // Create the bar chart using fetched data
    const salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.dates, // Use dates from fetched data as labels
            datasets: [{
                label: 'Total Sales',
                data: data.totalPrices, // Use totalPrices from fetched data as data
                backgroundColor: 'rgba(54, 162, 235, 0.5)', // Blue color for bars
                borderColor: 'rgba(54, 162, 235, 1)', // Border color
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
}

// Call fetchData function when the page loads
fetchData();
