<?php

class Factory
{
	private static $dbo;
	private static $user;

	/**
	 * Enter description here...
	 *
	 * @return MySQLAdapter
	 */
	static public function getDBO()
	{
		if (! self::$dbo)
		{
			//self::$dbo = new MySQLAdapter ( '192.168.5.150' , 'root' , 'root007' , '' , 'frotel' );
			self::$dbo = new MySQLAdapter ( 'localhost' , 'dark' , 'dark' , '' , 'frotel' );
		}
		return self::$dbo;
	}

	/**
	 *
	 * @return Session
	 */
	static public function getSession()
	{
		return Session::getInstance ();
	}

	/**
	 * Enter description here...
	 *
	 * @return Users
	 */
	static public function getUser()
	{
		if (! self::$user)
			self::$user = new Users ( );
		return self::$user;
	}

        static public function getDate($date='now',$type=Date::tyGregorian)
        {
            return new Date($date,$type);
        }
}
