<div class="jumbotron">
  <?php if((Auth::instance()->logged_in() && Auth::instance()->get_user()->has_voted()) || time() > $closesOn): ?>
		<h1><?php echo __("Bedankt"); ?></h1>
	  <p class="lead"><?php echo __("De docenten van de EWI bedanken je voor je stem!"); ?></p>
	  <?php if(time() < $closesOn): ?>
		<form method="post" action="auth/login">
			<input type="submit" class="btn btn-large btn-success" value="<?php echo __("Stem aanpassen"); ?>" />
			<input type="hidden" name="redirect" value="Docenten" />
		</form>
		<?php endif; ?>
	<?php else: ?>
		<h1><?php echo __("Beloon je docent voor zijn harde werk"); ?></h1>
	  <p class="lead"><?php echo __("De docenten van EWI werken hard om jou kennis en vaardigheden bij te brengen. Doe iets terug door op hen te stemmen en je waardering te uiten!"); ?></p>
	  <form method="post" action="auth/login">
			<?php if(!Auth::instance()->logged_in()): ?>
				<input type="<?php echo !isset($token) || !$token ? 'text' : 'hidden' ?>" name="token" size="5" placeholder="Token" class="token" value="<?php echo htmlentities($token); ?>" />
			<?php endif; ?>
			<input
				 type="submit" 
				 class="btn btn-large btn-success" 
				 value="<?php echo __("Stem nu"); ?>" 
				 data-toggle="popover" 
				 data-content="<?php echo __("De persoonlijke token die u per mail heeft ontvangen is de code om mee in te loggen."); ?>" 
				 data-original-title="<?php echo __("Aanmelden"); ?>" />
			<input type="hidden" name="redirect" value="Docenten" />
		</form>
	<?php endif; ?>
</div>

<hr>

<div class="row-fluid">
  <div class="span6">
    <h4><?php echo __("Meer dan een kroon"); ?></h4>
    <blockquote>
			<p>"<?php echo __("Een mooiere beloning kan ik mij niet wensen. TU docent van het jaar is meer dan een kroon op mijn werk. Via deze weg wil ik alle studenten die op mij gestemd hebben nogmaals bijzonder hartelijk danken!"); ?>"</p>
			<small>Joost de Groot, <cite title="TU Delta"><?php echo __("winnaar 2012 TU-breed"); ?></cite></small>
		</blockquote>
  </div>

  <div class="span6">
    <h4><?php echo __("De grootste eer"); ?></h4>
    <blockquote>
			<p>"<?php echo __("Ik zie het als de grootste eer die ik als docent kan behalen, om tot docent van het jaar te worden verkozen. Ik ben er bijzonder trots op!"); ?>"</p>
			<small>Tomas Klos, <cite title="TU Delta"><?php echo __("Informatica Docent van het Jaar 2012"); ?></cite></small>
		</blockquote>
  </div>
</div>

<div class="row-fluid">
  <div class="span6">
    <h4><?php echo __("Inloggen met token"); ?></h4>
    <p><?php echo __("Je ontvangt je token per e-mail. Elke student die in het TU adresboek staat als student Wiskunde of Informatica heeft op zijn studentmail een email met daarin een persoonlijke link met ingesloten token ontvangen.");?></p>
		<form method="post" action="<?php echo URL::site('Default/resend'); ?>">
			<p><?php echo __("Token niet ontvangen? Vul hier je mail-adres in en klik op 'verzend'. Binnenkort ontvang je alsnog een token."); ?></p>
			<div class="input-append">
				<input class="span10" name="mail" placeholder="<?php echo __("E-mailadres"); ?>" type="text" />
				<input class="span5 btn btn-primary" type="submit" value="<?php echo __("Verzend"); ?>" />
			</div>
		</form>
	</div>

  <div class="span6">
    <h4><?php echo __("De verkiezing");?></h4>
    <p><?php echo __("De Docent van het jaar verkiezing van EWI is een initiatief van de studieverenigingen W.I.S.V. 'Christiaan Huygens' en de ETV in samenwerking met de opleidingsdirectie en Marketing en Communicatie.");?></p>
  </div>
</div>