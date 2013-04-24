<div class="masthead">
  <ul class="nav nav-pills pull-right">
		<?php
		$urls = array(
		"Default" => "Home",
		"Docenten" => "Stemmen"
		);
		foreach($urls as $cont => $title){
			$url = $cont != "Default" ? Route::get('default')->uri(array(
			  'controller' => $cont
			)) : URL::base();
				
			echo Request::$current->controller() == $cont ? "<li class='active'>" : "<li>";
			echo "<a href='$url'>$title</a></li>\n";
		}
		?>
		<?php if(Auth::instance()->logged_in()): ?>
			<li class="dropdown">
		    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
		      <?php echo Auth::instance()->get_user()->name; ?>
		      <b class="caret"></b>
		    </a>
		    <ul class="dropdown-menu">
		      <li><a href="<?php echo URL::base(); ?>auth/logout">Afmelden</a></li>
		    </ul>
		  </li>	
		<?php else: ?>
			<li><a href="<?php echo URL::base(); ?>#login">Aanmelden</a></li>
		<?php endif; ?>
  </ul>
  <h3 class="muted"><?php echo $page_title; ?></h3>
</div>