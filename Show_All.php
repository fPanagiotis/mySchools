<?php include_once __DIR__ . "/assets/Version.php"; ?>
<!-- =======================================================================================
     Developer: Φράγκος Παναγιώτης (ΠΕ86)
     Έτος: <?= $mySchoolsYear; ?>

     Εφαρμογή προβολής και αναζήτησης σχολικών μονάδων
     Αυτόματη Έκδοση Build: <?= $mySchoolsVersion; ?>
     
     Web Site: www.tosxoleio.eu
     eMail: fpanos@sch.gr
======================================================================================= -->
<?php


// Δυναμικός τίτλος – μπορείς να τον αλλάζεις
$page_title = "www.tosxoleio.online - Ολες οι Σχολικές Μονάδες της Ελλάδας";

// Δυναμική περιγραφή
$page_description = "Δες όλες τις σχολικές μονάδες της Ελλάδας και των δύο βαθμίδων (Πρωτοβάθμια και Δευτεροβάθμια), Δημόσια και Ιδιωτικά. Μια ιστοσελίδα με εύκολη αναζήτηση ανά Περιφέρεια, Διεύθυνση Εκπαίδευσης, Βαθμίδα Εκπαίδευσης, Δήμο και δυνατότητα εξαγωγής σε CSV αρχείο. Μπορείτε να βρείτε εύκολα το σχολείο που σας ενδιαφέρει, να βρείτε το τηλέφωνο της κάθε Σχολικης Μονάδας, τη διεύθυνση ηλεκτρονικού ταχυδρομείου καθώς και να βρείτε το σχολειο στο χάρτη ";

// URL της σελίδας που μοιράζεσαι
$page_url = "https://dipe-g-athin.att.sch.gr/mySchools/Show_All.php";

// Εικόνα (πρέπει να είναι τουλάχιστον 1200×630)
$page_image = "Img/Share.png";

