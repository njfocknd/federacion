<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "federacioninfo.php" ?>
<?php include_once "deporteinfo.php" ?>
<?php include_once "federacion_tipoinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$federacion_add = NULL; // Initialize page object first

class cfederacion_add extends cfederacion {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{534073BD-D81F-448B-A31F-640F6B0B930C}";

	// Table name
	var $TableName = 'federacion';

	// Page object name
	var $PageObjName = 'federacion_add';

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

		// Table object (federacion)
		if (!isset($GLOBALS["federacion"]) || get_class($GLOBALS["federacion"]) == "cfederacion") {
			$GLOBALS["federacion"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["federacion"];
		}

		// Table object (deporte)
		if (!isset($GLOBALS['deporte'])) $GLOBALS['deporte'] = new cdeporte();

		// Table object (federacion_tipo)
		if (!isset($GLOBALS['federacion_tipo'])) $GLOBALS['federacion_tipo'] = new cfederacion_tipo();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'federacion', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("federacionlist.php"));
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
		global $EW_EXPORT, $federacion;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($federacion);
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
			if (@$_GET["idfederacion"] != "") {
				$this->idfederacion->setQueryStringValue($_GET["idfederacion"]);
				$this->setKey("idfederacion", $this->idfederacion->CurrentValue); // Set up key
			} else {
				$this->setKey("idfederacion", ""); // Clear key
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
					$this->Page_Terminate("federacionlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "federacionlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "federacionview.php")
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
		$this->nombre->CurrentValue = NULL;
		$this->nombre->OldValue = $this->nombre->CurrentValue;
		$this->nomenclatura->CurrentValue = NULL;
		$this->nomenclatura->OldValue = $this->nomenclatura->CurrentValue;
		$this->idfederacion_tipo->CurrentValue = 1;
		$this->iddeporte->CurrentValue = 1;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->nombre->FldIsDetailKey) {
			$this->nombre->setFormValue($objForm->GetValue("x_nombre"));
		}
		if (!$this->nomenclatura->FldIsDetailKey) {
			$this->nomenclatura->setFormValue($objForm->GetValue("x_nomenclatura"));
		}
		if (!$this->idfederacion_tipo->FldIsDetailKey) {
			$this->idfederacion_tipo->setFormValue($objForm->GetValue("x_idfederacion_tipo"));
		}
		if (!$this->iddeporte->FldIsDetailKey) {
			$this->iddeporte->setFormValue($objForm->GetValue("x_iddeporte"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->nombre->CurrentValue = $this->nombre->FormValue;
		$this->nomenclatura->CurrentValue = $this->nomenclatura->FormValue;
		$this->idfederacion_tipo->CurrentValue = $this->idfederacion_tipo->FormValue;
		$this->iddeporte->CurrentValue = $this->iddeporte->FormValue;
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
		$this->idfederacion->setDbValue($rs->fields('idfederacion'));
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->nomenclatura->setDbValue($rs->fields('nomenclatura'));
		$this->idfederacion_tipo->setDbValue($rs->fields('idfederacion_tipo'));
		$this->iddeporte->setDbValue($rs->fields('iddeporte'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idfederacion->DbValue = $row['idfederacion'];
		$this->nombre->DbValue = $row['nombre'];
		$this->nomenclatura->DbValue = $row['nomenclatura'];
		$this->idfederacion_tipo->DbValue = $row['idfederacion_tipo'];
		$this->iddeporte->DbValue = $row['iddeporte'];
		$this->estado->DbValue = $row['estado'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idfederacion")) <> "")
			$this->idfederacion->CurrentValue = $this->getKey("idfederacion"); // idfederacion
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
		// idfederacion
		// nombre
		// nomenclatura
		// idfederacion_tipo
		// iddeporte
		// estado
		// fecha_insercion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idfederacion
		$this->idfederacion->ViewValue = $this->idfederacion->CurrentValue;
		$this->idfederacion->ViewCustomAttributes = "";

		// nombre
		$this->nombre->ViewValue = $this->nombre->CurrentValue;
		$this->nombre->ViewCustomAttributes = "";

		// nomenclatura
		$this->nomenclatura->ViewValue = $this->nomenclatura->CurrentValue;
		$this->nomenclatura->ViewCustomAttributes = "";

		// idfederacion_tipo
		if (strval($this->idfederacion_tipo->CurrentValue) <> "") {
			$sFilterWrk = "`idfederacion_tipo`" . ew_SearchString("=", $this->idfederacion_tipo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idfederacion_tipo`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `federacion_tipo`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idfederacion_tipo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idfederacion_tipo->ViewValue = $this->idfederacion_tipo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idfederacion_tipo->ViewValue = $this->idfederacion_tipo->CurrentValue;
			}
		} else {
			$this->idfederacion_tipo->ViewValue = NULL;
		}
		$this->idfederacion_tipo->ViewCustomAttributes = "";

		// iddeporte
		if (strval($this->iddeporte->CurrentValue) <> "") {
			$sFilterWrk = "`iddeporte`" . ew_SearchString("=", $this->iddeporte->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `iddeporte`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `deporte`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->iddeporte, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->iddeporte->ViewValue = $this->iddeporte->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->iddeporte->ViewValue = $this->iddeporte->CurrentValue;
			}
		} else {
			$this->iddeporte->ViewValue = NULL;
		}
		$this->iddeporte->ViewCustomAttributes = "";

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

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";
			$this->nombre->TooltipValue = "";

			// nomenclatura
			$this->nomenclatura->LinkCustomAttributes = "";
			$this->nomenclatura->HrefValue = "";
			$this->nomenclatura->TooltipValue = "";

			// idfederacion_tipo
			$this->idfederacion_tipo->LinkCustomAttributes = "";
			$this->idfederacion_tipo->HrefValue = "";
			$this->idfederacion_tipo->TooltipValue = "";

			// iddeporte
			$this->iddeporte->LinkCustomAttributes = "";
			$this->iddeporte->HrefValue = "";
			$this->iddeporte->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// nombre
			$this->nombre->EditAttrs["class"] = "form-control";
			$this->nombre->EditCustomAttributes = "";
			$this->nombre->EditValue = ew_HtmlEncode($this->nombre->CurrentValue);
			$this->nombre->PlaceHolder = ew_RemoveHtml($this->nombre->FldCaption());

			// nomenclatura
			$this->nomenclatura->EditAttrs["class"] = "form-control";
			$this->nomenclatura->EditCustomAttributes = "";
			$this->nomenclatura->EditValue = ew_HtmlEncode($this->nomenclatura->CurrentValue);
			$this->nomenclatura->PlaceHolder = ew_RemoveHtml($this->nomenclatura->FldCaption());

			// idfederacion_tipo
			$this->idfederacion_tipo->EditAttrs["class"] = "form-control";
			$this->idfederacion_tipo->EditCustomAttributes = "";
			if ($this->idfederacion_tipo->getSessionValue() <> "") {
				$this->idfederacion_tipo->CurrentValue = $this->idfederacion_tipo->getSessionValue();
			if (strval($this->idfederacion_tipo->CurrentValue) <> "") {
				$sFilterWrk = "`idfederacion_tipo`" . ew_SearchString("=", $this->idfederacion_tipo->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `idfederacion_tipo`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `federacion_tipo`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idfederacion_tipo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->idfederacion_tipo->ViewValue = $this->idfederacion_tipo->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->idfederacion_tipo->ViewValue = $this->idfederacion_tipo->CurrentValue;
				}
			} else {
				$this->idfederacion_tipo->ViewValue = NULL;
			}
			$this->idfederacion_tipo->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->idfederacion_tipo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idfederacion_tipo`" . ew_SearchString("=", $this->idfederacion_tipo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idfederacion_tipo`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `federacion_tipo`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idfederacion_tipo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idfederacion_tipo->EditValue = $arwrk;
			}

			// iddeporte
			$this->iddeporte->EditAttrs["class"] = "form-control";
			$this->iddeporte->EditCustomAttributes = "";
			if ($this->iddeporte->getSessionValue() <> "") {
				$this->iddeporte->CurrentValue = $this->iddeporte->getSessionValue();
			if (strval($this->iddeporte->CurrentValue) <> "") {
				$sFilterWrk = "`iddeporte`" . ew_SearchString("=", $this->iddeporte->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `iddeporte`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `deporte`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->iddeporte, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->iddeporte->ViewValue = $this->iddeporte->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->iddeporte->ViewValue = $this->iddeporte->CurrentValue;
				}
			} else {
				$this->iddeporte->ViewValue = NULL;
			}
			$this->iddeporte->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->iddeporte->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`iddeporte`" . ew_SearchString("=", $this->iddeporte->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `iddeporte`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `deporte`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->iddeporte, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->iddeporte->EditValue = $arwrk;
			}

			// Add refer script
			// nombre

			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";

			// nomenclatura
			$this->nomenclatura->LinkCustomAttributes = "";
			$this->nomenclatura->HrefValue = "";

			// idfederacion_tipo
			$this->idfederacion_tipo->LinkCustomAttributes = "";
			$this->idfederacion_tipo->HrefValue = "";

			// iddeporte
			$this->iddeporte->LinkCustomAttributes = "";
			$this->iddeporte->HrefValue = "";
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
		if (!$this->nombre->FldIsDetailKey && !is_null($this->nombre->FormValue) && $this->nombre->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nombre->FldCaption(), $this->nombre->ReqErrMsg));
		}
		if (!$this->nomenclatura->FldIsDetailKey && !is_null($this->nomenclatura->FormValue) && $this->nomenclatura->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nomenclatura->FldCaption(), $this->nomenclatura->ReqErrMsg));
		}
		if (!$this->idfederacion_tipo->FldIsDetailKey && !is_null($this->idfederacion_tipo->FormValue) && $this->idfederacion_tipo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idfederacion_tipo->FldCaption(), $this->idfederacion_tipo->ReqErrMsg));
		}
		if (!$this->iddeporte->FldIsDetailKey && !is_null($this->iddeporte->FormValue) && $this->iddeporte->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->iddeporte->FldCaption(), $this->iddeporte->ReqErrMsg));
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

