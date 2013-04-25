<form method="get" id="form-selected-courses">
<h2>1. Gevolgde vakken <small>Zoek je vakken</small></h2>
<div class="row-fluid courses">
	<div class="span6">
		Selecteer je programma: <br>
		<div class="input-append course-finder-program">
			<select name="new[program]">
				<option value="">--- programma ---</option>
				<?php foreach($programs as $program){
					echo "<option value='$program->id'>$program->name</option>";
				} ?>
			</select>
			<button type="submit" class="btn btn-primary">Voeg toe</button>
		</div>
		
		<br> &oacute;f typ de naam van een vak: <br>
		<div class="input-append course-finder-name">
			<input id="new-course" name="new[course]" type="text" data-provide="typeahead" />
		  <button class="btn btn-primary" type="submit">Voeg toe</button>
		</div>
		

		<br> &oacute;f typ de naam van een docent: <br>
		<div class="input-append course-finder-teacher">
			<input id="new-nominee" name="new[nominee]" type="text" data-provide="typeahead" />
		  <button class="btn btn-primary" type="submit">Voeg toe</button>
		</div>
	</div>
	<div class="span6 selected-courses">
		Momenteel geselecteerde vakken<span class="course-count"></span>: <button data-toggle="modal" data-target="#reset-confirm" class="pull-right btn btn-danger btn-mini">Reset</button>
		<table class="table table-striped table-bordered table-condensed" id="courses-visible">
			<thead>
				<th></th>
				<th>Code</th>
				<th>Naam</th>
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
				<tr><td colspan="3">Zoek links vakken en voeg ze toe aan deze lijst.</td></tr>
			</tfoot>
		</table>
	</div>
</div>
<!-- Modal -->
<div id="reset-confirm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="Sluit" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Waarschuwing</h3>
  </div>
  <div class="modal-body">
    <p>Weet u zeker dat u de geselecteerde vakken wilt resetten? De bijbehorende docenten verdwijnen dan weer.</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Annuleren</button>
    <input type="reset" class="btn btn-primary" value="OK" />
  </div>
</div>
</form>