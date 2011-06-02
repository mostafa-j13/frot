<?php
class PageService extends Service
{
	private $weblog_id;
	
	function __construct()
	{
		parent::__construct();
		$this->weblog_id=$this->input->getInt('weblog_id');
	}

}