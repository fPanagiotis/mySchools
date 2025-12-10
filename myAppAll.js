/**
 * @fileoverview Script for handling table display, sorting, and pagination
 * for the school data.
 * NOTE: The ALL_SCHOOLS_DATA constant is assumed to be defined just before this script.
 */

// Global state variables
// ⚠️ ΠΡΟΣΟΧΗ: Η ALL_SCHOOLS_DATA ΠΡΕΠΕΙ να έχει οριστεί (π.χ. από JSON)
let currentData = ALL_SCHOOLS_DATA; // The data currently being displayed (after sorting/filtering)
let currentPage = 1;
let sortColumn = "mySchName"; // Default sort column
let sortDirection = "asc"; // Default sort direction

// --- Utility Functions (Adapted from app.js context) ---

/**
 * Normalizes text for better sorting/comparison by removing accents and converting to uppercase.
 * @param {string} text - The text to process.
 * @returns {string} The normalized text.
 */
function RemoveAccents(text) {
  if (!text) return "";
  // 1. Normalize (NFD): Separate the accented character from its diacritic
  const normalizedText = String(text).normalize("NFD");
  // 2. Remove Diacritics: Use RegEx to remove diacritics (Marks)
  return normalizedText.replace(/[\u0300-\u036f]/g, "").toUpperCase();
}

/**
 * Maps the Greek keys from the JSON data to the English equivalents used in the table logic.
 * The order must match the <th> elements in the HTML table.
 */
const TABLE_COLUMNS = [
  { key: "mySchCode", label: "ΚΩΔΙΚΟΣ" },
  { key: "mySchName", label: "ΟΝΟΜΑΣΙΑ" },
  { key: "mySchLevel", label: "ΒΑΘΜΙΔΑ" },
  { key: "mySchType", label: "ΤΥΠΟΣ ΣΧΟΛΕΙΟΥ" },
  { key: "mySchCharacter", label: "ΧΑΡΑΚΤΗΡΑΣ" },
  { key: "mySchProsanatol", label: "ΠΡΟΣΑΝΑΤΟΛΙΣΜΟΣ" },
  { key: "mySchEidikos", label: "ΕΙΔΙΚΟΣ ΤΥΠΟΣ" },
  { key: "mySchPeriferia", label: "ΠΕΡΙΦΕΡΕΙΑ" },
  { key: "mySchNomos", label: "ΝΟΜΟΣ" },
  { key: "mySchDimos", label: "ΔΗΜΟΣ" },
  { key: "mySchDimotikiEnotita", label: "ΔΗΜΟΤΙΚΗ ΕΝΟΤΗΤΑ" },
  { key: "mySchDief", label: "ΔΙΕΥΘΥΝΣΗ ΕΚΠΑΙΔΕΥΣΗΣ" },
  { key: "fullAddr", label: "ΠΛΗΡΗΣ ΔΙΕΥΘΥΝΣΗ" }, // Combined address
  { key: "mySchZip", label: "Τ.Κ." },
  { key: "mySchPhone", label: "ΤΗΛΕΦΩΝΟ" },
  { key: "mySchEmail", label: "EMAIL" },
  { key: "mySchLatitude", label: "ΠΛΑΤΟΣ" },
  { key: "mySchLongitude", label: "ΜΗΚΟΣ" },
];

/**
 * Pre-processes data to add the combined address.
 * @param {Array} schools - The raw school data array.
 * @returns {Array} The processed array with 'fullAddr'.
 */
function preprocessData(schools) {
  return schools.map((school) => ({
    ...school,
    fullAddr: `${school.mySchAddr || ""} ${school.mySchZip || ""}`.trim(),
  }));
}

// --- Sorting Logic ---

/**
 * Compares two values for sorting.
 * @param {any} a - First value.
 * @param {any} b - Second value.
 * @param {string} direction - 'asc' or 'desc'.
 * @returns {number} Standard comparison result (-1, 0, 1).
 */
function compareValues(a, b, direction) {
  // Handle null/undefined values by treating them as empty strings
  const valA = a == null ? "" : String(a);
  const valB = b == null ? "" : String(b);

  // Use RemoveAccents for proper Greek alphabetical sorting, except for numeric fields
  let normalizedA, normalizedB;
  if (typeof a === "number" && typeof b === "number") {
    normalizedA = a;
    normalizedB = b;
  } else {
    normalizedA = RemoveAccents(valA);
    normalizedB = RemoveAccents(valB);
  }

  let comparison = 0;
  if (normalizedA > normalizedB) {
    comparison = 1;
  } else if (normalizedA < normalizedB) {
    comparison = -1;
  }

  return direction === "desc" ? comparison * -1 : comparison;
}

/**
 * Sorts the data based on the current sort column and direction.
 */
function sortData() {
  currentData.sort((a, b) => {
    return compareValues(a[sortColumn], b[sortColumn], sortDirection);
  });
}

// --- Rendering Logic ---

/**
 * Renders the current page of data to the table body.
 */
