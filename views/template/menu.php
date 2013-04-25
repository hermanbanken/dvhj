<div class="masthead">
  <ul class="nav nav-pills pull-right">
		<?php if(Auth::instance()->logged_in()): ?>
      <li><a href="<?php echo URL::site("auth/logout"); ?>">Afmelden</a></li>
    <?php endif; ?>
  </ul>
  <h3 class="muted"><?php echo $page_title; ?></h3>
</div>