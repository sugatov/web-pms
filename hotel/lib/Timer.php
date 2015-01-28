<?php
class Timer
{
	protected $starttime;
	protected $stoptime;

	public function __construct()
	{
		$this->start();
	}
	
	public function start()
	{
		$this->starttime = microtime(true);
		$this->stoptime = 0.0;
	}

	public function stop()
	{
		$this->stoptime = microtime(true);
		return $this->duration();
	}
	
	public function duration()
	{
		if($this->stoptime > $this->starttime){
			return $this->stoptime - $this->starttime;
		} else {
			return 0.0;
		}
	}
}
