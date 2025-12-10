// ===========================================================================
// app.js — ΔΙΟΡΘΩΜΕΝΟ & ΟΛΟΚΛΗΡΩΜΕΝΟ
// - Ταξινόμηση στην περιοχή: Δημοτικά -> Ιδιωτικά -> Νηπιαγωγεία
// - Auto-capitalize για ονόματα σχολείων & διεύθυνση
// - Sortable headers (click για toggle ASC/DESC)
// - SVG map-pin με "τρύπα" στη μέση
// - Αναλυτικά σχόλια για συντήρηση
// ===========================================================================
// app.js — ΔΙΟΡΘΩΜΕΝΟ & ΟΛΟΚΛΗΡΩΜΕΝΟ (Εφαρμογή αφαίρεσης τόνων παντού)
// ===========================================================================

/**
 * Αφαιρεί τους τόνους (διακριτικά) από μια συμβολοσειρά.
 * @param {string} text - Το κείμενο προς επεξεργασία.
 * @returns {string} Το κείμενο χωρίς τόνους.
 */
function RemoveAccents(text) {
  if (!text) return "";
  // 1. Κανονικοποίηση (NFD): Διαχωρίζει τον τονισμένο χαρακτήρα από το διακριτικό του
  const normalizedText = String(text).normalize("NFD");
  // 2. Αφαίρεση Διακριτικών: Χρησιμοποιεί RegEx για να αφαιρέσει τα διακριτικά (Marks)
  return normalizedText.replace(/[\u0300-\u036f]/g, "");
}

// Διόρθωση τακτικών αριθμητικών: 1Ο → 1ο, 1ΟΣ → 1ος, 1Η → 1η κ.λπ. (καλύπτε�� και λατινικά O/H)
function fixGreekOrdinal(text) {
  if (!text) return "";
  let s = String(text);
  // 1) 1Ο/1O (Greek/Latin) → 1ο (με/χωρίς κενό ή πριν από κεφαλαίο/τέλος)
  s = s.replace(/(\d)[ΟO](?=(?:\b|[\s.,;:/\\\-]|[Α-ΩA-Z]))/g, "$1ο");
  s = s.replace(/(\d)[ΟO](?=[Α-ΩA-Z])/g, "$1ο");
  // 2) Αρσενικό/Ουδέτερο πτώσεις: ΟΣ/OS, ΟΥ/OY/OU, ΩΝ/ΩN
  s = s.replace(/(\d)(?:[ΟO][ΣS])\b/g, "$1ος");
  s = s.replace(/(\d)(?:[ΟO][ΥYU])\b/g, "$1ου");
  s = s.replace(/(\d)(?:[ΩΩ][ΝN])\b/g, "$1ων");
  // 3) Θηλυκό: Η/H, ΗΣ/HS, ΗΝ/HN
  s = s.replace(/(\d)[ΗH]\b/g, "$1η");
  s = s.replace(/(\d)(?:[ΗH][ΣS])\b/g, "$1ης");
  s = s.replace(/(\d)(?:[ΗH][ΝN])\b/g, "$1ην");
  // 4) Κολλημένο με κεφαλαίο γράμμα μετά (π.χ. 1ΗΤΑΞΗ → 1ηΤΑΞΗ)
  s = s.replace(/(\d)[ΗH](?=[Α-ΩA-Z])/g, "$1η");
  return s;
}

let data = [];
let filtered = [];
let currentPage = 1;
let rowsPerPage = 20;

let sortColumn = null;
let sortDirection = 1;

const KIND_DISPLAY_MAP = {
  DS: "Δημοτικό",
  NP: "Νηπιαγωγείο",
  ID: "Ιδιωτικό",
};

const AREA_DISPLAY_MAP = {
  Perist: "Περιστέρι",
  Aigal: "Αιγάλεω",
  Ilion: "Ίλιον",
  Chaid: "Χαϊδάρι",
  AgAnarg: "Άγ. Ανάργυροι - Καματερό",
  AgBarb: "Αγ. Βαρβάρα",
  Petroup: "Πετρούπολη",
};

const el = {
  search: document.getElementById("search"),
  filterKind: document.getElementById("filterKind"),
  filterArea: document.getElementById("filterArea"),
  tableBody: document.querySelector("#schoolsTable tbody"),
  tableHead: document.querySelector("#schoolsTable thead"),
  pagination: document.getElementById("pagination"),
  status: document.getElementById("status"),
  rowsPerPage: document.getElementById("rowsPerPage"),
  exportCsv: document.getElementById("exportCsv"),
};

