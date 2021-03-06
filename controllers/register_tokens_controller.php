<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . '/models/register_tokens.php');

class register_tokens_controller
{
	/*
	 * Adds a new register token to the database
	 *
	 * @param	int		$user_id		User ID associated with the token
	 * @param	string	$expiry_date	Data the token will expiry  in format 'Y-M-D h:m:s'. Optional
	 *
	 * @return	mixed					The token if added successfully, false otherwise
	 */
	public static function create ($user_id, $expiry_date = null)
	{
		return (register_tokens::add_token ($user_id, $expiry_date));
	}

	/*
	 * Checks if a given token is valid. Token will be deleted from the database if it's valid
	 *
	 * @param	string	$token	Register token to be checked
	 *
	 * @return	mixed			User ID associated with the token if it's valid and false otherwise
	 */
	public static function check ($token)
	{
		return (register_tokens::check_token ($token));
	}
}