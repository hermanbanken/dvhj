<div class="jumbotron">
  <?php if(Auth::instance()->logged_in() && Auth::instance()->get_user()->has_voted()): ?>
		<h1>Bedankt</h1>
	  <p class="lead">De docenten van de EWI bedanken je voor je stem!</p>
	  <form method="post" action="auth/login">
			<input type="submit" class="btn btn-large btn-success" value="Stem aanpassen" />
			<input type="hidden" name="redirect" value="Docenten" />
		</form>
	<?php else: ?>
		<h1>Beloon je docent voor zijn harde werk</h1>
	  <p class="lead">De docenten van de EWI werken hard om jou kennis en vaardigheden bij te brengen. Doe iets terug door op hen te stemmen en je waardering te uiten!</p>
	  <form method="post" action="auth/login">
			<?php if(!Auth::instance()->logged_in()): ?>
				<input type="<?php echo !isset($token) || !$token ? 'text' : 'hidden' ?>" name="token" size="5" placeholder="Token" class="token" value="<?php echo htmlentities($token); ?>" />
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
	<?php endif; ?>
</div>

<hr>

<div class="row-fluid">
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

<div class="row-fluid">
  <div class="span6">
    <h4>Inloggen met token</h4>
    <p>Je ontvangt je token per e-mail. Elke student die in het TU adresboek staat als student Wiskunde of Informatica heeft op zijn studentmail een email met daarin een persoonlijke link met ingesloten token ontvangen.</p>
	</div>

  <div class="span6">
    <h4>De verkiezing</h4>
    <p>De Docent van het jaar verkiezing van EWI is een initiatief van de studieverenigingen W.I.S.V. 'Christiaan Huygens' en de ETV in samenwerking met de opleidingsdirectie en Marketing en Communicatie.</p>
  </div>
</div>