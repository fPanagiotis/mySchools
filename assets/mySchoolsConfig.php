<?php include_once "assets/Version.php"; ?>
<!-- ===============================================================
     Developer: Φράγκος Παναγιώτης (ΠΕ86)
     Έτος: <?= $mySchoolsYear; ?>

     Εφαρμογή προβολής και αναζήτησης σχολικών μονάδων
     Αυτόματη Έκδοση Build: <?= $mySchoolsVersion; ?>
     
     Web Site: www.tosxoleio.eu
     eMail: fpanos@sch.gr
==================================================================== -->
<?php
$txtSch = "";
$txtPwd = "";
//    ΗΜΕΡΟΜΗΝΙΑ ΠΟΥ ΕΓΙΝΕ ΛΗΨΗ ΔΕΔΟΜΕΝΩΝ 
if (!defined('lastUpdate')) {
   define('lastUpdate', 'Δεκέμβριος 2025');
}
if (!defined('mySchoolsVersion')) {
   define('mySchoolsVersion', '2025.12.01');
}
//    ΟΝΟΜΑ DATABASE SERVER
if (!defined('dbServerName')) {
   define('dbServerName', '10.2.49.41:3306');
}
//    ΟΝΟΜΑ ΧΡΗΣΤΗ ΓΙΑ ΣΥΝΔΕΣΗ ΣΤΗ ΒΑΣΗ ΔΕΔΟΜΕΝΩΝ
if (!defined('dbUser')) {
   define('dbUser', 'grsdipe');
}
//    ΚΩΔΙΚΟΣ ΣΥΝΔΕΣΗΣ ΣΤΗ ΒΑΣΗ ΔΕΔΟΜΕΝΩΝ
if (!defined('dbPwd')) {
   define('dbPwd', 'P@n@g!0t!sFr@gkos');
}
//    ΟΝΟΜΑ ΒΑΣΗΣ ΔΕΔΟΜΕΝΩΝ
if (!defined('dbName')) {
   define('dbName', 'mySch');
}
//    ΕΜΦΑΝΙΣΗ ΣΦΑΛΜΑΤΩΝ
if (!defined('DB_DEBUG')) {
   define('DB_DEBUG', true);
}
if (!defined('DB_DEBUG_LOG')) {
   define('DB_DEBUG_LOG', true);
}

// if(!defined('mySxDrVersion')){define('mySxDrVersion', '20251224');}
// if(!defined('dbServerName')){define('dbServerName', '10.2.49.46:3306');}
// if(!defined('dbUser')){define('dbUser', 'dbUser');}
// if(!defined('dbPwd')){define('dbPwd', 'G#P@8eH6x9oyuphe');}
// if(!defined('dbName')){define('dbName', 'mySxDr');}
// if(!defined('DB_DEBUG')){define('DB_DEBUG', true);}
// if(!defined('DB_DEBUG_LOG')){define('DB_DEBUG_LOG', true);}
// ⚠️▶🔗🔔⏳⏱️💾🐞🛑🚫👍💥🔥🔒🔑🔍🔨🟡🔵🟡🟣⚫👀🔴🟠🟢🟤⚪🎯●○⬤◯🌐🔶⭕
// 💡 ✨ 🔧 ⚙️ 🛠️ 🧩 📌 📍 📎 🚀 🧠 💭 🗂️ 📁 📂  🖥️ 💻 🖱️ ⌨️ 🧪 🧬 🔍⋯ ☰ ⋮   📤  📥 
// ⭐ 🌟 ✨⚠️  ✅ ☑️⬇▶️⏹️ ⛔🔄 🔁 🔃 
// 📊 📈 📉📝 🗒️ ✏️📂 📁 🗑️✍️♻️ 📐📄📤 📥🔐 🔒 🔓⚡ 💾 🧱
// 🌐 🏷️ 🧭   ℹ️ 🔎 🧭📘 📙 📗💬 🗨️ 💭🛟 🆘     🏠 🏡
// ➡️ ⬅️ ⬆️ ⬇️ ↗️ ↘️ ↙️ ↖️🔙 🔚 🔛🆕 🆗 🆙
// ➕ ➖ ✖️ ➗🔍 ➕ 🔍 ➖ ❌ ❗ ❕ ❓✔️         
// 🏷️ 🎯 🎛️🔖 📜⚙️ 🔧 🛠️🔩 ⚒️ 🧲🧰 🔋
?>