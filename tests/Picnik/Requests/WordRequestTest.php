<?php namespace Picnik\Requests\Word;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Message\Response as GuzzleResponse;
use GuzzleHttp\Subscriber\History as GuzzleHistory;
use GuzzleHttp\Subscriber\Mock as GuzzleMock;
use Picnik\TestCase;
use Picnik\Client;

class WordRequestTest extends TestCase
{

	protected function getRequestInstance($word)
	{
		$c = $this->getClientMock();
		return new WordRequest($c, $word);
	}

	public function testCreatingInstanceWithWord()
	{
		$r = $this->getRequestInstance('foobar');

		$this->assertSame('foobar', $r->getWord());
	}

	public function testSettingNewWord()
	{
		$r = $this->getRequestInstance('foo');
		$r->setWord('bar');

		$this->assertSame('bar', $r->getWord());
	}

	public function testAddingANewParameter()
	{
		$r = $this->getRequestInstance('foobar');
		$this->assertArrayNotHasKey('bar', $r->getParameters());

		$r->setParameter('bar', 'test');
		$this->assertArrayHasKey('bar', $r->getParameters());
	}

	public function testModifyingAParameter()
	{
		$r = $this->getRequestInstance('foobar');
		$r->setParameter('bar', 'test');
		$this->assertSame('test', $r->getParameters()['bar']);

		$r->setParameter('bar', 'testfoo');
		$this->assertSame('testfoo', $r->getParameters()['bar']);
	}

	public function testUsingCanonicalWithParameterDefault()
	{
		$r = $this->getRequestInstance('foobar');
		$r->useCanonical();

		$this->assertTrue($r->getParameters()['useCanonical']);
	}

	public function testUsingCanonicalWithFalseParameter()
	{
		$r = $this->getRequestInstance('foobar');
		$r->useCanonical(false);

		$this->assertFalse($r->getParameters()['useCanonical']);
	}

	public function testUsingCanonicalWithNoneBooleanParameter()
	{
		$r = $this->getRequestInstance('foobar');
		$r->useCanonical('bar');

		$this->assertNotSame('bar', $r->getParameters()['useCanonical']);
	}

	public function testIncludingSuggestionsWithDefaultParameter()
	{
		$r = $this->getRequestInstance('foobar');
		$r->includeSuggestions();

		$this->assertTrue($r->getParameters()['includeSuggestions']);
	}

	public function testIncludingSuggestionsWithFalseParameter()
	{
		$r = $this->getRequestInstance('foobar');
		$r->includeSuggestions(false);

		$this->assertFalse($r->getParameters()['includeSuggestions']);
	}

	public function testIncludingSuggestionsWithNoneBooleanParameter()
	{
		$r = $this->getRequestInstance('foobar');
		$r->includeSuggestions('bar');

		$this->assertNotSame('bar', $r->getParameters()['includeSuggestions']);
	}

	/**
	 * @expectedException Picnik\Exceptions\AuthorizationException
	 */
	public function testExceptionThrownWhenGettingTheTargetWithMissingApiKey()
	{
		$c = $this->getClientMock();
		$c->shouldReceive('getApiKey')->once()->andReturn('');
		$r = new WordRequest($c, 'foobar');

		$r->get();
	}

	/**
	 * @expectedException Picnik\Exceptions\AuthorizationException
	 */
	public function testAuthorizationExceptionThrownOnUnauthorizedResponse()
	{
		$r = $this->getResponseMock(401, new \stdClass);
		
		$g = $this->getGuzzleClientMock();
		$g->shouldReceive('get')->andReturn($r);

		$c = $this->getClientMock();
		$c->shouldReceive('getApiKey')->andReturn('foobar');
		$c->shouldReceive('getGuzzle')->andReturn($g);

		$wr = new WordRequest($c, 'foobar');
		$wr->get();
	}

	/**
	 * @expectedException Picnik\Exceptions\RequestException
	 */
	public function testRequestExceptionThrownOnNonSuccessResponse()
	{
		$r = $this->getResponseMock(400, new \stdClass);
		
		$g = $this->getGuzzleClientMock();
		$g->shouldReceive('get')->andReturn($r);

		$c = $this->getClientMock();
		$c->shouldReceive('getApiKey')->andReturn('foobar');
		$c->shouldReceive('getGuzzle')->andReturn($g);

		$wr = new WordRequest($c, 'foobar');
		$wr->get();
	}

	public function testProperRequestGenerated()
	{
		$gc = new GuzzleClient;
		$gh = new GuzzleHistory;
		$gm = new GuzzleMock([new GuzzleResponse(200)]);

		$gc->getEmitter()->attach($gm);
		$gc->getEmitter()->attach($gh);

		$c = $this->getClientMock();
		$c->shouldReceive('getApiKey')->andReturn('foobar');
		$c->shouldReceive('getGuzzle')->andReturn($gc);

		$wr = new WordRequest($c, 'foobar');
		$wr->get();

		$gRequest = $gh->getLastRequest();

		$target = 'https://api.wordnik.com/v4/word.json/foobar';

		$this->assertStringStartsWith($target, $gRequest->getUrl());
		$this->assertEquals($wr->getParameters(), $gRequest->getQuery()->toArray());
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

		$wr = new WordRequest($c, 'foobar');
		
		$this->assertSame($rc, $wr->get());
	}

}
