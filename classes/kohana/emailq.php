<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Email queueing and delivering build for Pear Mail_Queue;
 * Check the README file before starting.
 *
 * @package Kohana/Emailq
 *
 */
class Kohana_Emailq {

	protected $config;


	/**
	 * Creates the Emailq object
	 *
	 * @static
	 * @return Kohana_Emailq
	 */
	public static function factory()
	{
		return new Kohana_Emailq();
	}

	/**
	 * Creates the Emailq object
	 *
	 * @return void
	 */
	public function Kohana_Emailq()
	{
		require_once MODPATH . 'emailq/swiftmailer/swift_required.php';
		$this->config = Kohana::config('emailq');
		//print_r($this->config);
	}

	/**
	 * Add a message to the database;
	 *
	 * @param  $email
	 * @param  $name
	 * @param  $subject
	 * @param  $body
	 * @return boolean - returns wether the message was added to the database.
	 */
	public function add_email($email, $name, $subject, $body)
	{
		$queue = ORM::factory('emailqueue');
		$queue->email = $email;
		$queue->name = $name;
		$queue->subject = $subject;
		$queue->body = $body;
		if ($queue->save())
			return true;
		return false;
	}

	/**
	 * Tries to send a batch of emails, removing them from the database if it
	 * succedes.
	 *
	 * @param int $amount - Amount of messages it will try to send per request.
	 * @return void
	 */
	public function send_emails($amount = 50)
	{
		$config = $this->config->mail_options;
		$emails = ORM::factory('emailqueue')
				->limit($amount)
				->find_all();

		$transport = Swift_SmtpTransport::newInstance(
				$this->config->mail_options['host'],
				$this->config->mail_options['port'], 'ssl')
				->setUsername($this->config->mail_options['username'])
				->setPassword($this->config->mail_options['password']);
		$mailer = Swift_Mailer::newInstance($transport);

		foreach ($emails as $e) {
			$message = Swift_Message::newInstance()
					->setSubject($e->subject)
					->setFrom(array($config['sender_email'] => $config['sender_name']))
					->setTo(array($e->email => $e->name))
					->setBody($e->body)
					->addPart($e->body, 'text/html');
			$result = $mailer->send($message);
			if ($result)
				$e->delete();
			//Optionally add any attachments
			//->attach(Swift_Attachment::fromPath('my-document.pdf'));
		}
	}


	/**
	 * Builds a table with the current queue
	 *
	 * @return string with an html table
	 */
	public function queue_table($class = null)
	{
		$emails = ORM::factory('emailqueue')->find_all();
		$table = "<table";

		if (isset($class))
			$table .= ' class="'. $class .'"';
		$table .= "> \n";
		$table .= "<thead> \n <tr>  \n\t<th>email</th>\n\t<th>Name</th>".
				"\n\t<th>Subject</th>\n </tr>  \n</thead>  \n"; // ugly html to render with line breaks and tabs
		foreach ($emails as $e) {
			$table .= "<tr>  \n" .
					"\t <td>" . $e->email . "</td>  \n" .
					"\t <td>" . $e->name . "</td>  \n" .
					"\t <td>" . $e->subject . "</td>  \n" .
					"</tr>  \n";
		}
		$table .= "</table>  \n";
		return $table;
	}

}