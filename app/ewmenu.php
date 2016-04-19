<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(9, "mi_federacion", $Language->MenuPhrase("9", "MenuText"), "federacionlist.php?cmd=resetall", -1, "", IsLoggedIn() || AllowListMenu('{534073BD-D81F-448B-A31F-640F6B0B930C}federacion'), FALSE);
$RootMenu->AddMenuItem(11, "mi_persona", $Language->MenuPhrase("11", "MenuText"), "personalist.php", -1, "", IsLoggedIn() || AllowListMenu('{534073BD-D81F-448B-A31F-640F6B0B930C}persona'), FALSE);
$RootMenu->AddMenuItem(8, "mci_Cate1logo", $Language->MenuPhrase("8", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(3, "mi_federacion_tipo", $Language->MenuPhrase("3", "MenuText"), "federacion_tipolist.php", 8, "", IsLoggedIn() || AllowListMenu('{534073BD-D81F-448B-A31F-640F6B0B930C}federacion_tipo'), FALSE);
$RootMenu->AddMenuItem(10, "mi_organo", $Language->MenuPhrase("10", "MenuText"), "organolist.php", 8, "", IsLoggedIn() || AllowListMenu('{534073BD-D81F-448B-A31F-640F6B0B930C}organo'), FALSE);
$RootMenu->AddMenuItem(2, "mi_deporte", $Language->MenuPhrase("2", "MenuText"), "deportelist.php", 8, "", IsLoggedIn() || AllowListMenu('{534073BD-D81F-448B-A31F-640F6B0B930C}deporte'), FALSE);
$RootMenu->AddMenuItem(1, "mi_departamento", $Language->MenuPhrase("1", "MenuText"), "departamentolist.php?cmd=resetall", 8, "", IsLoggedIn() || AllowListMenu('{534073BD-D81F-448B-A31F-640F6B0B930C}departamento'), FALSE);
$RootMenu->AddMenuItem(4, "mi_municipio", $Language->MenuPhrase("4", "MenuText"), "municipiolist.php?cmd=resetall", 1, "", IsLoggedIn() || AllowListMenu('{534073BD-D81F-448B-A31F-640F6B0B930C}municipio'), FALSE);
$RootMenu->AddMenuItem(12, "mi_puesto", $Language->MenuPhrase("12", "MenuText"), "puestolist.php?cmd=resetall", 8, "", IsLoggedIn() || AllowListMenu('{534073BD-D81F-448B-A31F-640F6B0B930C}puesto'), FALSE);
$RootMenu->AddMenuItem(13, "mi_puesto_tipo", $Language->MenuPhrase("13", "MenuText"), "puesto_tipolist.php", 12, "", IsLoggedIn() || AllowListMenu('{534073BD-D81F-448B-A31F-640F6B0B930C}puesto_tipo'), FALSE);
$RootMenu->AddMenuItem(-1, "mi_logout", $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, "mi_login", $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
<!-- End Main Menu -->
