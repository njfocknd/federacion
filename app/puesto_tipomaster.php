<?php

// nombre
?>
<?php if ($puesto_tipo->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $puesto_tipo->TableCaption() ?></h4> -->
<table id="tbl_puesto_tipomaster" class="table table-bordered table-striped ewViewTable">
<?php echo $puesto_tipo->TableCustomInnerHtml ?>
	<tbody>
<?php if ($puesto_tipo->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $puesto_tipo->nombre->FldCaption() ?></td>
			<td<?php echo $puesto_tipo->nombre->CellAttributes() ?>>
<span id="el_puesto_tipo_nombre">
<span<?php echo $puesto_tipo->nombre->ViewAttributes() ?>>
<?php echo $puesto_tipo->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
