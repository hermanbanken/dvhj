<form method="get" id="form-selected-courses">
<h2>1. <?php echo __("Gevolgde vakken"); ?> <small><?php echo __("Zoek je vakken"); ?></small></h2>
<div class="row-fluid courses">
	<div class="span6">
		<?php echo __("Selecteer je programma"); ?>: <br>
		<div class="input-append course-finder-program">
			<select name="new[program]">
				<option value="">--- <?php echo __("programma"); ?> ---</option>
				<?php foreach($programs as $program){
					echo "<option value='$program->id'>$program->name</option>";
				} ?>
			</select>
			<button type="submit" class="btn btn-primary"><?php echo __("Voeg toe"); ?></button>
		</div>
		
		<br> <?php echo __("&oacute;f typ de naam van een vak"); ?>: <br>
		<div class="input-append course-finder-name">
			<input id="new-course" name="new[course]" type="text" data-provide="typeahead" />
		  <button class="btn btn-primary" type="submit"><?php echo __("Voeg toe"); ?></button>
		</div>
		

		<br> <?php echo __("&oacute;f typ de naam van een docent"); ?>: <br>
		<div class="input-append course-finder-teacher">
			<input id="new-nominee" name="new[nominee]" type="text" data-provide="typeahead" />
		  <button class="btn btn-primary" type="submit"><?php echo __("Voeg toe"); ?></button>
		</div>
	</div>
	<div class="span6 selected-courses">
		<?php echo __("Momenteel geselecteerde vakken"); ?> <span class="course-count"></span>: <button data-toggle="modal" data-target="#reset-confirm" class="pull-right btn btn-danger btn-mini">Reset</button>
		<table class="table table-striped table-bordered table-condensed" id="courses-visible">
			<thead>
				<th></th>
				<th><?php echo __("Code"); ?></th>
				<th><?php echo __("Naam"); ?></th>
			</thead>
			<tbody>
				<?php foreach($courses as $course): ?>
				<tr class="course-<?php echo $course->id ?>">
					<td>
						<a class="delete" href="#"><i class="icon-trash"></i></a>
						<input type="hidden" name="course[]" class="course-id" value="<?php echo $course->id; ?>">
					</td>
					<td><?php echo $course->code; ?></td>
					<td><?php echo $course->name; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr><td colspan="3"><?php echo __("Zoek links vakken en voeg ze toe aan deze lijst."); ?></td></tr>
			</tfoot>
		</table>
	</div>
</div>
<!-- Modal -->
<div id="reset-confirm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="Sluit" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><?php echo __("Waarschuwing"); ?></h3>
  </div>
  <div class="modal-body">
    <p><?php echo __("Weet u zeker dat u de geselecteerde vakken wilt resetten? De bijbehorende docenten verdwijnen dan weer."); ?></p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo __("Annuleren"); ?></button>
    <input type="reset" class="btn btn-primary" value="OK" />
  </div>
</div>
</form>