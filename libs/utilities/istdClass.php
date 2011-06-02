<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of istdClass
 *
 * @author mostafa
 */
class istdClass implements ArrayAccess {

    //put your code here
    private $__data = array();

    public function __construct($data=null)
    {
	if($data && is_object($data))
	{
	    foreach($data as $key=>$val)
	    {
		$this->$key=$val;
	    }
	}
    }
    public function &__get($name) {
        if (isset($this->__data[strtolower($name)]))
            return $this->__data[strtolower($name)];
        return null;
    }

    public function __set($name, $value) {
        $this->__data[strtolower($name)] = $value;
    }

    public function __isset($name) {
        return isset($this->__data[strtolower($name)]);
    }

    public function __unset($name) {
        unset($this->__data[strtolower($name)]);
        ;
    }

    /**
     *
     * @param offset
     * @see ArrayAccess::offsetExists()
     */
    public function offsetExists($offset) {
        return isset($this->__data[strtolower($offset)]);
    }

    /**
     *
     * @param offset
     * @see ArrayAccess::offsetGet()
     */
    public function offsetGet($offset) {

        return isset($this->__data[strtolower($offset)]) ? $this->__data[strtolower($offset)] : null;
    }

    /**
     *
     * @param offset
     * @param value
     * @see ArrayAccess::offsetSet()
     */
    public function offsetSet($offset, $value) {
        return $this->__data[strtolower($offset)] = $value;
    }

    /**
     *
     * @param offset
     * @see ArrayAccess::offsetUnset()
     */
    public function offsetUnset($offset) {
        unset($this->__data[strtolower($offset)]);
    }

    

}
