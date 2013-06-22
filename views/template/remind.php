<p><strong>For English, scroll down.</strong></p>
<p>Beste student,</p>

<p>Je hebt nog niet gestemd voor de jaarlijkse "Docent van het jaar"-verkiezing. Uit je
waardering voor het harde werk van je docenten en geef ze een cijfer.</p>

<p>Via onderstaande link kun je aangeven welke vakken je gevolgd hebt en de
bijbehorende docenten een cijfer geven. Doe dit a.u.b. voor 19 mei 23:59 uur, want
dan sluit de verkiezing.</p>

<?php
$url = URL::site(
	URL::query(array("token"=>$student->token)),
	true
);
?><p><a href="<?php echo $url ?>"><?php echo $url; ?></a></p>

<p>Met vriendelijke groet,</p>

<p>Herman Banken</p>

<p>Commissaris Onderwijs Informatica<br />
der W.I.S.V. 'Christiaan Huygens'<br />
[t] (015) 2782532<br />
[w] <a href="http://ch.tudelft.nl">http://ch.tudelft.nl</a></p>

<p><strong>Disclaimer</strong>: aan bovenstaande link zit een persoonlijke token gekoppeld. Hiermee controleren we dat iedereen maar één keer stemt. Je stem wordt nooit gepubliceerd of kenbaargemaakt in combinatie met je persoonsgegevens.</p>

<p>-------------------<br /></p>

<p><strong>English:</strong></p>
<p>Dear student,</p>

<p>You haven't voted yet for the yearly "Teacher of the Year"-election. Show your teachers your appreciation for their hard work and give them a grade.</p>

<p>Using the personal link below you can select the courses you followed and give the matching teachers a grade. Please do this before the 20th of May, since the election will close on 2013-05-19 23:59.</p>

<?php
$url = URL::site(
	URL::query(array("lang"=>"en", "token"=>$student->token)),
	true
);
?><p><a href="<?php echo $url ?>"><?php echo $url; ?></a></p>

<p>Kind regards,</p>

<p>Herman Banken</p>

<p>Chief Commissioner of Computer Science Education<br />
of W.I.S.V. 'Christiaan Huygens'<br />
[t] (015) 2782532<br />
[w] <a href="http://ch.tudelft.nl">http://ch.tudelft.nl</a></p>

<p><strong>Disclaimer</strong>: a personal token is linked to the link above. With this we check that anyone votes only once. Your vote will never be published with your name or personal data.</p>