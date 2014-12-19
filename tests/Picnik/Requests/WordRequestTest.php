<?php namespace Picnik\Requests;

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

	

}
