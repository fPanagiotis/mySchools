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
$page_title = "dipegath.eu - Ολες οι Σχολικές Μονάδες της Δι.Π.Ε. Γ Αθήνας";

// Δυναμική περιγραφή
$page_description = "Δες όλες τις σχολικές μονάδες που ανήκουν στη Διεύθυνση Πρωτοβάθμιας Εκπαίδευσης Γ Αθήνας. Μια ιστοσελίδα με εύκολη αναζήτηση ανά περιοχή, ανά είδος σχολειου (Δημοτικό/Νηπιαγωγείο/Ιδιωτικό) και δυνατότητα εξαγωγής σε CSV αρχείο. Μπορείτε να βρείτε εύκολα το σχολείο που σας ενδιαφέρει, να βρείτε το τηλέφωνο της κάθε Σχολικης Μονάδας, τη διεύθυνση ηλεκτρονικού ταχυδρομείου καθώς και να βρείτε το σχολειο στο χάρτη ";

// URL της σελίδας που μοιράζεσαι
$page_url = "https://dipe-g-athin.att.sch.gr/mySchools/index.php";

// Εικόνα (πρέπει να είναι τουλάχιστον 1200×630)
$page_image = "Img/Share.png";
?>
<!doctype html>
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
  <title>Σχολικές Μονάδες της Δι.Π.Ε. Γ Αθήνας</title>
  <link rel="stylesheet" href="assets/styles.css">
  <link rel="icon" href="Img/Share.png" type="image/png" sizes="32x32">
  <style>
    /* Για να έχεις αρκετό περιεχόμενο και να δουλέψει η κύλιση */
    body {
      margin: 0 !important;
    }


    h1,
    h2,
    p {
      color: #333 !important;
    }

    p {
      margin-bottom: 20px !important;
      line-height: 1.6 !important;
    }

    th {
      color: darkblue;
      border-top: 1px solid rgba(125, 140, 255, 1);
      border-bottom: 1px solid rgba(125, 140, 255, 1);
    }

    /* Zoom circular buttons styling (match Show_All aesthetics) */
    #zoomControls {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
      align-items: center;
      justify-content: flex-start;
      color: rgba(125, 140, 255, 1);
      margin-top: 10px;
    }

    #zoomControls .circle-btn {
      min-width: 38px;
      width: 38px;
      height: 38px;
      border-radius: 50%;
      background: radial-gradient(circle at 18px 18px, rgba(255, 255, 255, 0) 0%, rgba(232, 235, 255, 0) 50%, rgba(177, 187, 255, 0) 100%);
      border: 2px solid rgba(91, 101, 152, 0.3);
      font-size: 18px;
      font-weight: 700;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.35), inset 0 0 5px 2px rgba(255, 255, 255, 0.8), inset 0 -5px 8px rgba(91, 101, 152, 0.4);
      padding: 0;
      user-select: none;
      background-clip: padding-box;
      color: rgba(125, 140, 255, 1) !important;
      touch-action: manipulation;
    }

    #zoomControls .circle-btn:hover {
      transform: translateY(-3px) scale(1.1);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.4), inset 0 0 5px 2px rgba(255, 255, 255, 0.9), inset 0 -5px 8px rgba(91, 101, 152, 0.5);
    }

    #zoomControls .circle-btn:active {
      transform: translateY(0) scale(0.95);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25), inset 0 2px 4px rgba(91, 101, 152, 0.2);
    }

    /* Mobile devices (< 768px) */
    @media (max-width: 767px) {
      #zoomControls .circle-btn {
        min-width: 44px;
        width: 44px;
        height: 44px;
        font-size: 20px;
      }

      #zoomControls {
        gap: 10px;
      }

      .row {
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 100%;
      }

      .input,
      .select,
      .btn {
        width: 100% !important;
        font-size: 16px;
        padding: 12px !important;
        min-height: 44px;
      }

      table {
        font-size: 12px;
      }

      th,
      td {
        padding: 8px 4px !important;
      }
    }

    /* Tablets (768px - 1024px) */
    @media (min-width: 768px) and (max-width: 1024px) {
      #zoomControls .circle-btn {
        min-width: 42px;
        width: 42px;
        height: 42px;
      }

      .row {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
      }

      .input,
      .select {
        flex: 1 1 calc(20% - 4px);
        min-width: 150px;
      }

      .btn {
        flex: 1 1 auto;
        min-width: 100px;
      }

      table {
        font-size: 13px;
      }
    }

    /* Desktop (> 1024px) */
    @media (min-width: 1025px) {
      .row {
        display: flex;
        gap: 10px;
        align-items: center;
      }


      .btn {
        white-space: nowrap;
      }
    }

    /* FINAL OVERRIDES: Enforce same text color for ALL buttons and inner symbols */
    :root {
      --forceBtnText: rgba(125, 140, 255, 1);
    }

    .btn,
    .btn *,
    button,
    button *,
    .circle-btn,
    .circle-btn *,
    .small-link,
    .small-link *,
    .pagination .btn,
    .pagination .btn *,
    .actions a,
    .actions a * {
      color: rgba(125, 140, 255, 1) !important;
      fill: var(--forceBtnText) !important;
      -webkit-text-fill-color: var(--forceBtnText) !important;
    }
  </style>
