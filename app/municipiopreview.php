<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "municipioinfo.php" ?>
<?php include_once "departamentoinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$municipio_preview = NULL; // Initialize page object first

class cmunicipio_preview extends cmunicipio {

	// Page ID
	var $PageID = 'preview';

	// Project ID
	var $ProjectID = "{534073BD-D81F-448B-A31F-640F6B0B930C}";

	// Table name
	var $TableName = 'municipio';

	// Page object name
	var $PageObjName = 'municipio_preview';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (municipio)
		if (!isset($GLOBALS["municipio"]) || get_class($GLOBALS["municipio"]) == "cmunicipio") {
			$GLOBALS["municipio"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["municipio"];
		}

		// Table object (departamento)
		if (!isset($GLOBALS['departamento'])) $GLOBALS['departamento'] = new cdepartamento();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'preview', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'municipio', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (is_null($Security)) $Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		$Security->LoadCurrentUserLevel(CurrentProjectID() . 'municipio');
		if (!$Security->CanList()) {
			echo ew_DeniedMsg();
			exit();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Set up list options
		$this->SetupListOptions();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();

		// Setup other options
		$this->SetupOtherOptions();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $municipio;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($municipio);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $Recordset;
	var $TotalRecs;
	var $RowCnt;
	var $RecCount;
	var $ListOptions; // List options
	var $OtherOptions; // Other options

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Load filter
		$filter = @$_GET["f"];
		$filter = ew_Decrypt($filter);
		if ($filter == "") $filter = "0=1";

		// Set up foreign keys from filter
		$this->SetupForeignKeysFromFilter($filter);

		// Call Recordset Selecting event
		$this->Recordset_Selecting($filter);

		// Load recordset
		$filter = $this->ApplyUserIDFilters($filter);
		$this->Recordset = $this->LoadRs($filter);
		$this->TotalRecs = ($this->Recordset) ? $this->Recordset->RecordCount() : 0;

		// Call Recordset Selected event
		$this->Recordset_Selected($this->Recordset);
		$this->LoadListRowValues($this->Recordset);
		$this->RenderOtherOptions();
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = TRUE;

		// Drop down button for ListOptions
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = TRUE;
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();
		$masterkeyurl = $this->MasterKeyUrl();

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		if ($Security->IsLoggedIn())
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl($masterkeyurl)) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		else
			$oListOpt->Body = "";

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->IsLoggedIn()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl($masterkeyurl)) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];
		$option->UseButtonGroup = TRUE;

		// Add group option item
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// Add
		$item = &$option->Add("add");
		$item->Visible = $Security->IsLoggedIn();
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->GetItem("add");
		$item->Body = "<a class=\"btn btn-default btn-sm ewAddEdit ewAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("AddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddLink")) . "\" href=\"" . ew_HtmlEncode($this->GetAddUrl($this->MasterKeyUrl())) . "\">" . $Language->Phrase("AddLink") . "</a>";
	}

	// Get master foreign key url
	function MasterKeyUrl() {
		$mastertblvar = @$_GET["t"];
		$url = "";
		if ($mastertblvar == "departamento") {
			$url = "" . EW_TABLE_SHOW_MASTER . "=departamento&fk_iddepartamento=" . urlencode(strval($this->iddepartamento->QueryStringValue)) . "";
		}
		return $url;
	}

	// Set up foreign keys from filter
	function SetupForeignKeysFromFilter($f) {
		$mastertblvar = @$_GET["t"];
		if ($mastertblvar == "departamento") {
			$find = "`iddepartamento`="; 
			$x = strpos($f, $find);
			if ($x !== FALSE) {
				$x += strlen($find);
				$val = substr($f, $x);
				$val = $this->UnquoteValue($val, "DB");
 				$this->iddepartamento->setQueryStringValue($val);
			}
		}
	}

	// Unquote value
	function UnquoteValue($val, $dbid) {
		if (substr($val,0,1) == "'" && substr($val,strlen($val)-1) == "'") {
			if (ew_GetConnectionType($dbid) == "MYSQL")
				return stripslashes(substr($val, 1, strlen($val)-2));
			else
				return str_replace("''", "'", substr($val, 1, strlen($val)-2));
		} else {
			return $val;
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}
}
?>
<?php ew_Header(FALSE, 'utf-8') ?>
<?php

