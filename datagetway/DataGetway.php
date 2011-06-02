<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataGetway
 *
 * @author user
 */
abstract class DataGetway {

    /**
     *
     * @var DataBaseAdapter
     */
    protected $db;


    public function  __construct()
    {
        $this->db=Factory::getDBO();
    }
}
?>
