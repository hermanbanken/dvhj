<div class="jumbotron">
  <h1>Beloon je docent voor zijn harde werk</h1>
  <p class="lead">De docenten van de EWI werken hard om jou kennis en vaardigheden bij te brengen. Doe iets terug door op hen te stemmen en je waardering te uiten!</p>
  <form method="post" action="auth/login">
		<?php if(!Auth::instance()->logged_in()): ?>
			<input type="text" name="token" size="5" placeholder="Token" class="token" />
		<?php endif; ?>
		<input
			 type="submit" 
			 class="btn btn-large btn-success" 
			 value="Stem nu" 
			 data-toggle="popover" 
			 data-content="De persoonlijke token die u per mail heeft ontvangen is de code om mee in te loggen." 
			 data-original-title="Aanmelden" />
		<input type="hidden" name="redirect" value="Docenten" />
	</form>
</div>

<hr>

<div class="row-fluid marketing">
  <div class="span6">
    <h4>Gravida</h4>
    <blockquote>
			<p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>
			<small>Joost de Groot, <cite title="TU Delta">winnaar 2012 TU-breed</cite></small>
		</blockquote>
  </div>

  <div class="span6">
    <h4>Maecenas</h4>
    <blockquote>
			<p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>
			<small>Tomas Klos, <cite title="TU Delta">Informatica Docent van het Jaar 2012</cite></small>
		</blockquote>
  </div>
</div>