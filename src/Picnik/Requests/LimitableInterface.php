<?php namespace Picnik\Requests;

interface LimitableInterface
{

	/**
	 * The maximum number of pronounciations that should be returned for the
	 * request. This method is chainable.
	 * @param  int $count the number of results this request should be limited to
	 * @return AbstractRequest
	 */
	public function limit($count);
	
}