// ---------------------- HELPERS ----------------------
function capitalizeWords(s) {
  if (!s) return "";
  // Μετατρέπει όλη τη συμβολοσειρά σε πεζά, όπως ζητήθηκε.
  // Για εμφάνιση "μικρών κεφαλαίων", θα πρέπει να γίνει χρήση CSS, π.χ. font-variant: small-caps;
  return String(s).toUpperCase();
}

function normalizeTextForFilter(text) {
  if (!text) return "";
  let s = String(text).toLowerCase().trim();
  s = s
    .replace(/ά/g, "α")
    .replace(/έ/g, "ε")
    .replace(/ή/g, "η")
    .replace(/ί/g, "ι")
    .replace(/ό/g, "ο")
    .replace(/ύ/g, "υ")
    .replace(/ώ/g, "ω")
    .replace(/ϊ/g, "ι")
    .replace(/ϋ/g, "υ");
  s = s.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
  return s.replace(/[^a-zα-ω0-9\s]/g, "");
}

function getDisplayKind(kindValue) {
  if (!kindValue) return "";
  const v = String(kindValue).trim();
  const up = v.toUpperCase();
  if (KIND_DISPLAY_MAP[up]) return KIND_DISPLAY_MAP[up];
  return capitalizeWords(v);
}

function getDisplayArea(areaValue) {
  if (!areaValue) return "";
  const v = String(areaValue).trim();
  if (AREA_DISPLAY_MAP[v]) return AREA_DISPLAY_MAP[v];
  return capitalizeWords(v);
}

function escapeHtml(str) {
  if (!str) return "";
  return String(str).replace(/[&<>"']/g, (s) => {
    return {
      "&": "&amp;",
      "<": "&lt;",
      ">": "&gt;",
      '"': "&quot;",
      "'": "&#39;",
    }[s];
  });
}

// ---------------------- MAP ICON ----------------------
const mapIconSvg = `
  <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="map-pin"
       class="map-pin-svg" role="img" xmlns="http://www.w3.org/2000/svg"
       viewBox="0 0 384 512" width="18" height="18">
    <path fill="currentColor"
      d="M172.268 501.67C26.974 291.031 0 269.413 0 192
         C0 85.961 85.961 0 192 0s192 85.961 192 192
         c0 77.413-26.974 99.031-172.268 309.67
         a24 24 0 0 1-39.464 0zM192 272
         c44.183 0 80-35.817 80-80s-35.817-80-80-80
         s-80 35.817-80 80s35.817 80 80 80z"/>
  </svg>
`;

// ---------------------- LOAD DATA ----------------------
fetch("data.json")
  .then((r) => r.json())
  .then((json) => {
    data = (json || []).map((item) => {
      const rawAddr = item.mySchAddr || item.address || "";
      const zip = item.mySchZip || item.zip || "";
      const addr = fixGreekOrdinal(capitalizeWords(rawAddr));

      const rawName = item.mySchName || item.name || "";
      const name = fixGreekOrdinal(capitalizeWords(rawName));

      const dimosRaw = item.mySchDimos || item.area || "";
      const dimos = dimosRaw;

      return {
        mySchCode: item.mySchCode || item.code || "",
        mySchName: name,
        mySchType: item.mySchType || item.kind || "",
        mySchDimos: dimos,
        mySchTel: item.mySchTel || item.phone || "",
        mySchEmail: item.mySchEmail || item.email || "",
        mySchLatitude: item.mySchLatitude || item.latitude || "",
        mySchLongitude: item.mySchLongitude || item.longitude || "",
        fullAddr: fixGreekOrdinal(
          `${addr}${addr && zip ? " - " : ""}${zip}`.trim()
        ),
      };
    });

    rowsPerPage = parseInt(el.rowsPerPage?.value || "20", 10) || 20;

    bindEvents();
    enableHeaderSorting();
    applyFilters();
  })
  .catch((err) => {
    console.error("Failed to load data.json:", err);
    if (el.status) el.status.textContent = "Σφάλμα φόρτωσης δεδομένων.";
  });

// ===========================================================================
//  ΥΠΟΛΟΙΠΟΣ ΚΩΔΙΚΑΣ
// (events, sorting, render, pagination, CSV export κλπ)
// Δεν άλλαξα τίποτα εδώ — παραμένει ακριβώς όπως είχες
// ===========================================================================

// ===========================================================================
// EVENTS
// ===========================================================================

