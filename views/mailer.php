<form method="post" class="form-horizontal">
	<?php if(isset($message)): ?>
		<div class="alert alert-success">
		  <?php echo $message; ?>
		</div>
	<?php endif; ?>
	
	<?php if(isset($students)): foreach($students as $student): ?>
		<div class='well'><?php include 'template/mail.php'; ?></div>
	<?php endforeach; else: ?>
		<div class='well'><?php include 'template/mail.php'; ?></div>
	<?php endif; ?>
  <div class="control-group">
    <div class="controls">
      <label class="checkbox">
        <input type="checkbox" checked> Zend naar alleen test gebruikers
      </label>
      <button type="submit" class="btn btn-primary">Verstuur</button>
    </div>
  </div>
</form>