<?php

// Create page object
if (!isset($persona_fotografia_grid)) $persona_fotografia_grid = new cpersona_fotografia_grid();

// Page init
$persona_fotografia_grid->Page_Init();

// Page main
$persona_fotografia_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$persona_fotografia_grid->Page_Render();
?>
<?php if ($persona_fotografia->Export == "") { ?>
<script type="text/javascript">

// Form object
var fpersona_fotografiagrid = new ew_Form("fpersona_fotografiagrid", "grid");
fpersona_fotografiagrid.FormKeyCountName = '<?php echo $persona_fotografia_grid->FormKeyCountName ?>';

// Validate form
fpersona_fotografiagrid.Validate = function() {
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
fpersona_fotografiagrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "fotografia", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha_insercion", false)) return false;
	return true;
}

// Form_CustomValidate event
fpersona_fotografiagrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpersona_fotografiagrid.ValidateRequired = true;
<?php } else { ?>
fpersona_fotografiagrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($persona_fotografia->CurrentAction == "gridadd") {
	if ($persona_fotografia->CurrentMode == "copy") {
		$bSelectLimit = $persona_fotografia_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$persona_fotografia_grid->TotalRecs = $persona_fotografia->SelectRecordCount();
			$persona_fotografia_grid->Recordset = $persona_fotografia_grid->LoadRecordset($persona_fotografia_grid->StartRec-1, $persona_fotografia_grid->DisplayRecs);
		} else {
			if ($persona_fotografia_grid->Recordset = $persona_fotografia_grid->LoadRecordset())
				$persona_fotografia_grid->TotalRecs = $persona_fotografia_grid->Recordset->RecordCount();
		}
		$persona_fotografia_grid->StartRec = 1;
		$persona_fotografia_grid->DisplayRecs = $persona_fotografia_grid->TotalRecs;
	} else {
		$persona_fotografia->CurrentFilter = "0=1";
		$persona_fotografia_grid->StartRec = 1;
		$persona_fotografia_grid->DisplayRecs = $persona_fotografia->GridAddRowCount;
	}
	$persona_fotografia_grid->TotalRecs = $persona_fotografia_grid->DisplayRecs;
	$persona_fotografia_grid->StopRec = $persona_fotografia_grid->DisplayRecs;
} else {
	$bSelectLimit = $persona_fotografia_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($persona_fotografia_grid->TotalRecs <= 0)
			$persona_fotografia_grid->TotalRecs = $persona_fotografia->SelectRecordCount();
	} else {
		if (!$persona_fotografia_grid->Recordset && ($persona_fotografia_grid->Recordset = $persona_fotografia_grid->LoadRecordset()))
			$persona_fotografia_grid->TotalRecs = $persona_fotografia_grid->Recordset->RecordCount();
	}
	$persona_fotografia_grid->StartRec = 1;
	$persona_fotografia_grid->DisplayRecs = $persona_fotografia_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$persona_fotografia_grid->Recordset = $persona_fotografia_grid->LoadRecordset($persona_fotografia_grid->StartRec-1, $persona_fotografia_grid->DisplayRecs);

	// Set no record found message
	if ($persona_fotografia->CurrentAction == "" && $persona_fotografia_grid->TotalRecs == 0) {
		if ($persona_fotografia_grid->SearchWhere == "0=101")
			$persona_fotografia_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$persona_fotografia_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$persona_fotografia_grid->RenderOtherOptions();
?>
<?php $persona_fotografia_grid->ShowPageHeader(); ?>
<?php
$persona_fotografia_grid->ShowMessage();
?>
<?php if ($persona_fotografia_grid->TotalRecs > 0 || $persona_fotografia->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fpersona_fotografiagrid" class="ewForm form-inline">
<?php if ($persona_fotografia_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($persona_fotografia_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_persona_fotografia" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_persona_fotografiagrid" class="table ewTable">
<?php echo $persona_fotografia->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$persona_fotografia_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$persona_fotografia_grid->RenderListOptions();

// Render list options (header, left)
$persona_fotografia_grid->ListOptions->Render("header", "left");
?>
<?php if ($persona_fotografia->fotografia->Visible) { // fotografia ?>
	<?php if ($persona_fotografia->SortUrl($persona_fotografia->fotografia) == "") { ?>
		<th data-name="fotografia"><div id="elh_persona_fotografia_fotografia" class="persona_fotografia_fotografia"><div class="ewTableHeaderCaption"><?php echo $persona_fotografia->fotografia->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fotografia"><div><div id="elh_persona_fotografia_fotografia" class="persona_fotografia_fotografia">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $persona_fotografia->fotografia->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($persona_fotografia->fotografia->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($persona_fotografia->fotografia->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($persona_fotografia->fecha_insercion->Visible) { // fecha_insercion ?>
	<?php if ($persona_fotografia->SortUrl($persona_fotografia->fecha_insercion) == "") { ?>
		<th data-name="fecha_insercion"><div id="elh_persona_fotografia_fecha_insercion" class="persona_fotografia_fecha_insercion"><div class="ewTableHeaderCaption"><?php echo $persona_fotografia->fecha_insercion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha_insercion"><div><div id="elh_persona_fotografia_fecha_insercion" class="persona_fotografia_fecha_insercion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $persona_fotografia->fecha_insercion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($persona_fotografia->fecha_insercion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($persona_fotografia->fecha_insercion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$persona_fotografia_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$persona_fotografia_grid->StartRec = 1;
$persona_fotografia_grid->StopRec = $persona_fotografia_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($persona_fotografia_grid->FormKeyCountName) && ($persona_fotografia->CurrentAction == "gridadd" || $persona_fotografia->CurrentAction == "gridedit" || $persona_fotografia->CurrentAction == "F")) {
		$persona_fotografia_grid->KeyCount = $objForm->GetValue($persona_fotografia_grid->FormKeyCountName);
		$persona_fotografia_grid->StopRec = $persona_fotografia_grid->StartRec + $persona_fotografia_grid->KeyCount - 1;
	}
}
$persona_fotografia_grid->RecCnt = $persona_fotografia_grid->StartRec - 1;
if ($persona_fotografia_grid->Recordset && !$persona_fotografia_grid->Recordset->EOF) {
	$persona_fotografia_grid->Recordset->MoveFirst();
	$bSelectLimit = $persona_fotografia_grid->UseSelectLimit;
	if (!$bSelectLimit && $persona_fotografia_grid->StartRec > 1)
		$persona_fotografia_grid->Recordset->Move($persona_fotografia_grid->StartRec - 1);
} elseif (!$persona_fotografia->AllowAddDeleteRow && $persona_fotografia_grid->StopRec == 0) {
	$persona_fotografia_grid->StopRec = $persona_fotografia->GridAddRowCount;
}

// Initialize aggregate
$persona_fotografia->RowType = EW_ROWTYPE_AGGREGATEINIT;
$persona_fotografia->ResetAttrs();
$persona_fotografia_grid->RenderRow();
if ($persona_fotografia->CurrentAction == "gridadd")
	$persona_fotografia_grid->RowIndex = 0;
if ($persona_fotografia->CurrentAction == "gridedit")
	$persona_fotografia_grid->RowIndex = 0;
while ($persona_fotografia_grid->RecCnt < $persona_fotografia_grid->StopRec) {
	$persona_fotografia_grid->RecCnt++;
	if (intval($persona_fotografia_grid->RecCnt) >= intval($persona_fotografia_grid->StartRec)) {
		$persona_fotografia_grid->RowCnt++;
		if ($persona_fotografia->CurrentAction == "gridadd" || $persona_fotografia->CurrentAction == "gridedit" || $persona_fotografia->CurrentAction == "F") {
			$persona_fotografia_grid->RowIndex++;
			$objForm->Index = $persona_fotografia_grid->RowIndex;
			if ($objForm->HasValue($persona_fotografia_grid->FormActionName))
				$persona_fotografia_grid->RowAction = strval($objForm->GetValue($persona_fotografia_grid->FormActionName));
			elseif ($persona_fotografia->CurrentAction == "gridadd")
				$persona_fotografia_grid->RowAction = "insert";
			else
				$persona_fotografia_grid->RowAction = "";
		}

		// Set up key count
		$persona_fotografia_grid->KeyCount = $persona_fotografia_grid->RowIndex;

		// Init row class and style
		$persona_fotografia->ResetAttrs();
		$persona_fotografia->CssClass = "";
		if ($persona_fotografia->CurrentAction == "gridadd") {
			if ($persona_fotografia->CurrentMode == "copy") {
				$persona_fotografia_grid->LoadRowValues($persona_fotografia_grid->Recordset); // Load row values
				$persona_fotografia_grid->SetRecordKey($persona_fotografia_grid->RowOldKey, $persona_fotografia_grid->Recordset); // Set old record key
			} else {
				$persona_fotografia_grid->LoadDefaultValues(); // Load default values
				$persona_fotografia_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$persona_fotografia_grid->LoadRowValues($persona_fotografia_grid->Recordset); // Load row values
		}
		$persona_fotografia->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($persona_fotografia->CurrentAction == "gridadd") // Grid add
			$persona_fotografia->RowType = EW_ROWTYPE_ADD; // Render add
		if ($persona_fotografia->CurrentAction == "gridadd" && $persona_fotografia->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$persona_fotografia_grid->RestoreCurrentRowFormValues($persona_fotografia_grid->RowIndex); // Restore form values
		if ($persona_fotografia->CurrentAction == "gridedit") { // Grid edit
			if ($persona_fotografia->EventCancelled) {
				$persona_fotografia_grid->RestoreCurrentRowFormValues($persona_fotografia_grid->RowIndex); // Restore form values
			}
			if ($persona_fotografia_grid->RowAction == "insert")
				$persona_fotografia->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$persona_fotografia->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($persona_fotografia->CurrentAction == "gridedit" && ($persona_fotografia->RowType == EW_ROWTYPE_EDIT || $persona_fotografia->RowType == EW_ROWTYPE_ADD) && $persona_fotografia->EventCancelled) // Update failed
			$persona_fotografia_grid->RestoreCurrentRowFormValues($persona_fotografia_grid->RowIndex); // Restore form values
		if ($persona_fotografia->RowType == EW_ROWTYPE_EDIT) // Edit row
			$persona_fotografia_grid->EditRowCnt++;
		if ($persona_fotografia->CurrentAction == "F") // Confirm row
			$persona_fotografia_grid->RestoreCurrentRowFormValues($persona_fotografia_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$persona_fotografia->RowAttrs = array_merge($persona_fotografia->RowAttrs, array('data-rowindex'=>$persona_fotografia_grid->RowCnt, 'id'=>'r' . $persona_fotografia_grid->RowCnt . '_persona_fotografia', 'data-rowtype'=>$persona_fotografia->RowType));

		// Render row
		$persona_fotografia_grid->RenderRow();

		// Render list options
		$persona_fotografia_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($persona_fotografia_grid->RowAction <> "delete" && $persona_fotografia_grid->RowAction <> "insertdelete" && !($persona_fotografia_grid->RowAction == "insert" && $persona_fotografia->CurrentAction == "F" && $persona_fotografia_grid->EmptyRow())) {
?>
	<tr<?php echo $persona_fotografia->RowAttributes() ?>>
<?php

// Render list options (body, left)
$persona_fotografia_grid->ListOptions->Render("body", "left", $persona_fotografia_grid->RowCnt);
?>
	<?php if ($persona_fotografia->fotografia->Visible) { // fotografia ?>
		<td data-name="fotografia"<?php echo $persona_fotografia->fotografia->CellAttributes() ?>>
<?php if ($persona_fotografia_grid->RowAction == "insert") { // Add record ?>
<span id="el<?php echo $persona_fotografia_grid->RowCnt ?>_persona_fotografia_fotografia" class="form-group persona_fotografia_fotografia">
<div id="fd_x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia">
<span title="<?php echo $persona_fotografia->fotografia->FldTitle() ? $persona_fotografia->fotografia->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($persona_fotografia->fotografia->ReadOnly || $persona_fotografia->fotografia->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="persona_fotografia" data-field="x_fotografia" name="x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" id="x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia"<?php echo $persona_fotografia->fotografia->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" id= "fn_x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" value="<?php echo $persona_fotografia->fotografia->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" id= "fa_x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" value="0">
<input type="hidden" name="fs_x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" id= "fs_x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" value="45">
<input type="hidden" name="fx_x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" id= "fx_x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" value="<?php echo $persona_fotografia->fotografia->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" id= "fm_x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" value="<?php echo $persona_fotografia->fotografia->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="persona_fotografia" data-field="x_fotografia" name="o<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" id="o<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" value="<?php echo ew_HtmlEncode($persona_fotografia->fotografia->OldValue) ?>">
<?php } elseif ($persona_fotografia->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $persona_fotografia_grid->RowCnt ?>_persona_fotografia_fotografia" class="persona_fotografia_fotografia">
<span>
<?php echo ew_GetFileViewTag($persona_fotografia->fotografia, $persona_fotografia->fotografia->ListViewValue()) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?php echo $persona_fotografia_grid->RowCnt ?>_persona_fotografia_fotografia" class="form-group persona_fotografia_fotografia">
<span>
<?php echo ew_GetFileViewTag($persona_fotografia->fotografia, $persona_fotografia->fotografia->EditValue) ?>
</span>
</span>
<input type="hidden" data-table="persona_fotografia" data-field="x_fotografia" name="x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" id="x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" value="<?php echo ew_HtmlEncode($persona_fotografia->fotografia->CurrentValue) ?>">
<?php } ?>
<a id="<?php echo $persona_fotografia_grid->PageObjName . "_row_" . $persona_fotografia_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($persona_fotografia->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="persona_fotografia" data-field="x_idpersona_fotografia" name="x<?php echo $persona_fotografia_grid->RowIndex ?>_idpersona_fotografia" id="x<?php echo $persona_fotografia_grid->RowIndex ?>_idpersona_fotografia" value="<?php echo ew_HtmlEncode($persona_fotografia->idpersona_fotografia->CurrentValue) ?>">
<input type="hidden" data-table="persona_fotografia" data-field="x_idpersona_fotografia" name="o<?php echo $persona_fotografia_grid->RowIndex ?>_idpersona_fotografia" id="o<?php echo $persona_fotografia_grid->RowIndex ?>_idpersona_fotografia" value="<?php echo ew_HtmlEncode($persona_fotografia->idpersona_fotografia->OldValue) ?>">
<?php } ?>
<?php if ($persona_fotografia->RowType == EW_ROWTYPE_EDIT || $persona_fotografia->CurrentMode == "edit") { ?>
<input type="hidden" data-table="persona_fotografia" data-field="x_idpersona_fotografia" name="x<?php echo $persona_fotografia_grid->RowIndex ?>_idpersona_fotografia" id="x<?php echo $persona_fotografia_grid->RowIndex ?>_idpersona_fotografia" value="<?php echo ew_HtmlEncode($persona_fotografia->idpersona_fotografia->CurrentValue) ?>">
<?php } ?>
	<?php if ($persona_fotografia->fecha_insercion->Visible) { // fecha_insercion ?>
		<td data-name="fecha_insercion"<?php echo $persona_fotografia->fecha_insercion->CellAttributes() ?>>
<?php if ($persona_fotografia->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $persona_fotografia_grid->RowCnt ?>_persona_fotografia_fecha_insercion" class="form-group persona_fotografia_fecha_insercion">
<input type="text" data-table="persona_fotografia" data-field="x_fecha_insercion" name="x<?php echo $persona_fotografia_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $persona_fotografia_grid->RowIndex ?>_fecha_insercion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($persona_fotografia->fecha_insercion->getPlaceHolder()) ?>" value="<?php echo $persona_fotografia->fecha_insercion->EditValue ?>"<?php echo $persona_fotografia->fecha_insercion->EditAttributes() ?>>
</span>
<input type="hidden" data-table="persona_fotografia" data-field="x_fecha_insercion" name="o<?php echo $persona_fotografia_grid->RowIndex ?>_fecha_insercion" id="o<?php echo $persona_fotografia_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($persona_fotografia->fecha_insercion->OldValue) ?>">
<?php } ?>
<?php if ($persona_fotografia->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $persona_fotografia_grid->RowCnt ?>_persona_fotografia_fecha_insercion" class="form-group persona_fotografia_fecha_insercion">
<input type="text" data-table="persona_fotografia" data-field="x_fecha_insercion" name="x<?php echo $persona_fotografia_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $persona_fotografia_grid->RowIndex ?>_fecha_insercion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($persona_fotografia->fecha_insercion->getPlaceHolder()) ?>" value="<?php echo $persona_fotografia->fecha_insercion->EditValue ?>"<?php echo $persona_fotografia->fecha_insercion->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($persona_fotografia->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $persona_fotografia_grid->RowCnt ?>_persona_fotografia_fecha_insercion" class="persona_fotografia_fecha_insercion">
<span<?php echo $persona_fotografia->fecha_insercion->ViewAttributes() ?>>
<?php echo $persona_fotografia->fecha_insercion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="persona_fotografia" data-field="x_fecha_insercion" name="x<?php echo $persona_fotografia_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $persona_fotografia_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($persona_fotografia->fecha_insercion->FormValue) ?>">
<input type="hidden" data-table="persona_fotografia" data-field="x_fecha_insercion" name="o<?php echo $persona_fotografia_grid->RowIndex ?>_fecha_insercion" id="o<?php echo $persona_fotografia_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($persona_fotografia->fecha_insercion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$persona_fotografia_grid->ListOptions->Render("body", "right", $persona_fotografia_grid->RowCnt);
?>
	</tr>
<?php if ($persona_fotografia->RowType == EW_ROWTYPE_ADD || $persona_fotografia->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fpersona_fotografiagrid.UpdateOpts(<?php echo $persona_fotografia_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($persona_fotografia->CurrentAction <> "gridadd" || $persona_fotografia->CurrentMode == "copy")
		if (!$persona_fotografia_grid->Recordset->EOF) $persona_fotografia_grid->Recordset->MoveNext();
}
?>
<?php
	if ($persona_fotografia->CurrentMode == "add" || $persona_fotografia->CurrentMode == "copy" || $persona_fotografia->CurrentMode == "edit") {
		$persona_fotografia_grid->RowIndex = '$rowindex$';
		$persona_fotografia_grid->LoadDefaultValues();

		// Set row properties
		$persona_fotografia->ResetAttrs();
		$persona_fotografia->RowAttrs = array_merge($persona_fotografia->RowAttrs, array('data-rowindex'=>$persona_fotografia_grid->RowIndex, 'id'=>'r0_persona_fotografia', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($persona_fotografia->RowAttrs["class"], "ewTemplate");
		$persona_fotografia->RowType = EW_ROWTYPE_ADD;

		// Render row
		$persona_fotografia_grid->RenderRow();

		// Render list options
		$persona_fotografia_grid->RenderListOptions();
		$persona_fotografia_grid->StartRowCnt = 0;
?>
	<tr<?php echo $persona_fotografia->RowAttributes() ?>>
<?php

// Render list options (body, left)
$persona_fotografia_grid->ListOptions->Render("body", "left", $persona_fotografia_grid->RowIndex);
?>
	<?php if ($persona_fotografia->fotografia->Visible) { // fotografia ?>
		<td data-name="fotografia">
<span id="el$rowindex$_persona_fotografia_fotografia" class="form-group persona_fotografia_fotografia">
<div id="fd_x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia">
<span title="<?php echo $persona_fotografia->fotografia->FldTitle() ? $persona_fotografia->fotografia->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($persona_fotografia->fotografia->ReadOnly || $persona_fotografia->fotografia->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="persona_fotografia" data-field="x_fotografia" name="x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" id="x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia"<?php echo $persona_fotografia->fotografia->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" id= "fn_x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" value="<?php echo $persona_fotografia->fotografia->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" id= "fa_x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" value="0">
<input type="hidden" name="fs_x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" id= "fs_x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" value="45">
<input type="hidden" name="fx_x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" id= "fx_x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" value="<?php echo $persona_fotografia->fotografia->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" id= "fm_x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" value="<?php echo $persona_fotografia->fotografia->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="persona_fotografia" data-field="x_fotografia" name="o<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" id="o<?php echo $persona_fotografia_grid->RowIndex ?>_fotografia" value="<?php echo ew_HtmlEncode($persona_fotografia->fotografia->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($persona_fotografia->fecha_insercion->Visible) { // fecha_insercion ?>
		<td data-name="fecha_insercion">
<?php if ($persona_fotografia->CurrentAction <> "F") { ?>
<span id="el$rowindex$_persona_fotografia_fecha_insercion" class="form-group persona_fotografia_fecha_insercion">
<input type="text" data-table="persona_fotografia" data-field="x_fecha_insercion" name="x<?php echo $persona_fotografia_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $persona_fotografia_grid->RowIndex ?>_fecha_insercion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($persona_fotografia->fecha_insercion->getPlaceHolder()) ?>" value="<?php echo $persona_fotografia->fecha_insercion->EditValue ?>"<?php echo $persona_fotografia->fecha_insercion->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_persona_fotografia_fecha_insercion" class="form-group persona_fotografia_fecha_insercion">
<span<?php echo $persona_fotografia->fecha_insercion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $persona_fotografia->fecha_insercion->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="persona_fotografia" data-field="x_fecha_insercion" name="x<?php echo $persona_fotografia_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $persona_fotografia_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($persona_fotografia->fecha_insercion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="persona_fotografia" data-field="x_fecha_insercion" name="o<?php echo $persona_fotografia_grid->RowIndex ?>_fecha_insercion" id="o<?php echo $persona_fotografia_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($persona_fotografia->fecha_insercion->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$persona_fotografia_grid->ListOptions->Render("body", "right", $persona_fotografia_grid->RowCnt);
?>
<script type="text/javascript">
fpersona_fotografiagrid.UpdateOpts(<?php echo $persona_fotografia_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($persona_fotografia->CurrentMode == "add" || $persona_fotografia->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $persona_fotografia_grid->FormKeyCountName ?>" id="<?php echo $persona_fotografia_grid->FormKeyCountName ?>" value="<?php echo $persona_fotografia_grid->KeyCount ?>">
<?php echo $persona_fotografia_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($persona_fotografia->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $persona_fotografia_grid->FormKeyCountName ?>" id="<?php echo $persona_fotografia_grid->FormKeyCountName ?>" value="<?php echo $persona_fotografia_grid->KeyCount ?>">
<?php echo $persona_fotografia_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($persona_fotografia->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fpersona_fotografiagrid">
</div>
<?php

// Close recordset
if ($persona_fotografia_grid->Recordset)
	$persona_fotografia_grid->Recordset->Close();
?>
</div>
</div>
<?php } ?>
<?php if ($persona_fotografia_grid->TotalRecs == 0 && $persona_fotografia->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($persona_fotografia_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($persona_fotografia->Export == "") { ?>
<script type="text/javascript">
fpersona_fotografiagrid.Init();
</script>
<?php } ?>
<?php
$persona_fotografia_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$persona_fotografia_grid->Page_Terminate();
?>
