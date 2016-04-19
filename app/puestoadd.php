<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "puestoinfo.php" ?>
<?php include_once "personainfo.php" ?>
<?php include_once "puesto_tipoinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$puesto_add = NULL; // Initialize page object first

class cpuesto_add extends cpuesto {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{534073BD-D81F-448B-A31F-640F6B0B930C}";

	// Table name
	var $TableName = 'puesto';

	// Page object name
	var $PageObjName = 'puesto_add';

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
    var $AuditTrailOnAdd = TRUE;
    var $AuditTrailOnEdit = FALSE;
    var $AuditTrailOnDelete = FALSE;
    var $AuditTrailOnView = FALSE;
    var $AuditTrailOnViewData = FALSE;
    var $AuditTrailOnSearch = FALSE;

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
		$hidden = TRUE;
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

		// Table object (puesto)
		if (!isset($GLOBALS["puesto"]) || get_class($GLOBALS["puesto"]) == "cpuesto") {
			$GLOBALS["puesto"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["puesto"];
		}

		// Table object (persona)
		if (!isset($GLOBALS['persona'])) $GLOBALS['persona'] = new cpersona();

		// Table object (puesto_tipo)
		if (!isset($GLOBALS['puesto_tipo'])) $GLOBALS['puesto_tipo'] = new cpuesto_tipo();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'puesto', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("puestolist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
		}

		// Create Token
		$this->CreateToken();
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
		global $EW_EXPORT, $puesto;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($puesto);
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["idpuesto"] != "") {
				$this->idpuesto->setQueryStringValue($_GET["idpuesto"]);
				$this->setKey("idpuesto", $this->idpuesto->CurrentValue); // Set up key
			} else {
				$this->setKey("idpuesto", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("puestolist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "puestolist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "puestoview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->idpuesto_tipo->CurrentValue = NULL;
		$this->idpuesto_tipo->OldValue = $this->idpuesto_tipo->CurrentValue;
		$this->idpersona->CurrentValue = NULL;
		$this->idpersona->OldValue = $this->idpersona->CurrentValue;
		$this->idfederacion->CurrentValue = NULL;
		$this->idfederacion->OldValue = $this->idfederacion->CurrentValue;
		$this->idorgano->CurrentValue = NULL;
		$this->idorgano->OldValue = $this->idorgano->CurrentValue;
		$this->fecha_inicio->CurrentValue = NULL;
		$this->fecha_inicio->OldValue = $this->fecha_inicio->CurrentValue;
		$this->fecha_fin->CurrentValue = NULL;
		$this->fecha_fin->OldValue = $this->fecha_fin->CurrentValue;
		$this->status->CurrentValue = "Electo";
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->idpuesto_tipo->FldIsDetailKey) {
			$this->idpuesto_tipo->setFormValue($objForm->GetValue("x_idpuesto_tipo"));
		}
		if (!$this->idpersona->FldIsDetailKey) {
			$this->idpersona->setFormValue($objForm->GetValue("x_idpersona"));
		}
		if (!$this->idfederacion->FldIsDetailKey) {
			$this->idfederacion->setFormValue($objForm->GetValue("x_idfederacion"));
		}
		if (!$this->idorgano->FldIsDetailKey) {
			$this->idorgano->setFormValue($objForm->GetValue("x_idorgano"));
		}
		if (!$this->fecha_inicio->FldIsDetailKey) {
			$this->fecha_inicio->setFormValue($objForm->GetValue("x_fecha_inicio"));
			$this->fecha_inicio->CurrentValue = ew_UnFormatDateTime($this->fecha_inicio->CurrentValue, 7);
		}
		if (!$this->fecha_fin->FldIsDetailKey) {
			$this->fecha_fin->setFormValue($objForm->GetValue("x_fecha_fin"));
			$this->fecha_fin->CurrentValue = ew_UnFormatDateTime($this->fecha_fin->CurrentValue, 7);
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->idpuesto_tipo->CurrentValue = $this->idpuesto_tipo->FormValue;
		$this->idpersona->CurrentValue = $this->idpersona->FormValue;
		$this->idfederacion->CurrentValue = $this->idfederacion->FormValue;
		$this->idorgano->CurrentValue = $this->idorgano->FormValue;
		$this->fecha_inicio->CurrentValue = $this->fecha_inicio->FormValue;
		$this->fecha_inicio->CurrentValue = ew_UnFormatDateTime($this->fecha_inicio->CurrentValue, 7);
		$this->fecha_fin->CurrentValue = $this->fecha_fin->FormValue;
		$this->fecha_fin->CurrentValue = ew_UnFormatDateTime($this->fecha_fin->CurrentValue, 7);
		$this->status->CurrentValue = $this->status->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->idpuesto->setDbValue($rs->fields('idpuesto'));
		$this->idpuesto_tipo->setDbValue($rs->fields('idpuesto_tipo'));
		$this->idpersona->setDbValue($rs->fields('idpersona'));
		$this->idfederacion->setDbValue($rs->fields('idfederacion'));
		$this->idorgano->setDbValue($rs->fields('idorgano'));
		$this->fecha_inicio->setDbValue($rs->fields('fecha_inicio'));
		$this->fecha_fin->setDbValue($rs->fields('fecha_fin'));
		$this->status->setDbValue($rs->fields('status'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idpuesto->DbValue = $row['idpuesto'];
		$this->idpuesto_tipo->DbValue = $row['idpuesto_tipo'];
		$this->idpersona->DbValue = $row['idpersona'];
		$this->idfederacion->DbValue = $row['idfederacion'];
		$this->idorgano->DbValue = $row['idorgano'];
		$this->fecha_inicio->DbValue = $row['fecha_inicio'];
		$this->fecha_fin->DbValue = $row['fecha_fin'];
		$this->status->DbValue = $row['status'];
		$this->estado->DbValue = $row['estado'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idpuesto")) <> "")
			$this->idpuesto->CurrentValue = $this->getKey("idpuesto"); // idpuesto
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// idpuesto
		// idpuesto_tipo
		// idpersona
		// idfederacion
		// idorgano
		// fecha_inicio
		// fecha_fin
		// status
		// estado
		// fecha_insercion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idpuesto
		$this->idpuesto->ViewValue = $this->idpuesto->CurrentValue;
		$this->idpuesto->ViewCustomAttributes = "";

		// idpuesto_tipo
		if (strval($this->idpuesto_tipo->CurrentValue) <> "") {
			$sFilterWrk = "`idpuesto_tipo`" . ew_SearchString("=", $this->idpuesto_tipo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idpuesto_tipo`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `puesto_tipo`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idpuesto_tipo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idpuesto_tipo->ViewValue = $this->idpuesto_tipo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idpuesto_tipo->ViewValue = $this->idpuesto_tipo->CurrentValue;
			}
		} else {
			$this->idpuesto_tipo->ViewValue = NULL;
		}
		$this->idpuesto_tipo->ViewCustomAttributes = "";

		// idpersona
		if (strval($this->idpersona->CurrentValue) <> "") {
			$sFilterWrk = "`idpersona`" . ew_SearchString("=", $this->idpersona->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idpersona`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `persona`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idpersona, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idpersona->ViewValue = $this->idpersona->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idpersona->ViewValue = $this->idpersona->CurrentValue;
			}
		} else {
			$this->idpersona->ViewValue = NULL;
		}
		$this->idpersona->ViewCustomAttributes = "";

		// idfederacion
		if (strval($this->idfederacion->CurrentValue) <> "") {
			$sFilterWrk = "`idfederacion`" . ew_SearchString("=", $this->idfederacion->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idfederacion`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `federacion`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idfederacion, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idfederacion->ViewValue = $this->idfederacion->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idfederacion->ViewValue = $this->idfederacion->CurrentValue;
			}
		} else {
			$this->idfederacion->ViewValue = NULL;
		}
		$this->idfederacion->ViewCustomAttributes = "";

		// idorgano
		if (strval($this->idorgano->CurrentValue) <> "") {
			$sFilterWrk = "`idorgano`" . ew_SearchString("=", $this->idorgano->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idorgano`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `organo`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idorgano, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idorgano->ViewValue = $this->idorgano->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idorgano->ViewValue = $this->idorgano->CurrentValue;
			}
		} else {
			$this->idorgano->ViewValue = NULL;
		}
		$this->idorgano->ViewCustomAttributes = "";

		// fecha_inicio
		$this->fecha_inicio->ViewValue = $this->fecha_inicio->CurrentValue;
		$this->fecha_inicio->ViewValue = ew_FormatDateTime($this->fecha_inicio->ViewValue, 7);
		$this->fecha_inicio->ViewCustomAttributes = "";

		// fecha_fin
		$this->fecha_fin->ViewValue = $this->fecha_fin->CurrentValue;
		$this->fecha_fin->ViewValue = ew_FormatDateTime($this->fecha_fin->ViewValue, 7);
		$this->fecha_fin->ViewCustomAttributes = "";

		// status
		if (strval($this->status->CurrentValue) <> "") {
			$this->status->ViewValue = $this->status->OptionCaption($this->status->CurrentValue);
		} else {
			$this->status->ViewValue = NULL;
		}
		$this->status->ViewCustomAttributes = "";

		// estado
		if (strval($this->estado->CurrentValue) <> "") {
			$this->estado->ViewValue = $this->estado->OptionCaption($this->estado->CurrentValue);
		} else {
			$this->estado->ViewValue = NULL;
		}
		$this->estado->ViewCustomAttributes = "";

		// fecha_insercion
		$this->fecha_insercion->ViewValue = $this->fecha_insercion->CurrentValue;
		$this->fecha_insercion->ViewValue = ew_FormatDateTime($this->fecha_insercion->ViewValue, 7);
		$this->fecha_insercion->ViewCustomAttributes = "";

			// idpuesto_tipo
			$this->idpuesto_tipo->LinkCustomAttributes = "";
			$this->idpuesto_tipo->HrefValue = "";
			$this->idpuesto_tipo->TooltipValue = "";

			// idpersona
			$this->idpersona->LinkCustomAttributes = "";
			$this->idpersona->HrefValue = "";
			$this->idpersona->TooltipValue = "";

			// idfederacion
			$this->idfederacion->LinkCustomAttributes = "";
			$this->idfederacion->HrefValue = "";
			$this->idfederacion->TooltipValue = "";

			// idorgano
			$this->idorgano->LinkCustomAttributes = "";
			$this->idorgano->HrefValue = "";
			$this->idorgano->TooltipValue = "";

			// fecha_inicio
			$this->fecha_inicio->LinkCustomAttributes = "";
			$this->fecha_inicio->HrefValue = "";
			$this->fecha_inicio->TooltipValue = "";

			// fecha_fin
			$this->fecha_fin->LinkCustomAttributes = "";
			$this->fecha_fin->HrefValue = "";
			$this->fecha_fin->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// idpuesto_tipo
			$this->idpuesto_tipo->EditAttrs["class"] = "form-control";
			$this->idpuesto_tipo->EditCustomAttributes = "";
			if ($this->idpuesto_tipo->getSessionValue() <> "") {
				$this->idpuesto_tipo->CurrentValue = $this->idpuesto_tipo->getSessionValue();
			if (strval($this->idpuesto_tipo->CurrentValue) <> "") {
				$sFilterWrk = "`idpuesto_tipo`" . ew_SearchString("=", $this->idpuesto_tipo->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `idpuesto_tipo`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `puesto_tipo`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idpuesto_tipo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->idpuesto_tipo->ViewValue = $this->idpuesto_tipo->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->idpuesto_tipo->ViewValue = $this->idpuesto_tipo->CurrentValue;
				}
			} else {
				$this->idpuesto_tipo->ViewValue = NULL;
			}
			$this->idpuesto_tipo->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->idpuesto_tipo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idpuesto_tipo`" . ew_SearchString("=", $this->idpuesto_tipo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idpuesto_tipo`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `puesto_tipo`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idpuesto_tipo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idpuesto_tipo->EditValue = $arwrk;
			}

			// idpersona
			$this->idpersona->EditAttrs["class"] = "form-control";
			$this->idpersona->EditCustomAttributes = "";
			if ($this->idpersona->getSessionValue() <> "") {
				$this->idpersona->CurrentValue = $this->idpersona->getSessionValue();
			if (strval($this->idpersona->CurrentValue) <> "") {
				$sFilterWrk = "`idpersona`" . ew_SearchString("=", $this->idpersona->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `idpersona`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `persona`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idpersona, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->idpersona->ViewValue = $this->idpersona->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->idpersona->ViewValue = $this->idpersona->CurrentValue;
				}
			} else {
				$this->idpersona->ViewValue = NULL;
			}
			$this->idpersona->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->idpersona->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idpersona`" . ew_SearchString("=", $this->idpersona->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idpersona`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `persona`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idpersona, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idpersona->EditValue = $arwrk;
			}

			// idfederacion
			$this->idfederacion->EditAttrs["class"] = "form-control";
			$this->idfederacion->EditCustomAttributes = "";
			if (trim(strval($this->idfederacion->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idfederacion`" . ew_SearchString("=", $this->idfederacion->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idfederacion`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `federacion`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idfederacion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idfederacion->EditValue = $arwrk;

			// idorgano
			$this->idorgano->EditAttrs["class"] = "form-control";
			$this->idorgano->EditCustomAttributes = "";
			if (trim(strval($this->idorgano->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idorgano`" . ew_SearchString("=", $this->idorgano->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idorgano`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `organo`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idorgano, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idorgano->EditValue = $arwrk;

			// fecha_inicio
			$this->fecha_inicio->EditAttrs["class"] = "form-control";
			$this->fecha_inicio->EditCustomAttributes = "";
			$this->fecha_inicio->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha_inicio->CurrentValue, 7));
			$this->fecha_inicio->PlaceHolder = ew_RemoveHtml($this->fecha_inicio->FldCaption());

			// fecha_fin
			$this->fecha_fin->EditAttrs["class"] = "form-control";
			$this->fecha_fin->EditCustomAttributes = "";
			$this->fecha_fin->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha_fin->CurrentValue, 7));
			$this->fecha_fin->PlaceHolder = ew_RemoveHtml($this->fecha_fin->FldCaption());

			// status
			$this->status->EditAttrs["class"] = "form-control";
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(TRUE);

			// Add refer script
			// idpuesto_tipo

			$this->idpuesto_tipo->LinkCustomAttributes = "";
			$this->idpuesto_tipo->HrefValue = "";

			// idpersona
			$this->idpersona->LinkCustomAttributes = "";
			$this->idpersona->HrefValue = "";

			// idfederacion
			$this->idfederacion->LinkCustomAttributes = "";
			$this->idfederacion->HrefValue = "";

			// idorgano
			$this->idorgano->LinkCustomAttributes = "";
			$this->idorgano->HrefValue = "";

			// fecha_inicio
			$this->fecha_inicio->LinkCustomAttributes = "";
			$this->fecha_inicio->HrefValue = "";

			// fecha_fin
			$this->fecha_fin->LinkCustomAttributes = "";
			$this->fecha_fin->HrefValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->idpuesto_tipo->FldIsDetailKey && !is_null($this->idpuesto_tipo->FormValue) && $this->idpuesto_tipo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idpuesto_tipo->FldCaption(), $this->idpuesto_tipo->ReqErrMsg));
		}
		if (!$this->idpersona->FldIsDetailKey && !is_null($this->idpersona->FormValue) && $this->idpersona->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idpersona->FldCaption(), $this->idpersona->ReqErrMsg));
		}
		if (!$this->idfederacion->FldIsDetailKey && !is_null($this->idfederacion->FormValue) && $this->idfederacion->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idfederacion->FldCaption(), $this->idfederacion->ReqErrMsg));
		}
		if (!$this->idorgano->FldIsDetailKey && !is_null($this->idorgano->FormValue) && $this->idorgano->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idorgano->FldCaption(), $this->idorgano->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->fecha_inicio->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha_inicio->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->fecha_fin->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha_fin->FldErrMsg());
		}
		if (!$this->status->FldIsDetailKey && !is_null($this->status->FormValue) && $this->status->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->status->FldCaption(), $this->status->ReqErrMsg));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// idpuesto_tipo
		$this->idpuesto_tipo->SetDbValueDef($rsnew, $this->idpuesto_tipo->CurrentValue, 0, FALSE);

		// idpersona
		$this->idpersona->SetDbValueDef($rsnew, $this->idpersona->CurrentValue, 0, FALSE);

		// idfederacion
		$this->idfederacion->SetDbValueDef($rsnew, $this->idfederacion->CurrentValue, 0, FALSE);

		// idorgano
		$this->idorgano->SetDbValueDef($rsnew, $this->idorgano->CurrentValue, 0, FALSE);

		// fecha_inicio
		$this->fecha_inicio->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha_inicio->CurrentValue, 7), NULL, FALSE);

		// fecha_fin
		$this->fecha_fin->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha_fin->CurrentValue, 7), NULL, FALSE);

		// status
		$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, "", strval($this->status->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->idpuesto->setDbValue($conn->Insert_ID());
				$rsnew['idpuesto'] = $this->idpuesto->DbValue;
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
			$this->WriteAuditTrailOnAdd($rsnew);
		}
		return $AddRow;
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "persona") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idpersona"] <> "") {
					$GLOBALS["persona"]->idpersona->setQueryStringValue($_GET["fk_idpersona"]);
					$this->idpersona->setQueryStringValue($GLOBALS["persona"]->idpersona->QueryStringValue);
					$this->idpersona->setSessionValue($this->idpersona->QueryStringValue);
					if (!is_numeric($GLOBALS["persona"]->idpersona->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "puesto_tipo") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idpuesto_tipo"] <> "") {
					$GLOBALS["puesto_tipo"]->idpuesto_tipo->setQueryStringValue($_GET["fk_idpuesto_tipo"]);
					$this->idpuesto_tipo->setQueryStringValue($GLOBALS["puesto_tipo"]->idpuesto_tipo->QueryStringValue);
					$this->idpuesto_tipo->setSessionValue($this->idpuesto_tipo->QueryStringValue);
					if (!is_numeric($GLOBALS["puesto_tipo"]->idpuesto_tipo->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "persona") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_idpersona"] <> "") {
					$GLOBALS["persona"]->idpersona->setFormValue($_POST["fk_idpersona"]);
					$this->idpersona->setFormValue($GLOBALS["persona"]->idpersona->FormValue);
					$this->idpersona->setSessionValue($this->idpersona->FormValue);
					if (!is_numeric($GLOBALS["persona"]->idpersona->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "puesto_tipo") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_idpuesto_tipo"] <> "") {
					$GLOBALS["puesto_tipo"]->idpuesto_tipo->setFormValue($_POST["fk_idpuesto_tipo"]);
					$this->idpuesto_tipo->setFormValue($GLOBALS["puesto_tipo"]->idpuesto_tipo->FormValue);
					$this->idpuesto_tipo->setSessionValue($this->idpuesto_tipo->FormValue);
					if (!is_numeric($GLOBALS["puesto_tipo"]->idpuesto_tipo->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "persona") {
				if ($this->idpersona->CurrentValue == "") $this->idpersona->setSessionValue("");
			}
			if ($sMasterTblVar <> "puesto_tipo") {
				if ($this->idpuesto_tipo->CurrentValue == "") $this->idpuesto_tipo->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("puestolist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'puesto';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'puesto';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['idpuesto'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserName();
		foreach (array_keys($rs) as $fldname) {
			if ($this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$newvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$newvalue = $rs[$fldname];
					else
						$newvalue = "[MEMO]"; // Memo Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$newvalue = "[XML]"; // XML Field
				} else {
					$newvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $usr, "A", $table, $fldname, $key, "", $newvalue);
			}
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($puesto_add)) $puesto_add = new cpuesto_add();

// Page init
$puesto_add->Page_Init();

// Page main
$puesto_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$puesto_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fpuestoadd = new ew_Form("fpuestoadd", "add");

// Validate form
fpuestoadd.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_idpuesto_tipo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $puesto->idpuesto_tipo->FldCaption(), $puesto->idpuesto_tipo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idpersona");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $puesto->idpersona->FldCaption(), $puesto->idpersona->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idfederacion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $puesto->idfederacion->FldCaption(), $puesto->idfederacion->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idorgano");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $puesto->idorgano->FldCaption(), $puesto->idorgano->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fecha_inicio");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($puesto->fecha_inicio->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fecha_fin");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($puesto->fecha_fin->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $puesto->status->FldCaption(), $puesto->status->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fpuestoadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpuestoadd.ValidateRequired = true;
<?php } else { ?>
fpuestoadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpuestoadd.Lists["x_idpuesto_tipo"] = {"LinkField":"x_idpuesto_tipo","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpuestoadd.Lists["x_idpersona"] = {"LinkField":"x_idpersona","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpuestoadd.Lists["x_idfederacion"] = {"LinkField":"x_idfederacion","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpuestoadd.Lists["x_idorgano"] = {"LinkField":"x_idorgano","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpuestoadd.Lists["x_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpuestoadd.Lists["x_status"].Options = <?php echo json_encode($puesto->status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $puesto_add->ShowPageHeader(); ?>
<?php
$puesto_add->ShowMessage();
?>
<form name="fpuestoadd" id="fpuestoadd" class="<?php echo $puesto_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($puesto_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $puesto_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="puesto">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($puesto->getCurrentMasterTable() == "persona") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="persona">
<input type="hidden" name="fk_idpersona" value="<?php echo $puesto->idpersona->getSessionValue() ?>">
<?php } ?>
<?php if ($puesto->getCurrentMasterTable() == "puesto_tipo") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="puesto_tipo">
<input type="hidden" name="fk_idpuesto_tipo" value="<?php echo $puesto->idpuesto_tipo->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($puesto->idpuesto_tipo->Visible) { // idpuesto_tipo ?>
	<div id="r_idpuesto_tipo" class="form-group">
		<label id="elh_puesto_idpuesto_tipo" for="x_idpuesto_tipo" class="col-sm-2 control-label ewLabel"><?php echo $puesto->idpuesto_tipo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $puesto->idpuesto_tipo->CellAttributes() ?>>
<?php if ($puesto->idpuesto_tipo->getSessionValue() <> "") { ?>
<span id="el_puesto_idpuesto_tipo">
<span<?php echo $puesto->idpuesto_tipo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $puesto->idpuesto_tipo->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idpuesto_tipo" name="x_idpuesto_tipo" value="<?php echo ew_HtmlEncode($puesto->idpuesto_tipo->CurrentValue) ?>">
<?php } else { ?>
<span id="el_puesto_idpuesto_tipo">
<select data-table="puesto" data-field="x_idpuesto_tipo" data-value-separator="<?php echo ew_HtmlEncode(is_array($puesto->idpuesto_tipo->DisplayValueSeparator) ? json_encode($puesto->idpuesto_tipo->DisplayValueSeparator) : $puesto->idpuesto_tipo->DisplayValueSeparator) ?>" id="x_idpuesto_tipo" name="x_idpuesto_tipo"<?php echo $puesto->idpuesto_tipo->EditAttributes() ?>>
<?php
if (is_array($puesto->idpuesto_tipo->EditValue)) {
	$arwrk = $puesto->idpuesto_tipo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($puesto->idpuesto_tipo->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $puesto->idpuesto_tipo->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($puesto->idpuesto_tipo->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($puesto->idpuesto_tipo->CurrentValue) ?>" selected><?php echo $puesto->idpuesto_tipo->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idpuesto_tipo`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `puesto_tipo`";
$sWhereWrk = "";
$puesto->idpuesto_tipo->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$puesto->idpuesto_tipo->LookupFilters += array("f0" => "`idpuesto_tipo` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$puesto->Lookup_Selecting($puesto->idpuesto_tipo, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $puesto->idpuesto_tipo->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_idpuesto_tipo" id="s_x_idpuesto_tipo" value="<?php echo $puesto->idpuesto_tipo->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $puesto->idpuesto_tipo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($puesto->idpersona->Visible) { // idpersona ?>
	<div id="r_idpersona" class="form-group">
		<label id="elh_puesto_idpersona" for="x_idpersona" class="col-sm-2 control-label ewLabel"><?php echo $puesto->idpersona->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $puesto->idpersona->CellAttributes() ?>>
<?php if ($puesto->idpersona->getSessionValue() <> "") { ?>
<span id="el_puesto_idpersona">
<span<?php echo $puesto->idpersona->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $puesto->idpersona->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idpersona" name="x_idpersona" value="<?php echo ew_HtmlEncode($puesto->idpersona->CurrentValue) ?>">
<?php } else { ?>
<span id="el_puesto_idpersona">
<select data-table="puesto" data-field="x_idpersona" data-value-separator="<?php echo ew_HtmlEncode(is_array($puesto->idpersona->DisplayValueSeparator) ? json_encode($puesto->idpersona->DisplayValueSeparator) : $puesto->idpersona->DisplayValueSeparator) ?>" id="x_idpersona" name="x_idpersona"<?php echo $puesto->idpersona->EditAttributes() ?>>
<?php
if (is_array($puesto->idpersona->EditValue)) {
	$arwrk = $puesto->idpersona->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($puesto->idpersona->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $puesto->idpersona->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($puesto->idpersona->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($puesto->idpersona->CurrentValue) ?>" selected><?php echo $puesto->idpersona->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idpersona`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `persona`";
$sWhereWrk = "";
$puesto->idpersona->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$puesto->idpersona->LookupFilters += array("f0" => "`idpersona` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$puesto->Lookup_Selecting($puesto->idpersona, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $puesto->idpersona->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_idpersona" id="s_x_idpersona" value="<?php echo $puesto->idpersona->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $puesto->idpersona->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($puesto->idfederacion->Visible) { // idfederacion ?>
	<div id="r_idfederacion" class="form-group">
		<label id="elh_puesto_idfederacion" for="x_idfederacion" class="col-sm-2 control-label ewLabel"><?php echo $puesto->idfederacion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $puesto->idfederacion->CellAttributes() ?>>
<span id="el_puesto_idfederacion">
<select data-table="puesto" data-field="x_idfederacion" data-value-separator="<?php echo ew_HtmlEncode(is_array($puesto->idfederacion->DisplayValueSeparator) ? json_encode($puesto->idfederacion->DisplayValueSeparator) : $puesto->idfederacion->DisplayValueSeparator) ?>" id="x_idfederacion" name="x_idfederacion"<?php echo $puesto->idfederacion->EditAttributes() ?>>
<?php
if (is_array($puesto->idfederacion->EditValue)) {
	$arwrk = $puesto->idfederacion->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($puesto->idfederacion->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $puesto->idfederacion->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($puesto->idfederacion->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($puesto->idfederacion->CurrentValue) ?>" selected><?php echo $puesto->idfederacion->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idfederacion`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `federacion`";
$sWhereWrk = "";
$puesto->idfederacion->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$puesto->idfederacion->LookupFilters += array("f0" => "`idfederacion` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$puesto->Lookup_Selecting($puesto->idfederacion, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $puesto->idfederacion->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_idfederacion" id="s_x_idfederacion" value="<?php echo $puesto->idfederacion->LookupFilterQuery() ?>">
</span>
<?php echo $puesto->idfederacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($puesto->idorgano->Visible) { // idorgano ?>
	<div id="r_idorgano" class="form-group">
		<label id="elh_puesto_idorgano" for="x_idorgano" class="col-sm-2 control-label ewLabel"><?php echo $puesto->idorgano->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $puesto->idorgano->CellAttributes() ?>>
<span id="el_puesto_idorgano">
<select data-table="puesto" data-field="x_idorgano" data-value-separator="<?php echo ew_HtmlEncode(is_array($puesto->idorgano->DisplayValueSeparator) ? json_encode($puesto->idorgano->DisplayValueSeparator) : $puesto->idorgano->DisplayValueSeparator) ?>" id="x_idorgano" name="x_idorgano"<?php echo $puesto->idorgano->EditAttributes() ?>>
<?php
if (is_array($puesto->idorgano->EditValue)) {
	$arwrk = $puesto->idorgano->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($puesto->idorgano->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $puesto->idorgano->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($puesto->idorgano->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($puesto->idorgano->CurrentValue) ?>" selected><?php echo $puesto->idorgano->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idorgano`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `organo`";
$sWhereWrk = "";
$puesto->idorgano->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$puesto->idorgano->LookupFilters += array("f0" => "`idorgano` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$puesto->Lookup_Selecting($puesto->idorgano, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $puesto->idorgano->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_idorgano" id="s_x_idorgano" value="<?php echo $puesto->idorgano->LookupFilterQuery() ?>">
</span>
<?php echo $puesto->idorgano->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($puesto->fecha_inicio->Visible) { // fecha_inicio ?>
	<div id="r_fecha_inicio" class="form-group">
		<label id="elh_puesto_fecha_inicio" for="x_fecha_inicio" class="col-sm-2 control-label ewLabel"><?php echo $puesto->fecha_inicio->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $puesto->fecha_inicio->CellAttributes() ?>>
<span id="el_puesto_fecha_inicio">
<input type="text" data-table="puesto" data-field="x_fecha_inicio" data-format="7" name="x_fecha_inicio" id="x_fecha_inicio" placeholder="<?php echo ew_HtmlEncode($puesto->fecha_inicio->getPlaceHolder()) ?>" value="<?php echo $puesto->fecha_inicio->EditValue ?>"<?php echo $puesto->fecha_inicio->EditAttributes() ?>>
<?php if (!$puesto->fecha_inicio->ReadOnly && !$puesto->fecha_inicio->Disabled && !isset($puesto->fecha_inicio->EditAttrs["readonly"]) && !isset($puesto->fecha_inicio->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fpuestoadd", "x_fecha_inicio", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php echo $puesto->fecha_inicio->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($puesto->fecha_fin->Visible) { // fecha_fin ?>
	<div id="r_fecha_fin" class="form-group">
		<label id="elh_puesto_fecha_fin" for="x_fecha_fin" class="col-sm-2 control-label ewLabel"><?php echo $puesto->fecha_fin->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $puesto->fecha_fin->CellAttributes() ?>>
<span id="el_puesto_fecha_fin">
<input type="text" data-table="puesto" data-field="x_fecha_fin" data-format="7" name="x_fecha_fin" id="x_fecha_fin" placeholder="<?php echo ew_HtmlEncode($puesto->fecha_fin->getPlaceHolder()) ?>" value="<?php echo $puesto->fecha_fin->EditValue ?>"<?php echo $puesto->fecha_fin->EditAttributes() ?>>
<?php if (!$puesto->fecha_fin->ReadOnly && !$puesto->fecha_fin->Disabled && !isset($puesto->fecha_fin->EditAttrs["readonly"]) && !isset($puesto->fecha_fin->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fpuestoadd", "x_fecha_fin", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php echo $puesto->fecha_fin->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($puesto->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_puesto_status" for="x_status" class="col-sm-2 control-label ewLabel"><?php echo $puesto->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $puesto->status->CellAttributes() ?>>
<span id="el_puesto_status">
<select data-table="puesto" data-field="x_status" data-value-separator="<?php echo ew_HtmlEncode(is_array($puesto->status->DisplayValueSeparator) ? json_encode($puesto->status->DisplayValueSeparator) : $puesto->status->DisplayValueSeparator) ?>" id="x_status" name="x_status"<?php echo $puesto->status->EditAttributes() ?>>
<?php
if (is_array($puesto->status->EditValue)) {
	$arwrk = $puesto->status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($puesto->status->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $puesto->status->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($puesto->status->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($puesto->status->CurrentValue) ?>" selected><?php echo $puesto->status->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $puesto->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $puesto_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fpuestoadd.Init();
</script>
<?php
$puesto_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$puesto_add->Page_Terminate();
?>
