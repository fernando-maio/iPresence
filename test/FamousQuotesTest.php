<?php

use PHPUnit\Framework\TestCase;
use Src\Components\FamousQuotes;

class FamousQuotesTest extends TestCase
{
    /**
     * @dataProvider provideQuotesFalse
     */
    public function testListQuotesFalse($name, $count)
    {
        $quotes = new FamousQuotes;
        $this->assertFalse($quotes->listQuotes($name, $count));
    }

    /**
     * @dataProvider provideQuotesIsArray
     */
    public function testListQuotesIsArray($name, $count)
    {
        $quotes = new FamousQuotes;
        $this->assertIsArray($quotes->listQuotes($name, $count));
    }
    
    public function testJsonFileData()
    {
        $this->assertFileExists(dirname(__DIR__) . '/src/Data/quotes.json');
    }

    public function provideQuotesFalse()
    {
        return array(
            array('vincent-van-gogh', '0'),
            array('vincent-van-gogh', '25'),
            array('vincent-van-gogh', null),
            array('steve-jobs', 'false'),
            array('fernando-maio', '')
        );
    }

    public function provideQuotesIsArray()
    {
        return array(
            array('vincent-van-gogh', '3'),
            array('Vincent-Van-Gogh', '8'),
            array('STEVE JOBS', '5'),
            array('Fernando Maio', '1')
        );
    }
}