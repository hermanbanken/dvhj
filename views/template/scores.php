<h2>Tussenstand <?php echo $name; ?></h2>
<?php 
$rows = array_merge(array(array(5, 4, 3)), count($scores) - 3 > 0 ? array_fill(0, count($scores)-3, array(3,3,3,3)) : array());
$badges = array_merge(array("gold", "", "warning"), count($scores) - 3 > 0 ? array_fill(0, count($scores) - 3, "important") : array());
$i = 1;

if($name == "TW"){
	$tmp = $scores[2];
	$scores[2] = $scores[0];
	$scores[0] = $tmp;
	$rows[0] = array(3, 4, 5);
	$badges[0] = "warning"; $badges[2] = "gold";
}

if(!function_exists("score")){
function score($name, $i){
	if($i == 1 && $name == "TW") return 3;
	if($i == 3 && $name == "TW") return 1;
	return $i;
}}

foreach($rows as $row): if(count($scores) > 0): ?>
<div class="row-fluid">
	<?php foreach($row as $col): if(count($scores) > 0): ?>
		<div class="span<?php echo $col; ?>">
			<div class="tutor score-<?php echo score($name, $i++); ?>">
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
						<i class="icon-pencil"></i>
						<?php echo $amount; ?></span>
				</span>
				<img src="<?php echo $img; ?>" style="width: 100%;" />
				<div class="score"><?php echo number_format($score, 1); ?></div>
			</div>
		</div>
	<?php endif; endforeach; ?>
</div>
<?php endif; endforeach; ?>