<div class="row-fluid"><div class="span12"><p>Stel eerst je vakkenpakket samen. Geef daarna elke docent een cijfer van 1 tot 10. Als je de docent een cijfer van 8 of hoger wil geven, ontvangen we graag een motivatie voor dit cijfer. Heb je een docent niet gehad, dan hoef je die docent geen cijfer te geven.</p></div></div>

<form method="get" id="form-selected-courses">
<h2>Gevolgde vakken</h2>
<div class="row-fluid">
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
		
		<br> of typ de naam van een vak: <br>
		<div class="input-append course-finder-name">
			<input id="new-course" name="new[course]" type="text" data-provide="typeahead" />
		  <button class="btn btn-primary" type="submit">Voeg toe</button>
		</div>
		

		<br> of typ de naam van een docent: <br>
		<div class="input-append course-finder-teacher">
			<input id="new-nominee" name="new[nominee]" type="text" data-provide="typeahead" />
		  <button class="btn btn-primary" type="submit">Voeg toe</button>
		</div>
	</div>
	<div class="span6 selected-courses">
		Geselecteerde vakken<span class="course-count"></span>: <input type="reset" class="pull-right btn btn-warning btn-mini" value="Reset" />
		<table class="table table-striped table-bordered table-condensed" id="courses-visible">
			<thead><th></th><th>Code</th><th>Naam</th></thead>
			<tbody><?php foreach($courses as $course): ?>
				<tr class="course-<?php echo $course->id ?>"><td><a class="delete" href="#"><i class="icon-trash"></i></a><input type="hidden" name="course[]" class="course-id" value="<?php echo $course->id; ?>"></td><td><?php echo $course->code; ?></td><td><?php echo $course->name; ?></td></tr>
			<?php endforeach; ?></tbody>
		</table>
	</div>
</div>
</form>

<hr>

<form method="get" id="form-votes">
<h2>Docenten</h2>
<div class="row-fluid">
	<div class="progress progress-striped span9">
	  <div class="bar" style="width: 0%;"></div>
	</div>
	<div class="span3">
		<input type="submit" class='btn btn-vote btn-success' value="Stem opslaan" />
	</div>
</div>
<div class="tutors visible-tutors">
<?php $tabIndex = 20; ?>
<?php foreach($tutors as $tutor): ?>
	<?php 
		$courses = $tutor->courses->find_all();
		$vote = ORM::factory('Vote');
		foreach($votes as $v){
			if($v->nominee == $tutor->id)
				$vote = $v;
		}
	?>
	<div class="tutor media<?php if(count($courses)) foreach($courses as $course){ echo " course-".$course->id; } ?>">
	  <a class="pull-left gravatar">
			<?php
			if(empty($tutor->photo)){
				$img = "//www.gravatar.com/avatar/".md5(strtolower(trim($tutor->mail)))."?d=mm&s=64";
			} else {
				$img = Photo::resized($tutor->photo, 64);
			}
			?>
	    <img class="media-object" src="<?php echo $img ?>" />
	  </a>
	  <a class="pull-right">
			<textarea tabindex="<?php echo $tabIndex+1; ?>" name="motivation[<?php echo $tutor->id; ?>]" placeholder="Motivatie, waarom dit cijfer. Bij een 8 of hoger verplicht." row="4"><?php echo $vote->why; ?></textarea>
		</a>
	  <a class="pull-right">
			<input tabindex="<?php echo $tabIndex; ?>"  type="number" class="grade" min="1" step="0.5" max="10" placeholder="7.5" name="grade[<?php echo $tutor->id; ?>]" value="<?php echo $vote->vote; ?>" />
	  </a>
		<?php $tabIndex += 2; ?>
	  <div class="media-body">
	    <h4 class="media-heading"><?php echo $tutor->name; ?></h4>
			<div><?php
			if(!count($courses))
				echo "er zijn voor deze docent nog geen vakken ingevoerd.";
			else foreach($courses as $course){
				?>
				<a class='course' href="#" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo $course->name; ?>">
					<?php echo $course->code; ?>
				</a>
				<?php
			}
			?></div>
	  </div>
	</div>
<?php endforeach; ?>
<div class="if-empty">Er zijn nog geen vakken geselecteerd waar docenten voor ingevoerd zijn. Voeg hierboven meer vakken toe om docenten te beoordelen.</div>
</div>

</form>