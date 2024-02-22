// Function to fetch data from generate_report.php
function fetchData() {
  // Make AJAX request to generate_report.php
  fetch("generate_report.php")
    .then((response) => response.json()) // Parse response as JSON
    .then((data) => {
      // Call function to render tables with fetched data
      renderTables(data);
    })
    .catch((error) => {
      console.error("Error fetching data:", error);
    });
}

// Function to render tables with fetched data
function renderTables(data) {
  // Get the element to append tables
  const tablesContainer = document.getElementById("tablesContainer");

  // Generate table for total quantity
  const quantityTable = generateTable(
    "Total Quantity",
    data.dates,
    data.totalQuantities
  );
  tablesContainer.appendChild(quantityTable);

  // Generate table for total price
  const priceTable = generateTable("Total Price", data.dates, data.totalPrices);
  tablesContainer.appendChild(priceTable);
}

// Function to generate a table with headers and data
function generateTable(title, labels, data) {
  // Create table element
  const table = document.createElement("table");

  // Create table caption
  const caption = table.createCaption();
  caption.textContent = title;

  // Create table header row
  const headerRow = table.insertRow();
  headerRow.insertCell().textContent = "Date";
  headerRow.insertCell().textContent = title;

  // Insert data rows
  for (let i = 0; i < labels.length; i++) {
    const row = table.insertRow();
    row.insertCell().textContent = labels[i];
    row.insertCell().textContent = data[i];
  }

  return table;
}

// Call fetchData function when the page loads
fetchData();
