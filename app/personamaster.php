<?php

// cui
// nombre
// apellido
// direccion
// telefonos

?>
<?php if ($persona->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $persona->TableCaption() ?></h4> -->
<table id="tbl_personamaster" class="table table-bordered table-striped ewViewTable">
<?php echo $persona->TableCustomInnerHtml ?>
	<tbody>
<?php if ($persona->cui->Visible) { // cui ?>
		<tr id="r_cui">
			<td><?php echo $persona->cui->FldCaption() ?></td>
			<td<?php echo $persona->cui->CellAttributes() ?>>
<span id="el_persona_cui">
<span<?php echo $persona->cui->ViewAttributes() ?>>
<?php echo $persona->cui->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($persona->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $persona->nombre->FldCaption() ?></td>
			<td<?php echo $persona->nombre->CellAttributes() ?>>
<span id="el_persona_nombre">
<span<?php echo $persona->nombre->ViewAttributes() ?>>
<?php echo $persona->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($persona->apellido->Visible) { // apellido ?>
		<tr id="r_apellido">
			<td><?php echo $persona->apellido->FldCaption() ?></td>
			<td<?php echo $persona->apellido->CellAttributes() ?>>
<span id="el_persona_apellido">
<span<?php echo $persona->apellido->ViewAttributes() ?>>
<?php echo $persona->apellido->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($persona->direccion->Visible) { // direccion ?>
		<tr id="r_direccion">
			<td><?php echo $persona->direccion->FldCaption() ?></td>
			<td<?php echo $persona->direccion->CellAttributes() ?>>
<span id="el_persona_direccion">
<span<?php echo $persona->direccion->ViewAttributes() ?>>
<?php echo $persona->direccion->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($persona->telefonos->Visible) { // telefonos ?>
		<tr id="r_telefonos">
			<td><?php echo $persona->telefonos->FldCaption() ?></td>
			<td<?php echo $persona->telefonos->CellAttributes() ?>>
<span id="el_persona_telefonos">
<span<?php echo $persona->telefonos->ViewAttributes() ?>>
<?php echo $persona->telefonos->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
