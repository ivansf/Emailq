# What is Emailq

Emailq is a simple email queueing system that stores emails created anywhere in your application and then sends them
using Cron.

This module is built for Kohana 3 framework. Tested in 3.09

# Requeriments

- ORM Module
- Cron for setting up delivery.
- A new table called email_queue;

# Installation

Create this database

	CREATE TABLE  `ko3`.`email_queue` (
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`email` VARCHAR( 40 ) NOT NULL ,
	`name` VARCHAR( 40 ) NOT NULL ,
	`subject` VARCHAR( 40 ) NOT NULL ,
	`body` TEXT NOT NULL
	) ENGINE = MYISAM ;

Configure the email settings

Copy the file /modules/Emailq/config/example.php to /modules/Emailq/config/emailq.php