// Create page object
if (!isset($municipio_preview)) $municipio_preview = new cmunicipio_preview();

// Page init
$municipio_preview->Page_Init();

// Page main
$municipio_preview->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$municipio_preview->Page_Render();
?>
<?php $municipio_preview->ShowPageHeader(); ?>
<?php if ($municipio_preview->TotalRecs > 0) { ?>
<div class="ewGrid">
<table class="table ewTable ewPreviewTable">
	<thead><!-- Table header -->
		<tr class="ewTableHeader">
<?php

// Render list options
$municipio_preview->RenderListOptions();

// Render list options (header, left)
$municipio_preview->ListOptions->Render("header", "left");
?>
<?php if ($municipio->nombre->Visible) { // nombre ?>
			<th><?php echo $municipio->nombre->FldCaption() ?></th>
<?php } ?>
<?php if ($municipio->siglas->Visible) { // siglas ?>
			<th><?php echo $municipio->siglas->FldCaption() ?></th>
<?php } ?>
<?php if ($municipio->iddepartamento->Visible) { // iddepartamento ?>
			<th><?php echo $municipio->iddepartamento->FldCaption() ?></th>
<?php } ?>
<?php

// Render list options (header, right)
$municipio_preview->ListOptions->Render("header", "right");
?>
		</tr>
	</thead>
	<tbody><!-- Table body -->
<?php
$municipio_preview->RecCount = 0;
$municipio_preview->RowCnt = 0;
while ($municipio_preview->Recordset && !$municipio_preview->Recordset->EOF) {

	// Init row class and style
	$municipio_preview->RecCount++;
	$municipio_preview->RowCnt++;
	$municipio_preview->CssStyle = "";
	$municipio_preview->LoadListRowValues($municipio_preview->Recordset);

	// Render row
	$municipio_preview->RowType = EW_ROWTYPE_PREVIEW; // Preview record
	$municipio_preview->RenderListRow();

	// Render list options
	$municipio_preview->RenderListOptions();
?>
	<tr<?php echo $municipio_preview->RowAttributes() ?>>
<?php

// Render list options (body, left)
$municipio_preview->ListOptions->Render("body", "left", $municipio_preview->RowCnt);
?>
<?php if ($municipio->nombre->Visible) { // nombre ?>
		<!-- nombre -->
		<td<?php echo $municipio->nombre->CellAttributes() ?>>
<span<?php echo $municipio->nombre->ViewAttributes() ?>>
<?php echo $municipio->nombre->ListViewValue() ?></span>
</td>
<?php } ?>
<?php if ($municipio->siglas->Visible) { // siglas ?>
		<!-- siglas -->
		<td<?php echo $municipio->siglas->CellAttributes() ?>>
<span<?php echo $municipio->siglas->ViewAttributes() ?>>
<?php echo $municipio->siglas->ListViewValue() ?></span>
</td>
<?php } ?>
<?php if ($municipio->iddepartamento->Visible) { // iddepartamento ?>
		<!-- iddepartamento -->
		<td<?php echo $municipio->iddepartamento->CellAttributes() ?>>
<span<?php echo $municipio->iddepartamento->ViewAttributes() ?>>
<?php echo $municipio->iddepartamento->ListViewValue() ?></span>
</td>
<?php } ?>
<?php

// Render list options (body, right)
$municipio_preview->ListOptions->Render("body", "right", $municipio_preview->RowCnt);
?>
	</tr>
<?php
	$municipio_preview->Recordset->MoveNext();
}
?>
	</tbody>
</table>
</div>
<?php } ?>
<div class="ewPreviewLowerPanel">
<?php if ($municipio_preview->TotalRecs > 0) { ?>
<div class="ewDetailCount"><?php echo $municipio_preview->TotalRecs ?>&nbsp;<?php echo $Language->Phrase("Record") ?></div>
<?php } else { ?>
<div class="ewDetailCount"><?php echo $Language->Phrase("NoRecord") ?></div>
<?php } ?>
<div class="ewPreviewOtherOptions">
<?php
	foreach ($municipio_preview->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php
$municipio_preview->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
if ($municipio_preview->Recordset)
	$municipio_preview->Recordset->Close();

// Output
$content = ob_get_contents();
ob_end_clean();
echo ew_ConvertToUtf8($content);
?>
<?php
$municipio_preview->Page_Terminate();
?>
