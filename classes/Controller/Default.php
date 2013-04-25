<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Default extends Controller_Website {

	public function action_index()
	{
		$this->template->content = View::factory("welcome");
		$this->template->content->set("token", $this->request->query("token"));
	}

	public function action_mail(){
		// Only if logged in
		if(!Auth::instance()->logged_in())
			HTTP::redirect("#login");
		
		$this->user = Auth::instance()->get_user();
		$this->template->content = View::factory("mailer")->bind('student', $this->user);

		if($this->request->method() !== "POST") {
			$students = ORM::factory('Student')->where('test', '=', 1)->find_all();
			return;
		}

		// Load classes
		require MODPATH.'kohana-email/vendor/swift/swift_required.php';
		
		// Create the Transport
		$transport = Swift_SmtpTransport::newInstance("ch.tudelft.nl", 25);
		// Create the Mailer using your created Transport
		$mailer = Swift_Mailer::newInstance($transport);
		
		// Create a message
		$message = Swift_Message::newInstance('Docent van het jaar 2013')
		  ->setFrom(array('coi@ch.tudelft.nl' => 'Commissaris Onderwijs Informatica'));

		// Send the message
		$failedRecipients = array();
		$numSent = 0;
		
		$students = ORM::factory('Student')->where('test', '=', 1)->find_all();

		foreach ($students as $student)
		{
			if (!$student->mail) continue;
			
		 	$message->setTo(array($student->mail => $student->name));
			$view = View::factory("template/mail")->set('student', $student);
			$message->setBody($view, 'text/html');
		  
		  $numSent += $mailer->send($message, $failedRecipients);
		}
		
		$error = count($failedRecipients) ? " Failed sending mails for ". implode(", ", $failedRecipients) : "";
		$this->template->content->set('message', sprintf("Sent %d messages.\n", $numSent).$error);
	}
} // End