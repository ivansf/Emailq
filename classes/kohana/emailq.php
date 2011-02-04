<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Email queueing and delivering build for Pear Mail_Queue;
 * Check the README file before starting.
 *
 * @package Kohana/Emailq
 *
 */
abstract class Kohana_Emailq {

	public static function factory($email, $name, $subject, $body) {
		require_once MODPATH . 'emailq/swiftmailer/swift_required.php';
		$config_file = Kohana::config('emailq');
		$queue = ORM::factory('emailqueue');
		$queue->email = $email;
		$queue->name = $name;
		$queue->subject = $subject;
		$queue->body = $body;
		$queue->save();
	}
}