</head>

<body id="page-content" style="transform: scale(1);" title="&nbsp;&#10;✨&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Κάντε κλικ στο&nbsp;ΤΗΛΕΦΩΝΟ για να τηλεφωνήσετε στη Μονάδα&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;✨&#10;✨&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Στο&nbsp;EMAIL για να στείλετε μήνυμα ηλεκτρονικού ταχυδρομείου&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;✨&#10;✨&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Στην&nbsp;ΠΙΝΕΖΑ για να δείτε τη Σχολική Μονάδα στο Χάρτη&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;✨&nbsp;&#10;&nbsp;">
  <main class="container">
    <header class="topbar">
      <?php include_once  __DIR__ . '/assets/myHeader.php' ?>
    </header>
    <section class="controls">
      <div class="row">
        <input id="search" class="input" placeholder="Αναζήτηση (όνομα, διεύθυνση ή κωδικός)" />

        <select id="filterKind" class="select" title="👀&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Επιλέξτε το είδος του Σχολείου (Δημοτικο/Νηπιαγωγείο/Ιδιωτικό)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;👀">
          <option value="" title="👀&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Επιλέξτε το είδος του Σχολείου (Δημοτικο/Νηπιαγωγείο/Ιδιωτικό)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;👀">👀 Όλα οι τύποι</option>
          <option value="DS" title="👀&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Επιλέξτε για να δείτε τη λίστα με τα Δημοτικά Σχολεία&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;👀">👀 Δημοτικό</option>
          <option value="NP" title="👀&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Επιλέξτε για να δείτε τη λίστα με τα Νηπιαγωγεία&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;👀">👀 Νηπιαγωγείο</option>
          <option value="ID" title="👀&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Επιλέξτε για να δείτε τη λίστα με τα Ιδιωτικά Σχολεία&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;👀">👀 Ιδιωτικό</option>
        </select>

        <select id="filterArea" class="select" title="👀&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Επιλέξτε μία από τις περιοχές που ανήκουν στη Διεύθυνση&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;👀">
          <option value="" title="👀&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Επιλέξτε μία από τις περιοχές που ανήκουν στη Διεύθυνση&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;👀">👀 Όλες οι περιοχές</option>
          <option value="Perist" title="👀&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Επιλέξτε για να δείτε τις Σχολικές Μονάδςες της περιοχής&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;👀">👀 Περιστέρι</option>
          <option value="Aigal" title="👀&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Επιλέξτε για να δείτε τις Σχολικές Μονάδςες της περιοχής&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;👀">👀 Αιγάλεω</option>
          <option value="Ilion" title="👀&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Επιλέξτε για να δείτε τις Σχολικές Μονάδςες της περιοχής&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;👀">👀 Ίλιον</option>
          <option value="Petroup" title="👀&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Επιλέξτε για να δείτε τις Σχολικές Μονάδςες της περιοχής&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;👀">👀 Πετρούπολη</option>
          <option value="Chaid" title="👀&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Επιλέξτε για να δείτε τις Σχολικές Μονάδςες της περιοχής&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;👀">👀 Χαϊδάρι</option>
          <option value="AgAnarg" title="👀&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Επιλέξτε για να δείτε τις Σχολικές Μονάδςες της περιοχής&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;👀">👀 Άγ. Ανάργυροι - Καματερό</option>
          <option value="AgBarb" title="👀&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Επιλέξτε για να δείτε τις Σχολικές Μονάδςες της περιοχής&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;👀">👀 Αγία Βαρβάρα</option>
        </select>

        <button id="exportCsv" class="btn" title="📥&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Κάντε κλικ για να κατεβάσετε στον υπολογιστή σας τη λίστα των Σχολικών Μονάδων&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;📥">📥 Λήψη&nbsp;&nbsp;</button>
      </div><br />

      <div class="row small" style="color:#5b6598;">
        <label>Εγγραφές ανά σελίδα:
          <select id="rowsPerPage" class="select small" title="👀&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Επιλέξτε πόσες Σχολικές Μονάδες θα βλέπετε σε κάθε σελίδα&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;👀">
            <option>👀 10</option>
            <option selected>👀 20</option>
            <option>👀 50</option>
          </select>
        </label>
      </div>
      <div id="zoomControls">
        <button id="zoomOutBtn" class="circle-btn" title="✨&nbsp;&nbsp;&nbsp;Σμίκρυνση&nbsp;&nbsp;&nbsp;✨" aria-label="Σμίκρυνση"><span class="sym">−</span></button>
        <button id="zoomInBtn" class="circle-btn" title="✨&nbsp;&nbsp;&nbsp;Μεγέθυνση&nbsp;&nbsp;&nbsp;✨" aria-label="Μεγέθυνση"><span class="sym">+</span></button>
        <button id="resetBtn" class="circle-btn" title="✨&nbsp;&nbsp;&nbsp;Επαναφορά&nbsp;&nbsp;&nbsp;✨" aria-label="Επαναφορά"><span class="sym">⤾</span></button>
        <button id="copyUrlBtn" class="circle-btn" title="✨&nbsp;&nbsp;&nbsp;Αντιγραφή συνδέσμου&nbsp;&nbsp;&nbsp;✨" aria-label="Αντιγραφή συνδέσμου">
          <img src="Img/CopyLink.png" alt="Αντιγραφή συνδέσμου" class="sym" style="width: 20px; height: 20px;">
        </button>
      </div>
    </section>

    <section class="tablewrap">
      <table id="schoolsTable" class="table">
        <thead>
          <tr style="background-color: rgba(125, 140, 255, 0.1);">
            <th>Τύπος</th>
            <th>Δήμος</th>
            <th>Κωδικός</th>
            <th>Ονομασία</th>
            <th>Τηλέφωνο</th>
            <th>Email</th>
            <th>Διεύθυνση</th>
            <th>Χάρτης</th>

          </tr>
        </thead>
        <tbody></tbody>
      </table>

      <div id="pagination" class="pagination"></div>

      <div id="status" class="status">Φόρτωση δεδομένων... Παρακαλώ περιμένετε...</div>
    </section>

  </main>

  <script src="assets/app.js"></script>
  <script src="assets/script.js"></script>
  <script>
    document.getElementById('copyUrlBtn').addEventListener('click', function(e) {
      e.preventDefault();
      const url = window.location.href;
      navigator.clipboard.writeText(url).then(() => {
        const btn = this;
        const originalTitle = btn.title;
        btn.title = '✨&nbsp;&nbsp;&nbsp;Αντιγράφηκε!&nbsp;&nbsp;&nbsp;✨';
        setTimeout(() => {
          btn.title = originalTitle;
        }, 2000);
      }).catch(() => {
        alert('Δεν ήταν δυνατή η αντιγραφή του συνδέσμου');
      });
    });
  </script>

  <?php include_once __DIR__  . "/assets/myFooter.php"; ?>


</body>

</html>