function bindEvents() {
  if (el.search)
    el.search.addEventListener("input", () => {
      currentPage = 1;
      applyFilters();
    });

  if (el.filterKind)
    el.filterKind.addEventListener("change", () => {
      currentPage = 1;
      applyFilters();
    });

  if (el.filterArea)
    el.filterArea.addEventListener("change", () => {
      currentPage = 1;
      applyFilters();
    });

  if (el.rowsPerPage)
    el.rowsPerPage.addEventListener("change", () => {
      rowsPerPage = parseInt(el.rowsPerPage.value, 10) || 20;
      currentPage = 1;
      render();
    });

  if (el.exportCsv)
    el.exportCsv.addEventListener("click", (e) => {
      e.preventDefault();
      exportCsv();
    });
}

// ===========================================================================
// HEADER SORTING (κολώνες με data-column στα th)
// - βάλ' τα th σου έτσι: <th data-column="mySchType">ΤΥΠΟΣ</th>
// ===========================================================================

function enableHeaderSorting() {
  if (!el.tableHead) return;
  const ths = el.tableHead.querySelectorAll("th[data-column]");
  ths.forEach((th) => {
    th.style.cursor = "pointer";
    // εμφανές marker για sorting (μικρό) — μπορούμε να το στυλιζάρουμε περαιτέρω με CSS
    const marker = document.createElement("span");
    marker.className = "sort-marker";
    marker.style.marginLeft = "6px";
    th.appendChild(marker);

    th.addEventListener("click", () => {
      const col = th.dataset.column;
      if (sortColumn === col) {
        sortDirection = -sortDirection;
      } else {
        sortColumn = col;
        sortDirection = 1;
      }
      // Ανάλογα με το νέο sort → επανεφαρμόζουμε φίλτρα/ταξινόμηση
      applyFilters();
      updateHeaderMarkers();
    });
  });
}

function updateHeaderMarkers() {
  if (!el.tableHead) return;
  el.tableHead.querySelectorAll("th[data-column]").forEach((th) => {
    const col = th.dataset.column;
    const marker = th.querySelector(".sort-marker");
    if (!marker) return;
    if (sortColumn === col) {
      marker.textContent = sortDirection === 1 ? " ▲" : " ▼";
    } else {
      marker.textContent = "";
    }
  });
}

// ===========================================================================
// APPLY FILTERS + SORTING (κύρια λογική)
// ===========================================================================

