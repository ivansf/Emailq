# What is Emailq

Emailq is a simple email queueing system that stores emails created anywhere in your application and then sends them using Cron.

This module is built for Kohana 3 framework. Tested in 3.09

Uses (and includes) Swiftmailer library (4.0.6)

# Requeriments

* ORM Module
* Cron for setting up delivery.
* A new table called email_queue;

# Installation

### Create the required table ###

	CREATE TABLE  `ko3`.`email_queue` (
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`email` VARCHAR( 40 ) NOT NULL ,
	`name` VARCHAR( 40 ) NOT NULL ,
	`subject` VARCHAR( 40 ) NOT NULL ,
	`body` TEXT NOT NULL
	) ENGINE = MYISAM ;

### Configure the email settings ###

Copy the file /modules/Emailq/config/example.php to /modules/Emailq/config/emailq.php

Open and configure your email options in :

	/modules/Emailq/config/emailq.php

# Using Emailq

For now, there's nothing much advanced to do with it.

To add a email to the queue:

	Emailq::factory()->add_email('email@email.com', 'Name', 'Subject', 'Body');

To setup the cron:

Create an action that calls sends_emails()

	public function action_send() {
		Emailq::factory()->send_emails();
	}