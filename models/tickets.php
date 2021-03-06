<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . '/database/database_manager.php');

class tickets
{
	/*
	 * Add a new ticket to the database
	 *
	 * @param	int		$user_id
	 * @param	int		$train_id
	 * @param	float	$price
	 * @param	string	$start_station
	 * @param	string	$end_station
	 * @param	string	$start_date
	 * @param	string	$end_date
	 * @param	int		$class
	 * @param	int		$wagon
	 * @param	int		$seat
	 *
	 * @return	mixed					New ticket id ticket was successfully added, and a query error otherwise
	 */
	public static function buy_ticket ($user_id, $train_id, $price, $start_station, $end_station,
									   $start_date, $end_date, $class, $wagon, $seat)
	{
		$db_manager = new database_manager ();
		$result = $db_manager -> insert (
			'tickets',
			[
				'user_id',
				'train_id',
				'price',
				'wagon',
				'seat',
				'class',
				'start_station',
				'end_station',
				'start_date',
				'end_date'
			],
			[
				$user_id,
				$train_id,
				$price,
				$wagon,
				$seat,
				$class,
				$start_station,
				$end_station,
				$start_date,
				$end_date
			]
		);

		if ($result === true)
		{
			$ticket_id = $db_manager -> select (
				'tickets',
				['ticket_id'],
				"user_id='$user_id' AND train_id='$train_id' AND start_date='$start_date'"
			);

			return ($ticket_id[0]['ticket_id']);
		}
		else
			return ($result);
	}

	/*
	 * Get all the tickets for a given user
	 *
	 * @param	int		$user_id	User's ID
	 *
	 * @return	array				The array of tickets the user has bought
	 */
	public static function get_tickets ($user_id)
	{
		$db_manager = new database_manager ();
		$tickets 	= $db_manager -> select (
			'tickets',
			null,
			"user_id='$user_id'"
		);

		return ($tickets);
	}

	public static function get_ticket ($ticket_id)
	{
		$db_manager = new database_manager ();

		$ticket		= $db_manager -> select (
			'tickets',
			[
				'ticket_id',
				'train_id',
				'price',
				'wagon',
				'seat',
				'purchase_date',
				'start_station',
				'end_station',
				'start_date',
				'end_date',
				'class'
			],
			"ticket_id='$ticket_id'"
		);

		return ($ticket[0]);
	}
}
