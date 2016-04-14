<?php

// nombre
// siglas
// gentilicio_masculino
// gentilicio_femenino

?>
<?php if ($pais->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $pais->TableCaption() ?></h4> -->
<table id="tbl_paismaster" class="table table-bordered table-striped ewViewTable">
<?php echo $pais->TableCustomInnerHtml ?>
	<tbody>
<?php if ($pais->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $pais->nombre->FldCaption() ?></td>
			<td<?php echo $pais->nombre->CellAttributes() ?>>
<span id="el_pais_nombre">
<span<?php echo $pais->nombre->ViewAttributes() ?>>
<?php echo $pais->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($pais->siglas->Visible) { // siglas ?>
		<tr id="r_siglas">
			<td><?php echo $pais->siglas->FldCaption() ?></td>
			<td<?php echo $pais->siglas->CellAttributes() ?>>
<span id="el_pais_siglas">
<span<?php echo $pais->siglas->ViewAttributes() ?>>
<?php echo $pais->siglas->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($pais->gentilicio_masculino->Visible) { // gentilicio_masculino ?>
		<tr id="r_gentilicio_masculino">
			<td><?php echo $pais->gentilicio_masculino->FldCaption() ?></td>
			<td<?php echo $pais->gentilicio_masculino->CellAttributes() ?>>
<span id="el_pais_gentilicio_masculino">
<span<?php echo $pais->gentilicio_masculino->ViewAttributes() ?>>
<?php echo $pais->gentilicio_masculino->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($pais->gentilicio_femenino->Visible) { // gentilicio_femenino ?>
		<tr id="r_gentilicio_femenino">
			<td><?php echo $pais->gentilicio_femenino->FldCaption() ?></td>
			<td<?php echo $pais->gentilicio_femenino->CellAttributes() ?>>
<span id="el_pais_gentilicio_femenino">
<span<?php echo $pais->gentilicio_femenino->ViewAttributes() ?>>
<?php echo $pais->gentilicio_femenino->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
