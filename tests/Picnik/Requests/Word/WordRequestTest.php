<?php namespace Picnik\Requests\Word;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Message\Response as GuzzleResponse;
use GuzzleHttp\Subscriber\History as GuzzleHistory;
use GuzzleHttp\Subscriber\Mock as GuzzleMock;
use Picnik\TestCase;
use Picnik\Client;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class WordRequestTest extends TestCase
{

	protected function getRequestInstance($word)
	{
		$c = $this->getClientMock();
		return new WordRequest($c, $word);
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

}
