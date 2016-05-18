# Docent van het Jaar website

Checklist:

- [ ] na verse clone: `git submodule update --init --recursive` zodat alle modules zijn gedownload. 
- [ ] update in [classes/controller/Website.php](blob/master/classes/Controller/Website.php#L2) de verkiezing-sluit-datum: tot wanneer kan je stemmen.
- [ ] zet je e-mail NetID gebruikersnaam en wachtwoord in [blob/master/config/email.php](blob/master/config/email.php)
- [ ] je moet de database vullen met docenten, vakken en studenten:
  - docenten en vakken vanaf studiegids.tudelft.nl. Ik had een export smurf tooltje. Dat ga ik zoeken. Staat nog niet in deze repo.
  - studenten komen uit de TU LDAP export / csa export. Je wilt voor een eerlijke verkiezing íedereen de kans geven te stemmen.

Wil je mails met tokens gaan sturen, dan kan je de `action_mail` gebruiken, maar die staat handmatig in code uitgezet. Wat notes:
- [Deze regel](blob/master/classes/Controller/Default.php#L14) voorkomt nu dat er gemaild kan worden, daar wil je waarschijnlijk iets veiligere check op doen, of de check heel snel terug zetten als je gemaild hebt... Lazy programmer.
- [Hier](blob/master/classes/Controller/Default.php#L42-L44) zorg ik er voor dat er 1000 mails tegelijk gestuurd worden. STMP wordt er niet heel blij van als je heel de TU in een keer mailt.
- Hetzelfde als de regels hierboven staan in de `action_remind` daar onder. Die mail kan je bijvoorbeeld 2 dagen voor de deadline sturen. 
