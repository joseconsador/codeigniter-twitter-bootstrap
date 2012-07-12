<?php

abstract class cBase 
{
	protected $_cache = array();
	protected $_id;

	public function __construct($id = null)
	{
		if (!is_null($id)) {
			if (!is_array($id) && !is_object($id)) {
				$this->load($id);	
			} else {
				$this->loadArray($id);
			}
		}
	}

	public function save()
	{
		return $this->getModel()->do_save((array) $this);
	}

	public function delete()
	{
		return $this->getModel()->delete($this->getId());
	}

	public function getId()
	{
		$model = $this->getModel();

		if (isset($this->{$model->get_primary_key()})) {
			return $this->{$model->get_primary_key()};
		} else {
			return null;
		}
	}

	public function load($key, $field = '')
	{
		$data = $this->getModel()->get($key, $field);
		$this->loadArray($data);
	}

	public function loadArray($data)
	{
		if ($data && (is_array($data) || is_object($data))) {
			foreach ($data as $p => $val)
			{
				$this->$p = $val;
			}		
		}
	}

	protected function getCache($index = null)
	{
		if (!is_null($index)) {
			return $this->_cache[$index];
		}

		return $this->_cache;
	}

	protected function setCache($index, $value)
	{
		$this->_cache[$index] = $value;
	}

	protected function inCache($index)
	{
		return array_key_exists($index, $this->getCache());
	}

	public function getDateCreated()
	{
		return date('M d, Y h:i a', strtotime($this->date_created));
	}

	public function getDateUpdated()
	{
		return date('M d, Y h:i a', strtotime($this->date_updated));
	}		
}