// Show_All.php — ΤΕΛΙΚΑ ΔΙΟΡΘΩΜΕΝΗ ΕΚΔΟΣΗ (Index & Title Side-by-Side, Info Full-Width, FIELDS IN GRID LAYOUT)
$jsonPath = __DIR__ . '/mySchoolsAll.json';
$schools = [];
if (file_exists($jsonPath)) {
   $raw = file_get_contents($jsonPath);
   $decoded = json_decode($raw, true);
   if (is_array($decoded)) {
      $schools = $decoded;
   } elseif (isset($decoded['schools']) && is_array($decoded['schools'])) {
      $schools = $decoded['schools'];
   }
}
$json_content = json_encode($schools, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
?>
<!DOCTYPE html>
<html lang="el">

<head>
   <meta charset="utf-8">
   <!-- ====== OPEN GRAPH (Facebook, Messenger, Viber, LinkedIn) ====== -->
   <meta property="og:type" content="website">
   <meta property="og:title" content="<?= $page_title ?>">
   <meta property="og:description" content="<?= $page_description ?>">
   <meta property="og:url" content="<?= $page_url ?>">
   <meta property="og:image" content="<?= $page_image ?>">
   <meta property="og:image:width" content="1200">
   <meta property="og:image:height" content="630">
   <meta property="og:locale" content="el_GR">

   <!-- ====== TWITTER CARD (Twitter/X, WhatsApp) ====== -->
   <meta name="twitter:card" content="summary_large_image">
   <meta name="twitter:title" content="<?= $page_title ?>">
   <meta name="twitter:description" content="<?= $page_description ?>">
   <meta name="twitter:image" content="<?= $page_image ?>">

   <!-- Optional SEO -->
   <meta name="description" content="<?= $page_description ?>">


   <meta name="viewport" content="width=device-width,initial-scale=1">
   <title>Όλες οι Σχολικές Μονάδες της Χώρας</title>
   <link rel="stylesheet" href="assets/styles.css">
   <link rel="icon" href="Img/Share.png" type="image/png" sizes="32x32">
   <title>Σχολικές Μονάδες</title>
   <style>
      /* --- ΒΑΣΙΚΟ ΣΤΥΛ & ΧΡΩΜΑΤΙΚΗ ΠΑΛΕΤΑ (ΑΛΛΑΓΗ ΧΡΩΜΑΤΩΝ ΕΔΩ) --- */
      :root {
         /* ΒΑΣΙΚΑ ΧΡΩΜΑΤΑ */
         --bg: #eef0f6;
         /* Κύριο background σελίδας (πολύ απαλό γκρι/μπλε) */
         --panel: #f7f8fc;
         /* Background Sidebar/Controls (ελαφρώς πιο σκούρο από το --bg) */
         --card: #ffffff;
         /* Background Κάρτας (Άσπρο) */
         --text: #3d4350;
         /* Σκούρο Κείμενο (κύριο κείμενο, π.χ. φίλτρα) */
         --muted: #6f7480;
         /* Σίγαση Κειμένου (Για Labels/Διευθύνσεις) */
         --myColor: #5b6598;
         /* Έντονο Σκούρο Accent (π.χ. Τίτλοι Sidebar & Τιμές πεδίων) */

         /* ΧΡΩΜΑΤΑ ACCENT (Απαλές Αποχρώσεις Μπλε/Μοβ) */
         --accent: #b1bbff;
         /* Κύριο Accent (π.χ. Index/Κεφαλίδα/Hover Περιγράμματα) */
         --accent-2: #e8ebff;
         /* Πιο Απαλό Accent (π.χ. Primary Button Background) */
         --color-border: #e2e8f0;
         /* Γραμμές διαχωρισμού/περιγράμματα */

         /* ΣΚΙΕΣ (Αν θέλετε πιο "επίπεδο" στυλ, μειώστε τα opacity/px) */
         --card-shadow:
            0 2px 4px rgba(0, 0, 0, 0.2),
            0 15px 30px rgba(0, 0, 0, 0.15);
         /* Βασική σκιά για βάθος κάρτας */
         --card-shadow-hover:
            0 4px 8px rgba(0, 0, 0, 0.1),
            0 20px 40px rgba(0, 0, 0, 0.25),
            0 0 0 2px var(--accent);
         /* Έντονη σκιά + φωτεινό περίγραμμα στο hover */
      }

      /* ΒΑΣΙΚΟ ΣΩΜΑ ΣΕΛΙΔΑΣ */
      body {
         font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
         margin: 0;
         background: var(--bg);
         color: var(--text);
         line-height: 1.5;

      }

      /* ΚΕΦΑΛΙΔΑ */
      header {
         padding: 18px 24px;
         background-color: rgba(125, 140, 255, 0.1);
         /* Χρήση του βασικού accent */
         color: var(--myColor);
         /* Σκούρο κείμενο για αντίθεση */
         box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
         text-align: center;
      }

      /* ΚΥΡΙΟΣ ΠΕΡΙΕΚΤΗΣ (ΣΕΛΙΔΑ) */
      .container {
         display: grid;
         grid-template-columns: 220px 1fr;
         gap: 20px;
         padding: 15px;
         max-width: 900px;
         margin: 15px auto;
         align-items: start;
      }

      /* --- SIDEBAR & ΦΙΛΤΡΑ (ΧΡΗΣΗ panel, myColor) --- */
      .sidebar {
         background: linear-gradient(135deg, var(--panel) 0%, rgba(248, 249, 253, 0.8) 100%);
         border-radius: 18px;
         padding: 18px 12px 18px 12px;
         box-shadow: 0 4px 12px rgba(91, 101, 152, 0.08), 0 2px 4px rgba(0, 0, 0, 0.04);
         position: sticky;
         text-align: center;
         top: 15px;
         border: 1px solid var(--color-border);
         transition: all 0.3s ease;
      }

      .sidebar:hover {
         box-shadow: 0 6px 16px rgba(91, 101, 152, 0.12), 0 3px 6px rgba(0, 0, 0, 0.06);
      }

      .sidebar h2 {
         font-size: 16px;
         margin-top: 0;
         margin-bottom: 14px;
         border-bottom: 2px solid var(--accent);
         padding-bottom: 8px;
         color: var(--myColor);
         font-weight: 500;
      }

      .filter-group {
         margin-bottom: 5px;
      }

      .filter-group label {
         font-size: 11px;
         font-weight: 500;
         display: block;
         margin-bottom: 5px;
         color: var(--text);
      }

      .filter-group input[type="text"]:focus,
      .filter-group select:focus {
         border-color: var(--accent);
         outline: none;
         box-shadow: 0 0 0 4px rgba(177, 187, 255, 0.4);
         /* Σκιά focus με το accent */
      }

      .filter-actions {
         display: grid;
         grid-template-columns: 1fr 1fr;
         gap: 3px;
         margin-top: 0px;
      }

      .filter-actions .btn {
         margin-left: 0;
         margin-top: 20px;
         width: 100%;
         font-weight: 500;
      }

      /* ΕΙΔΙΚΟ ΣΤΥΛ ΓΙΑ ΤΑ SELECT (ΓΙΑ ΤΟ ΒΕΛΑΚΙ) */
      select,
      input[type="text"] {
         padding: 6px 8px;
         border: 1px solid var(--accent);
         margin-bottom: 1px;
         border-radius: 8px;
         margin-left: 5px;
         max-width: 100%;
         width: 100%;
         box-sizing: border-box;
         font-size: 12px;
      }

      /* --- BUTTONS --- */
      .btn {
         padding: 8px 14px;
         border-radius: 8px;
         cursor: pointer;
         margin-left: 12px;
         font-weight: 400;
         border: 1px solid var(--accent);
         transition: background-color 0.2s, box-shadow 0.2s, transform 0.15s;
         font-size: 12px;
         color: rgba(125, 140, 255, 1);
      }

      .btn-primary {
         background: linear-gradient(180deg, rgba(255, 255, 255, 0.9) 0%, var(--accent-2) 100%);
         box-shadow:
            4px 4px 10px rgba(91, 101, 152, 0.2),
            -2px -2px 6px rgba(255, 255, 255, 0.8),
            inset 0 1px 2px rgba(255, 255, 255, 0.6);
         color: rgba(125, 140, 255, 1);
      }

      .btn-primary:hover {
         background: linear-gradient(180deg, rgba(255, 255, 255, 0.95) 0%, var(--accent) 100%);
         box-shadow:
            6px 6px 14px rgba(91, 101, 152, 0.25),
            -2px -2px 6px rgba(255, 255, 255, 0.9),
            inset 0 1px 3px rgba(255, 255, 255, 0.7);
         transform: translateY(-2px) scale(1.05);
         color: rgba(125, 140, 255, 1);
      }

      .btn-primary:active {
         transform: translateY(1px) scale(0.98);
         box-shadow:
            2px 2px 5px rgba(91, 101, 152, 0.15),
            inset 0 2px 4px rgba(91, 101, 152, 0.1);
      }

      .btn-ghost {
         background: linear-gradient(180deg, rgba(255, 255, 255, 0.7) 0%, rgba(232, 235, 255, 0.5) 100%);
         box-shadow:
            3px 3px 8px rgba(91, 101, 152, 0.15),
            -2px -2px 5px rgba(255, 255, 255, 0.7),
            inset 0 1px 1px rgba(255, 255, 255, 0.5);
         color: rgba(125, 140, 255, 1);
      }

      .btn-ghost:hover {
         background: linear-gradient(180deg, rgba(255, 255, 255, 0.9) 0%, var(--accent) 100%);
         border-color: var(--accent);
         box-shadow:
            5px 5px 12px rgba(91, 101, 152, 0.2),
            -2px -2px 6px rgba(255, 255, 255, 0.8),
            inset 0 1px 2px rgba(255, 255, 255, 0.6);
         transform: translateY(-2px) scale(1.05);
         color: rgba(125, 140, 255, 1);
      }

      .btn-ghost:active {
         transform: translateY(1px) scale(0.98);
         box-shadow:
            2px 2px 5px rgba(91, 101, 152, 0.1),
            inset 0 2px 4px rgba(91, 101, 152, 0.1);
      }

      /* --- MAIN CONTENT & CARDS (ΚΥΡΙΟ ΠΕΡΙΕΧΟΜΕΝΟ & ΚΑΡΤΕΣ) --- */
      .main {
         display: flex;
         flex-direction: column;
         gap: 20px;
         margin: 0 auto;
         width: 100%;
      }

      /* ΠΕΡΙΕΚΤΗΣ CONTROLS (TOP/BOTTOM) */
      .controls-top {
         font-size: 0.8em;
         padding-left: 10px;
      }

      /* ΠΕΡΙΕΚΤΗΣ ΚΑΡΤΩΝ (GRID LAYOUT) */
      .cards-wrapper {
         display: grid;
         grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
         gap: 15px;
         margin: 0 auto;
         width: 100%;
      }

      /* ΤΟ ΠΛΑΙΣΙΟ ΤΟΥ ΣΧΟΛΕΙΟΥ (1. ΕΝΙΣΧΥΜΕΝΟ 3D/GLOSSY) */
      .card {
         display: flex;
         flex-direction: column;
         /* ΣΤΟΙΒΑΖΕΙ ΤΗΝ ΚΕΦΑΛΙΔΑ ΚΑΙ ΤΟ INFO ΚΑΘΕΤΑ */

         /* ΝΕΟ: Ελαφρύ Gradient (για αίσθηση γυαλάδας από πάνω) */
         background: linear-gradient(180deg, var(--card) 0%, var(--panel) 100%);

         border-radius: 16px;
         padding: 25px 15px;
         gap: 15px;
         min-height: 120px;
         transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);

         /* ΝΕΟ: Ενισχυμένο Περίγραμμα - Δημιουργεί το εφέ "πλαίσιο" */
         border: 1px solid var(--color-border);
         /* ΔΙΑΓΡΑΨΑΜΕ το border-style: outset (το box-shadow είναι καλύτερο) */

         /* ΝΕΟ: Πιο Έντονη Box Shadow (3D/Νεομορφισμός) */
         box-shadow:
            /* 1. Εξωτερική Σκιά (Βάθος) - Πιο σκούρο/μπλε χρώμα (από το myColor) */
            8px 8px 15px rgba(91, 101, 152, 0.2),
            /* 2. Εξωτερική Σκιά (Highlight) - Λευκό φως από πάνω αριστερά */
            -8px -8px 15px rgba(255, 255, 255, 0.7),
            /* 3. Εσωτερική Σκιά (Volume/Gloss) - Λάμψη μέσα στο πλαίσιο */
            inset 0 1px 2px rgba(91, 101, 152, 0.1);

         /* Χρησιμοποιούμε τη βασική σκιά στο :root για το απλό --card-shadow,
       αλλά εδώ δίνουμε προτεραιότητα στη νέα 3D δομή. */
      }

      .card:hover {
         border-color: rgba(125, 140, 255, 0.1);
         box-shadow: var(--card-shadow-hover);
         transform: translateY(-3px) scale(1.03);
      }

      /* ΠΕΡΙΕΚΤΗΣ INDEX + ΤΙΤΛΟΣ (2. ΔΙΠΛΑ-ΔΙΠΛΑ) */
      .card-header {
         display: flex;
         /* ΟΡΙΖΕΙ ΤΗΝ ΕΜΦΑΝΙΣΗ INDEX + ΤΙΤΛΟΣ ΔΙΠΛΑ-ΔΙΠΛΑ */
         align-items: flex-start;
         gap: 12px;
      }

      /* Η ΑΡΙΘΜΗΣΗ INDEX */
      .card .index {
         min-width: 38px;
         height: 38px;
         border-radius: 50%;
         vertical-align: middle;

         /* 1. ΑΛΛΑΓΗ: Radial Gradient (Γυαλάδα) */
         /* Δημιουργεί την ψευδαίσθηση σφαίρας με το φως να έρχεται από το πάνω αριστερά (18px 18px). 
       Χρησιμοποιεί πιο έντονη αντίθεση χρωμάτων. */
         background: radial-gradient(circle at 18px 18px, #ffffff 0%, #e8ebff 50%, #b1bbff 100%);
         color: var(--myColor);
         display: flex;
         align-items: center;
         justify-content: center;
         font-weight: 700;
         font-size: 15px;
         flex-shrink: 0;

         /* 2. ΑΛΛΑΓΗ: Ελαφρώς πιο σκούρο/έντονο περίγραμμα */
         border: 2px solid rgba(91, 101, 152, 0.3);

         /* 3. ΑΛΛΑΓΗ: Πιο Έντονη Box Shadow (για 3D αίσθηση) */
         box-shadow:
            /* Εξωτερική σκιά (βάθος/αιώρηση): πιο μεγάλη και πιο σκούρα */
            0 8px 18px rgba(0, 0, 0, 0.35),

            /* Εσωτερική σκιά (Highlight/Γυαλάδα): Χρησιμοποιείται για να δημιουργήσει την αίσθηση υγρής, έντονης λάμψης στην επιφάνεια */
            inset 0 0 5px 2px rgba(255, 255, 255, 0.8),

            /* Εσωτερική σκιά (Depth/Volume): Πιο μετατοπισμένη προς τα κάτω για να "σκάψει" τον όγκο */
            inset 0 -5px 8px rgba(91, 101, 152, 0.4);
      }

      /* Ο ΤΙΤΛΟΣ ΤΟΥ ΣΧΟΛΕΙΟΥ */
      .card .card-title {
         font-weight: 700;
         font-size: 13px;
         color: var(--myColor);
         /* Έντονο χρώμα για έμφαση */
         line-height: 1.3;
         display: flex;
         align-items: center;
         gap: 8px;
         flex-grow: 1;
         /* Παίρνει το υπόλοιπο πλάτος */
      }

      /* ΠΕΡΙΕΚΤΗΣ ΓΙΑ ΤΑ ΥΠΟΛΟΙΠΑ ΠΕΔΙΑ (3. ΠΛΗΡΕΣ ΠΛΑΤΟΣ) */
      .card-info {
         display: flex;
         flex-direction: column;
         gap: 15px;
         /* Ελαφρά αύξηση στο κενό μεταξύ Details, Address, Actions */
         flex-grow: 1;
         width: 100%;
         /* Εξασφαλίζει πλήρες πλάτος */
      }

      /* ΠΕΡΙΕΚΤΗΣ ΔΟΜΗΜΕΝΩΝ ΠΕΔΙΩΝ (FIELDS - .details) */
      .card-info .details {
         display: flex;
         flex-direction: column;
         gap: 10px;
      }

      /* ΜΙΑ ΓΡΑΜΜΗ ΠΛΗΡΟΦΟΡΙΑΣ (π.χ. Κωδικός: 12345) */
      .field-line {
         font-size: 12px;
         color: var(--muted);
         /* Χρώμα για το label */
         line-height: 1.4;
         display: flex;
         flex-wrap: wrap;
         gap: 4px 8px;
      }

      .field-line[data-multiline="true"] {
         flex-direction: column;
         gap: 5px;
      }

      /* ΤΟ ΛΕΚΤΙΚΟ ΤΟΥ ΠΕΔΙΟΥ (π.χ. Κωδικός:) */
      .field-line .field-label {
         font-weight: 500;
      }

      .field-line .field-value {
         color: #6b7fd8;
         font-weight: 700;
      }

      .address {
         display: flex;
         align-items: center;
         justify-content: center;
         gap: 8px;
         color: var(--muted);
         font-size: 12px;
         font-weight: 500;
         padding: 8px 0;
         border-top: 1px solid var(--color-border);
         text-align: center;
      }


      .address-icon {
         width: 20px;
         height: 20px;
         min-width: 20px;
         color: var(--myColor);
         flex-shrink: 0;
      }

      .muted {
         color: var(--muted);
         font-size: 0.9em;
      }

      .actions {
         display: grid;
         grid-template-columns: 1fr;
         gap: 8px;
         margin-top: 5px;
         width: 100%;
      }

      /* ΠΛΗΚΤΡΑ ΕΝΕΡΓΕΙΩΝ (τηλέφωνο, email, χάρτης) - 3D/GLOSSY */
      .small-link {
         padding: 6px 11px;
         border-radius: 8px;
         text-decoration: none;
         font-size: 11px;
         display: flex;
         align-items: center;
         justify-content: center;
         color: rgba(125, 140, 255, 1);
         font-weight: 500;
         transition: all 0.2s cubic-bezier(0.25, 0.8, 0.25, 1);
         white-space: nowrap;
         overflow: hidden;

         text-overflow: ellipsis;

         /* 1. ΝΕΟ: Ελαφρύ Gradient για 'Πλαστικό' Look */
         /* Δίνει μια αίσθηση γυαλάδας από το πάνω μέρος του κουμπιού */
         background: linear-gradient(180deg, rgba(255, 255, 255, 1) 0%, var(--accent-2) 100%);

         /* 2. ΝΕΟ: Περίγραμμα */
         border: 1px solid rgba(91, 101, 152, 0.2);
         /* Λεπτό, απαλό περίγραμμα */

         /* 3. ΝΕΟ: 3D Box Shadow */
         box-shadow:
            /* Εξωτερική σκιά (κάτω/δεξιά) για να 'βγει' το κουμπί */
            3px 3px 6px rgba(91, 101, 152, 0.15),
            /* Εξωτερική σκιά (πάνω/αριστερά) για ανάγλυφο */
            -2px -2px 5px rgba(255, 255, 255, 0.8),
            /* Εσωτερική σκιά (top-left) για να ενισχύσει τη γυαλάδα */
            inset 0 1px 1px rgba(255, 255, 255, 0.5);
      }

      .small-link.email {
         grid-column: 1 / -1;
         padding: 7px 12px;
         font-weight: 500;
      }

      .small-link:hover {
         transform: translateY(-2px) scale(1.05);
         box-shadow:
            5px 5px 12px rgba(91, 101, 152, 0.2),
            -2px -2px 6px rgba(255, 255, 255, 0.8),
            inset 0 1px 2px rgba(255, 255, 255, 0.6);
         background: linear-gradient(180deg, rgba(255, 255, 255, 1) 0%, var(--accent) 100%);
      }

      .small-link:active {
         transform: translateY(1px) scale(0.98);
         box-shadow:
            2px 2px 5px rgba(91, 101, 152, 0.15),
            inset 0 2px 4px rgba(91, 101, 152, 0.1);
      }

      .small-link.map:hover {
         transform: translateY(-2px) scale(1.05);
         box-shadow:
            5px 5px 12px rgba(91, 101, 152, 0.2),
            -2px -2px 6px rgba(255, 255, 255, 0.8),
            inset 0 1px 2px rgba(255, 255, 255, 0.6);
         background: linear-gradient(180deg, rgba(255, 255, 255, 1) 0%, var(--accent) 100%);
      }

      .small-link.map:active {
         transform: translateY(1px) scale(0.98);
         box-shadow:
            2px 2px 5px rgba(91, 101, 152, 0.15),
            inset 0 2px 4px rgba(91, 101, 152, 0.1);
      }

      .small-link.map {
         color: var(--myColor);
         /* Χρήση του myColor για πιο έντονο κείμενο */
         /* Πιο έντονο κείμενο */
         transition: all 0.2s cubic-bezier(0.25, 0.8, 0.25, 1);

         /* 1. ΝΕΟ: Ελαφρύ Gradient για 'Πλαστικό' Look */
         /* Δίνει μια αίσθηση γυαλάδας από το πάνω μέρος του κουμπιού */
         background: linear-gradient(180deg, rgba(255, 255, 255, 1) 0%, var(--accent-2) 100%);

         /* 2. ΝΕΟ: Περίγραμμα */
         border: 1px solid rgba(91, 101, 152, 0.2);
         /* Λεπτό, απαλό περίγραμμα */

         /* 3. ΝΕΟ: 3D Box Shadow */
         box-shadow:
            /* Εξωτερική σκιά (κάτω/δεξιά) για να 'βγει' το κουμπί */
            3px 3px 6px rgba(91, 101, 152, 0.15),
            /* Εξωτερική σκιά (πάνω/αριστερά) για ανάγλυφο */
            -2px -2px 5px rgba(255, 255, 255, 0.8),
            /* Εσωτερική σκιά (top-left) για να ενισχύσει τη γυαλάδα */
            inset 0 1px 1px rgba(255, 255, 255, 0.5);
         padding: 6px 11px !important;
         font-size: 11px !important;
         font-weight: 500 !important;
         display: flex !important;
         color: rgba(125, 140, 255, 1);
      }


      .map-pin-svg {
         width: 30px;
         height: 30px;
         margin-right: 6px;
         color: var(--myColor);
      }


      /* --- PAGINATION (ΣΕΛΙΔΟΠΟΙΗΣΗ) --- */
      .pagination {
         display: flex;
         align-items: center;
         justify-content: space-between;
         /* αποφυγή επικάλυψης: αριστερά/δεξιά/κέντρο */
         gap: 12px;
         padding: 20px 0;
         font-weight: 300;
         font-size: 0.8em;
         width: 100%;
      }

      .pagination .info {
         flex: 1;
         text-align: center;
         white-space: nowrap;
      }


      /* Phone-like rectangular pagination buttons (uniform width and proper arrow spacing) */
      .pagination .btn {
         display: inline-flex;
         align-items: center;
         justify-content: center;
         gap: 8px;
         padding: 10px 16px;
         min-width: 130px;
         border: 1px solid var(--accent);
         margin-left: 0;
         font-weight: 500;
         border-radius: 10px;
         /* όχι στρογγυλά */
         background: linear-gradient(180deg, rgba(255, 255, 255, 0.95) 0%, var(--accent-2) 100%);
         box-shadow: 2px 2px 6px rgba(91, 101, 152, 0.15), -1px -1px 3px rgba(255, 255, 255, 0.8), inset 0 1px 0 rgba(255, 255, 255, 0.6);
         transition: background-color 0.15s, border-color 0.15s, transform 0.1s, box-shadow 0.15s;
         color: rgba(125, 140, 255, 1) !important;
      }

      .pagination .btn .arrow {
         font-size: 14px;
         line-height: 1;
         color: rgba(125, 140, 255, 1) !important;
      }

      .pagination .btn:hover {
         transform: translateY(-1px);
         background: linear-gradient(180deg, rgba(255, 255, 255, 1) 0%, var(--accent) 100%);
         box-shadow: 3px 3px 8px rgba(91, 101, 152, 0.2), -1px -1px 4px rgba(255, 255, 255, 0.9), inset 0 1px 0 rgba(255, 255, 255, 0.7);
      }

      .pagination .btn:active {
         transform: translateY(0);
         box-shadow: 1px 1px 3px rgba(91, 101, 152, 0.15), inset 0 2px 3px rgba(91, 101, 152, 0.15);
      }

      .pagination button[disabled] {
         opacity: 0.5;
         cursor: not-allowed;
         background: var(--bg) !important;
         color: var(--muted) !important;
         border-color: var(--color-border);
         transform: none;
         box-shadow: none;
      }

      /* --- RESPONSIVE --- */
      @media (max-width:1000px) {
         .container {
            grid-template-columns: 1fr;
            gap: 20px;
            padding: 15px;
         }

         .sidebar {
            order: 2;
            position: static;
            box-shadow: 0 6px 15px rgba(15, 20, 40, 0.1);
         }

         .cards-wrapper {
            grid-template-columns: repeat(2, 1fr);
         }

         .card:hover {
            transform: none;
            box-shadow: var(--card-shadow);
         }

      }

      @media (max-width: 640px) {
         .cards-wrapper {
            grid-template-columns: 1fr;
         }

         .card {
            padding: 15px 10px;
         }
      }

      #scrollToTop {
         position: fixed;
         bottom: 30px;
         right: 30px;
         min-width: 38px;
         width: 38px;
         height: 38px;
         border-radius: 50%;
         background: radial-gradient(circle at 18px 18px, #ffffff 0%, #e8ebff 50%, #b1bbff 100%);
         border: 2px solid rgba(91, 101, 152, 0.3);
         color: rgba(125, 140, 255, 1);
         font-size: 20px;
         font-weight: 700;
         display: flex;
         align-items: center;
         justify-content: center;
         cursor: pointer;
         transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
         box-shadow: 0 8px 18px rgba(0, 0, 0, 0.35), inset 0 0 5px 2px rgba(255, 255, 255, 0.8), inset 0 -5px 8px rgba(91, 101, 152, 0.4);
         padding: 0;
         z-index: 9999;
      }

      #scrollToTop:hover {
         transform: translateY(-3px) scale(1.1);
         box-shadow: 0 12px 24px rgba(0, 0, 0, 0.4), inset 0 0 5px 2px rgba(255, 255, 255, 0.9), inset 0 -5px 8px rgba(91, 101, 152, 0.5);
      }

      #scrollToTop:active {
         transform: translateY(0) scale(0.95);
         box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25), inset 0 2px 4px rgba(91, 101, 152, 0.2);
      }

      #scrollToTop.hidden {
         opacity: 0;
         pointer-events: none;
         /*         visibility: hidden; */
         transition: opacity 0.3s ease;
      }

      #mainFooter {
         background-color: #e2e5f7;
         padding: 20px;
         margin-top: 40px;
         font-size: 0.8em;
         color: #5b6598;
         display: flex;
         justify-content: center;
         align-items: center;
         box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.2);
         text-align: center;
         width: 100%;
         box-sizing: border-box;
         position: sticky;
         bottom: 0;
         left: 0;
         right: 0;
         width: 100%;
         z-index: 999;
         font-style: normal;
         font-weight: 400;
         font-style: italic;
      }

      .footer-row-2 {
         text-align: center;
         color: #5b6598;
         line-height: 1.5;
      }

      .footer-row-1 {
         display: none;
      }

      #mainFooter a {
         color: rgba(125, 140, 255);
         text-decoration: none;
         font-size: inherit;
         font-style: normal;
         font-weight: 400;
         font-style: italic;
      }

      #mainFooter a:hover {
         text-decoration: underline;
      }

      /* Zoom controls and scaling */
      .top-right-controls {
         position: fixed;
         top: 14px;
         right: 16px;
         display: flex;
         flex-direction: column;
         gap: 8px;
         z-index: 10000;
      }

      .top-right-controls .controls-row {
         display: flex;
         gap: 10px;
         justify-content: flex-end;
      }

      .circle-btn {
         min-width: 38px;
         width: 38px;
         height: 38px;
         border-radius: 50%;
         background: radial-gradient(circle at 18px 18px, #ffffff 0%, #e8ebff 50%, #b1bbff 100%);
         border: 2px solid rgba(91, 101, 152, 0.3);
         color: rgba(125, 140, 255, 1) !important;
         -webkit-text-fill-color: var(--myColor) !important;
         font-size: 18px;
         font-weight: 500;
         display: flex;
         align-items: center;
         justify-content: center;
         cursor: pointer;
         transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
         box-shadow: 0 8px 18px rgba(0, 0, 0, 0.35), inset 0 0 5px 2px rgba(255, 255, 255, 0.8), inset 0 -5px 8px rgba(91, 101, 152, 0.4);
         padding: 0;
         user-select: none;
      }

      /* Force child symbols (span/svg/text) to inherit the same color */
      .top-right-controls .circle-btn>*,
      .top-right-controls .circle-btn svg,
      .top-right-controls .circle-btn path {
         color: rgba(125, 140, 255, 1) !important;
         fill: rgba(125, 140, 255, 1) !important;
         -webkit-text-fill-color: rgba(125, 140, 255, 1) !important;
      }

      .circle-btn:hover {
         transform: translateY(-3px) scale(1.1);
         box-shadow: 0 12px 24px rgba(0, 0, 0, 0.4), inset 0 0 5px 2px rgba(255, 255, 255, 0.9), inset 0 -5px 8px rgba(91, 101, 152, 0.5);
      }

      .circle-btn:active {
         transform: translateY(0) scale(0.95);
         box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25), inset 0 2px 4px rgba(91, 101, 152, 0.2);
      }

      /* Zoom μέσω root font-size (transform στο body αφαιρέθηκε) */
   </style>
