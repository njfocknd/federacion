<?php

// nombre
// siglas

?>
<?php if ($deporte->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $deporte->TableCaption() ?></h4> -->
<table id="tbl_deportemaster" class="table table-bordered table-striped ewViewTable">
<?php echo $deporte->TableCustomInnerHtml ?>
	<tbody>
<?php if ($deporte->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $deporte->nombre->FldCaption() ?></td>
			<td<?php echo $deporte->nombre->CellAttributes() ?>>
<span id="el_deporte_nombre">
<span<?php echo $deporte->nombre->ViewAttributes() ?>>
<?php echo $deporte->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($deporte->siglas->Visible) { // siglas ?>
		<tr id="r_siglas">
			<td><?php echo $deporte->siglas->FldCaption() ?></td>
			<td<?php echo $deporte->siglas->CellAttributes() ?>>
<span id="el_deporte_siglas">
<span<?php echo $deporte->siglas->ViewAttributes() ?>>
<?php echo $deporte->siglas->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
