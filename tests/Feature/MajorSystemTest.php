<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\MajorSystem\MajorSystem;

class MajorSystemTest extends TestCase
{
    private $major;

    protected function setUp(): void
    {
        parent::setUp();
        $this->major = new MajorSystem();
    }

    public function testMajorSystemCanLoadWordList()
    {
        $batchGenerator = $this->major->getWordBatch();
        $firstBatch = $batchGenerator->current();
        preg_match('/aardvark/', $firstBatch, $matches);
        preg_match_all('/\n/', $firstBatch, $lineMatches[0]);
        $this->assertEquals('aardvark', $matches[0]);
        $this->assertEquals(1000, count($lineMatches[0][0]));
    }

    public function testMajorSystemCanSearchForPattern()
    {
        $results = $this->major->searchWordList('/^chess$/m');
        $this->assertTrue(in_array("chess", $results));
    }

    public function testMajorSystemCanFormPatternFromNumber()
    {
        $testVals = [
            0 => '/^[aeiouwhy]*[sz][aeiouwhy]*$/mi',
            -5 => '/^[aeiouwhy]*l[aeiouwhy]*$/mi',
            23 => '/^[aeiouwhy]*n[aeiouwhy]*m[aeiouwhy]*$/mi'
        ];
        foreach ($testVals as $number => $expectedPattern) {
            $this->assertEquals($expectedPattern, $this->major->getPattern($number));
        }
    }

    public function testMajorSystemBreaksUpLongNumbers()
    {
        // An array of numbers that are too long/repetitive for a single
        // word result:
        $testVals = [
            123456789,
            333333333,
        ];
        foreach ($testVals as $number) {
            // A result should *always* be returned, so we expect no out of
            // bounds error here:
            $result = ($this->major->getMatches($number))[0];
            //$result = array_pop($list);
            // We expect multiple words for these test values:
            $this->assertGreaterThan(1, str_word_count($result));
        }
        // And a small number should result in a single word:
        $simpleResult = ($this->major->getMatches(8))[0];
        $this->assertEquals(1, str_word_count($simpleResult));
    }
}