function renderTable() {
  const tableBody = document.getElementById("table-body");
  const recordsPerPage = parseInt(
    document.getElementById("recordsPerPage").value,
    10
  );

  // Sort the data before calculating pages
  sortData();

  const startIndex = (currentPage - 1) * recordsPerPage;
  const endIndex = startIndex + recordsPerPage;
  const paginatedData = currentData.slice(startIndex, endIndex);

  // Clear existing rows
  tableBody.innerHTML = "";

  // Render new rows
  paginatedData.forEach((school) => {
    const row = tableBody.insertRow();

    TABLE_COLUMNS.forEach((col) => {
      const cell = row.insertCell();
      let displayValue = school[col.key] == null ? "" : String(school[col.key]);

      // Special formatting for email and phone (optional: add links)
      if (col.key === "mySchEmail" && displayValue) {
        cell.innerHTML = `<a href="mailto:${displayValue}">${displayValue}</a>`;
      } else if (col.key === "mySchPhone" && displayValue) {
        cell.innerHTML = `<a href="tel:${displayValue}">${displayValue}</a>`;
      } else if (col.key === "mySchLatitude" || col.key === "mySchLongitude") {
        // Ensure coordinates are displayed without trailing zeros if they are 0
        cell.textContent = displayValue
          ? parseFloat(displayValue).toFixed(6)
          : "";
      } else {
        cell.textContent = displayValue;
      }
    });
  });

  updatePaginationControls();
  updateHeaderIcons();
}

/**
 * Updates the state of the pagination controls and the page info.
 */
function updatePaginationControls() {
  const totalRecords = currentData.length;
  const recordsPerPage = parseInt(
    document.getElementById("recordsPerPage").value,
    10
  );
  const totalPages = Math.ceil(totalRecords / recordsPerPage);

  const prevButton = document.getElementById("prevPage");
  const nextButton = document.getElementById("nextPage");
  const pageInfo = document.getElementById("pageInfo");

  pageInfo.textContent = `Σελίδα ${currentPage} από ${totalPages || 1}`;

  // Disable/Enable buttons
  prevButton.disabled = currentPage === 1;
  nextButton.disabled = currentPage >= totalPages;

  // If no data, disable both
  if (totalRecords === 0) {
    prevButton.disabled = true;
    nextButton.disabled = true;
  }
}

/**
 * Attaches the sorting event listeners to the table headers.
 */
function attachHeaderListeners() {
  const tableHeaders = document.querySelectorAll("table thead th");
  tableHeaders.forEach((header, index) => {
    const columnKey = TABLE_COLUMNS[index].key;

    // Add a visual indicator for sortable columns
    header.classList.add("sortable");

    header.addEventListener("click", () => {
      if (sortColumn === columnKey) {
        // Toggle direction
        sortDirection = sortDirection === "asc" ? "desc" : "asc";
      } else {
        // New column, set default direction
        sortColumn = columnKey;
        sortDirection = "asc";
      }
      // Reset to first page and re-render/sort
      currentPage = 1;
      renderTable();
    });
  });
}

/**
 * Updates the visual icons/indicators on the table headers.
 */
function updateHeaderIcons() {
  const tableHeaders = document.querySelectorAll("table thead th");

  tableHeaders.forEach((header) => {
    header.classList.remove("sort-asc", "sort-desc");
  });

  const columnIndex = TABLE_COLUMNS.findIndex((col) => col.key === sortColumn);
  if (columnIndex !== -1) {
    tableHeaders[columnIndex].classList.add(`sort-${sortDirection}`);
  }
}

// --- Pagination Control Functions (called by HTML buttons) ---

/**
 * Changes the current page.
 * @param {number} delta - +1 for next, -1 for previous.
 */
function changePage(delta) {
  const recordsPerPage = parseInt(
    document.getElementById("recordsPerPage").value,
    10
  );
  const totalPages = Math.ceil(currentData.length / recordsPerPage);

  const newPage = currentPage + delta;

  if (newPage >= 1 && newPage <= totalPages) {
    currentPage = newPage;
    renderTable();
  }
}

/**
 * Resets pagination and re-renders when the records per page changes.
 */
function resetPaginationAndFilter() {
  currentPage = 1;
  // Re-apply filter logic here if there was any (currently none needed)
  // currentData = ALL_SCHOOLS_DATA; // Or apply filter here

  renderTable();
}

// --- Initialization ---

/**
 * Initializes the entire application.
 */
function initializeTable() {
  // 1. Pre-process the initial data (add combined address, etc.)
  currentData = preprocessData(ALL_SCHOOLS_DATA);

  // 2. Attach click listeners for sorting on headers
  attachHeaderListeners();

  // 3. Initial rendering
  renderTable();
}

// Attach a default visual style for the sorting indicators (you might want to use CSS for this)
const style = document.createElement("style");
style.textContent = `
    .sortable {
        cursor: pointer;
        position: relative;
    }
    .sortable::after {
        content: '';
        display: inline-block;
        margin-left: 5px;
        width: 0;
        height: 0;
        border-left: 4px solid transparent;
        border-right: 4px solid transparent;
        opacity: 0.3; /* Visually subtle until active */
    }
    .sort-asc::after {
        border-bottom: 4px solid #000; /* Up arrow for ASC */
        opacity: 1; 
    }
    .sort-desc::after {
        border-top: 4px solid #000; /* Down arrow for DESC */
        opacity: 1;
    }
`;
document.head.appendChild(style);

// Run initialization once the DOM is ready
document.addEventListener("DOMContentLoaded", initializeTable);
