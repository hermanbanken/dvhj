<?php 
$rows = array_merge(array(array(5, 4, 3)), array_fill(0, count($scores)-3, array(3,3,3,3)));
$badges = array_merge(array("gold", "", "warning"), array_fill(0, count($scores) - 3, "important"));
$i = 1;

foreach($rows as $row): ?>
<div class="row-fluid">
	<?php foreach($row as $col): if(count($scores) > 0): ?>
		<div class="span<?php echo $col; ?>">
			<div class="tutor score-<?php echo $i++; ?>">
				<?php
				list($tutor, $score, $amount) = array_shift($scores);
				$badge = array_shift($badges);
				
				if(empty($tutor->photo)){
					$mail = $tutor->mail;
					$img = "//www.gravatar.com/avatar/".md5(strtolower(trim($mail)))."?d=mm&s=200";
				} else {
					$img = URL::site("imagefly/w300-c/".$tutor->photo);
				}
				?>
				<span class="name">
					<?php echo $tutor->name; ?>
					<span class="pull-right votes badge<?php if($badge) echo " badge-".$badge; ?>">
						<i class="icon-eye-open"></i>
						<?php echo $amount; ?></span>
				</span>
				<img src="<?php echo $img; ?>" style="width: 100%;" />
				<div class="score"><?php echo number_format($score, 0); ?></div>
			</div>
		</div>
	<?php endif; endforeach; ?>
</div>
<?php endforeach; ?>
<div class="clearfix"></div>