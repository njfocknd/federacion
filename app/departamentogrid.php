<?php

// Create page object
if (!isset($departamento_grid)) $departamento_grid = new cdepartamento_grid();

// Page init
$departamento_grid->Page_Init();

// Page main
$departamento_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$departamento_grid->Page_Render();
?>
<?php if ($departamento->Export == "") { ?>
<script type="text/javascript">

// Form object
var fdepartamentogrid = new ew_Form("fdepartamentogrid", "grid");
fdepartamentogrid.FormKeyCountName = '<?php echo $departamento_grid->FormKeyCountName ?>';

// Validate form
fdepartamentogrid.Validate = function() {
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
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fdepartamentogrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "siglas", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idpais", false)) return false;
	return true;
}

// Form_CustomValidate event
fdepartamentogrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdepartamentogrid.ValidateRequired = true;
<?php } else { ?>
fdepartamentogrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdepartamentogrid.Lists["x_idpais"] = {"LinkField":"x_idpais","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<?php } ?>
<?php
if ($departamento->CurrentAction == "gridadd") {
	if ($departamento->CurrentMode == "copy") {
		$bSelectLimit = $departamento_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$departamento_grid->TotalRecs = $departamento->SelectRecordCount();
			$departamento_grid->Recordset = $departamento_grid->LoadRecordset($departamento_grid->StartRec-1, $departamento_grid->DisplayRecs);
		} else {
			if ($departamento_grid->Recordset = $departamento_grid->LoadRecordset())
				$departamento_grid->TotalRecs = $departamento_grid->Recordset->RecordCount();
		}
		$departamento_grid->StartRec = 1;
		$departamento_grid->DisplayRecs = $departamento_grid->TotalRecs;
	} else {
		$departamento->CurrentFilter = "0=1";
		$departamento_grid->StartRec = 1;
		$departamento_grid->DisplayRecs = $departamento->GridAddRowCount;
	}
	$departamento_grid->TotalRecs = $departamento_grid->DisplayRecs;
	$departamento_grid->StopRec = $departamento_grid->DisplayRecs;
} else {
	$bSelectLimit = $departamento_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($departamento_grid->TotalRecs <= 0)
			$departamento_grid->TotalRecs = $departamento->SelectRecordCount();
	} else {
		if (!$departamento_grid->Recordset && ($departamento_grid->Recordset = $departamento_grid->LoadRecordset()))
			$departamento_grid->TotalRecs = $departamento_grid->Recordset->RecordCount();
	}
	$departamento_grid->StartRec = 1;
	$departamento_grid->DisplayRecs = $departamento_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$departamento_grid->Recordset = $departamento_grid->LoadRecordset($departamento_grid->StartRec-1, $departamento_grid->DisplayRecs);

	// Set no record found message
	if ($departamento->CurrentAction == "" && $departamento_grid->TotalRecs == 0) {
		if ($departamento_grid->SearchWhere == "0=101")
			$departamento_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$departamento_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$departamento_grid->RenderOtherOptions();
?>
<?php $departamento_grid->ShowPageHeader(); ?>
<?php
$departamento_grid->ShowMessage();
?>
<?php if ($departamento_grid->TotalRecs > 0 || $departamento->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fdepartamentogrid" class="ewForm form-inline">
<?php if ($departamento_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($departamento_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_departamento" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_departamentogrid" class="table ewTable">
<?php echo $departamento->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$departamento_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$departamento_grid->RenderListOptions();

// Render list options (header, left)
$departamento_grid->ListOptions->Render("header", "left");
?>
<?php if ($departamento->nombre->Visible) { // nombre ?>
	<?php if ($departamento->SortUrl($departamento->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_departamento_nombre" class="departamento_nombre"><div class="ewTableHeaderCaption"><?php echo $departamento->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div><div id="elh_departamento_nombre" class="departamento_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $departamento->nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($departamento->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($departamento->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($departamento->siglas->Visible) { // siglas ?>
	<?php if ($departamento->SortUrl($departamento->siglas) == "") { ?>
		<th data-name="siglas"><div id="elh_departamento_siglas" class="departamento_siglas"><div class="ewTableHeaderCaption"><?php echo $departamento->siglas->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="siglas"><div><div id="elh_departamento_siglas" class="departamento_siglas">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $departamento->siglas->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($departamento->siglas->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($departamento->siglas->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($departamento->idpais->Visible) { // idpais ?>
	<?php if ($departamento->SortUrl($departamento->idpais) == "") { ?>
		<th data-name="idpais"><div id="elh_departamento_idpais" class="departamento_idpais"><div class="ewTableHeaderCaption"><?php echo $departamento->idpais->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idpais"><div><div id="elh_departamento_idpais" class="departamento_idpais">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $departamento->idpais->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($departamento->idpais->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($departamento->idpais->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$departamento_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$departamento_grid->StartRec = 1;
$departamento_grid->StopRec = $departamento_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($departamento_grid->FormKeyCountName) && ($departamento->CurrentAction == "gridadd" || $departamento->CurrentAction == "gridedit" || $departamento->CurrentAction == "F")) {
		$departamento_grid->KeyCount = $objForm->GetValue($departamento_grid->FormKeyCountName);
		$departamento_grid->StopRec = $departamento_grid->StartRec + $departamento_grid->KeyCount - 1;
	}
}
$departamento_grid->RecCnt = $departamento_grid->StartRec - 1;
if ($departamento_grid->Recordset && !$departamento_grid->Recordset->EOF) {
	$departamento_grid->Recordset->MoveFirst();
	$bSelectLimit = $departamento_grid->UseSelectLimit;
	if (!$bSelectLimit && $departamento_grid->StartRec > 1)
		$departamento_grid->Recordset->Move($departamento_grid->StartRec - 1);
} elseif (!$departamento->AllowAddDeleteRow && $departamento_grid->StopRec == 0) {
	$departamento_grid->StopRec = $departamento->GridAddRowCount;
}

// Initialize aggregate
$departamento->RowType = EW_ROWTYPE_AGGREGATEINIT;
$departamento->ResetAttrs();
$departamento_grid->RenderRow();
if ($departamento->CurrentAction == "gridadd")
	$departamento_grid->RowIndex = 0;
if ($departamento->CurrentAction == "gridedit")
	$departamento_grid->RowIndex = 0;
while ($departamento_grid->RecCnt < $departamento_grid->StopRec) {
	$departamento_grid->RecCnt++;
	if (intval($departamento_grid->RecCnt) >= intval($departamento_grid->StartRec)) {
		$departamento_grid->RowCnt++;
		if ($departamento->CurrentAction == "gridadd" || $departamento->CurrentAction == "gridedit" || $departamento->CurrentAction == "F") {
			$departamento_grid->RowIndex++;
			$objForm->Index = $departamento_grid->RowIndex;
			if ($objForm->HasValue($departamento_grid->FormActionName))
				$departamento_grid->RowAction = strval($objForm->GetValue($departamento_grid->FormActionName));
			elseif ($departamento->CurrentAction == "gridadd")
				$departamento_grid->RowAction = "insert";
			else
				$departamento_grid->RowAction = "";
		}

		// Set up key count
		$departamento_grid->KeyCount = $departamento_grid->RowIndex;

		// Init row class and style
		$departamento->ResetAttrs();
		$departamento->CssClass = "";
		if ($departamento->CurrentAction == "gridadd") {
			if ($departamento->CurrentMode == "copy") {
				$departamento_grid->LoadRowValues($departamento_grid->Recordset); // Load row values
				$departamento_grid->SetRecordKey($departamento_grid->RowOldKey, $departamento_grid->Recordset); // Set old record key
			} else {
				$departamento_grid->LoadDefaultValues(); // Load default values
				$departamento_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$departamento_grid->LoadRowValues($departamento_grid->Recordset); // Load row values
		}
		$departamento->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($departamento->CurrentAction == "gridadd") // Grid add
			$departamento->RowType = EW_ROWTYPE_ADD; // Render add
		if ($departamento->CurrentAction == "gridadd" && $departamento->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$departamento_grid->RestoreCurrentRowFormValues($departamento_grid->RowIndex); // Restore form values
		if ($departamento->CurrentAction == "gridedit") { // Grid edit
			if ($departamento->EventCancelled) {
				$departamento_grid->RestoreCurrentRowFormValues($departamento_grid->RowIndex); // Restore form values
			}
			if ($departamento_grid->RowAction == "insert")
				$departamento->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$departamento->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($departamento->CurrentAction == "gridedit" && ($departamento->RowType == EW_ROWTYPE_EDIT || $departamento->RowType == EW_ROWTYPE_ADD) && $departamento->EventCancelled) // Update failed
			$departamento_grid->RestoreCurrentRowFormValues($departamento_grid->RowIndex); // Restore form values
		if ($departamento->RowType == EW_ROWTYPE_EDIT) // Edit row
			$departamento_grid->EditRowCnt++;
		if ($departamento->CurrentAction == "F") // Confirm row
			$departamento_grid->RestoreCurrentRowFormValues($departamento_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$departamento->RowAttrs = array_merge($departamento->RowAttrs, array('data-rowindex'=>$departamento_grid->RowCnt, 'id'=>'r' . $departamento_grid->RowCnt . '_departamento', 'data-rowtype'=>$departamento->RowType));

		// Render row
		$departamento_grid->RenderRow();

		// Render list options
		$departamento_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($departamento_grid->RowAction <> "delete" && $departamento_grid->RowAction <> "insertdelete" && !($departamento_grid->RowAction == "insert" && $departamento->CurrentAction == "F" && $departamento_grid->EmptyRow())) {
?>
	<tr<?php echo $departamento->RowAttributes() ?>>
<?php

// Render list options (body, left)
$departamento_grid->ListOptions->Render("body", "left", $departamento_grid->RowCnt);
?>
	<?php if ($departamento->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $departamento->nombre->CellAttributes() ?>>
<?php if ($departamento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $departamento_grid->RowCnt ?>_departamento_nombre" class="form-group departamento_nombre">
<input type="text" data-table="departamento" data-field="x_nombre" name="x<?php echo $departamento_grid->RowIndex ?>_nombre" id="x<?php echo $departamento_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($departamento->nombre->getPlaceHolder()) ?>" value="<?php echo $departamento->nombre->EditValue ?>"<?php echo $departamento->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-table="departamento" data-field="x_nombre" name="o<?php echo $departamento_grid->RowIndex ?>_nombre" id="o<?php echo $departamento_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($departamento->nombre->OldValue) ?>">
<?php } ?>
<?php if ($departamento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $departamento_grid->RowCnt ?>_departamento_nombre" class="form-group departamento_nombre">
<input type="text" data-table="departamento" data-field="x_nombre" name="x<?php echo $departamento_grid->RowIndex ?>_nombre" id="x<?php echo $departamento_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($departamento->nombre->getPlaceHolder()) ?>" value="<?php echo $departamento->nombre->EditValue ?>"<?php echo $departamento->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($departamento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $departamento_grid->RowCnt ?>_departamento_nombre" class="departamento_nombre">
<span<?php echo $departamento->nombre->ViewAttributes() ?>>
<?php echo $departamento->nombre->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="departamento" data-field="x_nombre" name="x<?php echo $departamento_grid->RowIndex ?>_nombre" id="x<?php echo $departamento_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($departamento->nombre->FormValue) ?>">
<input type="hidden" data-table="departamento" data-field="x_nombre" name="o<?php echo $departamento_grid->RowIndex ?>_nombre" id="o<?php echo $departamento_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($departamento->nombre->OldValue) ?>">
<?php } ?>
<a id="<?php echo $departamento_grid->PageObjName . "_row_" . $departamento_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($departamento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="departamento" data-field="x_iddepartamento" name="x<?php echo $departamento_grid->RowIndex ?>_iddepartamento" id="x<?php echo $departamento_grid->RowIndex ?>_iddepartamento" value="<?php echo ew_HtmlEncode($departamento->iddepartamento->CurrentValue) ?>">
<input type="hidden" data-table="departamento" data-field="x_iddepartamento" name="o<?php echo $departamento_grid->RowIndex ?>_iddepartamento" id="o<?php echo $departamento_grid->RowIndex ?>_iddepartamento" value="<?php echo ew_HtmlEncode($departamento->iddepartamento->OldValue) ?>">
<?php } ?>
<?php if ($departamento->RowType == EW_ROWTYPE_EDIT || $departamento->CurrentMode == "edit") { ?>
<input type="hidden" data-table="departamento" data-field="x_iddepartamento" name="x<?php echo $departamento_grid->RowIndex ?>_iddepartamento" id="x<?php echo $departamento_grid->RowIndex ?>_iddepartamento" value="<?php echo ew_HtmlEncode($departamento->iddepartamento->CurrentValue) ?>">
<?php } ?>
	<?php if ($departamento->siglas->Visible) { // siglas ?>
		<td data-name="siglas"<?php echo $departamento->siglas->CellAttributes() ?>>
<?php if ($departamento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $departamento_grid->RowCnt ?>_departamento_siglas" class="form-group departamento_siglas">
<input type="text" data-table="departamento" data-field="x_siglas" name="x<?php echo $departamento_grid->RowIndex ?>_siglas" id="x<?php echo $departamento_grid->RowIndex ?>_siglas" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($departamento->siglas->getPlaceHolder()) ?>" value="<?php echo $departamento->siglas->EditValue ?>"<?php echo $departamento->siglas->EditAttributes() ?>>
</span>
<input type="hidden" data-table="departamento" data-field="x_siglas" name="o<?php echo $departamento_grid->RowIndex ?>_siglas" id="o<?php echo $departamento_grid->RowIndex ?>_siglas" value="<?php echo ew_HtmlEncode($departamento->siglas->OldValue) ?>">
<?php } ?>
<?php if ($departamento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $departamento_grid->RowCnt ?>_departamento_siglas" class="form-group departamento_siglas">
<input type="text" data-table="departamento" data-field="x_siglas" name="x<?php echo $departamento_grid->RowIndex ?>_siglas" id="x<?php echo $departamento_grid->RowIndex ?>_siglas" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($departamento->siglas->getPlaceHolder()) ?>" value="<?php echo $departamento->siglas->EditValue ?>"<?php echo $departamento->siglas->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($departamento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $departamento_grid->RowCnt ?>_departamento_siglas" class="departamento_siglas">
<span<?php echo $departamento->siglas->ViewAttributes() ?>>
<?php echo $departamento->siglas->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="departamento" data-field="x_siglas" name="x<?php echo $departamento_grid->RowIndex ?>_siglas" id="x<?php echo $departamento_grid->RowIndex ?>_siglas" value="<?php echo ew_HtmlEncode($departamento->siglas->FormValue) ?>">
<input type="hidden" data-table="departamento" data-field="x_siglas" name="o<?php echo $departamento_grid->RowIndex ?>_siglas" id="o<?php echo $departamento_grid->RowIndex ?>_siglas" value="<?php echo ew_HtmlEncode($departamento->siglas->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($departamento->idpais->Visible) { // idpais ?>
		<td data-name="idpais"<?php echo $departamento->idpais->CellAttributes() ?>>
<?php if ($departamento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($departamento->idpais->getSessionValue() <> "") { ?>
<span id="el<?php echo $departamento_grid->RowCnt ?>_departamento_idpais" class="form-group departamento_idpais">
<span<?php echo $departamento->idpais->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $departamento->idpais->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $departamento_grid->RowIndex ?>_idpais" name="x<?php echo $departamento_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($departamento->idpais->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $departamento_grid->RowCnt ?>_departamento_idpais" class="form-group departamento_idpais">
<select data-table="departamento" data-field="x_idpais" data-value-separator="<?php echo ew_HtmlEncode(is_array($departamento->idpais->DisplayValueSeparator) ? json_encode($departamento->idpais->DisplayValueSeparator) : $departamento->idpais->DisplayValueSeparator) ?>" id="x<?php echo $departamento_grid->RowIndex ?>_idpais" name="x<?php echo $departamento_grid->RowIndex ?>_idpais"<?php echo $departamento->idpais->EditAttributes() ?>>
<?php
if (is_array($departamento->idpais->EditValue)) {
	$arwrk = $departamento->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($departamento->idpais->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $departamento->idpais->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($departamento->idpais->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($departamento->idpais->CurrentValue) ?>" selected><?php echo $departamento->idpais->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $departamento->idpais->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$departamento->idpais->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$departamento->idpais->LookupFilters += array("f0" => "`idpais` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$departamento->Lookup_Selecting($departamento->idpais, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `idpais`";
if ($sSqlWrk <> "") $departamento->idpais->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $departamento_grid->RowIndex ?>_idpais" id="s_x<?php echo $departamento_grid->RowIndex ?>_idpais" value="<?php echo $departamento->idpais->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="departamento" data-field="x_idpais" name="o<?php echo $departamento_grid->RowIndex ?>_idpais" id="o<?php echo $departamento_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($departamento->idpais->OldValue) ?>">
<?php } ?>
<?php if ($departamento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($departamento->idpais->getSessionValue() <> "") { ?>
<span id="el<?php echo $departamento_grid->RowCnt ?>_departamento_idpais" class="form-group departamento_idpais">
<span<?php echo $departamento->idpais->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $departamento->idpais->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $departamento_grid->RowIndex ?>_idpais" name="x<?php echo $departamento_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($departamento->idpais->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $departamento_grid->RowCnt ?>_departamento_idpais" class="form-group departamento_idpais">
<select data-table="departamento" data-field="x_idpais" data-value-separator="<?php echo ew_HtmlEncode(is_array($departamento->idpais->DisplayValueSeparator) ? json_encode($departamento->idpais->DisplayValueSeparator) : $departamento->idpais->DisplayValueSeparator) ?>" id="x<?php echo $departamento_grid->RowIndex ?>_idpais" name="x<?php echo $departamento_grid->RowIndex ?>_idpais"<?php echo $departamento->idpais->EditAttributes() ?>>
<?php
if (is_array($departamento->idpais->EditValue)) {
	$arwrk = $departamento->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($departamento->idpais->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $departamento->idpais->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($departamento->idpais->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($departamento->idpais->CurrentValue) ?>" selected><?php echo $departamento->idpais->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $departamento->idpais->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$departamento->idpais->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$departamento->idpais->LookupFilters += array("f0" => "`idpais` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$departamento->Lookup_Selecting($departamento->idpais, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `idpais`";
if ($sSqlWrk <> "") $departamento->idpais->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $departamento_grid->RowIndex ?>_idpais" id="s_x<?php echo $departamento_grid->RowIndex ?>_idpais" value="<?php echo $departamento->idpais->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($departamento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $departamento_grid->RowCnt ?>_departamento_idpais" class="departamento_idpais">
<span<?php echo $departamento->idpais->ViewAttributes() ?>>
<?php echo $departamento->idpais->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="departamento" data-field="x_idpais" name="x<?php echo $departamento_grid->RowIndex ?>_idpais" id="x<?php echo $departamento_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($departamento->idpais->FormValue) ?>">
<input type="hidden" data-table="departamento" data-field="x_idpais" name="o<?php echo $departamento_grid->RowIndex ?>_idpais" id="o<?php echo $departamento_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($departamento->idpais->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$departamento_grid->ListOptions->Render("body", "right", $departamento_grid->RowCnt);
?>
	</tr>
<?php if ($departamento->RowType == EW_ROWTYPE_ADD || $departamento->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fdepartamentogrid.UpdateOpts(<?php echo $departamento_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($departamento->CurrentAction <> "gridadd" || $departamento->CurrentMode == "copy")
		if (!$departamento_grid->Recordset->EOF) $departamento_grid->Recordset->MoveNext();
}
?>
<?php
	if ($departamento->CurrentMode == "add" || $departamento->CurrentMode == "copy" || $departamento->CurrentMode == "edit") {
		$departamento_grid->RowIndex = '$rowindex$';
		$departamento_grid->LoadDefaultValues();

		// Set row properties
		$departamento->ResetAttrs();
		$departamento->RowAttrs = array_merge($departamento->RowAttrs, array('data-rowindex'=>$departamento_grid->RowIndex, 'id'=>'r0_departamento', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($departamento->RowAttrs["class"], "ewTemplate");
		$departamento->RowType = EW_ROWTYPE_ADD;

		// Render row
		$departamento_grid->RenderRow();

		// Render list options
		$departamento_grid->RenderListOptions();
		$departamento_grid->StartRowCnt = 0;
?>
	<tr<?php echo $departamento->RowAttributes() ?>>
<?php

// Render list options (body, left)
$departamento_grid->ListOptions->Render("body", "left", $departamento_grid->RowIndex);
?>
	<?php if ($departamento->nombre->Visible) { // nombre ?>
		<td data-name="nombre">
<?php if ($departamento->CurrentAction <> "F") { ?>
<span id="el$rowindex$_departamento_nombre" class="form-group departamento_nombre">
<input type="text" data-table="departamento" data-field="x_nombre" name="x<?php echo $departamento_grid->RowIndex ?>_nombre" id="x<?php echo $departamento_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($departamento->nombre->getPlaceHolder()) ?>" value="<?php echo $departamento->nombre->EditValue ?>"<?php echo $departamento->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_departamento_nombre" class="form-group departamento_nombre">
<span<?php echo $departamento->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $departamento->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="departamento" data-field="x_nombre" name="x<?php echo $departamento_grid->RowIndex ?>_nombre" id="x<?php echo $departamento_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($departamento->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="departamento" data-field="x_nombre" name="o<?php echo $departamento_grid->RowIndex ?>_nombre" id="o<?php echo $departamento_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($departamento->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($departamento->siglas->Visible) { // siglas ?>
		<td data-name="siglas">
<?php if ($departamento->CurrentAction <> "F") { ?>
<span id="el$rowindex$_departamento_siglas" class="form-group departamento_siglas">
<input type="text" data-table="departamento" data-field="x_siglas" name="x<?php echo $departamento_grid->RowIndex ?>_siglas" id="x<?php echo $departamento_grid->RowIndex ?>_siglas" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($departamento->siglas->getPlaceHolder()) ?>" value="<?php echo $departamento->siglas->EditValue ?>"<?php echo $departamento->siglas->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_departamento_siglas" class="form-group departamento_siglas">
<span<?php echo $departamento->siglas->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $departamento->siglas->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="departamento" data-field="x_siglas" name="x<?php echo $departamento_grid->RowIndex ?>_siglas" id="x<?php echo $departamento_grid->RowIndex ?>_siglas" value="<?php echo ew_HtmlEncode($departamento->siglas->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="departamento" data-field="x_siglas" name="o<?php echo $departamento_grid->RowIndex ?>_siglas" id="o<?php echo $departamento_grid->RowIndex ?>_siglas" value="<?php echo ew_HtmlEncode($departamento->siglas->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($departamento->idpais->Visible) { // idpais ?>
		<td data-name="idpais">
<?php if ($departamento->CurrentAction <> "F") { ?>
<?php if ($departamento->idpais->getSessionValue() <> "") { ?>
<span id="el$rowindex$_departamento_idpais" class="form-group departamento_idpais">
<span<?php echo $departamento->idpais->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $departamento->idpais->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $departamento_grid->RowIndex ?>_idpais" name="x<?php echo $departamento_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($departamento->idpais->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_departamento_idpais" class="form-group departamento_idpais">
<select data-table="departamento" data-field="x_idpais" data-value-separator="<?php echo ew_HtmlEncode(is_array($departamento->idpais->DisplayValueSeparator) ? json_encode($departamento->idpais->DisplayValueSeparator) : $departamento->idpais->DisplayValueSeparator) ?>" id="x<?php echo $departamento_grid->RowIndex ?>_idpais" name="x<?php echo $departamento_grid->RowIndex ?>_idpais"<?php echo $departamento->idpais->EditAttributes() ?>>
<?php
if (is_array($departamento->idpais->EditValue)) {
	$arwrk = $departamento->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($departamento->idpais->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $departamento->idpais->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($departamento->idpais->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($departamento->idpais->CurrentValue) ?>" selected><?php echo $departamento->idpais->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $departamento->idpais->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$departamento->idpais->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$departamento->idpais->LookupFilters += array("f0" => "`idpais` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$departamento->Lookup_Selecting($departamento->idpais, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `idpais`";
if ($sSqlWrk <> "") $departamento->idpais->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $departamento_grid->RowIndex ?>_idpais" id="s_x<?php echo $departamento_grid->RowIndex ?>_idpais" value="<?php echo $departamento->idpais->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_departamento_idpais" class="form-group departamento_idpais">
<span<?php echo $departamento->idpais->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $departamento->idpais->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="departamento" data-field="x_idpais" name="x<?php echo $departamento_grid->RowIndex ?>_idpais" id="x<?php echo $departamento_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($departamento->idpais->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="departamento" data-field="x_idpais" name="o<?php echo $departamento_grid->RowIndex ?>_idpais" id="o<?php echo $departamento_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($departamento->idpais->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$departamento_grid->ListOptions->Render("body", "right", $departamento_grid->RowCnt);
?>
<script type="text/javascript">
fdepartamentogrid.UpdateOpts(<?php echo $departamento_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($departamento->CurrentMode == "add" || $departamento->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $departamento_grid->FormKeyCountName ?>" id="<?php echo $departamento_grid->FormKeyCountName ?>" value="<?php echo $departamento_grid->KeyCount ?>">
<?php echo $departamento_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($departamento->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $departamento_grid->FormKeyCountName ?>" id="<?php echo $departamento_grid->FormKeyCountName ?>" value="<?php echo $departamento_grid->KeyCount ?>">
<?php echo $departamento_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($departamento->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fdepartamentogrid">
</div>
<?php

// Close recordset
if ($departamento_grid->Recordset)
	$departamento_grid->Recordset->Close();
?>
</div>
</div>
<?php } ?>
<?php if ($departamento_grid->TotalRecs == 0 && $departamento->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($departamento_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($departamento->Export == "") { ?>
<script type="text/javascript">
fdepartamentogrid.Init();
</script>
<?php } ?>
<?php
$departamento_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$departamento_grid->Page_Terminate();
?>
