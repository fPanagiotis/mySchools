# mySxDr — Read-only table package

Αυτό το πακέτο περιέχει όλα τα αρχεία για να υλοποιήσεις μία σελίδα που εμφανίζει έναν πίνακα σχολείων (έως ~1000 εγγραφές) με **client-side JSON**, **live search**, **φιλτράρισμα**, **highlight** και **pagination** — χωρίς φορτίο στον server κατά την χρήση.

Περιλαμβάνονται αναλυτικά σχόλια σε κάθε αρχείο και στις σημαντικές εντολές.

## Περιεχόμενα
- `generate_data.php` — PHP script που διαβάζει τη βάση (PDO) και παράγει `data.json`.
- `data.json` — Δείγμα δεδομένων (μικρό) — αντικατέστησε με το πραγματικό output από `generate_data.php`.
- `index.php` — Η σελίδα εμφάνισης (dark-mode, responsive, live search, filters, highlight, export CSV).
- `assets/styles.css` — Όλο το CSS, με σκοτεινό θεματισμό και responsive κανόνες.
- `assets/app.js` — Όλο το JavaScript (fetch data, filter, search, pagination, highlight, export).

## Οδηγίες εγκατάστασης
1. Αντέγραψε τον φάκελο `school_table_package` στο web-root του site (π.χ. `/var/www/vhosts/yourdomain/httpdocs/mysxdr/`).
2. Ρύθμισε τα credentials της βάσης στο `generate_data.php` (host, db, user, pass).
3. Τρέξε `php generate_data.php` για να δημιουργηθεί το `data.json` (ή ρύθμισε cron/trigger όταν αλλάζει ο πίνακας).
4. Βεβαιώσου τα permissions: `data.json` πρέπει να είναι αναγνώσιμο (π.χ. 644).

## Χρήση
- Η σελίδα `index.php` φορτώνει `data.json` με `fetch()` και κάνει όλα τα filters/search/pagination client-side.
- Αν ο πίνακας μεγαλώσει σημαντικά (>20k εγγραφές) σκέψου server-side filtering.

## Σημειώσεις ασφάλειας
- Μη διατηρείς credentials σε δημόσιο repo.
- Το πακέτο προορίζεται για read-only ανάγνωση — δεν εκθέτει endpoints για αλλαγές.

-- Δημιουργία πίνακα σχολείων
CREATE TABLE mySchools (
    mySchId INT AUTO_INCREMENT PRIMARY KEY,

    mySchType VARCHAR(50) NOT NULL DEFAULT '',
    mySchDimos VARCHAR(100) NOT NULL DEFAULT '',
    mySchCode VARCHAR(10) NOT NULL DEFAULT '',
    mySchName VARCHAR(255) NOT NULL DEFAULT '',
    mySchTel VARCHAR(25) DEFAULT '',
    mySchEmail VARCHAR(50) DEFAULT '',
    mySchAddr VARCHAR(255) DEFAULT '',
    mySchZip VARCHAR(5) DEFAULT '',
    
    mySchLatitude DECIMAL(9,6) DEFAULT NULL,
    mySchLongitude DECIMAL(9,6) DEFAULT NULL,

    INDEX (mySchCode),
    INDEX (mySchDimos),
    INDEX (mySchType)
);



INSERT INTO mySchools (mySchType, mySchDimos, mySchCode, mySchName, mySchTel, mySchEmail, mySchAddr, mySchZip, mySchLatitude, mySchLongitude) VALUES 


INSERT INTO mySchools (mySchType, mySchDimos, mySchCode, mySchName, mySchTel, mySchEmail, mySchAddr, mySchZip, mySchLatitude, mySchLongitude) VALUES 
