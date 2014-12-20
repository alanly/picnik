<?php namespace Picnik;

use Mockery as m;

/**
 * @author  Alan Ly <hello@alan.ly>
 */
class TestCase extends \PHPUnit_Framework_TestCase
{

	public function tearDown()
	{
		m::close();
	}

	protected function getClientMock()
	{
		$r = m::mock('Picnik\Client');

		return $r;
	}

	/**
	 * Returns a mock of the Guzzle's ResponseInterface.
	 * @param  int      $statusCode the HTTP status code for the response
	 * @param  StdClass $json       the stdClass object holding the JSON response
	 * @return ResponseInterface
	 */
	protected function getResponseMock($statusCode, $json)
	{
		$r = m::mock('GuzzleHttp\Message\ResponseInterface');
		$r->shouldReceive('getStatusCode')->andReturn($statusCode);
		$r->shouldReceive('json')->andReturn($json);

		return $r;
	}

	/**
	 * Returns a mock of the GuzzleHttp Client, prepared for a GET request.
	 * @param  ResponseInterface $response the response returned for the request
	 * @return GuzzleHttp\Client
	 */
	protected function getGuzzleClientMock()
	{
		$c = m::mock('GuzzleHttp\Client');
		return $c;
	}
	
}
