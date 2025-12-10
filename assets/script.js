// script.js

// 1. Αρχικές σταθερές κλίμακας
let currentScale = 1.0;
const scaleStep = 0.02; // Βήμα αύξησης/μείωσης (π.χ., 10%)
const maxScale = 2.0;
const minScale = 0.5;

// Η ΔΙΟΡΘΩΣΗ: Τυλίγουμε όλο τον κώδικα μέσα στο DOMContentLoaded
document.addEventListener('DOMContentLoaded', () => {
    
    // 2. Παίρνουμε τα στοιχεία (ΤΩΡΑ ΔΟΥΛΕΥΕΙ, γιατί το DOM έχει φορτωθεί)
    const pageContent = document.getElementById('page-content');
    const zoomInBtn = document.getElementById('zoomInBtn');
    const zoomOutBtn = document.getElementById('zoomOutBtn');
    const resetBtn = document.getElementById('resetBtn');

    /**
     * Εφαρμόζει την τρέχουσα τιμή κλίμακας στο CSS.
     */
    function applyZoom() {
        // Εδώ η μεταβλητή pageContent δεν θα είναι πλέον null
        pageContent.style.transform = `scale(${currentScale})`;
    }

    // 3. Λογική για τη Μεγέθυνση (Zoom In)
    zoomInBtn.addEventListener('click', () => {
        if (currentScale < maxScale) {
            currentScale = Math.min(maxScale, currentScale + scaleStep);
            applyZoom();
        }
    });

    // 4. Λογική για τη Σμίκρυνση (Zoom Out)
    zoomOutBtn.addEventListener('click', () => {
        if (currentScale > minScale) {
            currentScale = Math.max(minScale, currentScale - scaleStep);
            applyZoom();
        }
    });

    // 5. Λογική για την Επαναφορά (Reset)
    resetBtn.addEventListener('click', () => {
        currentScale = 1.0;
        applyZoom();
    });

    // Εφαρμόζουμε την αρχική κλίμακα
    applyZoom();
}); // Τέλος του DOMContentLoaded