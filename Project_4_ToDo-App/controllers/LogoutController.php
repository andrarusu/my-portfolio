<?php
session_start();               // Pornește sesiunea (pentru a o putea închide)
session_unset();               // Șterge toate variabilele din sesiune
session_destroy();             // Distruge sesiunea
header("Location: ../views/login.php");  // Redirecționează utilizatorul spre login
exit;


// !!!!!!!!!!!!!!!!!!!!!!!!!!!!

// 🔐 Scop: Îți asigură că utilizatorul este complet delogat și nu mai are acces la pagina dashboard.php.

// 📌 Asigură-te că:
// în dashboard.php ai verificare activă de sesiune (isset($_SESSION['user']))

// butonul/linkul de logout trimite către: