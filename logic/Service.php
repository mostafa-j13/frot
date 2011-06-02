<?php
class Service {
	/**
	 *
	 * @var DataBaseAdapter
	 */
	protected $db;
	
	/**
	 *
	 * @var Request
	 */
	protected $input;


    /**
     *
     * @var Response
     */
    protected $reponse;


    public function __construct()
	{
		$this->db=Factory::getDBO();
		$this->input=Request::getInstance();
        $this->reponse=Response::getInstance();
	}
}