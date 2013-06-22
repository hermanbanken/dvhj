<div class="container-fluid">
<?php if($bayes): ?>
	<p><?php echo __("ranking_expl"); ?></p>
<?php endif; ?>
<div class="row-fluid halfs-needed-1200">
<?php foreach($studies as $name => $scores): ?>
	<div class="half span6 half-<?php echo $name; ?>">
<?php if(count($scores) > 0) include 'template/scores.php'; ?>
	</div>
<?php endforeach; ?>
</div>
<div id="refs">
	<ul><li>[1] - <a href="http://leedumond.com/blog/the-wisdom-of-crowds-implementing-a-smart-ranking-algorithm/">The Wisdom of Crowds: Implementing a Smart Ranking Algorithm</a></li></ul>
</div>
</div>