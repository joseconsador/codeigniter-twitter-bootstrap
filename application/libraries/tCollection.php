<?php

class tCollection
{
	private $_type;
	private $_collection = array();

	public function __construct($type, $collection = array())
	{
		$this->_type = $type;

		if (count($collection) > 0) {
			$this->addToCollection($collection);
		} else {
			foreach ($collection as $c) {
				$o = new $this->_type($c);
				$this->_collection[$o->getId()] = $o;
			}
		}
	}

	public function addToCollection($collection)
	{
		if (!is_array($collection)) {
			$collection = array($collection);
		}

		foreach ($collection as $c) {
			if (!is_array($c)) {
				$o = new $this->_type($c);
			} else {
				$o = $c;
			}
			$id = $o->getId();

			if (is_null($id)) {
				$this->_collection[] = $o;
			} else {
				$this->_collection[$id] = $o;
			}
		}
	}

	public function getCollection()
	{
		return $this->_collection;
	}

	public function get($id) 
	{
		if (isset($this->_collection[$id])) {
			return $this->_collection[$id];
		} else {
			return null;
		}
	}

	public function delete()
	{
		$collection = $this->getCollection();

		foreach ($collection as $c) {
			$c->delete();
		}

		return TRUE;
	}

	public function save()
	{
		$collection = $this->getCollection();

		foreach ($collection as $c) {
			$c->save();
		}
	}
}