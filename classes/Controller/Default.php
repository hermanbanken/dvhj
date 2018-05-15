<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Default extends Controller_Website {

	public function action_index()
	{
		$this->template->content = View::factory("welcome");
		$this->template->content->set("token", $this->request->query("token"));
	}

	public function action_mail(){
		// Only if logged in
		//if(!Auth::instance()->logged_in())
		HTTP::redirect("#login");

		$config = Kohana::$config->load('email');
		
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
		$message = Swift_Message::newInstance('Docent van het jaar '.date("Y"))
		  ->setFrom($config['sender']);

		// Send the message
		$failedRecipients = array();
		$numSent = 0;
		
		$students = ORM::factory('Student')->where('test', '=', 1)->find_all();
		$offset = 0;
		//$students = ORM::factory('Student')->limit(1000)->offset($offset)->find_all();

		foreach ($students as $student)
		{	
		
			if (!$student->mail) continue;
			
		 	//$message->setTo(array($student->mail => $student->name));
		//	$view = View::factory("template/mail")->set('student', $student);
			//$message->setBody($view, 'text/html');
		  
			//echo $student->mail . "\n";flush();
		  //$numSent += $mailer->send($message, $failedRecipients);
		}
		
		$error = count($failedRecipients) ? " Failed sending mails for ". implode(", ", $failedRecipients) : "";
		$this->template->content->set('message', sprintf("Sent %d messages from offset $offset.\n", $numSent).$error);
	}
	
	public function action_remind(){
		// Only if logged in
		//if(!Auth::instance()->logged_in())
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
		$message = Swift_Message::newInstance('Nog 2 dagen stemmen op jouw Docent van het jaar '.date("Y"))
		  ->setFrom($config['sender']);

		// Send the message
		$failedRecipients = array();
		$numSent = 0;
		
		$offset = 0;
		$students = ORM::factory('Student')->where('id', 'NOT IN', DB::expr("(SELECT student FROM votes)"))->offset($offset)->limit(300)->find_all();

		foreach ($students as $student)
		{
			if (!$student->mail) continue;
			
			$addr = isset($student->mail_ch) && !empty($student->mail_ch) ? $student->mail_ch : $student->mail;
		 	$message->setTo(array($addr => $student->name));
			$view = View::factory("template/mail")->set('student', $student);
			$message->setBody($view, 'text/html');
		  
			echo $addr . "\n";flush();
		  $numSent += $mailer->send($message, $failedRecipients);
		}
		
		$error = count($failedRecipients) ? " Failed sending mails for ". implode(", ", $failedRecipients) : "";
		$this->template->content->set('message', sprintf("Sent %d messages from $offset till ".($offset+300).".\n", $numSent).$error);
	}
	
	public function action_resend(){
		
		// Load classes
		require MODPATH.'kohana-email/vendor/swiftmailer/lib/swift_required.php';
		
		$config = Kohana::$config->load('email');
		
		$mail = $this->request->post("mail");
		
		// Create the Transport
		$transport = Swift_SmtpTransport::newInstance("ch.tudelft.nl", 25);
		// Create the Mailer using your created Transport
		$mailer = Swift_Mailer::newInstance($transport);
		
		// Create a message
		$message = Swift_Message::newInstance('Docent van het jaar '.date("Y"))
		  ->setFrom(array('website@ch.tudelft.nl' => 'Website DVHJ'));
		
	 	$message->setTo($config['sender']);
		$view = "<p>Vanaf ".$_SERVER['REMOTE_ADDR']." is een verzoek geplaatst voor het mail adres ".$mail."</p>";
		$message->setBody($view, 'text/html');
	  $mailer->send($message, $failedRecipients);
		
		HTTP::redirect("?message=".__("Verzoek geplaatst."));
	}
} // End
