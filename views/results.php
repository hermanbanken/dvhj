<div class="container-fluid">
<div class="row-fluid halfs-needed-1200">
<?php foreach($studies as $name => $results): ?>
	<div class="half span6 half-<?php echo $name; ?>">
		<table>
			<tr><th>Aantal stemmers</th><td><?php print_r ($results['student_count']); ?></td></tr>
			<tr><th>Aantal gestemde docenten</th><td><?php print_r( $results['tutor_count']); ?></td></tr>
			<tr><th>Aantal stemmen</th><td><?php print_r( $results['vote_count']); ?></td></tr>
		</table>
	</div>
<?php endforeach; ?>
</div>
</div>
