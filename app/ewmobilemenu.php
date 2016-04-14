<!-- Begin Main Menu -->
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(8, "mmci_Cate1logo", $Language->MenuPhrase("8", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(3, "mmi_federacion_tipo", $Language->MenuPhrase("3", "MenuText"), "federacion_tipolist.php", 8, "", IsLoggedIn() || AllowListMenu('{534073BD-D81F-448B-A31F-640F6B0B930C}federacion_tipo'), FALSE);
$RootMenu->AddMenuItem(5, "mmi_organo_tipo", $Language->MenuPhrase("5", "MenuText"), "organo_tipolist.php", 8, "", IsLoggedIn() || AllowListMenu('{534073BD-D81F-448B-A31F-640F6B0B930C}organo_tipo'), FALSE);
$RootMenu->AddMenuItem(2, "mmi_deporte", $Language->MenuPhrase("2", "MenuText"), "deportelist.php", 8, "", IsLoggedIn() || AllowListMenu('{534073BD-D81F-448B-A31F-640F6B0B930C}deporte'), FALSE);
$RootMenu->AddMenuItem(6, "mmi_pais", $Language->MenuPhrase("6", "MenuText"), "paislist.php", 8, "", IsLoggedIn() || AllowListMenu('{534073BD-D81F-448B-A31F-640F6B0B930C}pais'), FALSE);
$RootMenu->AddMenuItem(1, "mmi_departamento", $Language->MenuPhrase("1", "MenuText"), "departamentolist.php?cmd=resetall", 6, "", IsLoggedIn() || AllowListMenu('{534073BD-D81F-448B-A31F-640F6B0B930C}departamento'), FALSE);
$RootMenu->AddMenuItem(4, "mmi_municipio", $Language->MenuPhrase("4", "MenuText"), "municipiolist.php?cmd=resetall", 1, "", IsLoggedIn() || AllowListMenu('{534073BD-D81F-448B-A31F-640F6B0B930C}municipio'), FALSE);
$RootMenu->AddMenuItem(-1, "mmi_logout", $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, "mmi_login", $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
<!-- End Main Menu -->
