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
}
