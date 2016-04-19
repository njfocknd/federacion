<?php

// nombre
// siglas

?>
<?php if ($federacion_tipo->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $federacion_tipo->TableCaption() ?></h4> -->
<table id="tbl_federacion_tipomaster" class="table table-bordered table-striped ewViewTable">
<?php echo $federacion_tipo->TableCustomInnerHtml ?>
	<tbody>
<?php if ($federacion_tipo->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $federacion_tipo->nombre->FldCaption() ?></td>
			<td<?php echo $federacion_tipo->nombre->CellAttributes() ?>>
<span id="el_federacion_tipo_nombre">
<span<?php echo $federacion_tipo->nombre->ViewAttributes() ?>>
<?php echo $federacion_tipo->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($federacion_tipo->siglas->Visible) { // siglas ?>
		<tr id="r_siglas">
			<td><?php echo $federacion_tipo->siglas->FldCaption() ?></td>
			<td<?php echo $federacion_tipo->siglas->CellAttributes() ?>>
<span id="el_federacion_tipo_siglas">
<span<?php echo $federacion_tipo->siglas->ViewAttributes() ?>>
<?php echo $federacion_tipo->siglas->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
