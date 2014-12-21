<?php namespace Picnik\Requests\Word;

use Mockery;
use Picnik\TestCase;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class AbstractWordRequestTest extends TestCase
{

	protected function getAbstractInstance()
	{
		$m = Mockery::mock("Picnik\Requests\Word\AbstractWordRequest")
		         ->makePartial()
		         ->shouldAllowMockingProtectedMethods();

		$m->shouldReceive('generateRequestTarget')->andReturn('foobar');

		return $m;
	}

	public function testSettingNewWord()
	{
		$r = $this->getAbstractInstance();
		$r->setWord('bar');

		$this->assertSame('bar', $r->getWord());
	}

	public function testAddingANewParameter()
	{
		$r = $this->getAbstractInstance();
		$this->assertArrayNotHasKey('bar', $r->getParameters());

		$r->setParameter('bar', 'test');
		$this->assertArrayHasKey('bar', $r->getParameters());
	}

	public function testModifyingAParameter()
	{
		$r = $this->getAbstractInstance();
		$r->setParameter('bar', 'test');
		$this->assertSame('test', $r->getParameters()['bar']);

		$r->setParameter('bar', 'testfoo');
		$this->assertSame('testfoo', $r->getParameters()['bar']);
	}

	public function testUsingCanonicalWithParameterDefault()
	{
		$r = $this->getAbstractInstance();
		$r->useCanonical();

		$this->assertSame('true', $r->getParameters()['useCanonical']);
	}

	public function testUsingCanonicalWithFalseParameter()
	{
		$r = $this->getAbstractInstance();
		$r->useCanonical(false);

		$this->assertSame('false', $r->getParameters()['useCanonical']);
	}

	public function testUsingCanonicalWithNoneBooleanParameter()
	{
		$r = $this->getAbstractInstance();
		$r->useCanonical('bar');

		$this->assertNotSame('bar', $r->getParameters()['useCanonical']);
	}

	/**
	 * @expectedException Picnik\Exceptions\AuthorizationException
	 */
	public function testExceptionThrownWhenGettingTheTargetWithMissingApiKey()
	{
		$c = $this->getClientMock();
		$c->shouldReceive('getApiKey')->once()->andReturn('');

		$r = $this->getAbstractInstance();
		$r->setClient($c);

		$r->get();
	}

		/**
	 * @expectedException Picnik\Exceptions\AuthorizationException
	 */
	public function testAuthorizationExceptionThrownOnUnauthorizedResponse()
	{		
		$g = $this->getGuzzleClientMock();
		$g->shouldReceive('get')
		  ->andReturn($this->getResponseMock(401, new \stdClass));

		$c = $this->getClientMock();
		$c->shouldReceive('getApiKey')->andReturn('foobar');
		$c->shouldReceive('getGuzzle')->andReturn($g);

		$r = $this->getAbstractInstance();
		$r->setClient($c);

		$r->get();
	}

	/**
	 * @expectedException Picnik\Exceptions\RequestException
	 */
	public function testRequestExceptionThrownOnNonSuccessResponse()
	{		
		$g = $this->getGuzzleClientMock();
		$g->shouldReceive('get')
		  ->andReturn($this->getResponseMock(400, new \stdClass));

		$c = $this->getClientMock();
		$c->shouldReceive('getApiKey')->andReturn('foobar');
		$c->shouldReceive('getGuzzle')->andReturn($g);

		$r = $this->getAbstractInstance();
		$r->setClient($c);

		$r->get();
	}

	public function testClassReturnedOnSuccessfulResponse()
	{
		$rc = new \stdClass;

		$r = $this->getResponseMock(200, $rc);
		
		$g = $this->getGuzzleClientMock();
		$g->shouldReceive('get')->andReturn($r);

		$c = $this->getClientMock();
		$c->shouldReceive('getApiKey')->andReturn('foobar');
		$c->shouldReceive('getGuzzle')->andReturn($g);

		$r = $this->getAbstractInstance();
		$r->setClient($c);

		$r->get();
	}
	
}
