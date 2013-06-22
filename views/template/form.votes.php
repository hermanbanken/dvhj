<form method="get" id="form-votes">
<div class="affixed">
	<h2>2. <?php echo __("Docenten"); ?> <small><?php echo __("Geef hieronder je cijfer"); ?></small></h2>
	<div class="row-fluid">
		<div class="progress progress-striped span9">
		  <div class="bar" style="width: 0%;"></div>
		</div>
		<div class="span3">
			<input type="submit" class='btn btn-vote btn-success' value="<?php echo __("Stem opslaan"); ?>" />
		</div>
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
	  <div class="pull-left gravatar">
			<?php
			if(empty($tutor->photo)){
				$mail = $tutor->mail;
				$img = "//www.gravatar.com/avatar/".md5(strtolower(trim($mail)))."?d=mm&s=200";
			} else {
				$img = URL::site("imagefly/w64-c/".$tutor->photo);
			}
			?>
	    <img class="media-object" src="<?php echo $img ?>" />
			<a class="disable"><i class="icon-trash icon-white"></i></a>
		</div>
	  <div class="media-body visible-phone">
	  <?php ob_start(); ?>
	    <h4 class="media-heading"><?php echo $tutor->name; ?></h4>
			<div><?php
			if(!count($courses))
				echo __("er zijn voor deze docent nog geen vakken ingevoerd.");
			else foreach($courses as $course){
				?>
				<span class='badge' data-id="<?php echo $course->id ?>" data-original-title="<?php echo $course->name; ?>" data-toggle="tooltip" data-placement="bottom">
					<?php echo $course->code; ?>
				</span>
				<?php
			}
			?></div>
		<?php $mediabody = ob_get_flush(); ?>
		</div>
		<a class="pull-right motivation">
			<textarea tabindex="<?php echo $tabIndex+1; ?>" name="motivation[<?php echo $tutor->id; ?>]" placeholder="<?php echo __("Motivatie, waarom dit cijfer. Zeker bij een 8 of hoger."); ?>" row="4"><?php echo $vote->why; ?></textarea>
		</a>
	  <a class="pull-right">
			<input tabindex="<?php echo $tabIndex; ?>"  type="number" class="grade" min="1" step="0.5" max="10" placeholder="_._" name="grade[<?php echo $tutor->id; ?>]" value="<?php echo $vote->vote; ?>" />
	  </a>
		<?php $tabIndex += 2; ?>
	  <div class="media-body hidden-phone">
			<?php echo $mediabody; ?>
	  </div>
	</div>
<?php endforeach; ?>
<div class="if-empty"><?php echo __("Er zijn nog geen vakken geselecteerd waar docenten voor ingevoerd zijn. Voeg hierboven meer vakken toe om docenten te beoordelen."); ?></div>
</div>

<!-- Modal -->
<div id="save-confirm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="Sluit" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><?php echo __("Uw stem is ontvangen"); ?></h3>
  </div>
  <div class="modal-body">
    <p><?php echo __("Uw stem is ontvangen. Mocht u deze nog willen uitbreiden/aanpassen dan kan dit nog tot de stemmen sluiten."); ?></p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo __("Aanpassen"); ?></button>
    <a href="<?php echo URL::base(); ?>" class="btn btn-primary">OK</a>
  </div>
</div>

</form>