<?php

// Create page object
if (!isset($federacion_grid)) $federacion_grid = new cfederacion_grid();

// Page init
$federacion_grid->Page_Init();

// Page main
$federacion_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$federacion_grid->Page_Render();
?>
<?php if ($federacion->Export == "") { ?>
<script type="text/javascript">

// Form object
var ffederaciongrid = new ew_Form("ffederaciongrid", "grid");
ffederaciongrid.FormKeyCountName = '<?php echo $federacion_grid->FormKeyCountName ?>';

// Validate form
ffederaciongrid.Validate = function() {
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
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ffederaciongrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nomenclatura", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idfederacion_tipo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "iddeporte", false)) return false;
	return true;
}

// Form_CustomValidate event
ffederaciongrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ffederaciongrid.ValidateRequired = true;
<?php } else { ?>
ffederaciongrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ffederaciongrid.Lists["x_idfederacion_tipo"] = {"LinkField":"x_idfederacion_tipo","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ffederaciongrid.Lists["x_iddeporte"] = {"LinkField":"x_iddeporte","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<?php } ?>
<?php
if ($federacion->CurrentAction == "gridadd") {
	if ($federacion->CurrentMode == "copy") {
		$bSelectLimit = $federacion_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$federacion_grid->TotalRecs = $federacion->SelectRecordCount();
			$federacion_grid->Recordset = $federacion_grid->LoadRecordset($federacion_grid->StartRec-1, $federacion_grid->DisplayRecs);
		} else {
			if ($federacion_grid->Recordset = $federacion_grid->LoadRecordset())
				$federacion_grid->TotalRecs = $federacion_grid->Recordset->RecordCount();
		}
		$federacion_grid->StartRec = 1;
		$federacion_grid->DisplayRecs = $federacion_grid->TotalRecs;
	} else {
		$federacion->CurrentFilter = "0=1";
		$federacion_grid->StartRec = 1;
		$federacion_grid->DisplayRecs = $federacion->GridAddRowCount;
	}
	$federacion_grid->TotalRecs = $federacion_grid->DisplayRecs;
	$federacion_grid->StopRec = $federacion_grid->DisplayRecs;
} else {
	$bSelectLimit = $federacion_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($federacion_grid->TotalRecs <= 0)
			$federacion_grid->TotalRecs = $federacion->SelectRecordCount();
	} else {
		if (!$federacion_grid->Recordset && ($federacion_grid->Recordset = $federacion_grid->LoadRecordset()))
			$federacion_grid->TotalRecs = $federacion_grid->Recordset->RecordCount();
	}
	$federacion_grid->StartRec = 1;
	$federacion_grid->DisplayRecs = $federacion_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$federacion_grid->Recordset = $federacion_grid->LoadRecordset($federacion_grid->StartRec-1, $federacion_grid->DisplayRecs);

	// Set no record found message
	if ($federacion->CurrentAction == "" && $federacion_grid->TotalRecs == 0) {
		if ($federacion_grid->SearchWhere == "0=101")
			$federacion_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$federacion_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$federacion_grid->RenderOtherOptions();
?>
<?php $federacion_grid->ShowPageHeader(); ?>
<?php
$federacion_grid->ShowMessage();
?>
<?php if ($federacion_grid->TotalRecs > 0 || $federacion->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="ffederaciongrid" class="ewForm form-inline">
<?php if ($federacion_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($federacion_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_federacion" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_federaciongrid" class="table ewTable">
<?php echo $federacion->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$federacion_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$federacion_grid->RenderListOptions();

// Render list options (header, left)
$federacion_grid->ListOptions->Render("header", "left");
?>
<?php if ($federacion->nombre->Visible) { // nombre ?>
	<?php if ($federacion->SortUrl($federacion->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_federacion_nombre" class="federacion_nombre"><div class="ewTableHeaderCaption"><?php echo $federacion->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div><div id="elh_federacion_nombre" class="federacion_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $federacion->nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($federacion->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($federacion->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($federacion->nomenclatura->Visible) { // nomenclatura ?>
	<?php if ($federacion->SortUrl($federacion->nomenclatura) == "") { ?>
		<th data-name="nomenclatura"><div id="elh_federacion_nomenclatura" class="federacion_nomenclatura"><div class="ewTableHeaderCaption"><?php echo $federacion->nomenclatura->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomenclatura"><div><div id="elh_federacion_nomenclatura" class="federacion_nomenclatura">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $federacion->nomenclatura->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($federacion->nomenclatura->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($federacion->nomenclatura->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($federacion->idfederacion_tipo->Visible) { // idfederacion_tipo ?>
	<?php if ($federacion->SortUrl($federacion->idfederacion_tipo) == "") { ?>
		<th data-name="idfederacion_tipo"><div id="elh_federacion_idfederacion_tipo" class="federacion_idfederacion_tipo"><div class="ewTableHeaderCaption"><?php echo $federacion->idfederacion_tipo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idfederacion_tipo"><div><div id="elh_federacion_idfederacion_tipo" class="federacion_idfederacion_tipo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $federacion->idfederacion_tipo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($federacion->idfederacion_tipo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($federacion->idfederacion_tipo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($federacion->iddeporte->Visible) { // iddeporte ?>
	<?php if ($federacion->SortUrl($federacion->iddeporte) == "") { ?>
		<th data-name="iddeporte"><div id="elh_federacion_iddeporte" class="federacion_iddeporte"><div class="ewTableHeaderCaption"><?php echo $federacion->iddeporte->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="iddeporte"><div><div id="elh_federacion_iddeporte" class="federacion_iddeporte">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $federacion->iddeporte->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($federacion->iddeporte->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($federacion->iddeporte->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$federacion_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$federacion_grid->StartRec = 1;
$federacion_grid->StopRec = $federacion_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($federacion_grid->FormKeyCountName) && ($federacion->CurrentAction == "gridadd" || $federacion->CurrentAction == "gridedit" || $federacion->CurrentAction == "F")) {
		$federacion_grid->KeyCount = $objForm->GetValue($federacion_grid->FormKeyCountName);
		$federacion_grid->StopRec = $federacion_grid->StartRec + $federacion_grid->KeyCount - 1;
	}
}
$federacion_grid->RecCnt = $federacion_grid->StartRec - 1;
if ($federacion_grid->Recordset && !$federacion_grid->Recordset->EOF) {
	$federacion_grid->Recordset->MoveFirst();
	$bSelectLimit = $federacion_grid->UseSelectLimit;
	if (!$bSelectLimit && $federacion_grid->StartRec > 1)
		$federacion_grid->Recordset->Move($federacion_grid->StartRec - 1);
} elseif (!$federacion->AllowAddDeleteRow && $federacion_grid->StopRec == 0) {
	$federacion_grid->StopRec = $federacion->GridAddRowCount;
}

// Initialize aggregate
$federacion->RowType = EW_ROWTYPE_AGGREGATEINIT;
$federacion->ResetAttrs();
$federacion_grid->RenderRow();
if ($federacion->CurrentAction == "gridadd")
	$federacion_grid->RowIndex = 0;
if ($federacion->CurrentAction == "gridedit")
	$federacion_grid->RowIndex = 0;
while ($federacion_grid->RecCnt < $federacion_grid->StopRec) {
	$federacion_grid->RecCnt++;
	if (intval($federacion_grid->RecCnt) >= intval($federacion_grid->StartRec)) {
		$federacion_grid->RowCnt++;
		if ($federacion->CurrentAction == "gridadd" || $federacion->CurrentAction == "gridedit" || $federacion->CurrentAction == "F") {
			$federacion_grid->RowIndex++;
			$objForm->Index = $federacion_grid->RowIndex;
			if ($objForm->HasValue($federacion_grid->FormActionName))
				$federacion_grid->RowAction = strval($objForm->GetValue($federacion_grid->FormActionName));
			elseif ($federacion->CurrentAction == "gridadd")
				$federacion_grid->RowAction = "insert";
			else
				$federacion_grid->RowAction = "";
		}

		// Set up key count
		$federacion_grid->KeyCount = $federacion_grid->RowIndex;

		// Init row class and style
		$federacion->ResetAttrs();
		$federacion->CssClass = "";
		if ($federacion->CurrentAction == "gridadd") {
			if ($federacion->CurrentMode == "copy") {
				$federacion_grid->LoadRowValues($federacion_grid->Recordset); // Load row values
				$federacion_grid->SetRecordKey($federacion_grid->RowOldKey, $federacion_grid->Recordset); // Set old record key
			} else {
				$federacion_grid->LoadDefaultValues(); // Load default values
				$federacion_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$federacion_grid->LoadRowValues($federacion_grid->Recordset); // Load row values
		}
		$federacion->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($federacion->CurrentAction == "gridadd") // Grid add
			$federacion->RowType = EW_ROWTYPE_ADD; // Render add
		if ($federacion->CurrentAction == "gridadd" && $federacion->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$federacion_grid->RestoreCurrentRowFormValues($federacion_grid->RowIndex); // Restore form values
		if ($federacion->CurrentAction == "gridedit") { // Grid edit
			if ($federacion->EventCancelled) {
				$federacion_grid->RestoreCurrentRowFormValues($federacion_grid->RowIndex); // Restore form values
			}
			if ($federacion_grid->RowAction == "insert")
				$federacion->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$federacion->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($federacion->CurrentAction == "gridedit" && ($federacion->RowType == EW_ROWTYPE_EDIT || $federacion->RowType == EW_ROWTYPE_ADD) && $federacion->EventCancelled) // Update failed
			$federacion_grid->RestoreCurrentRowFormValues($federacion_grid->RowIndex); // Restore form values
		if ($federacion->RowType == EW_ROWTYPE_EDIT) // Edit row
			$federacion_grid->EditRowCnt++;
		if ($federacion->CurrentAction == "F") // Confirm row
			$federacion_grid->RestoreCurrentRowFormValues($federacion_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$federacion->RowAttrs = array_merge($federacion->RowAttrs, array('data-rowindex'=>$federacion_grid->RowCnt, 'id'=>'r' . $federacion_grid->RowCnt . '_federacion', 'data-rowtype'=>$federacion->RowType));

		// Render row
		$federacion_grid->RenderRow();

		// Render list options
		$federacion_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($federacion_grid->RowAction <> "delete" && $federacion_grid->RowAction <> "insertdelete" && !($federacion_grid->RowAction == "insert" && $federacion->CurrentAction == "F" && $federacion_grid->EmptyRow())) {
?>
	<tr<?php echo $federacion->RowAttributes() ?>>
<?php

// Render list options (body, left)
$federacion_grid->ListOptions->Render("body", "left", $federacion_grid->RowCnt);
?>
	<?php if ($federacion->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $federacion->nombre->CellAttributes() ?>>
<?php if ($federacion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $federacion_grid->RowCnt ?>_federacion_nombre" class="form-group federacion_nombre">
<input type="text" data-table="federacion" data-field="x_nombre" name="x<?php echo $federacion_grid->RowIndex ?>_nombre" id="x<?php echo $federacion_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($federacion->nombre->getPlaceHolder()) ?>" value="<?php echo $federacion->nombre->EditValue ?>"<?php echo $federacion->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-table="federacion" data-field="x_nombre" name="o<?php echo $federacion_grid->RowIndex ?>_nombre" id="o<?php echo $federacion_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($federacion->nombre->OldValue) ?>">
<?php } ?>
<?php if ($federacion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $federacion_grid->RowCnt ?>_federacion_nombre" class="form-group federacion_nombre">
<input type="text" data-table="federacion" data-field="x_nombre" name="x<?php echo $federacion_grid->RowIndex ?>_nombre" id="x<?php echo $federacion_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($federacion->nombre->getPlaceHolder()) ?>" value="<?php echo $federacion->nombre->EditValue ?>"<?php echo $federacion->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($federacion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $federacion_grid->RowCnt ?>_federacion_nombre" class="federacion_nombre">
<span<?php echo $federacion->nombre->ViewAttributes() ?>>
<?php echo $federacion->nombre->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="federacion" data-field="x_nombre" name="x<?php echo $federacion_grid->RowIndex ?>_nombre" id="x<?php echo $federacion_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($federacion->nombre->FormValue) ?>">
<input type="hidden" data-table="federacion" data-field="x_nombre" name="o<?php echo $federacion_grid->RowIndex ?>_nombre" id="o<?php echo $federacion_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($federacion->nombre->OldValue) ?>">
<?php } ?>
<a id="<?php echo $federacion_grid->PageObjName . "_row_" . $federacion_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($federacion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="federacion" data-field="x_idfederacion" name="x<?php echo $federacion_grid->RowIndex ?>_idfederacion" id="x<?php echo $federacion_grid->RowIndex ?>_idfederacion" value="<?php echo ew_HtmlEncode($federacion->idfederacion->CurrentValue) ?>">
<input type="hidden" data-table="federacion" data-field="x_idfederacion" name="o<?php echo $federacion_grid->RowIndex ?>_idfederacion" id="o<?php echo $federacion_grid->RowIndex ?>_idfederacion" value="<?php echo ew_HtmlEncode($federacion->idfederacion->OldValue) ?>">
<?php } ?>
<?php if ($federacion->RowType == EW_ROWTYPE_EDIT || $federacion->CurrentMode == "edit") { ?>
<input type="hidden" data-table="federacion" data-field="x_idfederacion" name="x<?php echo $federacion_grid->RowIndex ?>_idfederacion" id="x<?php echo $federacion_grid->RowIndex ?>_idfederacion" value="<?php echo ew_HtmlEncode($federacion->idfederacion->CurrentValue) ?>">
<?php } ?>
	<?php if ($federacion->nomenclatura->Visible) { // nomenclatura ?>
		<td data-name="nomenclatura"<?php echo $federacion->nomenclatura->CellAttributes() ?>>
<?php if ($federacion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $federacion_grid->RowCnt ?>_federacion_nomenclatura" class="form-group federacion_nomenclatura">
<input type="text" data-table="federacion" data-field="x_nomenclatura" name="x<?php echo $federacion_grid->RowIndex ?>_nomenclatura" id="x<?php echo $federacion_grid->RowIndex ?>_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($federacion->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $federacion->nomenclatura->EditValue ?>"<?php echo $federacion->nomenclatura->EditAttributes() ?>>
</span>
<input type="hidden" data-table="federacion" data-field="x_nomenclatura" name="o<?php echo $federacion_grid->RowIndex ?>_nomenclatura" id="o<?php echo $federacion_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($federacion->nomenclatura->OldValue) ?>">
<?php } ?>
<?php if ($federacion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $federacion_grid->RowCnt ?>_federacion_nomenclatura" class="form-group federacion_nomenclatura">
<input type="text" data-table="federacion" data-field="x_nomenclatura" name="x<?php echo $federacion_grid->RowIndex ?>_nomenclatura" id="x<?php echo $federacion_grid->RowIndex ?>_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($federacion->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $federacion->nomenclatura->EditValue ?>"<?php echo $federacion->nomenclatura->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($federacion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $federacion_grid->RowCnt ?>_federacion_nomenclatura" class="federacion_nomenclatura">
<span<?php echo $federacion->nomenclatura->ViewAttributes() ?>>
<?php echo $federacion->nomenclatura->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="federacion" data-field="x_nomenclatura" name="x<?php echo $federacion_grid->RowIndex ?>_nomenclatura" id="x<?php echo $federacion_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($federacion->nomenclatura->FormValue) ?>">
<input type="hidden" data-table="federacion" data-field="x_nomenclatura" name="o<?php echo $federacion_grid->RowIndex ?>_nomenclatura" id="o<?php echo $federacion_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($federacion->nomenclatura->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($federacion->idfederacion_tipo->Visible) { // idfederacion_tipo ?>
		<td data-name="idfederacion_tipo"<?php echo $federacion->idfederacion_tipo->CellAttributes() ?>>
<?php if ($federacion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($federacion->idfederacion_tipo->getSessionValue() <> "") { ?>
<span id="el<?php echo $federacion_grid->RowCnt ?>_federacion_idfederacion_tipo" class="form-group federacion_idfederacion_tipo">
<span<?php echo $federacion->idfederacion_tipo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $federacion->idfederacion_tipo->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" name="x<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" value="<?php echo ew_HtmlEncode($federacion->idfederacion_tipo->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $federacion_grid->RowCnt ?>_federacion_idfederacion_tipo" class="form-group federacion_idfederacion_tipo">
<select data-table="federacion" data-field="x_idfederacion_tipo" data-value-separator="<?php echo ew_HtmlEncode(is_array($federacion->idfederacion_tipo->DisplayValueSeparator) ? json_encode($federacion->idfederacion_tipo->DisplayValueSeparator) : $federacion->idfederacion_tipo->DisplayValueSeparator) ?>" id="x<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" name="x<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo"<?php echo $federacion->idfederacion_tipo->EditAttributes() ?>>
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
if (@$emptywrk) $federacion->idfederacion_tipo->OldValue = "";
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
<input type="hidden" name="s_x<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" id="s_x<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" value="<?php echo $federacion->idfederacion_tipo->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="federacion" data-field="x_idfederacion_tipo" name="o<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" id="o<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" value="<?php echo ew_HtmlEncode($federacion->idfederacion_tipo->OldValue) ?>">
<?php } ?>
<?php if ($federacion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($federacion->idfederacion_tipo->getSessionValue() <> "") { ?>
<span id="el<?php echo $federacion_grid->RowCnt ?>_federacion_idfederacion_tipo" class="form-group federacion_idfederacion_tipo">
<span<?php echo $federacion->idfederacion_tipo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $federacion->idfederacion_tipo->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" name="x<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" value="<?php echo ew_HtmlEncode($federacion->idfederacion_tipo->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $federacion_grid->RowCnt ?>_federacion_idfederacion_tipo" class="form-group federacion_idfederacion_tipo">
<select data-table="federacion" data-field="x_idfederacion_tipo" data-value-separator="<?php echo ew_HtmlEncode(is_array($federacion->idfederacion_tipo->DisplayValueSeparator) ? json_encode($federacion->idfederacion_tipo->DisplayValueSeparator) : $federacion->idfederacion_tipo->DisplayValueSeparator) ?>" id="x<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" name="x<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo"<?php echo $federacion->idfederacion_tipo->EditAttributes() ?>>
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
if (@$emptywrk) $federacion->idfederacion_tipo->OldValue = "";
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
<input type="hidden" name="s_x<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" id="s_x<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" value="<?php echo $federacion->idfederacion_tipo->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($federacion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $federacion_grid->RowCnt ?>_federacion_idfederacion_tipo" class="federacion_idfederacion_tipo">
<span<?php echo $federacion->idfederacion_tipo->ViewAttributes() ?>>
<?php echo $federacion->idfederacion_tipo->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="federacion" data-field="x_idfederacion_tipo" name="x<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" id="x<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" value="<?php echo ew_HtmlEncode($federacion->idfederacion_tipo->FormValue) ?>">
<input type="hidden" data-table="federacion" data-field="x_idfederacion_tipo" name="o<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" id="o<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" value="<?php echo ew_HtmlEncode($federacion->idfederacion_tipo->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($federacion->iddeporte->Visible) { // iddeporte ?>
		<td data-name="iddeporte"<?php echo $federacion->iddeporte->CellAttributes() ?>>
<?php if ($federacion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($federacion->iddeporte->getSessionValue() <> "") { ?>
<span id="el<?php echo $federacion_grid->RowCnt ?>_federacion_iddeporte" class="form-group federacion_iddeporte">
<span<?php echo $federacion->iddeporte->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $federacion->iddeporte->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $federacion_grid->RowIndex ?>_iddeporte" name="x<?php echo $federacion_grid->RowIndex ?>_iddeporte" value="<?php echo ew_HtmlEncode($federacion->iddeporte->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $federacion_grid->RowCnt ?>_federacion_iddeporte" class="form-group federacion_iddeporte">
<select data-table="federacion" data-field="x_iddeporte" data-value-separator="<?php echo ew_HtmlEncode(is_array($federacion->iddeporte->DisplayValueSeparator) ? json_encode($federacion->iddeporte->DisplayValueSeparator) : $federacion->iddeporte->DisplayValueSeparator) ?>" id="x<?php echo $federacion_grid->RowIndex ?>_iddeporte" name="x<?php echo $federacion_grid->RowIndex ?>_iddeporte"<?php echo $federacion->iddeporte->EditAttributes() ?>>
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
if (@$emptywrk) $federacion->iddeporte->OldValue = "";
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
<input type="hidden" name="s_x<?php echo $federacion_grid->RowIndex ?>_iddeporte" id="s_x<?php echo $federacion_grid->RowIndex ?>_iddeporte" value="<?php echo $federacion->iddeporte->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="federacion" data-field="x_iddeporte" name="o<?php echo $federacion_grid->RowIndex ?>_iddeporte" id="o<?php echo $federacion_grid->RowIndex ?>_iddeporte" value="<?php echo ew_HtmlEncode($federacion->iddeporte->OldValue) ?>">
<?php } ?>
<?php if ($federacion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($federacion->iddeporte->getSessionValue() <> "") { ?>
<span id="el<?php echo $federacion_grid->RowCnt ?>_federacion_iddeporte" class="form-group federacion_iddeporte">
<span<?php echo $federacion->iddeporte->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $federacion->iddeporte->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $federacion_grid->RowIndex ?>_iddeporte" name="x<?php echo $federacion_grid->RowIndex ?>_iddeporte" value="<?php echo ew_HtmlEncode($federacion->iddeporte->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $federacion_grid->RowCnt ?>_federacion_iddeporte" class="form-group federacion_iddeporte">
<select data-table="federacion" data-field="x_iddeporte" data-value-separator="<?php echo ew_HtmlEncode(is_array($federacion->iddeporte->DisplayValueSeparator) ? json_encode($federacion->iddeporte->DisplayValueSeparator) : $federacion->iddeporte->DisplayValueSeparator) ?>" id="x<?php echo $federacion_grid->RowIndex ?>_iddeporte" name="x<?php echo $federacion_grid->RowIndex ?>_iddeporte"<?php echo $federacion->iddeporte->EditAttributes() ?>>
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
if (@$emptywrk) $federacion->iddeporte->OldValue = "";
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
<input type="hidden" name="s_x<?php echo $federacion_grid->RowIndex ?>_iddeporte" id="s_x<?php echo $federacion_grid->RowIndex ?>_iddeporte" value="<?php echo $federacion->iddeporte->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($federacion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $federacion_grid->RowCnt ?>_federacion_iddeporte" class="federacion_iddeporte">
<span<?php echo $federacion->iddeporte->ViewAttributes() ?>>
<?php echo $federacion->iddeporte->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="federacion" data-field="x_iddeporte" name="x<?php echo $federacion_grid->RowIndex ?>_iddeporte" id="x<?php echo $federacion_grid->RowIndex ?>_iddeporte" value="<?php echo ew_HtmlEncode($federacion->iddeporte->FormValue) ?>">
<input type="hidden" data-table="federacion" data-field="x_iddeporte" name="o<?php echo $federacion_grid->RowIndex ?>_iddeporte" id="o<?php echo $federacion_grid->RowIndex ?>_iddeporte" value="<?php echo ew_HtmlEncode($federacion->iddeporte->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$federacion_grid->ListOptions->Render("body", "right", $federacion_grid->RowCnt);
?>
	</tr>
<?php if ($federacion->RowType == EW_ROWTYPE_ADD || $federacion->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ffederaciongrid.UpdateOpts(<?php echo $federacion_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($federacion->CurrentAction <> "gridadd" || $federacion->CurrentMode == "copy")
		if (!$federacion_grid->Recordset->EOF) $federacion_grid->Recordset->MoveNext();
}
?>
<?php
	if ($federacion->CurrentMode == "add" || $federacion->CurrentMode == "copy" || $federacion->CurrentMode == "edit") {
		$federacion_grid->RowIndex = '$rowindex$';
		$federacion_grid->LoadDefaultValues();

		// Set row properties
		$federacion->ResetAttrs();
		$federacion->RowAttrs = array_merge($federacion->RowAttrs, array('data-rowindex'=>$federacion_grid->RowIndex, 'id'=>'r0_federacion', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($federacion->RowAttrs["class"], "ewTemplate");
		$federacion->RowType = EW_ROWTYPE_ADD;

		// Render row
		$federacion_grid->RenderRow();

		// Render list options
		$federacion_grid->RenderListOptions();
		$federacion_grid->StartRowCnt = 0;
?>
	<tr<?php echo $federacion->RowAttributes() ?>>
<?php

// Render list options (body, left)
$federacion_grid->ListOptions->Render("body", "left", $federacion_grid->RowIndex);
?>
	<?php if ($federacion->nombre->Visible) { // nombre ?>
		<td data-name="nombre">
<?php if ($federacion->CurrentAction <> "F") { ?>
<span id="el$rowindex$_federacion_nombre" class="form-group federacion_nombre">
<input type="text" data-table="federacion" data-field="x_nombre" name="x<?php echo $federacion_grid->RowIndex ?>_nombre" id="x<?php echo $federacion_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($federacion->nombre->getPlaceHolder()) ?>" value="<?php echo $federacion->nombre->EditValue ?>"<?php echo $federacion->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_federacion_nombre" class="form-group federacion_nombre">
<span<?php echo $federacion->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $federacion->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="federacion" data-field="x_nombre" name="x<?php echo $federacion_grid->RowIndex ?>_nombre" id="x<?php echo $federacion_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($federacion->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="federacion" data-field="x_nombre" name="o<?php echo $federacion_grid->RowIndex ?>_nombre" id="o<?php echo $federacion_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($federacion->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($federacion->nomenclatura->Visible) { // nomenclatura ?>
		<td data-name="nomenclatura">
<?php if ($federacion->CurrentAction <> "F") { ?>
<span id="el$rowindex$_federacion_nomenclatura" class="form-group federacion_nomenclatura">
<input type="text" data-table="federacion" data-field="x_nomenclatura" name="x<?php echo $federacion_grid->RowIndex ?>_nomenclatura" id="x<?php echo $federacion_grid->RowIndex ?>_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($federacion->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $federacion->nomenclatura->EditValue ?>"<?php echo $federacion->nomenclatura->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_federacion_nomenclatura" class="form-group federacion_nomenclatura">
<span<?php echo $federacion->nomenclatura->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $federacion->nomenclatura->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="federacion" data-field="x_nomenclatura" name="x<?php echo $federacion_grid->RowIndex ?>_nomenclatura" id="x<?php echo $federacion_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($federacion->nomenclatura->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="federacion" data-field="x_nomenclatura" name="o<?php echo $federacion_grid->RowIndex ?>_nomenclatura" id="o<?php echo $federacion_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($federacion->nomenclatura->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($federacion->idfederacion_tipo->Visible) { // idfederacion_tipo ?>
		<td data-name="idfederacion_tipo">
<?php if ($federacion->CurrentAction <> "F") { ?>
<?php if ($federacion->idfederacion_tipo->getSessionValue() <> "") { ?>
<span id="el$rowindex$_federacion_idfederacion_tipo" class="form-group federacion_idfederacion_tipo">
<span<?php echo $federacion->idfederacion_tipo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $federacion->idfederacion_tipo->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" name="x<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" value="<?php echo ew_HtmlEncode($federacion->idfederacion_tipo->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_federacion_idfederacion_tipo" class="form-group federacion_idfederacion_tipo">
<select data-table="federacion" data-field="x_idfederacion_tipo" data-value-separator="<?php echo ew_HtmlEncode(is_array($federacion->idfederacion_tipo->DisplayValueSeparator) ? json_encode($federacion->idfederacion_tipo->DisplayValueSeparator) : $federacion->idfederacion_tipo->DisplayValueSeparator) ?>" id="x<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" name="x<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo"<?php echo $federacion->idfederacion_tipo->EditAttributes() ?>>
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
if (@$emptywrk) $federacion->idfederacion_tipo->OldValue = "";
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
<input type="hidden" name="s_x<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" id="s_x<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" value="<?php echo $federacion->idfederacion_tipo->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_federacion_idfederacion_tipo" class="form-group federacion_idfederacion_tipo">
<span<?php echo $federacion->idfederacion_tipo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $federacion->idfederacion_tipo->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="federacion" data-field="x_idfederacion_tipo" name="x<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" id="x<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" value="<?php echo ew_HtmlEncode($federacion->idfederacion_tipo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="federacion" data-field="x_idfederacion_tipo" name="o<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" id="o<?php echo $federacion_grid->RowIndex ?>_idfederacion_tipo" value="<?php echo ew_HtmlEncode($federacion->idfederacion_tipo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($federacion->iddeporte->Visible) { // iddeporte ?>
		<td data-name="iddeporte">
<?php if ($federacion->CurrentAction <> "F") { ?>
<?php if ($federacion->iddeporte->getSessionValue() <> "") { ?>
<span id="el$rowindex$_federacion_iddeporte" class="form-group federacion_iddeporte">
<span<?php echo $federacion->iddeporte->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $federacion->iddeporte->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $federacion_grid->RowIndex ?>_iddeporte" name="x<?php echo $federacion_grid->RowIndex ?>_iddeporte" value="<?php echo ew_HtmlEncode($federacion->iddeporte->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_federacion_iddeporte" class="form-group federacion_iddeporte">
<select data-table="federacion" data-field="x_iddeporte" data-value-separator="<?php echo ew_HtmlEncode(is_array($federacion->iddeporte->DisplayValueSeparator) ? json_encode($federacion->iddeporte->DisplayValueSeparator) : $federacion->iddeporte->DisplayValueSeparator) ?>" id="x<?php echo $federacion_grid->RowIndex ?>_iddeporte" name="x<?php echo $federacion_grid->RowIndex ?>_iddeporte"<?php echo $federacion->iddeporte->EditAttributes() ?>>
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
if (@$emptywrk) $federacion->iddeporte->OldValue = "";
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
<input type="hidden" name="s_x<?php echo $federacion_grid->RowIndex ?>_iddeporte" id="s_x<?php echo $federacion_grid->RowIndex ?>_iddeporte" value="<?php echo $federacion->iddeporte->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_federacion_iddeporte" class="form-group federacion_iddeporte">
<span<?php echo $federacion->iddeporte->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $federacion->iddeporte->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="federacion" data-field="x_iddeporte" name="x<?php echo $federacion_grid->RowIndex ?>_iddeporte" id="x<?php echo $federacion_grid->RowIndex ?>_iddeporte" value="<?php echo ew_HtmlEncode($federacion->iddeporte->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="federacion" data-field="x_iddeporte" name="o<?php echo $federacion_grid->RowIndex ?>_iddeporte" id="o<?php echo $federacion_grid->RowIndex ?>_iddeporte" value="<?php echo ew_HtmlEncode($federacion->iddeporte->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$federacion_grid->ListOptions->Render("body", "right", $federacion_grid->RowCnt);
?>
<script type="text/javascript">
ffederaciongrid.UpdateOpts(<?php echo $federacion_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($federacion->CurrentMode == "add" || $federacion->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $federacion_grid->FormKeyCountName ?>" id="<?php echo $federacion_grid->FormKeyCountName ?>" value="<?php echo $federacion_grid->KeyCount ?>">
<?php echo $federacion_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($federacion->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $federacion_grid->FormKeyCountName ?>" id="<?php echo $federacion_grid->FormKeyCountName ?>" value="<?php echo $federacion_grid->KeyCount ?>">
<?php echo $federacion_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($federacion->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ffederaciongrid">
</div>
<?php

// Close recordset
if ($federacion_grid->Recordset)
	$federacion_grid->Recordset->Close();
?>
</div>
</div>
<?php } ?>
<?php if ($federacion_grid->TotalRecs == 0 && $federacion->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($federacion_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($federacion->Export == "") { ?>
<script type="text/javascript">
ffederaciongrid.Init();
</script>
<?php } ?>
<?php
$federacion_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$federacion_grid->Page_Terminate();
?>
