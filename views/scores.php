<div class="container-fluid">
<div class="row-fluid halfs-needed-1200">
<?php foreach($studies as $name => $scores): ?>
	<div class="half span6 half-<?php echo $name; ?>">
<?php if(count($scores) > 0) include 'template/scores.php'; ?>
	</div>
<?php endforeach; ?>
</div>
</div>