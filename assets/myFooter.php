<?php include_once "Version.php"; ?>
<!-- =======================================================================================
     Developer: Φράγκος Παναγιώτης (ΠΕ86)
     Έτος: <?= $mySchoolsYear; ?>

     Εφαρμογή προβολής και αναζήτησης σχολικών μονάδων
     Αυτόματη Έκδοση Build: <?= $mySchoolsVersion; ?>
     
     Web Site: www.tosxoleio.eu
     eMail: fpanos@sch.gr
======================================================================================= -->

<head>
    <style type="text/css">
        /* =====================================================
        FOOTER
        ==========================================================*/
        #mainFooter {
            /* Φωτεινό, απαλό φόντο */
            background-color: #eef0f8;
            padding: 10px 20px 20px 20px;
            margin-top: 40px;
            font-size: 0.9em;
            color: rgba(125, 140, 255, 1);
            /* Flexbox για να ελέγξουμε τη διάταξη */
            display: flex;
            justify-content: space-between;
            /* Σπρώχνει τα στοιχεία στα άκρα */
            align-items: flex-end;
            width: 100%;
            text-align: center;
            box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.2);
        }

        /* ----------------------------------------------------- */
        /* ΑΡΙΣΤΕΡΑ: COPYRIGHT & ΤΕΧΝΙΚΕΣ ΠΛΗΡΟΦΟΡΙΕΣ (footer-row-2) */
        /* ----------------------------------------------------- */
        .footer-row-2 {
            /* Αυτή η ενότητα μένει Αριστερά */
            text-align: left;
            font-size: 0.95em;
            color: #5b6598;
            /* Πιο διακριτικό χρώμα */
            max-width: 900px;
            /* Διασφάλιση ότι δεν θα συρρικνωθεί υπερβολικά */
            flex-shrink: 0;
            line-height: 1.5;
            flex-grow: 1;
        }

        /* ----------------------------------------------------- */
        /* ΚΕΝΤΡΟ: ΔΙΕΥΘΥΝΣΕΙΣ & EMAILS (footer-row-1) */
        /* ----------------------------------------------------- */
        .footer-row-1 {
            /* Δημιουργούμε ένα block για τα στοιχεία επικοινωνίας στο ΚΕΝΤΡΟ */
            text-align: center;
            color: #5b6598;
            line-height: 1.5;
            flex-grow: 1;
            /* Παίρνει όλο τον διαθέσιμο χώρο στο κέντρο */
            padding: 0 20px;
            /* Απομόνωση από τα άκρα */
        }

        /* Στυλ για Συνδέσμους/Emails */
        #mainFooter a {
            color: rgba(125, 140, 255, 1);
            /* Το χρώμα έμφασης */
            text-decoration: none;
            font-weight: 400;
        }

        #mainFooter a:hover {
            text-decoration: none;
        }


        /*==========================================================
                  HEADER
        ===========================================================*/
        #mainHeader {
            /* Flexbox για να ελέγξουμε τη διάταξη */
            display: fixed;
            top: 0px;
            left: 0px;
            right: 0px;
        }


        /* Στυλ για Συνδέσμους/Emails */
        #mainHeader a {
            color: #5b6598;
            /* Το χρώμα έμφασης */
            text-decoration: none;
            font-weight: 500;

        }

        #mainHeader a:hover {
            text-decoration: none;
        }
    </style>
</head>
<footer id="mainFooter" title="✨&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Σχεδίαση - Κατασκευή Συντήρηση: Φράγκος Παναγίωτης - fpanos@sch.gr&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;✨">
    <div class="footer-row-2">
        <a href="mailto:fpanos@sch.gr" title="Φράγκος Παναγιώτης (ΠΕ86) - fpanos@sch.gr ">&copy; Σχεδίαση - Κατασκευή - Συντήρηση: Φράγκος Παναγιώτης</a> <br />
        Δεδομένα από το mySchool.sch.gr (12/2025)<br />
        Version: <?= $mySchoolsVersion ?>
    </div>

    <div class="footer-row-1">
        Διεύθυνση Πρωτοβάθμιας Εκπαίδευσης Γ' Αθήνας<br />
        Μάκρης 3 - Αιγάλεω (πλησίον διασταύρωσης Θηβών & Ιεράς Οδού), 12241 <br />
        <a href='http://dipegath.gr' class='myLink'>www.dipegath.gr</a>&nbsp;-&nbsp;
        <a href='mailto:dipegath@sch.gr' class='myLink'>dipegath@sch.gr</a>

    </div>
</footer>