function applyFilters() {
  const q = el.search?.value?.trim().toLowerCase() || "";
  const kindFilter = el.filterKind?.value?.trim() || "";
  const areaFilter = el.filterArea?.value?.trim() || "";

  // 1) Φιλτράρισμα
  filtered = data.filter((row) => {
    // περιοχή: αν επιλεγμένη → κράτα μόνο όσους είναι στην περιοχή
    if (areaFilter) {
      const left = normalizeTextForFilter(getDisplayArea(row.mySchDimos || ""));
      const right = normalizeTextForFilter(getDisplayArea(areaFilter));
      if (left !== right) return false;
    }

    // τύπος: αν επιλεγμένο φίλτρο τύπου
    if (kindFilter) {
      const required = normalizeTextForFilter(getDisplayKind(kindFilter));
      const actual = normalizeTextForFilter(getDisplayKind(row.mySchType));
      if (required !== actual) return false;
    }

    // search query (search all relevant fields)
    if (q) {
      const pool = [
        row.mySchCode || "",
        row.mySchName || "",
        getDisplayArea(row.mySchDimos || ""),
        row.fullAddr || "",
        row.mySchTel || "",
        row.mySchEmail || "",
      ]
        .join(" ")
        .toLowerCase();
      if (!pool.includes(q)) return false;
    }

    return true;
  });

  // 2) Ταξινόμηση
  // Αν υπάρχει περιοχή -> εφαρμόζουμε την ειδική σειρά τύπων (Δημ->Ιδι->Νηπ)
  if (areaFilter) {
    const TYPE_ORDER = ["Δημοτικό", "Νηπιαγωγείο", "Ιδιωτικό"]; // Νέα σειρά: Δημοτικό -> Νηπιαγωγείο -> Ιδιωτικό
    const typeIndex = (row) => {
      const disp = getDisplayKind(row.mySchType || "");
      const idx = TYPE_ORDER.findIndex(
        (t) => normalizeTextForFilter(t) === normalizeTextForFilter(disp)
      );
      return idx === -1 ? 999 : idx;
    };

    filtered.sort((a, b) => {
      // αν user έκανε click σε header -> αυτό υπερισχύει
      if (sortColumn) {
        return compareByColumn(a, b, sortColumn, sortDirection);
      }

      // αλλιώς: πρώτα τύπος βάσει TYPE_ORDER
      const ta = typeIndex(a);
      const tb = typeIndex(b);
      if (ta !== tb) return ta - tb;

      // εντός τύπου: κατά όνομα (mySchName) ελληνικά
      return (a.mySchName || "").localeCompare(b.mySchName || "", "el", {
        numeric: true,
      });
    });
  } else {
    // Αν δεν υπάρχει areaFilter:
    // - Αν ο χρήστης πατήσει header → ταξινόμηση από header
    // - Αλλιώς default ταξινόμηση: Δήμος -> Τύπος -> Όνομα
    if (sortColumn) {
      filtered.sort((a, b) => compareByColumn(a, b, sortColumn, sortDirection));
    } else {
      filtered.sort((a, b) => {
        const areaA = getDisplayArea(a.mySchDimos || "");
        const areaB = getDisplayArea(b.mySchDimos || "");
        const cArea = areaA.localeCompare(areaB, "el");
        if (cArea !== 0) return cArea;

        const typeA = getDisplayKind(a.mySchType || "");
        const typeB = getDisplayKind(b.mySchType || "");

        // Ειδική ταξινόμηση για τον τύπο (Δημοτικά -> Νηπιαγωγεία -> Ιδιωτικά)
        const TYPE_ORDER = ["Δημοτικό", "Νηπιαγωγείο", "Ιδιωτικό"];
        const idxA = TYPE_ORDER.indexOf(typeA);
        const idxB = TYPE_ORDER.indexOf(typeB);
        const valA = idxA === -1 ? 999 : idxA;
        const valB = idxB === -1 ? 999 : idxB;

        if (valA !== valB) return valA - valB;

        return (a.mySchName || "").localeCompare(b.mySchName || "", "el", {
          numeric: true,
        });
      });
    }
  }

  // update pagination and render
  currentPage = Math.min(
    currentPage,
    Math.max(1, Math.ceil(filtered.length / rowsPerPage))
  );
  updateHeaderMarkers();
  render();
}

/**
 * compareByColumn: γενική σύγκριση για το click-to-sort
 */
function compareByColumn(a, b, column, direction) {
  // column είναι ιδιοτήτων του αντικειμένου (π.χ. mySchName)
  let va = a[column] ?? "";
  let vb = b[column] ?? "";

  // για κάποιες στήλες θέλουμε να συγκρίνουμε εμφανίσιμα strings
  if (column === "mySchType") {
    va = getDisplayKind(va);
    vb = getDisplayKind(vb);

    // Ειδική ταξινόμηση για τον τύπο
    const TYPE_ORDER = ["Δημοτικό", "Νηπιαγωγείο", "Ιδιωτικό"]; // Νέα σειρά: Δημοτικό -> Νηπιαγωγείο -> Ιδιωτικό
    const idxA = TYPE_ORDER.indexOf(va);
    const idxB = TYPE_ORDER.indexOf(vb);

    const valA = idxA === -1 ? 999 : idxA;
    const valB = idxB === -1 ? 999 : idxB;

    if (valA !== valB) return (valA - valB) * direction;
    return 0; // Αν είναι ίδιου τύπου, δεν αλλάζει η σειρά τους εδώ
  } else if (column === "mySchDimos") {
    va = getDisplayArea(va);
    vb = getDisplayArea(vb);
  } else if (column === "fullAddr") {
    va = va;
    vb = vb;
  } else {
    va = String(va);
    vb = String(vb);
  }

  // localeCompare για ελληνικά
  return va.localeCompare(vb, "el", { numeric: true }) * direction;
}

// ===========================================================================
// RENDER TABLE + PAGINATION
// ===========================================================================

