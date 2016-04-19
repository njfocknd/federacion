<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "paisinfo.php" ?>
<?php include_once "departamentogridcls.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$pais_add = NULL; // Initialize page object first

class cpais_add extends cpais {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{534073BD-D81F-448B-A31F-640F6B0B930C}";

	// Table name
	var $TableName = 'pais';

	// Page object name
	var $PageObjName = 'pais_add';

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

		// Table object (pais)
		if (!isset($GLOBALS["pais"]) || get_class($GLOBALS["pais"]) == "cpais") {
			$GLOBALS["pais"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pais"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pais', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("paislist.php"));
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

			// Process auto fill for detail table 'departamento'
			if (@$_POST["grid"] == "fdepartamentogrid") {
				if (!isset($GLOBALS["departamento_grid"])) $GLOBALS["departamento_grid"] = new cdepartamento_grid;
				$GLOBALS["departamento_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $pais;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($pais);
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

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["idpais"] != "") {
				$this->idpais->setQueryStringValue($_GET["idpais"]);
				$this->setKey("idpais", $this->idpais->CurrentValue); // Set up key
			} else {
				$this->setKey("idpais", ""); // Clear key
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

		// Set up detail parameters
		$this->SetUpDetailParms();

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
					$this->Page_Terminate("paislist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "paislist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "paisview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetUpDetailParms();
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
		$this->siglas->CurrentValue = NULL;
		$this->siglas->OldValue = $this->siglas->CurrentValue;
		$this->gentilicio_masculino->CurrentValue = NULL;
		$this->gentilicio_masculino->OldValue = $this->gentilicio_masculino->CurrentValue;
		$this->gentilicio_femenino->CurrentValue = NULL;
		$this->gentilicio_femenino->OldValue = $this->gentilicio_femenino->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->nombre->FldIsDetailKey) {
			$this->nombre->setFormValue($objForm->GetValue("x_nombre"));
		}
		if (!$this->siglas->FldIsDetailKey) {
			$this->siglas->setFormValue($objForm->GetValue("x_siglas"));
		}
		if (!$this->gentilicio_masculino->FldIsDetailKey) {
			$this->gentilicio_masculino->setFormValue($objForm->GetValue("x_gentilicio_masculino"));
		}
		if (!$this->gentilicio_femenino->FldIsDetailKey) {
			$this->gentilicio_femenino->setFormValue($objForm->GetValue("x_gentilicio_femenino"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->nombre->CurrentValue = $this->nombre->FormValue;
		$this->siglas->CurrentValue = $this->siglas->FormValue;
		$this->gentilicio_masculino->CurrentValue = $this->gentilicio_masculino->FormValue;
		$this->gentilicio_femenino->CurrentValue = $this->gentilicio_femenino->FormValue;
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
		$this->idpais->setDbValue($rs->fields('idpais'));
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->siglas->setDbValue($rs->fields('siglas'));
		$this->gentilicio_masculino->setDbValue($rs->fields('gentilicio_masculino'));
		$this->gentilicio_femenino->setDbValue($rs->fields('gentilicio_femenino'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idpais->DbValue = $row['idpais'];
		$this->nombre->DbValue = $row['nombre'];
		$this->siglas->DbValue = $row['siglas'];
		$this->gentilicio_masculino->DbValue = $row['gentilicio_masculino'];
		$this->gentilicio_femenino->DbValue = $row['gentilicio_femenino'];
		$this->estado->DbValue = $row['estado'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idpais")) <> "")
			$this->idpais->CurrentValue = $this->getKey("idpais"); // idpais
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
		// idpais
		// nombre
		// siglas
		// gentilicio_masculino
		// gentilicio_femenino
		// estado
		// fecha_insercion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idpais
		$this->idpais->ViewValue = $this->idpais->CurrentValue;
		$this->idpais->ViewCustomAttributes = "";

		// nombre
		$this->nombre->ViewValue = $this->nombre->CurrentValue;
		$this->nombre->ViewCustomAttributes = "";

		// siglas
		$this->siglas->ViewValue = $this->siglas->CurrentValue;
		$this->siglas->ViewCustomAttributes = "";

		// gentilicio_masculino
		$this->gentilicio_masculino->ViewValue = $this->gentilicio_masculino->CurrentValue;
		$this->gentilicio_masculino->ViewCustomAttributes = "";

		// gentilicio_femenino
		$this->gentilicio_femenino->ViewValue = $this->gentilicio_femenino->CurrentValue;
		$this->gentilicio_femenino->ViewCustomAttributes = "";

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

			// siglas
			$this->siglas->LinkCustomAttributes = "";
			$this->siglas->HrefValue = "";
			$this->siglas->TooltipValue = "";

			// gentilicio_masculino
			$this->gentilicio_masculino->LinkCustomAttributes = "";
			$this->gentilicio_masculino->HrefValue = "";
			$this->gentilicio_masculino->TooltipValue = "";

			// gentilicio_femenino
			$this->gentilicio_femenino->LinkCustomAttributes = "";
			$this->gentilicio_femenino->HrefValue = "";
			$this->gentilicio_femenino->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// nombre
			$this->nombre->EditAttrs["class"] = "form-control";
			$this->nombre->EditCustomAttributes = "";
			$this->nombre->EditValue = ew_HtmlEncode($this->nombre->CurrentValue);
			$this->nombre->PlaceHolder = ew_RemoveHtml($this->nombre->FldCaption());

			// siglas
			$this->siglas->EditAttrs["class"] = "form-control";
			$this->siglas->EditCustomAttributes = "";
			$this->siglas->EditValue = ew_HtmlEncode($this->siglas->CurrentValue);
			$this->siglas->PlaceHolder = ew_RemoveHtml($this->siglas->FldCaption());

			// gentilicio_masculino
			$this->gentilicio_masculino->EditAttrs["class"] = "form-control";
			$this->gentilicio_masculino->EditCustomAttributes = "";
			$this->gentilicio_masculino->EditValue = ew_HtmlEncode($this->gentilicio_masculino->CurrentValue);
			$this->gentilicio_masculino->PlaceHolder = ew_RemoveHtml($this->gentilicio_masculino->FldCaption());

			// gentilicio_femenino
			$this->gentilicio_femenino->EditAttrs["class"] = "form-control";
			$this->gentilicio_femenino->EditCustomAttributes = "";
			$this->gentilicio_femenino->EditValue = ew_HtmlEncode($this->gentilicio_femenino->CurrentValue);
			$this->gentilicio_femenino->PlaceHolder = ew_RemoveHtml($this->gentilicio_femenino->FldCaption());

			// Add refer script
			// nombre

			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";

			// siglas
			$this->siglas->LinkCustomAttributes = "";
			$this->siglas->HrefValue = "";

			// gentilicio_masculino
			$this->gentilicio_masculino->LinkCustomAttributes = "";
			$this->gentilicio_masculino->HrefValue = "";

			// gentilicio_femenino
			$this->gentilicio_femenino->LinkCustomAttributes = "";
			$this->gentilicio_femenino->HrefValue = "";
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

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("departamento", $DetailTblVar) && $GLOBALS["departamento"]->DetailAdd) {
			if (!isset($GLOBALS["departamento_grid"])) $GLOBALS["departamento_grid"] = new cdepartamento_grid(); // get detail page object
			$GLOBALS["departamento_grid"]->ValidateGridForm();
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

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// nombre
		$this->nombre->SetDbValueDef($rsnew, $this->nombre->CurrentValue, NULL, FALSE);

		// siglas
		$this->siglas->SetDbValueDef($rsnew, $this->siglas->CurrentValue, NULL, FALSE);

		// gentilicio_masculino
		$this->gentilicio_masculino->SetDbValueDef($rsnew, $this->gentilicio_masculino->CurrentValue, NULL, FALSE);

		// gentilicio_femenino
		$this->gentilicio_femenino->SetDbValueDef($rsnew, $this->gentilicio_femenino->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->idpais->setDbValue($conn->Insert_ID());
				$rsnew['idpais'] = $this->idpais->DbValue;
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

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("departamento", $DetailTblVar) && $GLOBALS["departamento"]->DetailAdd) {
				$GLOBALS["departamento"]->idpais->setSessionValue($this->idpais->CurrentValue); // Set master key
				if (!isset($GLOBALS["departamento_grid"])) $GLOBALS["departamento_grid"] = new cdepartamento_grid(); // Get detail page object
				$AddRow = $GLOBALS["departamento_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["departamento"]->idpais->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("departamento", $DetailTblVar)) {
				if (!isset($GLOBALS["departamento_grid"]))
					$GLOBALS["departamento_grid"] = new cdepartamento_grid;
				if ($GLOBALS["departamento_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["departamento_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["departamento_grid"]->CurrentMode = "add";
					$GLOBALS["departamento_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["departamento_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["departamento_grid"]->setStartRecordNumber(1);
					$GLOBALS["departamento_grid"]->idpais->FldIsDetailKey = TRUE;
					$GLOBALS["departamento_grid"]->idpais->CurrentValue = $this->idpais->CurrentValue;
					$GLOBALS["departamento_grid"]->idpais->setSessionValue($GLOBALS["departamento_grid"]->idpais->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("paislist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($pais_add)) $pais_add = new cpais_add();

// Page init
$pais_add->Page_Init();

// Page main
$pais_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pais_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fpaisadd = new ew_Form("fpaisadd", "add");

// Validate form
fpaisadd.Validate = function() {
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
fpaisadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpaisadd.ValidateRequired = true;
<?php } else { ?>
fpaisadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
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
<?php $pais_add->ShowPageHeader(); ?>
<?php
$pais_add->ShowMessage();
?>
<form name="fpaisadd" id="fpaisadd" class="<?php echo $pais_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pais_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pais_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pais">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($pais->nombre->Visible) { // nombre ?>
	<div id="r_nombre" class="form-group">
		<label id="elh_pais_nombre" for="x_nombre" class="col-sm-2 control-label ewLabel"><?php echo $pais->nombre->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pais->nombre->CellAttributes() ?>>
<span id="el_pais_nombre">
<input type="text" data-table="pais" data-field="x_nombre" name="x_nombre" id="x_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($pais->nombre->getPlaceHolder()) ?>" value="<?php echo $pais->nombre->EditValue ?>"<?php echo $pais->nombre->EditAttributes() ?>>
</span>
<?php echo $pais->nombre->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pais->siglas->Visible) { // siglas ?>
	<div id="r_siglas" class="form-group">
		<label id="elh_pais_siglas" for="x_siglas" class="col-sm-2 control-label ewLabel"><?php echo $pais->siglas->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pais->siglas->CellAttributes() ?>>
<span id="el_pais_siglas">
<input type="text" data-table="pais" data-field="x_siglas" name="x_siglas" id="x_siglas" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($pais->siglas->getPlaceHolder()) ?>" value="<?php echo $pais->siglas->EditValue ?>"<?php echo $pais->siglas->EditAttributes() ?>>
</span>
<?php echo $pais->siglas->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pais->gentilicio_masculino->Visible) { // gentilicio_masculino ?>
	<div id="r_gentilicio_masculino" class="form-group">
		<label id="elh_pais_gentilicio_masculino" for="x_gentilicio_masculino" class="col-sm-2 control-label ewLabel"><?php echo $pais->gentilicio_masculino->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pais->gentilicio_masculino->CellAttributes() ?>>
<span id="el_pais_gentilicio_masculino">
<input type="text" data-table="pais" data-field="x_gentilicio_masculino" name="x_gentilicio_masculino" id="x_gentilicio_masculino" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($pais->gentilicio_masculino->getPlaceHolder()) ?>" value="<?php echo $pais->gentilicio_masculino->EditValue ?>"<?php echo $pais->gentilicio_masculino->EditAttributes() ?>>
</span>
<?php echo $pais->gentilicio_masculino->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pais->gentilicio_femenino->Visible) { // gentilicio_femenino ?>
	<div id="r_gentilicio_femenino" class="form-group">
		<label id="elh_pais_gentilicio_femenino" for="x_gentilicio_femenino" class="col-sm-2 control-label ewLabel"><?php echo $pais->gentilicio_femenino->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pais->gentilicio_femenino->CellAttributes() ?>>
<span id="el_pais_gentilicio_femenino">
<input type="text" data-table="pais" data-field="x_gentilicio_femenino" name="x_gentilicio_femenino" id="x_gentilicio_femenino" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($pais->gentilicio_femenino->getPlaceHolder()) ?>" value="<?php echo $pais->gentilicio_femenino->EditValue ?>"<?php echo $pais->gentilicio_femenino->EditAttributes() ?>>
</span>
<?php echo $pais->gentilicio_femenino->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("departamento", explode(",", $pais->getCurrentDetailTable())) && $departamento->DetailAdd) {
?>
<?php if ($pais->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("departamento", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "departamentogrid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $pais_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fpaisadd.Init();
</script>
<?php
$pais_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pais_add->Page_Terminate();
?>
