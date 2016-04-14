<?php

// nombre
// siglas
// idpais

?>
<?php if ($departamento->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $departamento->TableCaption() ?></h4> -->
<table id="tbl_departamentomaster" class="table table-bordered table-striped ewViewTable">
<?php echo $departamento->TableCustomInnerHtml ?>
	<tbody>
<?php if ($departamento->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $departamento->nombre->FldCaption() ?></td>
			<td<?php echo $departamento->nombre->CellAttributes() ?>>
<span id="el_departamento_nombre">
<span<?php echo $departamento->nombre->ViewAttributes() ?>>
<?php echo $departamento->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($departamento->siglas->Visible) { // siglas ?>
		<tr id="r_siglas">
			<td><?php echo $departamento->siglas->FldCaption() ?></td>
			<td<?php echo $departamento->siglas->CellAttributes() ?>>
<span id="el_departamento_siglas">
<span<?php echo $departamento->siglas->ViewAttributes() ?>>
<?php echo $departamento->siglas->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($departamento->idpais->Visible) { // idpais ?>
		<tr id="r_idpais">
			<td><?php echo $departamento->idpais->FldCaption() ?></td>
			<td<?php echo $departamento->idpais->CellAttributes() ?>>
<span id="el_departamento_idpais">
<span<?php echo $departamento->idpais->ViewAttributes() ?>>
<?php echo $departamento->idpais->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