</head>

<body>
   <header>
      <h1 style="margin:0;font-size:24px;font-weight:700;">ΟΛΕΣ οι Σχολικές Μονάδες </h1>
   </header>

   <div class="top-right-controls" id="topRightControls" aria-label="Εργαλεία εμφάνισης">
      <div class="controls-row">
         <div class="circle-btn" id="zoomOutBtn" title="Σμίκρυνση" aria-label="Σμίκρυνση">−</div>
         <div class="circle-btn" id="zoomInBtn" title="Μεγέθυνση" aria-label="Μεγέθυνση">+</div>
         <div class="circle-btn" id="zoomResetBtn" title="Επαναφορά" aria-label="Επαναφορά">⤾</div>
      </div>
      <div class="controls-row">
         <div class="circle-btn" id="printBtn" title="Εκτύπωση" aria-label="Εκτύπωση">🖨</div>
      </div>
      <div class="controls-row">
         <div class="circle-btn" id="csvBtn" title="Λήψη αρχείου CSV" aria-label="Λήψη αρχείου CSV">⤓</div>
      </div>
   </div>

   <div style="display:none;">
      <svg aria-hidden="true" focusable="false" data-icon="school-building"
         id="school-svg-template" role="img" xmlns="http://www.w3.org/2000/svg"
         viewBox="0 0 32 32" width="28" height="28">
         <g fill="currentColor">
            <rect x="4" y="10" width="24" height="16" rx="1" />
            <rect x="6" y="12" width="2" height="2" />
            <rect x="10" y="12" width="2" height="2" />
            <rect x="14" y="12" width="2" height="2" />
            <rect x="18" y="12" width="2" height="2" />
            <rect x="22" y="12" width="2" height="2" />
            <rect x="6" y="16" width="2" height="2" />
            <rect x="10" y="16" width="2" height="2" />
            <rect x="14" y="16" width="2" height="2" />
            <rect x="18" y="16" width="2" height="2" />
            <rect x="22" y="16" width="2" height="2" />
            <polygon points="4,10 16,2 28,10" />
            <rect x="15" y="3" width="2" height="3" fill="currentColor" opacity="0.6" />
         </g>
      </svg>
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
         <path d="M12 0C6.418 0 1.973 3.605 0 7.792c 3.605 6.418 0 12 0 6.418 3.605 12 7.792 3.605 12 0 6.418 0 12 0zm6.25 4.5a 7.5 0 0 0 6.75 1.5 7.5 6.75 1.5 7.5 0 0 0-6.75 1.5 7.5-6.75 1.5zm0 2.25a 3.75 0 0 0 3 1.5 3.75 3 1.5 3.75 0 0 0-3 1.5 3.75-3 1.5zm0 2.5a 6.75 0 0 0 6 3 6.75 6 3 6.75 0 0 0-6 3 6.75-6 3zm0 1.5a 3 0 0 0 3 1.5 3 3 1.5 3 0 0 0-3 1.5 3-3 1.5zm0 0.75a 3.75 0 0 0 3 0.75 3.75 3 0.75 3.75 0 0 0-3 0.75 3.75-3 0.75z" fill="currentColor" />
      </svg>
      <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="map-pin"
         id="map-pin-svg-template" role="img" xmlns="http://www.w3.org/2000/svg"
         viewBox="0 0 384 512" width="18" height="18">
         <path fill="currentColor"
            d="M172.268 501.67C26.974 291.031 0 269.413 0 192
             C0 85.961 85.961 0 192 0s192 85.961 192 192
             c0 77.413-26.974 99.031-172.268 309.67
             a24 24 0 0 1-39.464 0zM192 272
             c44.183 0 80-35.817 80-80s-35.817-80-80-80
             s-80 35.817-80 80s35.817 80 80 80z" />
      </svg>
   </div>

   <div class="container">
      <aside class="sidebar" aria-label="Φίλτρα">
         <h2>Επιλογές</h2>
         <div class="filter-group">
            <label for="searchText">Αναζήτηση<br /> (Όνομα / Κωδικός / Διεύθυνση)</label>
            <input type="text" id="searchText" placeholder="Όνομα, Κωδικός, Διεύθυνση..." onkeyup="onSearchKey()">
         </div>

         <div class="filter-group"><label for="mySchPeriferia">ΠΕΡΙΦΕΡΕΙΑ</label><select id="mySchPeriferia" onchange="onPeriferiaChange()">
               <option value="">Όλα</option>
            </select></div>
         <div class="filter-group"><label for="mySchNomos">ΝΟΜΟΣ</label><select id="mySchNomos" onchange="onNomosChange()">
               <option value="">Όλοι</option>
            </select></div>
         <div class="filter-group"><label for="mySchDimos">ΔΗΜΟΣ</label><select id="mySchDimos" onchange="onDimosChange()">
               <option value="">Όλοι</option>
            </select></div>
         <div class="filter-group"><label for="mySchDimotikiEnotita">ΔΗΜΟΤΙΚΗ ΚΟΙΝΟΤΗΤΑ</label><select id="mySchDimotikiEnotita" onchange="onOtherFilterChange()">
               <option value="">Όλοι</option>
            </select></div>
         <div class="filter-group"><label for="mySchLevel">ΒΑΘΜΙΔΑ</label><select id="mySchLevel" onchange="onOtherFilterChange()">
               <option value="">Όλοι</option>
            </select></div>
         <div class="filter-group"><label for="mySchCharacter">ΧΑΡΑΚΤΗΡΑΣ</label><select id="mySchCharacter" onchange="onOtherFilterChange()">
               <option value="">Όλοι</option>
            </select></div>
         <div class="filter-group"><label for="mySchDief">ΔΙΕΥΘΥΝΣΗ ΕΚΠΑΙΔΕΥΣΗΣ</label><select id="mySchDief" onchange="onOtherFilterChange()">
               <option value="">Όλοι</option>
            </select></div>
         <div class="filter-group"><label for="mySchProsanatol">ΠΡΟΣΑΝΑΤΟΛΙΣΜΟΣ</label><select id="mySchProsanatol" onchange="onOtherFilterChange()">
               <option value="">Όλοι</option>
            </select></div>
         <div class="filter-group"><label for="mySchType">ΤΥΠΟΣ ΣΧΟΛΕΙΟΥ</label><select id="mySchType" onchange="onOtherFilterChange()">
               <option value="">Όλοι</option>
            </select></div>

         <div class="filter-actions">
            <button class="btn btn-ghost" onclick="resetAllFilters()">Επαναφορά</button>
            <button class="btn btn-primary" onclick="applyFiltersAndRender()">Εφαρμογή</button>
         </div>

         <div style="margin-top:20px; font-weight:300;" class="muted">
            Εγγραφές ανά σελίδα:
            <select id="recordsPerPage" onchange="onRecordsPerPageChange()" style="margin-left:8px;padding:8px 10px;border-radius:10px;border:1px solid var(--accent);width:50%;">
               <option value="20" selected>20</option>
               <option value="50">50</option>
               <option value="100">100</option>
            </select>
         </div>
      </aside>

      <main class="main" role="main">
         <div class="controls-top">
            <div class="left"><span id="pageInfoTop" class="muted"></span></div>
            <div class="right muted">Συνολικές εγγραφές: <span id="totalRecords">0</span></div>
         </div>

         <div id="cards-wrapper" class="cards-wrapper" aria-live="polite"></div>

         <div class="pagination" id="pagination-controls">
            <button id="prevPage" class="btn btn-ghost" onclick="changePage(-1)"><span class="arrow">←</span><span>Προηγούμενη</span></button>
            <div class="info" id="pageInfo">Σελίδα 1 από 1</div>
            <button id="nextPage" class="btn btn-ghost" onclick="changePage(1)"><span>Επόμενη</span><span class="arrow">→</span></button>
         </div>
      </main>
   </div>

   <script>
      const ALL_SCHOOLS_DATA_RAW = <?php echo $json_content === null ? '[]' : $json_content; ?>;

      const mapPinSvgTemplate = document.getElementById('map-pin-svg-template')?.outerHTML || '';

      /* FULL corrected logic: all filters initially set to 'Όλα' and all records visible */
      const CASCADING_KEYS = ['mySchPeriferia', 'mySchNomos', 'mySchDimos', 'mySchDimotikiEnotita'];
      const OTHER_KEYS = ['mySchLevel', 'mySchCharacter', 'mySchDief', 'mySchProsanatol', 'mySchType'];
      const ALL_FILTER_KEYS = CASCADING_KEYS.concat(OTHER_KEYS);
      let ALL_SCHOOLS_DATA = [],
         currentData = [],
         currentPage = 1,
         sortColumn = 'mySchName',
         sortDirection = 'asc';

      function RemoveAccents(text) {
         if (!text) return "";
         return String(text).normalize("NFD").replace(/[\u0300-\u036f]/g, '').toUpperCase();
      }

      function uniqSorted(arr) {
         return Array.from(new Set(arr.filter(v => v !== null && v !== undefined && String(v).trim() !== ''))).sort((a, b) => RemoveAccents(String(a)) > RemoveAccents(String(b)) ? 1 : (RemoveAccents(String(a)) < RemoveAccents(String(b)) ? -1 : 0));
      }

      function preprocessData(schools) {
         return schools.map(s => {
            const normalized = {};
            for (const k in s) {
               let v = s[k];
               if (v === null || v === undefined) v = '';
               if (typeof v === 'string') v = v.trim();
               normalized[k] = v;
            } ['mySchPeriferia', 'mySchNomos', 'mySchDimos', 'mySchDimotikiEnotita', 'mySchLevel', 'mySchType', 'mySchCharacter', 'mySchDief', 'mySchProsanatol', 'mySchCode', 'mySchName', 'mySchPhone', 'mySchEmail', 'mySchAddr', 'mySchZip', 'mySchLatitude', 'mySchLongitude'].forEach(k => {
               if (!(k in normalized)) normalized[k] = '';
            });
            normalized.fullAddr = ((normalized.mySchAddr || '') + (normalized.mySchAddr && normalized.mySchZip ? ' - ' : '') + (normalized.mySchZip || '')).trim();
            normalized.mapLink = {
               lat: normalized.mySchLatitude,
               lon: normalized.mySchLongitude
            };
            return normalized;
         });
      }

      function getUniqueValuesForKey(key, constraints = {}) {
         let values = [];
         for (const row of ALL_SCHOOLS_DATA) {
            let ok = true;
            for (const ck in constraints) {
               const constraintVal = constraints[ck];
               if (!constraintVal) continue;
               if (RemoveAccents(String(row[ck] || '')) !== RemoveAccents(String(constraintVal || ''))) {
                  ok = false;
                  break;
               }
            }
            if (ok) {
               const v = row[key];
               if (v !== null && v !== undefined && String(v).trim() !== '') values.push(v);
            }
         }
         let result = uniqSorted(values);
         if (result.length === 0) {
            const global = [];
            for (const row of ALL_SCHOOLS_DATA) {
               const v = row[key];
               if (v !== null && v !== undefined && String(v).trim() !== '') global.push(v);
            }
            result = uniqSorted(global);
         }
         return result;
      }

      function setSelectOptions(selectEl, values, placeholderText = 'Όλοι') {
         if (!selectEl) return;
         const prev = selectEl.value;
         selectEl.innerHTML = '';
         const emptyOption = document.createElement('option');
         emptyOption.value = '';
         emptyOption.textContent = placeholderText;
         emptyOption.className = 'empty-opt';
         selectEl.appendChild(emptyOption);
         values.forEach(v => {
            const opt = document.createElement('option');
            opt.value = String(v);
            opt.textContent = String(v);
            selectEl.appendChild(opt);
         });
         if (prev) {
            const found = Array.from(selectEl.options).some(o => o.value === prev);
            if (found) selectEl.value = prev;
         }
      }

      function populateOtherSelectsBasedOnConstraints() {
         const perVal = document.getElementById('mySchPeriferia').value;
         const nomVal = document.getElementById('mySchNomos').value;
         const dimVal = document.getElementById('mySchDimos').value;
         const denVal = document.getElementById('mySchDimotikiEnotita').value;
         const constraints = {};
         if (perVal) constraints.mySchPeriferia = perVal;
         if (nomVal) constraints.mySchNomos = nomVal;
         if (dimVal) constraints.mySchDimos = dimVal;
         if (denVal) constraints.mySchDimotikiEnotita = denVal;
         ['mySchLevel', 'mySchCharacter', 'mySchDief', 'mySchProsanatol', 'mySchType'].forEach(k => setSelectOptions(document.getElementById(k), getUniqueValuesForKey(k, constraints), 'Όλοι'));
      }

      function populatePeriferia() {
         const perSelect = document.getElementById('mySchPeriferia');
         const perValues = getUniqueValuesForKey('mySchPeriferia', {});
         setSelectOptions(perSelect, perValues, 'Όλα');
         onPeriferiaChange();
      }

      function onPeriferiaChange() {
         const perVal = document.getElementById('mySchPeriferia').value;
         const nomosVals = perVal ? getUniqueValuesForKey('mySchNomos', {
            mySchPeriferia: perVal
         }) : getUniqueValuesForKey('mySchNomos', {});
         setSelectOptions(document.getElementById('mySchNomos'), nomosVals, 'Όλοι');
         onNomosChange();
         populateOtherSelectsBasedOnConstraints();
         applyFiltersAndRender();
      }

      function onNomosChange() {
         const perVal = document.getElementById('mySchPeriferia').value;
         const nomVal = document.getElementById('mySchNomos').value;
         const constraints = {};
         if (perVal) constraints.mySchPeriferia = perVal;
         if (nomVal) constraints.mySchNomos = nomVal;
         const dimosVals = getUniqueValuesForKey('mySchDimos', constraints);
         setSelectOptions(document.getElementById('mySchDimos'), dimosVals, 'Όλοι');
         onDimosChange();
         populateOtherSelectsBasedOnConstraints();
         applyFiltersAndRender();
      }

      function onDimosChange() {
         const perVal = document.getElementById('mySchPeriferia').value;
         const nomVal = document.getElementById('mySchNomos').value;
         const dimVal = document.getElementById('mySchDimos').value;
         const constraints = {};
         if (perVal) constraints.mySchPeriferia = perVal;
         if (nomVal) constraints.mySchNomos = nomVal;
         if (dimVal) constraints.mySchDimos = dimVal;
         const denVals = getUniqueValuesForKey('mySchDimotikiEnotita', constraints);
         setSelectOptions(document.getElementById('mySchDimotikiEnotita'), denVals, 'Όλοι');
         populateOtherSelectsBasedOnConstraints();
         applyFiltersAndRender();
      }

      function onOtherFilterChange() {
         applyFiltersAndRender();
      }

      function getActiveFilters() {
         const f = {};
         ALL_FILTER_KEYS.forEach(k => {
            const el = document.getElementById(k);
            if (el && el.value && String(el.value).trim() !== '') f[k] = el.value;
         });
         return f;
      }

      function applyFilters() {
         const searchText = RemoveAccents((document.getElementById('searchText').value || '').trim());
         const active = getActiveFilters();
         if (Object.keys(active).length === 0 && searchText === '') {
            currentData = ALL_SCHOOLS_DATA.slice();
            return;
         }
         currentData = ALL_SCHOOLS_DATA.filter(s => {
            for (const k in active) {
               if (RemoveAccents(String(s[k] || '')) !== RemoveAccents(String(active[k] || ''))) return false;
            }
            if (searchText) {
               const searchFields = [s.mySchName, s.mySchCode, s.mySchPhone, s.mySchEmail, s.fullAddr, s.mySchDimos, s.mySchNomos];
               const match = searchFields.some(f => f && RemoveAccents(String(f)).includes(searchText));
               if (!match) return false;
            }
            return true;
         });
      }

      function compareValues(a, b, direction) {
         const valA = a == null ? '' : String(a);
         const valB = b == null ? '' : String(b);
         let normalizedA, normalizedB;
         if (!isNaN(parseFloat(a)) && isFinite(a) && !isNaN(parseFloat(b)) && isFinite(b)) {
            normalizedA = parseFloat(a);
            normalizedB = parseFloat(b);
         } else {
            normalizedA = RemoveAccents(valA);
            normalizedB = RemoveAccents(valB);
         }
         let cmp = 0;
         if (normalizedA > normalizedB) cmp = 1;
         else if (normalizedA < normalizedB) cmp = -1;
         return direction === 'desc' ? cmp * -1 : cmp;
      }

      function sortData() {
         if (!currentData || currentData.length === 0) return;
         // Default sort is by mySchName
         currentData.sort((a, b) => compareValues(a[sortColumn], b[sortColumn], sortDirection));
      }

      /* Render cards & pagination */
      function renderCards() {
         const wrapper = document.getElementById('cards-wrapper');
         const recordsPerPageSelect = document.getElementById('recordsPerPage');
         if (!wrapper || !recordsPerPageSelect) return;
         const recordsPerPage = parseInt(recordsPerPageSelect.value, 10) || 25;
         sortData();
         const totalRecords = currentData.length;
         const totalPages = Math.max(1, Math.ceil(totalRecords / recordsPerPage));
         if (currentPage > totalPages) currentPage = totalPages;
         const startIndex = (currentPage - 1) * recordsPerPage;
         const endIndex = Math.min(startIndex + recordsPerPage, totalRecords);
         const pageData = currentData.slice(startIndex, endIndex);
         wrapper.innerHTML = '';
         document.getElementById('totalRecords').textContent = totalRecords;

         const fromRecord = totalRecords > 0 ? startIndex + 1 : 0;
         const toRecord = endIndex;

         document.getElementById('pageInfo').textContent = `Σελίδα ${currentPage} από ${totalPages} (Εγγραφές: ${fromRecord}-${toRecord})`;
         document.getElementById('pageInfoTop').textContent = totalRecords > 0 ? `Εμφανίζονται ${fromRecord} - ${toRecord} από ${totalRecords}` : 'Δεν βρέθηκαν εγγραφές';

         if (pageData.length === 0) {
            wrapper.innerHTML = '<div style="padding:20px;background:var(--card);border-radius:16px;box-shadow:0 6px 18px rgba(15,20,40,0.08);border:1px solid var(--color-border);">Δεν βρέθηκαν εγγραφές.</div>';
            updatePaginationButtons(totalPages);
            return;
         }
         pageData.forEach((school, idx) => {
            const globalIndex = startIndex + idx + 1;

            // 1. Δημιουργία Βασικής Δομής
            const card = document.createElement('article');
            card.className = 'card';

            // 2. Δημιουργία Header (Index + Title)
            const header = document.createElement('div');
            header.className = 'card-header'; // <-- flex container (Index + Title)

            const indexDiv = document.createElement('div');
            indexDiv.className = 'index';

            // Χρώματα ανάλογα με τη βαθμίδα του σχολείου
            const levelColorMap = {
               'ΔΗΜΟΤΙΚΟ': ['#c9d1e0', '#d4dcec', '#bfc8de', '#cad3e1'],
               'ΓΥΜΝΑΣΙΟ': ['#7a89c1', '#8699d4', '#7389c8', '#6b7fb8'],
               'ΛΥΚΕΙΟ': ['#3d4563', '#2f3950', '#4a556f', '#343f55']
            };

            const getSchoolColor = (level) => {
               if (!level) return '#6b7fd8';
               const normalized = level.toUpperCase().trim();
               for (const [key, colors] of Object.entries(levelColorMap)) {
                  if (normalized.includes(key)) {
                     return colors[Math.floor(Math.random() * colors.length)];
                  }
               }
               return '#6b7fd8';
            };

            const schoolColor = getSchoolColor(school.mySchLevel);

            const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            svg.setAttribute('viewBox', '0 0 24 24');
            svg.setAttribute('width', '20');
            svg.setAttribute('height', '20');
            svg.style.color = schoolColor;
            svg.style.display = 'block';

            const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            path.setAttribute('fill', 'currentColor');
            path.setAttribute('d', 'M12 2L3 8v2h1v9h16v-9h1V8l-9-6zm6 15h-3v-4h-2v4H8v-7h10v7z');

            svg.appendChild(path);
            indexDiv.appendChild(svg);

            const title = document.createElement('div');
            title.className = 'card-title';
            const schoolName = (school.mySchName || '—').replace(/(\d)Ο\s/g, '$1ο ');
            title.textContent = schoolName;
            title.style.color = schoolColor;

            const lat = school.mySchLatitude || (school.mapLink && school.mapLink.lat);
            const lon = school.mySchLongitude || (school.mapLink && school.mapLink.lon);
            const hasCoords = lat && lon;

            // if (hasCoords) {
            //    const mapPin = document.createElement('a');
            //    mapPin.className = 'map-pin-link';
            //    mapPin.href = `https://www.google.com/maps/search/?api=1&query=${lat},${lon}`;
            //    mapPin.target = '_blank';
            //    mapPin.rel = 'noopener noreferrer';
            //    mapPin.title = 'Δείτε στο χάρτη';

            //    const mapSvg = document.getElementById('map-pin-svg-template')?.outerHTML || '';
            //    const mapPinClone = document.createElement('div');
            //    mapPinClone.innerHTML = mapSvg;
            //    mapPinClone.querySelector('svg')?.classList.add('map-pin-svg');

            //    mapPin.appendChild(mapPinClone.querySelector('svg'));
            //    title.appendChild(mapPin);
            // }

            // Συναρμολόγηση Header: INDEX + TITLE (πλάι-πλάι)
            header.appendChild(indexDiv);
            header.appendChild(title);

            // 3. Δημιουργία Info (Fields + Address + Actions) - Παίρνει Όλο το Πλάτος
            const info = document.createElement('div');
            info.className = 'card-info'; // <-- full width container (below header)

            // 4. Δημιουργία Δομημένων Πεδίων (Label/Value separation)
            const fieldsContainer = document.createElement('div');
            fieldsContainer.className = 'details'; // Εδώ εφαρμόζεται το Grid

            // Field Data in desired Label: Value format
            const fieldsData = [{
                  label: 'Κωδικός:',
                  value: school.mySchCode
               },
               {
                  label: 'Βαθμίδα:',
                  value: school.mySchLevel
               },
               {
                  label: 'Τύπος:',
                  value: school.mySchType
               },
               {
                  label: 'Δήμος:',
                  value: school.mySchDimos
               },
               {
                  label: 'Δ/νση Εκπαίδευσης:',
                  value: school.mySchDief
               },
               {
                  label: 'Προσανατολισμός:',
                  value: school.mySchProsanatol
               }
            ];

            // Φιλτράρισμα και Δημιουργία πεδίων με διακριτό χρώμα
            fieldsData.filter(f => f.value).forEach(f => {
               const line = document.createElement('div');
               line.className = 'field-line';
               if (f.label === 'Δ/νση Εκπαίδευσης:') line.setAttribute('data-multiline', 'true');

               const labelSpan = document.createElement('span');
               labelSpan.className = 'field-label';
               labelSpan.textContent = f.label;

               const valueSpan = document.createElement('span');
               valueSpan.className = 'field-value';
               valueSpan.textContent = f.value;

               line.appendChild(labelSpan);
               line.appendChild(valueSpan);
               fieldsContainer.appendChild(line);
            });


            // 5. Δημιουργία Διεύθυνσης
            const addr = document.createElement('div');
            addr.className = 'address';

            // Δημιουργία εικονιδίου
            const addrIcon = document.createElement('div');
            const mapPinSvgTemplate = document.getElementById('map-pin-svg-template');
            if (mapPinSvgTemplate) {
               const svgClone = mapPinSvgTemplate.cloneNode(true);
               svgClone.id = '';
               svgClone.classList.add('address-icon');
               addrIcon.appendChild(svgClone);
            }

            // Δημιουργία κειμένου
            const addrText = document.createElement('span');
            addrText.textContent = school.fullAddr || (school.mySchAddr || '—');

            // Προσθήκη εικονιδίου + κείμενο
            addr.appendChild(addrIcon);
            addr.appendChild(addrText);
            // 6. Δημιουργία Actions (Phone + Map στην ίδια γραμμή, Email κάτω)
            const actions = document.createElement('div');
            actions.className = 'actions';

            // Πρώτη γραμμή: Phone & Map
            const row1 = document.createElement('div');
            row1.style.display = 'grid';
            row1.style.gridTemplateColumns = '1fr 1fr';
            row1.style.gap = '8px';

            if (school.mySchPhone) {
               const aPhone = document.createElement('a');
               aPhone.className = 'small-link';
               aPhone.href = `tel:+30${school.mySchPhone}`;
               aPhone.textContent = school.mySchPhone;
               row1.appendChild(aPhone);
            }

            if (hasCoords) {
               const aMap = document.createElement('a');
               aMap.className = 'small-link map';
               const mapUrl = `https://www.google.com/maps/search/?api=1&query=${lat},${lon}`;
               aMap.href = mapUrl;
               aMap.target = '_blank';
               aMap.rel = 'noopener noreferrer';
               aMap.textContent = 'Δες στον Χάρτη';
               row1.appendChild(aMap);
            }

            actions.appendChild(row1);

            // Δεύτερη γραμμή: Email
            if (school.mySchEmail) {
               const aMail = document.createElement('a');
               aMail.className = 'small-link email';
               aMail.href = `mailto:${school.mySchEmail}`;
               aMail.textContent = school.mySchEmail;
               aMail.style.marginTop = '8px';
               aMail.style.textTransform = 'lowercase';
               actions.appendChild(aMail);
            }

            // 7. Συναρμολόγηση του info block
            info.appendChild(fieldsContainer);
            info.appendChild(addr);
            info.appendChild(actions);

            // 8. Συναρμολόγηση της Κάρτας: Header (side-by-side) πάνω, Info (full-width) κάτω
            card.appendChild(header);
            card.appendChild(info);

            wrapper.appendChild(card);
         });
         updatePaginationButtons(totalPages);
      }

      function updatePaginationButtons(totalPages) {
         const prevButton = document.getElementById('prevPage');
         const nextButton = document.getElementById('nextPage');
         if (!prevButton || !nextButton) return;
         prevButton.disabled = currentPage <= 1;
         nextButton.disabled = currentPage >= totalPages;
      }

      function changePage(delta) {
         const recordsPerPage = parseInt(document.getElementById('recordsPerPage').value, 10) || 25;
         const totalPages = Math.max(1, Math.ceil(currentData.length / recordsPerPage));
         const newPage = currentPage + delta;
         if (newPage >= 1 && newPage <= totalPages) {
            currentPage = newPage;
            renderCards();
            window.scrollTo({
               top: 0,
               behavior: 'smooth'
            });
         }
      }

      function onRecordsPerPageChange() {
         currentPage = 1;
         renderCards();
      }

      function onSearchKey() {
         currentPage = 1;
         applyFiltersAndRender();
      }

      function resetAllFilters() {
         document.getElementById('searchText').value = '';
         ALL_FILTER_KEYS.forEach(k => {
            const el = document.getElementById(k);
            if (el) el.value = '';
         });
         // Προσπάθεια επαναφοράς σε ΑΤΤΙΚΗ αν υπάρχει
         const periferiaEl = document.getElementById('mySchPeriferia');
         if (periferiaEl && Array.from(periferiaEl.options).some(o => o.value === 'ΑΤΤΙΚΗΣ')) {
            periferiaEl.value = 'ΑΤΤΙΚΗΣ';
            onPeriferiaChange();
         } else {
            populatePeriferia();
            applyFiltersAndRender();
         }
      }

      function applyFiltersAndRender() {
         applyFilters();
         currentPage = 1;
         renderCards();
      }

      /* INIT */
      function initializePage() {
         ALL_SCHOOLS_DATA = preprocessData(ALL_SCHOOLS_DATA_RAW || []);
         currentData = ALL_SCHOOLS_DATA.slice();
         // Attempt to select 'ΑΤΤΙΚΗΣ' and filter cascaded menus if possible
         populatePeriferia();
         const periferiaEl = document.getElementById('mySchPeriferia');
         if (periferiaEl) {
            const foundAttiki = Array.from(periferiaEl.options).some(o => o.value === 'ΑΤΤΙΚΗΣ');
            if (foundAttiki) {
               periferiaEl.value = '';
               populateOtherSelectsBasedOnConstraints();
               applyFiltersAndRender();
            } else {
               populateOtherSelectsBasedOnConstraints();
               applyFiltersAndRender();
            }
         } else {
            populateOtherSelectsBasedOnConstraints();
            applyFiltersAndRender();
         }

         const searchEl = document.getElementById('searchText');
         if (searchEl) searchEl.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
               applyFiltersAndRender();
            }
         });
      }
      document.addEventListener('DOMContentLoaded', initializePage);

      // Initialize scroll-to-top after DOM is ready to avoid null references
      document.addEventListener('DOMContentLoaded', function() {
         const scrollToTopBtn = document.getElementById('scrollToTop');
         if (!scrollToTopBtn) return;

         window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
               // scrollToTopBtn.classList.remove('hidden');
            } else {
               // scrollToTopBtn.classList.add('hidden');
            }
         });

         scrollToTopBtn.addEventListener('click', () => {
            window.scrollTo({
               top: 0,
               behavior: 'smooth'
            });
         });
      });

      function scrollToTop() {
         console.log("scrollToTop called");
         window.scrollTo(0, 0);
      }
      // Zoom controls with persistence
      (function() {
         const ZOOM_KEY = 'mySchools.uiZoom';
         let uiZoom = parseFloat(localStorage.getItem(ZOOM_KEY));
         if (isNaN(uiZoom)) uiZoom = 1;
         const ZOOM_MIN = 0.6,
            ZOOM_MAX = 1.6,
            ZOOM_STEP = 0.1;

         function applyZoom() {
            if (uiZoom < ZOOM_MIN) uiZoom = ZOOM_MIN;
            if (uiZoom > ZOOM_MAX) uiZoom = ZOOM_MAX;
            // Ενημέρωση root font-size για πραγματικό ζουμ του UI
            document.documentElement.style.fontSize = (uiZoom * 100).toFixed(0) + '%';
            // Διατηρώ και την CSS μεταβλητή αν χρειαστεί αλλού
            document.documentElement.style.setProperty('--ui-zoom', uiZoom);
            const zin = document.getElementById('zoomInBtn');
            const zout = document.getElementById('zoomOutBtn');
            if (zin) zin.style.opacity = uiZoom >= ZOOM_MAX ? '0.5' : '1';
            if (zout) zout.style.opacity = uiZoom <= ZOOM_MIN ? '0.5' : '1';
         }

         function zoomIn() {
            uiZoom = Math.min(uiZoom + ZOOM_STEP, ZOOM_MAX);
            localStorage.setItem(ZOOM_KEY, uiZoom.toFixed(2));
            applyZoom();
         }

         function zoomOut() {
            uiZoom = Math.max(uiZoom - ZOOM_STEP, ZOOM_MIN);
            localStorage.setItem(ZOOM_KEY, uiZoom.toFixed(2));
            applyZoom();
         }

         function resetZoom() {
            uiZoom = 1;
            localStorage.setItem(ZOOM_KEY, uiZoom.toFixed(2));
            applyZoom();
         }

         function toCSVValue(v) {
            if (v === null || v === undefined) return '';
            const s = String(v).replace(/\r?\n|\r/g, ' ').trim();
            // Αν περιέχει κόμμα, εισαγωγικά ή ; τυλίγουμε σε εισαγωγικά και διπλασιάζουμε τα εσωτερικά εισαγωγικά
            if (/[",;]/.test(s)) return '"' + s.replace(/"/g, '""') + '"';
            return s;
         }

         function downloadCSV() {
            try {
               const headers = [
                  'Κωδικός', 'Ονομασία', 'Βαθμίδα', 'Τύπος', 'Δήμος', 'Δ/νση Εκπαίδευσης', 'Προσανατολισμός', 'Τηλέφωνο', 'Email', 'Διεύθυνση', 'Τ.Κ.', 'Latitude', 'Longitude'
               ];
               const lines = [headers.join(';')];
               (currentData || []).forEach(s => {
                  const row = [
                     s.mySchCode, s.mySchName, s.mySchLevel, s.mySchType, s.mySchDimos,
                     s.mySchDief, s.mySchProsanatol, s.mySchPhone, s.mySchEmail,
                     s.mySchAddr, s.mySchZip, s.mySchLatitude, s.mySchLongitude
                  ].map(toCSVValue).join(';');
                  lines.push(row);
               });
               const csvContent = '\uFEFF' + lines.join('\r\n'); // BOM + CRLF για Excel/Windows
               const blob = new Blob([csvContent], {
                  type: 'text/csv;charset=utf-8;'
               });
               const url = URL.createObjectURL(blob);
               const a = document.createElement('a');
               a.href = url;
               a.download = 'schools.csv';
               document.body.appendChild(a);
               a.click();
               document.body.removeChild(a);
               URL.revokeObjectURL(url);
            } catch (e) {
               console.error('CSV export failed', e);
               alert('Αποτυχία δημιουργίας CSV.');
            }
         }

         function printResults() {
            window.print();
         }

         document.addEventListener('DOMContentLoaded', function() {
            applyZoom();
            const zin = document.getElementById('zoomInBtn');
            const zout = document.getElementById('zoomOutBtn');
            const zreset = document.getElementById('zoomResetBtn');
            const pbtn = document.getElementById('printBtn');
            const cbtn = document.getElementById('csvBtn');
            if (zin) zin.addEventListener('click', zoomIn);
            if (zout) zout.addEventListener('click', zoomOut);
            if (zreset) zreset.addEventListener('click', resetZoom);
            if (pbtn) pbtn.addEventListener('click', printResults);
            if (cbtn) cbtn.addEventListener('click', downloadCSV);
         });
      })();
   </script>
   <button id="scrollToTop" class="custom-scroll-to-top" onclick="scrollToTop()">^

   </button>





   <?php include_once __DIR__ . "/assets/myFooterAll.php" ?>
</body>

</html>