		// nombre
		$this->nombre->SetDbValueDef($rsnew, $this->nombre->CurrentValue, "", FALSE);

		// nomenclatura
		$this->nomenclatura->SetDbValueDef($rsnew, $this->nomenclatura->CurrentValue, "", FALSE);

		// idfederacion_tipo
		$this->idfederacion_tipo->SetDbValueDef($rsnew, $this->idfederacion_tipo->CurrentValue, 0, FALSE);

		// iddeporte
		$this->iddeporte->SetDbValueDef($rsnew, $this->iddeporte->CurrentValue, 0, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->idfederacion->setDbValue($conn->Insert_ID());
				$rsnew['idfederacion'] = $this->idfederacion->DbValue;
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
			if ($sMasterTblVar == "federacion_tipo") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idfederacion_tipo"] <> "") {
					$GLOBALS["federacion_tipo"]->idfederacion_tipo->setQueryStringValue($_GET["fk_idfederacion_tipo"]);
					$this->idfederacion_tipo->setQueryStringValue($GLOBALS["federacion_tipo"]->idfederacion_tipo->QueryStringValue);
					$this->idfederacion_tipo->setSessionValue($this->idfederacion_tipo->QueryStringValue);
					if (!is_numeric($GLOBALS["federacion_tipo"]->idfederacion_tipo->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "deporte") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_iddeporte"] <> "") {
					$GLOBALS["deporte"]->iddeporte->setQueryStringValue($_GET["fk_iddeporte"]);
					$this->iddeporte->setQueryStringValue($GLOBALS["deporte"]->iddeporte->QueryStringValue);
					$this->iddeporte->setSessionValue($this->iddeporte->QueryStringValue);
					if (!is_numeric($GLOBALS["deporte"]->iddeporte->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "federacion_tipo") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_idfederacion_tipo"] <> "") {
					$GLOBALS["federacion_tipo"]->idfederacion_tipo->setFormValue($_POST["fk_idfederacion_tipo"]);
					$this->idfederacion_tipo->setFormValue($GLOBALS["federacion_tipo"]->idfederacion_tipo->FormValue);
					$this->idfederacion_tipo->setSessionValue($this->idfederacion_tipo->FormValue);
					if (!is_numeric($GLOBALS["federacion_tipo"]->idfederacion_tipo->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "deporte") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_iddeporte"] <> "") {
					$GLOBALS["deporte"]->iddeporte->setFormValue($_POST["fk_iddeporte"]);
					$this->iddeporte->setFormValue($GLOBALS["deporte"]->iddeporte->FormValue);
					$this->iddeporte->setSessionValue($this->iddeporte->FormValue);
					if (!is_numeric($GLOBALS["deporte"]->iddeporte->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "federacion_tipo") {
				if ($this->idfederacion_tipo->CurrentValue == "") $this->idfederacion_tipo->setSessionValue("");
			}
			if ($sMasterTblVar <> "deporte") {
				if ($this->iddeporte->CurrentValue == "") $this->iddeporte->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("federacionlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'federacion';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'federacion';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['idfederacion'];

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
if (!isset($federacion_add)) $federacion_add = new cfederacion_add();

// Page init
$federacion_add->Page_Init();

// Page main
$federacion_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$federacion_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ffederacionadd = new ew_Form("ffederacionadd", "add");

// Validate form
ffederacionadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $federacion->nombre->FldCaption(), $federacion->nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nomenclatura");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $federacion->nomenclatura->FldCaption(), $federacion->nomenclatura->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idfederacion_tipo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $federacion->idfederacion_tipo->FldCaption(), $federacion->idfederacion_tipo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_iddeporte");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $federacion->iddeporte->FldCaption(), $federacion->iddeporte->ReqErrMsg)) ?>");

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
ffederacionadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ffederacionadd.ValidateRequired = true;
<?php } else { ?>
ffederacionadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ffederacionadd.Lists["x_idfederacion_tipo"] = {"LinkField":"x_idfederacion_tipo","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ffederacionadd.Lists["x_iddeporte"] = {"LinkField":"x_iddeporte","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

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
<?php $federacion_add->ShowPageHeader(); ?>
<?php
$federacion_add->ShowMessage();
?>
<form name="ffederacionadd" id="ffederacionadd" class="<?php echo $federacion_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($federacion_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $federacion_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="federacion">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($federacion->getCurrentMasterTable() == "federacion_tipo") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="federacion_tipo">
<input type="hidden" name="fk_idfederacion_tipo" value="<?php echo $federacion->idfederacion_tipo->getSessionValue() ?>">
<?php } ?>
<?php if ($federacion->getCurrentMasterTable() == "deporte") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="deporte">
<input type="hidden" name="fk_iddeporte" value="<?php echo $federacion->iddeporte->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($federacion->nombre->Visible) { // nombre ?>
	<div id="r_nombre" class="form-group">
		<label id="elh_federacion_nombre" for="x_nombre" class="col-sm-2 control-label ewLabel"><?php echo $federacion->nombre->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $federacion->nombre->CellAttributes() ?>>
<span id="el_federacion_nombre">
<input type="text" data-table="federacion" data-field="x_nombre" name="x_nombre" id="x_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($federacion->nombre->getPlaceHolder()) ?>" value="<?php echo $federacion->nombre->EditValue ?>"<?php echo $federacion->nombre->EditAttributes() ?>>
</span>
<?php echo $federacion->nombre->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($federacion->nomenclatura->Visible) { // nomenclatura ?>
	<div id="r_nomenclatura" class="form-group">
		<label id="elh_federacion_nomenclatura" for="x_nomenclatura" class="col-sm-2 control-label ewLabel"><?php echo $federacion->nomenclatura->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $federacion->nomenclatura->CellAttributes() ?>>
<span id="el_federacion_nomenclatura">
<input type="text" data-table="federacion" data-field="x_nomenclatura" name="x_nomenclatura" id="x_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($federacion->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $federacion->nomenclatura->EditValue ?>"<?php echo $federacion->nomenclatura->EditAttributes() ?>>
</span>
<?php echo $federacion->nomenclatura->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($federacion->idfederacion_tipo->Visible) { // idfederacion_tipo ?>
	<div id="r_idfederacion_tipo" class="form-group">
		<label id="elh_federacion_idfederacion_tipo" for="x_idfederacion_tipo" class="col-sm-2 control-label ewLabel"><?php echo $federacion->idfederacion_tipo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $federacion->idfederacion_tipo->CellAttributes() ?>>
<?php if ($federacion->idfederacion_tipo->getSessionValue() <> "") { ?>
<span id="el_federacion_idfederacion_tipo">
<span<?php echo $federacion->idfederacion_tipo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $federacion->idfederacion_tipo->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idfederacion_tipo" name="x_idfederacion_tipo" value="<?php echo ew_HtmlEncode($federacion->idfederacion_tipo->CurrentValue) ?>">
<?php } else { ?>
<span id="el_federacion_idfederacion_tipo">
<select data-table="federacion" data-field="x_idfederacion_tipo" data-value-separator="<?php echo ew_HtmlEncode(is_array($federacion->idfederacion_tipo->DisplayValueSeparator) ? json_encode($federacion->idfederacion_tipo->DisplayValueSeparator) : $federacion->idfederacion_tipo->DisplayValueSeparator) ?>" id="x_idfederacion_tipo" name="x_idfederacion_tipo"<?php echo $federacion->idfederacion_tipo->EditAttributes() ?>>
<?php
if (is_array($federacion->idfederacion_tipo->EditValue)) {
	$arwrk = $federacion->idfederacion_tipo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($federacion->idfederacion_tipo->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $federacion->idfederacion_tipo->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($federacion->idfederacion_tipo->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($federacion->idfederacion_tipo->CurrentValue) ?>" selected><?php echo $federacion->idfederacion_tipo->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idfederacion_tipo`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `federacion_tipo`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$federacion->idfederacion_tipo->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$federacion->idfederacion_tipo->LookupFilters += array("f0" => "`idfederacion_tipo` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$federacion->Lookup_Selecting($federacion->idfederacion_tipo, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $federacion->idfederacion_tipo->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_idfederacion_tipo" id="s_x_idfederacion_tipo" value="<?php echo $federacion->idfederacion_tipo->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $federacion->idfederacion_tipo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($federacion->iddeporte->Visible) { // iddeporte ?>
	<div id="r_iddeporte" class="form-group">
		<label id="elh_federacion_iddeporte" for="x_iddeporte" class="col-sm-2 control-label ewLabel"><?php echo $federacion->iddeporte->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $federacion->iddeporte->CellAttributes() ?>>
<?php if ($federacion->iddeporte->getSessionValue() <> "") { ?>
<span id="el_federacion_iddeporte">
<span<?php echo $federacion->iddeporte->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $federacion->iddeporte->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_iddeporte" name="x_iddeporte" value="<?php echo ew_HtmlEncode($federacion->iddeporte->CurrentValue) ?>">
<?php } else { ?>
<span id="el_federacion_iddeporte">
<select data-table="federacion" data-field="x_iddeporte" data-value-separator="<?php echo ew_HtmlEncode(is_array($federacion->iddeporte->DisplayValueSeparator) ? json_encode($federacion->iddeporte->DisplayValueSeparator) : $federacion->iddeporte->DisplayValueSeparator) ?>" id="x_iddeporte" name="x_iddeporte"<?php echo $federacion->iddeporte->EditAttributes() ?>>
<?php
if (is_array($federacion->iddeporte->EditValue)) {
	$arwrk = $federacion->iddeporte->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($federacion->iddeporte->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $federacion->iddeporte->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($federacion->iddeporte->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($federacion->iddeporte->CurrentValue) ?>" selected><?php echo $federacion->iddeporte->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `iddeporte`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `deporte`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$federacion->iddeporte->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$federacion->iddeporte->LookupFilters += array("f0" => "`iddeporte` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$federacion->Lookup_Selecting($federacion->iddeporte, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $federacion->iddeporte->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_iddeporte" id="s_x_iddeporte" value="<?php echo $federacion->iddeporte->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $federacion->iddeporte->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $federacion_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
ffederacionadd.Init();
</script>
<?php
$federacion_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$federacion_add->Page_Terminate();
?>
