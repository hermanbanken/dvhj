<div class="masthead">
  <ul class="nav nav-pills pull-right">
		<?php if(Auth::instance()->logged_in()): ?>
      <li><a href="<?php echo URL::site("auth/logout"); ?>"><?php echo __("Afmelden"); ?></a></li>
    <?php endif; ?>
		<li><?php if($lang == 'nl'): ?>
			<a href="?lang=en<?php if(isset($token)) echo "&token=$token" ?>" lang="en"><img class="language-icon" src="<?php echo URL::site('assets/img/en.png'); ?>" width="16" height="11" alt="English" title="English"> English</a>
			<?php else: ?>
			<a href="?lang=nl<?php if(isset($token)) echo "&token=$token" ?>" lang="nl"><img class="language-icon" src="<?php echo URL::site('assets/img/nl.png'); ?>" width="16" height="11" alt="English" title="Nederlands"> Nederlands</a>
			<?php endif; ?>
		</li>
	</ul>
  <h3 class="muted"><?php echo $page_title; ?></h3>
</div>