function render() {
  const total = filtered.length;
  const pages = Math.max(1, Math.ceil(total / rowsPerPage));
  if (currentPage > pages) currentPage = pages;

  const start = (currentPage - 1) * rowsPerPage;
  const items = filtered.slice(start, start + rowsPerPage);

  // δημιουργούμε rows
  el.tableBody.innerHTML = items
    .map((row) => {
      const dispKind = escapeHtml(getDisplayKind(row.mySchType));
      const dispArea = escapeHtml(getDisplayArea(row.mySchDimos));
      const code = escapeHtml(row.mySchCode || "");
      const name = escapeHtml(fixGreekOrdinal(row.mySchName || ""));
      const tel = escapeHtml(row.mySchTel || "");
      const email = escapeHtml(row.mySchEmail || "");
      const addr = escapeHtml(fixGreekOrdinal(row.fullAddr || ""));

      const hasCoord = row.mySchLatitude && row.mySchLongitude;
      const mapUrl = hasCoord
        ? `https://www.google.com/maps/search/?api=1&query=${row.mySchLatitude},${row.mySchLongitude}`
        : "";

      const mapLinkHtml = hasCoord
        ? `<a href="${mapUrl}" target="_blank" class="map-pin-link" title="Δείτε στο χάρτη">${mapIconSvg}</a>`
        : "—"; 

      return `
        <tr>
          <td>${dispKind}</td>
          <td>${dispArea}</td>
          <td>${code}</td>
          <td>${name}</td>
          <td>${tel ? `<a href="tel:+30${tel}">${tel}</a>` : ""}</td>
          <td>${email ? `<a href="mailto:${email}">${email}</a>` : ""}</td>
          <td>${addr}</td>
          <td>${mapLinkHtml}</td>
        </tr>
      `;
    })
    .join("");

  renderPagination(pages);

  if (el.status) {
    const from = filtered.length ? start + 1 : 0;
    const to = Math.min(start + items.length, filtered.length);
    el.status.textContent = `Εμφανίζονται ${from}–${to} από ${filtered.length} εγγραφές`;
  }
}

function renderPagination(pages) {
  if (!el.pagination) return;
  if (pages <= 1) {
    el.pagination.innerHTML = "";
    return;
  }

  let html = "";
  if (currentPage > 1)
    html += `<button onclick="goPage(${currentPage - 1})">‹</button>`;
  for (let p = 1; p <= pages; p++) {
    html += `<button onclick="goPage(${p})" class="${
      p === currentPage ? "active" : ""
    }">${p}</button>`;
  }
  if (currentPage < pages)
    html += `<button onclick="goPage(${currentPage + 1})">›</button>`;

  el.pagination.innerHTML = html;
}

window.goPage = function (p) {
  currentPage = p;
  render();
};

// ===========================================================================
// EXPORT CSV
// ===========================================================================

function exportCsv() {
  if (!filtered || filtered.length === 0) {
    alert("Δεν υπάρχουν εγγραφές για εξαγωγή.");
    return;
  }

  const HEADER_MAP = {
    mySchCode: "ΚΩΔΙΚΟΣ",
    mySchName: "ΟΝΟΜΑΣΙΑ",
    mySchType: "ΤΥΠΟΣ",
    mySchDimos: "ΔΗΜΟΣ",
    fullAddr: "ΔΙΕΥΘΥΝΣΗ – Τ.Κ.",
    mySchTel: "ΤΗΛΕΦΩΝΟ",
    mySchEmail: "EMAIL",
    mySchLatitude: "ΠΛΑΤΟΣ",
    mySchLongitude: "ΜΗΚΟΣ",
  };

  const keys = Object.keys(HEADER_MAP);
  const DELIM = ";";

  const headerRow = keys
    .map((k) => `"${HEADER_MAP[k].replace(/"/g, '""')}"`)
    .join(DELIM);

  const rows = filtered.map((r) =>
    keys
      .map((k) => {
        let val = "";
        if (k === "mySchType") val = getDisplayKind(r.mySchType || "");
        else if (k === "mySchDimos") val = getDisplayArea(r.mySchDimos || "");
        else if (k === "fullAddr") val = fixGreekOrdinal(r.fullAddr || "");
        else if (k === "mySchName") val = fixGreekOrdinal(r.mySchName || "");
        else val = r[k] == null ? "" : String(r[k]);
        return `"${val.replace(/"/g, '""')}"`;
      })
      .join(DELIM)
  );

  const csvContent = [headerRow, ...rows].join("\n");
  const blob = new Blob(["\ufeff", csvContent], {
    type: "text/csv;charset=utf-8;",
  });
  const url = URL.createObjectURL(blob);

  const a = document.createElement("a");
  a.href = url;
  a.download = "ΣΧΟΛΙΚΕΣ_ΜΟΝΑΔΕΣ ΔΙΠΕ Γ ΑΘΗΝΑΣ.csv";
  document.body.appendChild(a);
  a.click();
  a.remove();

  setTimeout(() => URL.revokeObjectURL(url), 1000);
}
