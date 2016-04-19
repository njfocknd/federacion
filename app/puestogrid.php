<?php

// Create page object
if (!isset($puesto_grid)) $puesto_grid = new cpuesto_grid();

// Page init
$puesto_grid->Page_Init();

// Page main
$puesto_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$puesto_grid->Page_Render();
?>
<?php if ($puesto->Export == "") { ?>
<script type="text/javascript">

// Form object
var fpuestogrid = new ew_Form("fpuestogrid", "grid");
fpuestogrid.FormKeyCountName = '<?php echo $puesto_grid->FormKeyCountName ?>';

// Validate form
fpuestogrid.Validate = function() {
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
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fpuestogrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idpuesto_tipo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idpersona", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idfederacion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idorgano", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha_inicio", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha_fin", false)) return false;
	if (ew_ValueChanged(fobj, infix, "status", false)) return false;
	return true;
}

// Form_CustomValidate event
fpuestogrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpuestogrid.ValidateRequired = true;
<?php } else { ?>
fpuestogrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpuestogrid.Lists["x_idpuesto_tipo"] = {"LinkField":"x_idpuesto_tipo","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpuestogrid.Lists["x_idpersona"] = {"LinkField":"x_idpersona","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpuestogrid.Lists["x_idfederacion"] = {"LinkField":"x_idfederacion","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpuestogrid.Lists["x_idorgano"] = {"LinkField":"x_idorgano","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpuestogrid.Lists["x_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpuestogrid.Lists["x_status"].Options = <?php echo json_encode($puesto->status->Options()) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($puesto->CurrentAction == "gridadd") {
	if ($puesto->CurrentMode == "copy") {
		$bSelectLimit = $puesto_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$puesto_grid->TotalRecs = $puesto->SelectRecordCount();
			$puesto_grid->Recordset = $puesto_grid->LoadRecordset($puesto_grid->StartRec-1, $puesto_grid->DisplayRecs);
		} else {
			if ($puesto_grid->Recordset = $puesto_grid->LoadRecordset())
				$puesto_grid->TotalRecs = $puesto_grid->Recordset->RecordCount();
		}
		$puesto_grid->StartRec = 1;
		$puesto_grid->DisplayRecs = $puesto_grid->TotalRecs;
	} else {
		$puesto->CurrentFilter = "0=1";
		$puesto_grid->StartRec = 1;
		$puesto_grid->DisplayRecs = $puesto->GridAddRowCount;
	}
	$puesto_grid->TotalRecs = $puesto_grid->DisplayRecs;
	$puesto_grid->StopRec = $puesto_grid->DisplayRecs;
} else {
	$bSelectLimit = $puesto_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($puesto_grid->TotalRecs <= 0)
			$puesto_grid->TotalRecs = $puesto->SelectRecordCount();
	} else {
		if (!$puesto_grid->Recordset && ($puesto_grid->Recordset = $puesto_grid->LoadRecordset()))
			$puesto_grid->TotalRecs = $puesto_grid->Recordset->RecordCount();
	}
	$puesto_grid->StartRec = 1;
	$puesto_grid->DisplayRecs = $puesto_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$puesto_grid->Recordset = $puesto_grid->LoadRecordset($puesto_grid->StartRec-1, $puesto_grid->DisplayRecs);

	// Set no record found message
	if ($puesto->CurrentAction == "" && $puesto_grid->TotalRecs == 0) {
		if ($puesto_grid->SearchWhere == "0=101")
			$puesto_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$puesto_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$puesto_grid->RenderOtherOptions();
?>
<?php $puesto_grid->ShowPageHeader(); ?>
<?php
$puesto_grid->ShowMessage();
?>
<?php if ($puesto_grid->TotalRecs > 0 || $puesto->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fpuestogrid" class="ewForm form-inline">
<?php if ($puesto_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($puesto_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_puesto" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_puestogrid" class="table ewTable">
<?php echo $puesto->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$puesto_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$puesto_grid->RenderListOptions();

// Render list options (header, left)
$puesto_grid->ListOptions->Render("header", "left");
?>
<?php if ($puesto->idpuesto_tipo->Visible) { // idpuesto_tipo ?>
	<?php if ($puesto->SortUrl($puesto->idpuesto_tipo) == "") { ?>
		<th data-name="idpuesto_tipo"><div id="elh_puesto_idpuesto_tipo" class="puesto_idpuesto_tipo"><div class="ewTableHeaderCaption"><?php echo $puesto->idpuesto_tipo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idpuesto_tipo"><div><div id="elh_puesto_idpuesto_tipo" class="puesto_idpuesto_tipo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $puesto->idpuesto_tipo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($puesto->idpuesto_tipo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($puesto->idpuesto_tipo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($puesto->idpersona->Visible) { // idpersona ?>
	<?php if ($puesto->SortUrl($puesto->idpersona) == "") { ?>
		<th data-name="idpersona"><div id="elh_puesto_idpersona" class="puesto_idpersona"><div class="ewTableHeaderCaption"><?php echo $puesto->idpersona->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idpersona"><div><div id="elh_puesto_idpersona" class="puesto_idpersona">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $puesto->idpersona->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($puesto->idpersona->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($puesto->idpersona->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($puesto->idfederacion->Visible) { // idfederacion ?>
	<?php if ($puesto->SortUrl($puesto->idfederacion) == "") { ?>
		<th data-name="idfederacion"><div id="elh_puesto_idfederacion" class="puesto_idfederacion"><div class="ewTableHeaderCaption"><?php echo $puesto->idfederacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idfederacion"><div><div id="elh_puesto_idfederacion" class="puesto_idfederacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $puesto->idfederacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($puesto->idfederacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($puesto->idfederacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($puesto->idorgano->Visible) { // idorgano ?>
	<?php if ($puesto->SortUrl($puesto->idorgano) == "") { ?>
		<th data-name="idorgano"><div id="elh_puesto_idorgano" class="puesto_idorgano"><div class="ewTableHeaderCaption"><?php echo $puesto->idorgano->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idorgano"><div><div id="elh_puesto_idorgano" class="puesto_idorgano">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $puesto->idorgano->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($puesto->idorgano->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($puesto->idorgano->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($puesto->fecha_inicio->Visible) { // fecha_inicio ?>
	<?php if ($puesto->SortUrl($puesto->fecha_inicio) == "") { ?>
		<th data-name="fecha_inicio"><div id="elh_puesto_fecha_inicio" class="puesto_fecha_inicio"><div class="ewTableHeaderCaption"><?php echo $puesto->fecha_inicio->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha_inicio"><div><div id="elh_puesto_fecha_inicio" class="puesto_fecha_inicio">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $puesto->fecha_inicio->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($puesto->fecha_inicio->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($puesto->fecha_inicio->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($puesto->fecha_fin->Visible) { // fecha_fin ?>
	<?php if ($puesto->SortUrl($puesto->fecha_fin) == "") { ?>
		<th data-name="fecha_fin"><div id="elh_puesto_fecha_fin" class="puesto_fecha_fin"><div class="ewTableHeaderCaption"><?php echo $puesto->fecha_fin->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha_fin"><div><div id="elh_puesto_fecha_fin" class="puesto_fecha_fin">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $puesto->fecha_fin->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($puesto->fecha_fin->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($puesto->fecha_fin->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($puesto->status->Visible) { // status ?>
	<?php if ($puesto->SortUrl($puesto->status) == "") { ?>
		<th data-name="status"><div id="elh_puesto_status" class="puesto_status"><div class="ewTableHeaderCaption"><?php echo $puesto->status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status"><div><div id="elh_puesto_status" class="puesto_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $puesto->status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($puesto->status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($puesto->status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$puesto_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$puesto_grid->StartRec = 1;
$puesto_grid->StopRec = $puesto_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($puesto_grid->FormKeyCountName) && ($puesto->CurrentAction == "gridadd" || $puesto->CurrentAction == "gridedit" || $puesto->CurrentAction == "F")) {
		$puesto_grid->KeyCount = $objForm->GetValue($puesto_grid->FormKeyCountName);
		$puesto_grid->StopRec = $puesto_grid->StartRec + $puesto_grid->KeyCount - 1;
	}
}
$puesto_grid->RecCnt = $puesto_grid->StartRec - 1;
if ($puesto_grid->Recordset && !$puesto_grid->Recordset->EOF) {
	$puesto_grid->Recordset->MoveFirst();
	$bSelectLimit = $puesto_grid->UseSelectLimit;
	if (!$bSelectLimit && $puesto_grid->StartRec > 1)
		$puesto_grid->Recordset->Move($puesto_grid->StartRec - 1);
} elseif (!$puesto->AllowAddDeleteRow && $puesto_grid->StopRec == 0) {
	$puesto_grid->StopRec = $puesto->GridAddRowCount;
}

// Initialize aggregate
$puesto->RowType = EW_ROWTYPE_AGGREGATEINIT;
$puesto->ResetAttrs();
$puesto_grid->RenderRow();
if ($puesto->CurrentAction == "gridadd")
	$puesto_grid->RowIndex = 0;
if ($puesto->CurrentAction == "gridedit")
	$puesto_grid->RowIndex = 0;
while ($puesto_grid->RecCnt < $puesto_grid->StopRec) {
	$puesto_grid->RecCnt++;
	if (intval($puesto_grid->RecCnt) >= intval($puesto_grid->StartRec)) {
		$puesto_grid->RowCnt++;
		if ($puesto->CurrentAction == "gridadd" || $puesto->CurrentAction == "gridedit" || $puesto->CurrentAction == "F") {
			$puesto_grid->RowIndex++;
			$objForm->Index = $puesto_grid->RowIndex;
			if ($objForm->HasValue($puesto_grid->FormActionName))
				$puesto_grid->RowAction = strval($objForm->GetValue($puesto_grid->FormActionName));
			elseif ($puesto->CurrentAction == "gridadd")
				$puesto_grid->RowAction = "insert";
			else
				$puesto_grid->RowAction = "";
		}

		// Set up key count
		$puesto_grid->KeyCount = $puesto_grid->RowIndex;

		// Init row class and style
		$puesto->ResetAttrs();
		$puesto->CssClass = "";
		if ($puesto->CurrentAction == "gridadd") {
			if ($puesto->CurrentMode == "copy") {
				$puesto_grid->LoadRowValues($puesto_grid->Recordset); // Load row values
				$puesto_grid->SetRecordKey($puesto_grid->RowOldKey, $puesto_grid->Recordset); // Set old record key
			} else {
				$puesto_grid->LoadDefaultValues(); // Load default values
				$puesto_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$puesto_grid->LoadRowValues($puesto_grid->Recordset); // Load row values
		}
		$puesto->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($puesto->CurrentAction == "gridadd") // Grid add
			$puesto->RowType = EW_ROWTYPE_ADD; // Render add
		if ($puesto->CurrentAction == "gridadd" && $puesto->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$puesto_grid->RestoreCurrentRowFormValues($puesto_grid->RowIndex); // Restore form values
		if ($puesto->CurrentAction == "gridedit") { // Grid edit
			if ($puesto->EventCancelled) {
				$puesto_grid->RestoreCurrentRowFormValues($puesto_grid->RowIndex); // Restore form values
			}
			if ($puesto_grid->RowAction == "insert")
				$puesto->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$puesto->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($puesto->CurrentAction == "gridedit" && ($puesto->RowType == EW_ROWTYPE_EDIT || $puesto->RowType == EW_ROWTYPE_ADD) && $puesto->EventCancelled) // Update failed
			$puesto_grid->RestoreCurrentRowFormValues($puesto_grid->RowIndex); // Restore form values
		if ($puesto->RowType == EW_ROWTYPE_EDIT) // Edit row
			$puesto_grid->EditRowCnt++;
		if ($puesto->CurrentAction == "F") // Confirm row
			$puesto_grid->RestoreCurrentRowFormValues($puesto_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$puesto->RowAttrs = array_merge($puesto->RowAttrs, array('data-rowindex'=>$puesto_grid->RowCnt, 'id'=>'r' . $puesto_grid->RowCnt . '_puesto', 'data-rowtype'=>$puesto->RowType));

		// Render row
		$puesto_grid->RenderRow();

		// Render list options
		$puesto_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($puesto_grid->RowAction <> "delete" && $puesto_grid->RowAction <> "insertdelete" && !($puesto_grid->RowAction == "insert" && $puesto->CurrentAction == "F" && $puesto_grid->EmptyRow())) {
?>
	<tr<?php echo $puesto->RowAttributes() ?>>
<?php

// Render list options (body, left)
$puesto_grid->ListOptions->Render("body", "left", $puesto_grid->RowCnt);
?>
	<?php if ($puesto->idpuesto_tipo->Visible) { // idpuesto_tipo ?>
		<td data-name="idpuesto_tipo"<?php echo $puesto->idpuesto_tipo->CellAttributes() ?>>
<?php if ($puesto->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($puesto->idpuesto_tipo->getSessionValue() <> "") { ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_idpuesto_tipo" class="form-group puesto_idpuesto_tipo">
<span<?php echo $puesto->idpuesto_tipo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $puesto->idpuesto_tipo->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" name="x<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" value="<?php echo ew_HtmlEncode($puesto->idpuesto_tipo->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_idpuesto_tipo" class="form-group puesto_idpuesto_tipo">
<select data-table="puesto" data-field="x_idpuesto_tipo" data-value-separator="<?php echo ew_HtmlEncode(is_array($puesto->idpuesto_tipo->DisplayValueSeparator) ? json_encode($puesto->idpuesto_tipo->DisplayValueSeparator) : $puesto->idpuesto_tipo->DisplayValueSeparator) ?>" id="x<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" name="x<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo"<?php echo $puesto->idpuesto_tipo->EditAttributes() ?>>
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
if (@$emptywrk) $puesto->idpuesto_tipo->OldValue = "";
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
<input type="hidden" name="s_x<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" id="s_x<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" value="<?php echo $puesto->idpuesto_tipo->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="puesto" data-field="x_idpuesto_tipo" name="o<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" id="o<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" value="<?php echo ew_HtmlEncode($puesto->idpuesto_tipo->OldValue) ?>">
<?php } ?>
<?php if ($puesto->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($puesto->idpuesto_tipo->getSessionValue() <> "") { ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_idpuesto_tipo" class="form-group puesto_idpuesto_tipo">
<span<?php echo $puesto->idpuesto_tipo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $puesto->idpuesto_tipo->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" name="x<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" value="<?php echo ew_HtmlEncode($puesto->idpuesto_tipo->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_idpuesto_tipo" class="form-group puesto_idpuesto_tipo">
<select data-table="puesto" data-field="x_idpuesto_tipo" data-value-separator="<?php echo ew_HtmlEncode(is_array($puesto->idpuesto_tipo->DisplayValueSeparator) ? json_encode($puesto->idpuesto_tipo->DisplayValueSeparator) : $puesto->idpuesto_tipo->DisplayValueSeparator) ?>" id="x<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" name="x<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo"<?php echo $puesto->idpuesto_tipo->EditAttributes() ?>>
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
if (@$emptywrk) $puesto->idpuesto_tipo->OldValue = "";
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
<input type="hidden" name="s_x<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" id="s_x<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" value="<?php echo $puesto->idpuesto_tipo->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($puesto->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_idpuesto_tipo" class="puesto_idpuesto_tipo">
<span<?php echo $puesto->idpuesto_tipo->ViewAttributes() ?>>
<?php echo $puesto->idpuesto_tipo->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="puesto" data-field="x_idpuesto_tipo" name="x<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" id="x<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" value="<?php echo ew_HtmlEncode($puesto->idpuesto_tipo->FormValue) ?>">
<input type="hidden" data-table="puesto" data-field="x_idpuesto_tipo" name="o<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" id="o<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" value="<?php echo ew_HtmlEncode($puesto->idpuesto_tipo->OldValue) ?>">
<?php } ?>
<a id="<?php echo $puesto_grid->PageObjName . "_row_" . $puesto_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($puesto->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="puesto" data-field="x_idpuesto" name="x<?php echo $puesto_grid->RowIndex ?>_idpuesto" id="x<?php echo $puesto_grid->RowIndex ?>_idpuesto" value="<?php echo ew_HtmlEncode($puesto->idpuesto->CurrentValue) ?>">
<input type="hidden" data-table="puesto" data-field="x_idpuesto" name="o<?php echo $puesto_grid->RowIndex ?>_idpuesto" id="o<?php echo $puesto_grid->RowIndex ?>_idpuesto" value="<?php echo ew_HtmlEncode($puesto->idpuesto->OldValue) ?>">
<?php } ?>
<?php if ($puesto->RowType == EW_ROWTYPE_EDIT || $puesto->CurrentMode == "edit") { ?>
<input type="hidden" data-table="puesto" data-field="x_idpuesto" name="x<?php echo $puesto_grid->RowIndex ?>_idpuesto" id="x<?php echo $puesto_grid->RowIndex ?>_idpuesto" value="<?php echo ew_HtmlEncode($puesto->idpuesto->CurrentValue) ?>">
<?php } ?>
	<?php if ($puesto->idpersona->Visible) { // idpersona ?>
		<td data-name="idpersona"<?php echo $puesto->idpersona->CellAttributes() ?>>
<?php if ($puesto->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($puesto->idpersona->getSessionValue() <> "") { ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_idpersona" class="form-group puesto_idpersona">
<span<?php echo $puesto->idpersona->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $puesto->idpersona->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $puesto_grid->RowIndex ?>_idpersona" name="x<?php echo $puesto_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($puesto->idpersona->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_idpersona" class="form-group puesto_idpersona">
<select data-table="puesto" data-field="x_idpersona" data-value-separator="<?php echo ew_HtmlEncode(is_array($puesto->idpersona->DisplayValueSeparator) ? json_encode($puesto->idpersona->DisplayValueSeparator) : $puesto->idpersona->DisplayValueSeparator) ?>" id="x<?php echo $puesto_grid->RowIndex ?>_idpersona" name="x<?php echo $puesto_grid->RowIndex ?>_idpersona"<?php echo $puesto->idpersona->EditAttributes() ?>>
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
if (@$emptywrk) $puesto->idpersona->OldValue = "";
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
<input type="hidden" name="s_x<?php echo $puesto_grid->RowIndex ?>_idpersona" id="s_x<?php echo $puesto_grid->RowIndex ?>_idpersona" value="<?php echo $puesto->idpersona->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="puesto" data-field="x_idpersona" name="o<?php echo $puesto_grid->RowIndex ?>_idpersona" id="o<?php echo $puesto_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($puesto->idpersona->OldValue) ?>">
<?php } ?>
<?php if ($puesto->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($puesto->idpersona->getSessionValue() <> "") { ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_idpersona" class="form-group puesto_idpersona">
<span<?php echo $puesto->idpersona->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $puesto->idpersona->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $puesto_grid->RowIndex ?>_idpersona" name="x<?php echo $puesto_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($puesto->idpersona->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_idpersona" class="form-group puesto_idpersona">
<select data-table="puesto" data-field="x_idpersona" data-value-separator="<?php echo ew_HtmlEncode(is_array($puesto->idpersona->DisplayValueSeparator) ? json_encode($puesto->idpersona->DisplayValueSeparator) : $puesto->idpersona->DisplayValueSeparator) ?>" id="x<?php echo $puesto_grid->RowIndex ?>_idpersona" name="x<?php echo $puesto_grid->RowIndex ?>_idpersona"<?php echo $puesto->idpersona->EditAttributes() ?>>
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
if (@$emptywrk) $puesto->idpersona->OldValue = "";
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
<input type="hidden" name="s_x<?php echo $puesto_grid->RowIndex ?>_idpersona" id="s_x<?php echo $puesto_grid->RowIndex ?>_idpersona" value="<?php echo $puesto->idpersona->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($puesto->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_idpersona" class="puesto_idpersona">
<span<?php echo $puesto->idpersona->ViewAttributes() ?>>
<?php echo $puesto->idpersona->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="puesto" data-field="x_idpersona" name="x<?php echo $puesto_grid->RowIndex ?>_idpersona" id="x<?php echo $puesto_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($puesto->idpersona->FormValue) ?>">
<input type="hidden" data-table="puesto" data-field="x_idpersona" name="o<?php echo $puesto_grid->RowIndex ?>_idpersona" id="o<?php echo $puesto_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($puesto->idpersona->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($puesto->idfederacion->Visible) { // idfederacion ?>
		<td data-name="idfederacion"<?php echo $puesto->idfederacion->CellAttributes() ?>>
<?php if ($puesto->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_idfederacion" class="form-group puesto_idfederacion">
<select data-table="puesto" data-field="x_idfederacion" data-value-separator="<?php echo ew_HtmlEncode(is_array($puesto->idfederacion->DisplayValueSeparator) ? json_encode($puesto->idfederacion->DisplayValueSeparator) : $puesto->idfederacion->DisplayValueSeparator) ?>" id="x<?php echo $puesto_grid->RowIndex ?>_idfederacion" name="x<?php echo $puesto_grid->RowIndex ?>_idfederacion"<?php echo $puesto->idfederacion->EditAttributes() ?>>
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
if (@$emptywrk) $puesto->idfederacion->OldValue = "";
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
<input type="hidden" name="s_x<?php echo $puesto_grid->RowIndex ?>_idfederacion" id="s_x<?php echo $puesto_grid->RowIndex ?>_idfederacion" value="<?php echo $puesto->idfederacion->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="puesto" data-field="x_idfederacion" name="o<?php echo $puesto_grid->RowIndex ?>_idfederacion" id="o<?php echo $puesto_grid->RowIndex ?>_idfederacion" value="<?php echo ew_HtmlEncode($puesto->idfederacion->OldValue) ?>">
<?php } ?>
<?php if ($puesto->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_idfederacion" class="form-group puesto_idfederacion">
<select data-table="puesto" data-field="x_idfederacion" data-value-separator="<?php echo ew_HtmlEncode(is_array($puesto->idfederacion->DisplayValueSeparator) ? json_encode($puesto->idfederacion->DisplayValueSeparator) : $puesto->idfederacion->DisplayValueSeparator) ?>" id="x<?php echo $puesto_grid->RowIndex ?>_idfederacion" name="x<?php echo $puesto_grid->RowIndex ?>_idfederacion"<?php echo $puesto->idfederacion->EditAttributes() ?>>
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
if (@$emptywrk) $puesto->idfederacion->OldValue = "";
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
<input type="hidden" name="s_x<?php echo $puesto_grid->RowIndex ?>_idfederacion" id="s_x<?php echo $puesto_grid->RowIndex ?>_idfederacion" value="<?php echo $puesto->idfederacion->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($puesto->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_idfederacion" class="puesto_idfederacion">
<span<?php echo $puesto->idfederacion->ViewAttributes() ?>>
<?php echo $puesto->idfederacion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="puesto" data-field="x_idfederacion" name="x<?php echo $puesto_grid->RowIndex ?>_idfederacion" id="x<?php echo $puesto_grid->RowIndex ?>_idfederacion" value="<?php echo ew_HtmlEncode($puesto->idfederacion->FormValue) ?>">
<input type="hidden" data-table="puesto" data-field="x_idfederacion" name="o<?php echo $puesto_grid->RowIndex ?>_idfederacion" id="o<?php echo $puesto_grid->RowIndex ?>_idfederacion" value="<?php echo ew_HtmlEncode($puesto->idfederacion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($puesto->idorgano->Visible) { // idorgano ?>
		<td data-name="idorgano"<?php echo $puesto->idorgano->CellAttributes() ?>>
<?php if ($puesto->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_idorgano" class="form-group puesto_idorgano">
<select data-table="puesto" data-field="x_idorgano" data-value-separator="<?php echo ew_HtmlEncode(is_array($puesto->idorgano->DisplayValueSeparator) ? json_encode($puesto->idorgano->DisplayValueSeparator) : $puesto->idorgano->DisplayValueSeparator) ?>" id="x<?php echo $puesto_grid->RowIndex ?>_idorgano" name="x<?php echo $puesto_grid->RowIndex ?>_idorgano"<?php echo $puesto->idorgano->EditAttributes() ?>>
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
if (@$emptywrk) $puesto->idorgano->OldValue = "";
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
<input type="hidden" name="s_x<?php echo $puesto_grid->RowIndex ?>_idorgano" id="s_x<?php echo $puesto_grid->RowIndex ?>_idorgano" value="<?php echo $puesto->idorgano->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="puesto" data-field="x_idorgano" name="o<?php echo $puesto_grid->RowIndex ?>_idorgano" id="o<?php echo $puesto_grid->RowIndex ?>_idorgano" value="<?php echo ew_HtmlEncode($puesto->idorgano->OldValue) ?>">
<?php } ?>
<?php if ($puesto->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_idorgano" class="form-group puesto_idorgano">
<select data-table="puesto" data-field="x_idorgano" data-value-separator="<?php echo ew_HtmlEncode(is_array($puesto->idorgano->DisplayValueSeparator) ? json_encode($puesto->idorgano->DisplayValueSeparator) : $puesto->idorgano->DisplayValueSeparator) ?>" id="x<?php echo $puesto_grid->RowIndex ?>_idorgano" name="x<?php echo $puesto_grid->RowIndex ?>_idorgano"<?php echo $puesto->idorgano->EditAttributes() ?>>
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
if (@$emptywrk) $puesto->idorgano->OldValue = "";
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
<input type="hidden" name="s_x<?php echo $puesto_grid->RowIndex ?>_idorgano" id="s_x<?php echo $puesto_grid->RowIndex ?>_idorgano" value="<?php echo $puesto->idorgano->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($puesto->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_idorgano" class="puesto_idorgano">
<span<?php echo $puesto->idorgano->ViewAttributes() ?>>
<?php echo $puesto->idorgano->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="puesto" data-field="x_idorgano" name="x<?php echo $puesto_grid->RowIndex ?>_idorgano" id="x<?php echo $puesto_grid->RowIndex ?>_idorgano" value="<?php echo ew_HtmlEncode($puesto->idorgano->FormValue) ?>">
<input type="hidden" data-table="puesto" data-field="x_idorgano" name="o<?php echo $puesto_grid->RowIndex ?>_idorgano" id="o<?php echo $puesto_grid->RowIndex ?>_idorgano" value="<?php echo ew_HtmlEncode($puesto->idorgano->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($puesto->fecha_inicio->Visible) { // fecha_inicio ?>
		<td data-name="fecha_inicio"<?php echo $puesto->fecha_inicio->CellAttributes() ?>>
<?php if ($puesto->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_fecha_inicio" class="form-group puesto_fecha_inicio">
<input type="text" data-table="puesto" data-field="x_fecha_inicio" data-format="7" name="x<?php echo $puesto_grid->RowIndex ?>_fecha_inicio" id="x<?php echo $puesto_grid->RowIndex ?>_fecha_inicio" placeholder="<?php echo ew_HtmlEncode($puesto->fecha_inicio->getPlaceHolder()) ?>" value="<?php echo $puesto->fecha_inicio->EditValue ?>"<?php echo $puesto->fecha_inicio->EditAttributes() ?>>
<?php if (!$puesto->fecha_inicio->ReadOnly && !$puesto->fecha_inicio->Disabled && !isset($puesto->fecha_inicio->EditAttrs["readonly"]) && !isset($puesto->fecha_inicio->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fpuestogrid", "x<?php echo $puesto_grid->RowIndex ?>_fecha_inicio", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<input type="hidden" data-table="puesto" data-field="x_fecha_inicio" name="o<?php echo $puesto_grid->RowIndex ?>_fecha_inicio" id="o<?php echo $puesto_grid->RowIndex ?>_fecha_inicio" value="<?php echo ew_HtmlEncode($puesto->fecha_inicio->OldValue) ?>">
<?php } ?>
<?php if ($puesto->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_fecha_inicio" class="form-group puesto_fecha_inicio">
<input type="text" data-table="puesto" data-field="x_fecha_inicio" data-format="7" name="x<?php echo $puesto_grid->RowIndex ?>_fecha_inicio" id="x<?php echo $puesto_grid->RowIndex ?>_fecha_inicio" placeholder="<?php echo ew_HtmlEncode($puesto->fecha_inicio->getPlaceHolder()) ?>" value="<?php echo $puesto->fecha_inicio->EditValue ?>"<?php echo $puesto->fecha_inicio->EditAttributes() ?>>
<?php if (!$puesto->fecha_inicio->ReadOnly && !$puesto->fecha_inicio->Disabled && !isset($puesto->fecha_inicio->EditAttrs["readonly"]) && !isset($puesto->fecha_inicio->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fpuestogrid", "x<?php echo $puesto_grid->RowIndex ?>_fecha_inicio", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($puesto->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_fecha_inicio" class="puesto_fecha_inicio">
<span<?php echo $puesto->fecha_inicio->ViewAttributes() ?>>
<?php echo $puesto->fecha_inicio->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="puesto" data-field="x_fecha_inicio" name="x<?php echo $puesto_grid->RowIndex ?>_fecha_inicio" id="x<?php echo $puesto_grid->RowIndex ?>_fecha_inicio" value="<?php echo ew_HtmlEncode($puesto->fecha_inicio->FormValue) ?>">
<input type="hidden" data-table="puesto" data-field="x_fecha_inicio" name="o<?php echo $puesto_grid->RowIndex ?>_fecha_inicio" id="o<?php echo $puesto_grid->RowIndex ?>_fecha_inicio" value="<?php echo ew_HtmlEncode($puesto->fecha_inicio->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($puesto->fecha_fin->Visible) { // fecha_fin ?>
		<td data-name="fecha_fin"<?php echo $puesto->fecha_fin->CellAttributes() ?>>
<?php if ($puesto->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_fecha_fin" class="form-group puesto_fecha_fin">
<input type="text" data-table="puesto" data-field="x_fecha_fin" data-format="7" name="x<?php echo $puesto_grid->RowIndex ?>_fecha_fin" id="x<?php echo $puesto_grid->RowIndex ?>_fecha_fin" placeholder="<?php echo ew_HtmlEncode($puesto->fecha_fin->getPlaceHolder()) ?>" value="<?php echo $puesto->fecha_fin->EditValue ?>"<?php echo $puesto->fecha_fin->EditAttributes() ?>>
<?php if (!$puesto->fecha_fin->ReadOnly && !$puesto->fecha_fin->Disabled && !isset($puesto->fecha_fin->EditAttrs["readonly"]) && !isset($puesto->fecha_fin->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fpuestogrid", "x<?php echo $puesto_grid->RowIndex ?>_fecha_fin", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<input type="hidden" data-table="puesto" data-field="x_fecha_fin" name="o<?php echo $puesto_grid->RowIndex ?>_fecha_fin" id="o<?php echo $puesto_grid->RowIndex ?>_fecha_fin" value="<?php echo ew_HtmlEncode($puesto->fecha_fin->OldValue) ?>">
<?php } ?>
<?php if ($puesto->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_fecha_fin" class="form-group puesto_fecha_fin">
<input type="text" data-table="puesto" data-field="x_fecha_fin" data-format="7" name="x<?php echo $puesto_grid->RowIndex ?>_fecha_fin" id="x<?php echo $puesto_grid->RowIndex ?>_fecha_fin" placeholder="<?php echo ew_HtmlEncode($puesto->fecha_fin->getPlaceHolder()) ?>" value="<?php echo $puesto->fecha_fin->EditValue ?>"<?php echo $puesto->fecha_fin->EditAttributes() ?>>
<?php if (!$puesto->fecha_fin->ReadOnly && !$puesto->fecha_fin->Disabled && !isset($puesto->fecha_fin->EditAttrs["readonly"]) && !isset($puesto->fecha_fin->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fpuestogrid", "x<?php echo $puesto_grid->RowIndex ?>_fecha_fin", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($puesto->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_fecha_fin" class="puesto_fecha_fin">
<span<?php echo $puesto->fecha_fin->ViewAttributes() ?>>
<?php echo $puesto->fecha_fin->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="puesto" data-field="x_fecha_fin" name="x<?php echo $puesto_grid->RowIndex ?>_fecha_fin" id="x<?php echo $puesto_grid->RowIndex ?>_fecha_fin" value="<?php echo ew_HtmlEncode($puesto->fecha_fin->FormValue) ?>">
<input type="hidden" data-table="puesto" data-field="x_fecha_fin" name="o<?php echo $puesto_grid->RowIndex ?>_fecha_fin" id="o<?php echo $puesto_grid->RowIndex ?>_fecha_fin" value="<?php echo ew_HtmlEncode($puesto->fecha_fin->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($puesto->status->Visible) { // status ?>
		<td data-name="status"<?php echo $puesto->status->CellAttributes() ?>>
<?php if ($puesto->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_status" class="form-group puesto_status">
<select data-table="puesto" data-field="x_status" data-value-separator="<?php echo ew_HtmlEncode(is_array($puesto->status->DisplayValueSeparator) ? json_encode($puesto->status->DisplayValueSeparator) : $puesto->status->DisplayValueSeparator) ?>" id="x<?php echo $puesto_grid->RowIndex ?>_status" name="x<?php echo $puesto_grid->RowIndex ?>_status"<?php echo $puesto->status->EditAttributes() ?>>
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
if (@$emptywrk) $puesto->status->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-table="puesto" data-field="x_status" name="o<?php echo $puesto_grid->RowIndex ?>_status" id="o<?php echo $puesto_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($puesto->status->OldValue) ?>">
<?php } ?>
<?php if ($puesto->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_status" class="form-group puesto_status">
<select data-table="puesto" data-field="x_status" data-value-separator="<?php echo ew_HtmlEncode(is_array($puesto->status->DisplayValueSeparator) ? json_encode($puesto->status->DisplayValueSeparator) : $puesto->status->DisplayValueSeparator) ?>" id="x<?php echo $puesto_grid->RowIndex ?>_status" name="x<?php echo $puesto_grid->RowIndex ?>_status"<?php echo $puesto->status->EditAttributes() ?>>
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
if (@$emptywrk) $puesto->status->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($puesto->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $puesto_grid->RowCnt ?>_puesto_status" class="puesto_status">
<span<?php echo $puesto->status->ViewAttributes() ?>>
<?php echo $puesto->status->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="puesto" data-field="x_status" name="x<?php echo $puesto_grid->RowIndex ?>_status" id="x<?php echo $puesto_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($puesto->status->FormValue) ?>">
<input type="hidden" data-table="puesto" data-field="x_status" name="o<?php echo $puesto_grid->RowIndex ?>_status" id="o<?php echo $puesto_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($puesto->status->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$puesto_grid->ListOptions->Render("body", "right", $puesto_grid->RowCnt);
?>
	</tr>
<?php if ($puesto->RowType == EW_ROWTYPE_ADD || $puesto->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fpuestogrid.UpdateOpts(<?php echo $puesto_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($puesto->CurrentAction <> "gridadd" || $puesto->CurrentMode == "copy")
		if (!$puesto_grid->Recordset->EOF) $puesto_grid->Recordset->MoveNext();
}
?>
<?php
	if ($puesto->CurrentMode == "add" || $puesto->CurrentMode == "copy" || $puesto->CurrentMode == "edit") {
		$puesto_grid->RowIndex = '$rowindex$';
		$puesto_grid->LoadDefaultValues();

		// Set row properties
		$puesto->ResetAttrs();
		$puesto->RowAttrs = array_merge($puesto->RowAttrs, array('data-rowindex'=>$puesto_grid->RowIndex, 'id'=>'r0_puesto', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($puesto->RowAttrs["class"], "ewTemplate");
		$puesto->RowType = EW_ROWTYPE_ADD;

		// Render row
		$puesto_grid->RenderRow();

		// Render list options
		$puesto_grid->RenderListOptions();
		$puesto_grid->StartRowCnt = 0;
?>
	<tr<?php echo $puesto->RowAttributes() ?>>
<?php

// Render list options (body, left)
$puesto_grid->ListOptions->Render("body", "left", $puesto_grid->RowIndex);
?>
	<?php if ($puesto->idpuesto_tipo->Visible) { // idpuesto_tipo ?>
		<td data-name="idpuesto_tipo">
<?php if ($puesto->CurrentAction <> "F") { ?>
<?php if ($puesto->idpuesto_tipo->getSessionValue() <> "") { ?>
<span id="el$rowindex$_puesto_idpuesto_tipo" class="form-group puesto_idpuesto_tipo">
<span<?php echo $puesto->idpuesto_tipo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $puesto->idpuesto_tipo->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" name="x<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" value="<?php echo ew_HtmlEncode($puesto->idpuesto_tipo->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_puesto_idpuesto_tipo" class="form-group puesto_idpuesto_tipo">
<select data-table="puesto" data-field="x_idpuesto_tipo" data-value-separator="<?php echo ew_HtmlEncode(is_array($puesto->idpuesto_tipo->DisplayValueSeparator) ? json_encode($puesto->idpuesto_tipo->DisplayValueSeparator) : $puesto->idpuesto_tipo->DisplayValueSeparator) ?>" id="x<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" name="x<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo"<?php echo $puesto->idpuesto_tipo->EditAttributes() ?>>
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
if (@$emptywrk) $puesto->idpuesto_tipo->OldValue = "";
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
<input type="hidden" name="s_x<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" id="s_x<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" value="<?php echo $puesto->idpuesto_tipo->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_puesto_idpuesto_tipo" class="form-group puesto_idpuesto_tipo">
<span<?php echo $puesto->idpuesto_tipo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $puesto->idpuesto_tipo->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="puesto" data-field="x_idpuesto_tipo" name="x<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" id="x<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" value="<?php echo ew_HtmlEncode($puesto->idpuesto_tipo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="puesto" data-field="x_idpuesto_tipo" name="o<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" id="o<?php echo $puesto_grid->RowIndex ?>_idpuesto_tipo" value="<?php echo ew_HtmlEncode($puesto->idpuesto_tipo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($puesto->idpersona->Visible) { // idpersona ?>
		<td data-name="idpersona">
<?php if ($puesto->CurrentAction <> "F") { ?>
<?php if ($puesto->idpersona->getSessionValue() <> "") { ?>
<span id="el$rowindex$_puesto_idpersona" class="form-group puesto_idpersona">
<span<?php echo $puesto->idpersona->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $puesto->idpersona->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $puesto_grid->RowIndex ?>_idpersona" name="x<?php echo $puesto_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($puesto->idpersona->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_puesto_idpersona" class="form-group puesto_idpersona">
<select data-table="puesto" data-field="x_idpersona" data-value-separator="<?php echo ew_HtmlEncode(is_array($puesto->idpersona->DisplayValueSeparator) ? json_encode($puesto->idpersona->DisplayValueSeparator) : $puesto->idpersona->DisplayValueSeparator) ?>" id="x<?php echo $puesto_grid->RowIndex ?>_idpersona" name="x<?php echo $puesto_grid->RowIndex ?>_idpersona"<?php echo $puesto->idpersona->EditAttributes() ?>>
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
if (@$emptywrk) $puesto->idpersona->OldValue = "";
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
<input type="hidden" name="s_x<?php echo $puesto_grid->RowIndex ?>_idpersona" id="s_x<?php echo $puesto_grid->RowIndex ?>_idpersona" value="<?php echo $puesto->idpersona->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_puesto_idpersona" class="form-group puesto_idpersona">
<span<?php echo $puesto->idpersona->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $puesto->idpersona->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="puesto" data-field="x_idpersona" name="x<?php echo $puesto_grid->RowIndex ?>_idpersona" id="x<?php echo $puesto_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($puesto->idpersona->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="puesto" data-field="x_idpersona" name="o<?php echo $puesto_grid->RowIndex ?>_idpersona" id="o<?php echo $puesto_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($puesto->idpersona->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($puesto->idfederacion->Visible) { // idfederacion ?>
		<td data-name="idfederacion">
<?php if ($puesto->CurrentAction <> "F") { ?>
<span id="el$rowindex$_puesto_idfederacion" class="form-group puesto_idfederacion">
<select data-table="puesto" data-field="x_idfederacion" data-value-separator="<?php echo ew_HtmlEncode(is_array($puesto->idfederacion->DisplayValueSeparator) ? json_encode($puesto->idfederacion->DisplayValueSeparator) : $puesto->idfederacion->DisplayValueSeparator) ?>" id="x<?php echo $puesto_grid->RowIndex ?>_idfederacion" name="x<?php echo $puesto_grid->RowIndex ?>_idfederacion"<?php echo $puesto->idfederacion->EditAttributes() ?>>
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
if (@$emptywrk) $puesto->idfederacion->OldValue = "";
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
<input type="hidden" name="s_x<?php echo $puesto_grid->RowIndex ?>_idfederacion" id="s_x<?php echo $puesto_grid->RowIndex ?>_idfederacion" value="<?php echo $puesto->idfederacion->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_puesto_idfederacion" class="form-group puesto_idfederacion">
<span<?php echo $puesto->idfederacion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $puesto->idfederacion->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="puesto" data-field="x_idfederacion" name="x<?php echo $puesto_grid->RowIndex ?>_idfederacion" id="x<?php echo $puesto_grid->RowIndex ?>_idfederacion" value="<?php echo ew_HtmlEncode($puesto->idfederacion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="puesto" data-field="x_idfederacion" name="o<?php echo $puesto_grid->RowIndex ?>_idfederacion" id="o<?php echo $puesto_grid->RowIndex ?>_idfederacion" value="<?php echo ew_HtmlEncode($puesto->idfederacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($puesto->idorgano->Visible) { // idorgano ?>
		<td data-name="idorgano">
<?php if ($puesto->CurrentAction <> "F") { ?>
<span id="el$rowindex$_puesto_idorgano" class="form-group puesto_idorgano">
<select data-table="puesto" data-field="x_idorgano" data-value-separator="<?php echo ew_HtmlEncode(is_array($puesto->idorgano->DisplayValueSeparator) ? json_encode($puesto->idorgano->DisplayValueSeparator) : $puesto->idorgano->DisplayValueSeparator) ?>" id="x<?php echo $puesto_grid->RowIndex ?>_idorgano" name="x<?php echo $puesto_grid->RowIndex ?>_idorgano"<?php echo $puesto->idorgano->EditAttributes() ?>>
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
if (@$emptywrk) $puesto->idorgano->OldValue = "";
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
<input type="hidden" name="s_x<?php echo $puesto_grid->RowIndex ?>_idorgano" id="s_x<?php echo $puesto_grid->RowIndex ?>_idorgano" value="<?php echo $puesto->idorgano->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_puesto_idorgano" class="form-group puesto_idorgano">
<span<?php echo $puesto->idorgano->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $puesto->idorgano->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="puesto" data-field="x_idorgano" name="x<?php echo $puesto_grid->RowIndex ?>_idorgano" id="x<?php echo $puesto_grid->RowIndex ?>_idorgano" value="<?php echo ew_HtmlEncode($puesto->idorgano->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="puesto" data-field="x_idorgano" name="o<?php echo $puesto_grid->RowIndex ?>_idorgano" id="o<?php echo $puesto_grid->RowIndex ?>_idorgano" value="<?php echo ew_HtmlEncode($puesto->idorgano->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($puesto->fecha_inicio->Visible) { // fecha_inicio ?>
		<td data-name="fecha_inicio">
<?php if ($puesto->CurrentAction <> "F") { ?>
<span id="el$rowindex$_puesto_fecha_inicio" class="form-group puesto_fecha_inicio">
<input type="text" data-table="puesto" data-field="x_fecha_inicio" data-format="7" name="x<?php echo $puesto_grid->RowIndex ?>_fecha_inicio" id="x<?php echo $puesto_grid->RowIndex ?>_fecha_inicio" placeholder="<?php echo ew_HtmlEncode($puesto->fecha_inicio->getPlaceHolder()) ?>" value="<?php echo $puesto->fecha_inicio->EditValue ?>"<?php echo $puesto->fecha_inicio->EditAttributes() ?>>
<?php if (!$puesto->fecha_inicio->ReadOnly && !$puesto->fecha_inicio->Disabled && !isset($puesto->fecha_inicio->EditAttrs["readonly"]) && !isset($puesto->fecha_inicio->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fpuestogrid", "x<?php echo $puesto_grid->RowIndex ?>_fecha_inicio", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_puesto_fecha_inicio" class="form-group puesto_fecha_inicio">
<span<?php echo $puesto->fecha_inicio->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $puesto->fecha_inicio->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="puesto" data-field="x_fecha_inicio" name="x<?php echo $puesto_grid->RowIndex ?>_fecha_inicio" id="x<?php echo $puesto_grid->RowIndex ?>_fecha_inicio" value="<?php echo ew_HtmlEncode($puesto->fecha_inicio->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="puesto" data-field="x_fecha_inicio" name="o<?php echo $puesto_grid->RowIndex ?>_fecha_inicio" id="o<?php echo $puesto_grid->RowIndex ?>_fecha_inicio" value="<?php echo ew_HtmlEncode($puesto->fecha_inicio->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($puesto->fecha_fin->Visible) { // fecha_fin ?>
		<td data-name="fecha_fin">
<?php if ($puesto->CurrentAction <> "F") { ?>
<span id="el$rowindex$_puesto_fecha_fin" class="form-group puesto_fecha_fin">
<input type="text" data-table="puesto" data-field="x_fecha_fin" data-format="7" name="x<?php echo $puesto_grid->RowIndex ?>_fecha_fin" id="x<?php echo $puesto_grid->RowIndex ?>_fecha_fin" placeholder="<?php echo ew_HtmlEncode($puesto->fecha_fin->getPlaceHolder()) ?>" value="<?php echo $puesto->fecha_fin->EditValue ?>"<?php echo $puesto->fecha_fin->EditAttributes() ?>>
<?php if (!$puesto->fecha_fin->ReadOnly && !$puesto->fecha_fin->Disabled && !isset($puesto->fecha_fin->EditAttrs["readonly"]) && !isset($puesto->fecha_fin->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fpuestogrid", "x<?php echo $puesto_grid->RowIndex ?>_fecha_fin", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_puesto_fecha_fin" class="form-group puesto_fecha_fin">
<span<?php echo $puesto->fecha_fin->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $puesto->fecha_fin->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="puesto" data-field="x_fecha_fin" name="x<?php echo $puesto_grid->RowIndex ?>_fecha_fin" id="x<?php echo $puesto_grid->RowIndex ?>_fecha_fin" value="<?php echo ew_HtmlEncode($puesto->fecha_fin->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="puesto" data-field="x_fecha_fin" name="o<?php echo $puesto_grid->RowIndex ?>_fecha_fin" id="o<?php echo $puesto_grid->RowIndex ?>_fecha_fin" value="<?php echo ew_HtmlEncode($puesto->fecha_fin->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($puesto->status->Visible) { // status ?>
		<td data-name="status">
<?php if ($puesto->CurrentAction <> "F") { ?>
<span id="el$rowindex$_puesto_status" class="form-group puesto_status">
<select data-table="puesto" data-field="x_status" data-value-separator="<?php echo ew_HtmlEncode(is_array($puesto->status->DisplayValueSeparator) ? json_encode($puesto->status->DisplayValueSeparator) : $puesto->status->DisplayValueSeparator) ?>" id="x<?php echo $puesto_grid->RowIndex ?>_status" name="x<?php echo $puesto_grid->RowIndex ?>_status"<?php echo $puesto->status->EditAttributes() ?>>
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
if (@$emptywrk) $puesto->status->OldValue = "";
?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_puesto_status" class="form-group puesto_status">
<span<?php echo $puesto->status->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $puesto->status->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="puesto" data-field="x_status" name="x<?php echo $puesto_grid->RowIndex ?>_status" id="x<?php echo $puesto_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($puesto->status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="puesto" data-field="x_status" name="o<?php echo $puesto_grid->RowIndex ?>_status" id="o<?php echo $puesto_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($puesto->status->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$puesto_grid->ListOptions->Render("body", "right", $puesto_grid->RowCnt);
?>
<script type="text/javascript">
fpuestogrid.UpdateOpts(<?php echo $puesto_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($puesto->CurrentMode == "add" || $puesto->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $puesto_grid->FormKeyCountName ?>" id="<?php echo $puesto_grid->FormKeyCountName ?>" value="<?php echo $puesto_grid->KeyCount ?>">
<?php echo $puesto_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($puesto->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $puesto_grid->FormKeyCountName ?>" id="<?php echo $puesto_grid->FormKeyCountName ?>" value="<?php echo $puesto_grid->KeyCount ?>">
<?php echo $puesto_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($puesto->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fpuestogrid">
</div>
<?php

// Close recordset
if ($puesto_grid->Recordset)
	$puesto_grid->Recordset->Close();
?>
</div>
</div>
<?php } ?>
<?php if ($puesto_grid->TotalRecs == 0 && $puesto->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($puesto_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($puesto->Export == "") { ?>
<script type="text/javascript">
fpuestogrid.Init();
</script>
<?php } ?>
<?php
$puesto_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$puesto_grid->Page_Terminate();
?>
