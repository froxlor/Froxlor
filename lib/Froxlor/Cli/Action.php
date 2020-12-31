<?php
namespace Froxlor\Cli;

abstract class Action
{

	protected function __construct($args)
	{
		$this->_args = $args;
	}

	public function getActionName()
	{
		return get_called_class();
	}

	abstract public function run();
}
