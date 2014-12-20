<?php namespace Picnik\Requests\Word;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Message\Response as GuzzleResponse;
use GuzzleHttp\Subscriber\History as GuzzleHistory;
use GuzzleHttp\Subscriber\Mock as GuzzleMock;
use Picnik\TestCase;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class DefinitionsRequestTest extends TestCase
{

	protected function getRequestInstance($word)
	{
		$d = $this->getClientMock();
		return new DefinitionsRequest($d, $word);
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

		$r = new DefinitionsRequest($c, 'foobar');
		$r->get();

		$gRequest = $gh->getLastRequest();

		$target = 'https://api.wordnik.com/v4/word.json/foobar/definitions';

		$this->assertStringStartsWith($target, $gRequest->getUrl());
		$this->assertEquals($r->getParameters(), $gRequest->getQuery()->toArray());
	}

	public function testLimitParameter()
	{
		$r = $this->getRequestInstance('foobar');
		$r->limit(15);

		$this->assertSame(15, $r->getParameters()['limit']);
	}

	public function testPartOfSpeechParameter()
	{
		$r = $this->getRequestInstance('foobar');
		$r->partOfSpeech('verb');

		$this->assertSame('verb', $r->getParameters()['partOfSpeech']);
	}

	public function testIncludeRelatedParameter()
	{
		$r = $this->getRequestInstance('foobar');
		$r->includeRelated(true);

		$this->assertSame(true, $r->getParameters()['includeRelated']);
	}

	public function testSourceDictionariesParameterWithString()
	{
		$r = $this->getRequestInstance('foobar');
		$r->sourceDictionaries('foo');

		$this->assertSame('foo', $r->getParameters()['sourceDictionaries']);
	}

	public function testSourceDictionariesParameterWithCommaDelimitedString()
	{
		$r = $this->getRequestInstance('foobar');
		$r->sourceDictionaries('foo,bar');

		$this->assertSame('foo,bar', $r->getParameters()['sourceDictionaries']);
	}

	public function testSourceDictionariesParameterWithArray()
	{
		$r = $this->getRequestInstance('foobar');
		$r->sourceDictionaries(['foo', 'bar']);

		$this->assertSame(['foo', 'bar'], $r->getParameters()['sourceDictionaries']);
	}

	public function testIncludeTagsParameter()
	{
		$r = $this->getRequestInstance('foobar');
		$r->includeTags(true);

		$this->assertSame(true, $r->getParameters()['includeTags']);
	}
	
}
