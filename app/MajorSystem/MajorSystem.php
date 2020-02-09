<?php

namespace App\MajorSystem;

use Illuminate\Support\Facades\Storage;

class MajorSystem
{
    const PATTERN_MAP = [
        0 => '[sz]',        // s, z. TODO: soft c-sounds
        1 => '[td][^h]',    // t or d but not th
        2 => 'n',
        3 => 'm',
        4 => 'r',
        5 => 'l',
        6 => '(sh|ch|j|zh)', // TODO: soft g-sounds
        7 => '[kcgq]',
        8 => '[fv]',
        9 => '[pb]',
    ];

    const UNASSIGNED = '[aeiouwhy]*';

    /**
     * Create a new MajorSystem instance.
     *
     * @param string $word_list
     * @return void
     */
    public function __construct(string $word_list = '')
    {
        if (!empty($word_list)) {
            $this->wordList = $word_list;
        }
    }

    /**
     * Generator that returns a batch of lines from the word list file.
     *
     * @param int $batchSize
     * @return string
     *
     * @throws \Exception
     */
    public function getWordBatch(int $batchSize = 1001)
    {
        $batchValue = '';
        $path = storage_path('app/words.txt');
        if (file_exists($path)) {
            $handle = fopen($path, 'r');
            $count = 1;
            while (!feof($handle)) {
                $nextLine = fgets($handle);
                $count++;
                if ($nextLine === false || $count === $batchSize) {
                    $count = 1;
                    if (is_string($nextLine)) {
                        $batchValue .= $nextLine;
                    }
                    yield $batchValue;
                    $batchValue = '';
                } else {
                    $batchValue .= $nextLine;
                }
            }
            fclose($handle);
        } else {
            throw new \Exception('Word list file not found.');
        }
    }

    /**
     * Search the word list for matches and return an array of results.
     *
     * @param string $pattern
     * @return array
     */
    public function searchWordList(string $pattern)
    {
        $results = [];
        $reader = $this->getWordBatch();
        foreach ($reader as $batch) {
            $matchCount = preg_match_all($pattern, $batch, $matches);
            if ($matchCount > 0) {
                foreach ($matches[0] as $match) {
                    $results[] = $match;
                }
            }
        }
        return $results;
    }

    /**
     * Create a regular expression to test a number against its Major System
     * representation.
     *
     * @param int $number
     * @return string
     */
    public function getPattern(int $number)
    {
        $pattern = '/^' . self::UNASSIGNED;
        foreach (str_split(strval(abs($number))) as $digit) {
            $pattern .= self::PATTERN_MAP[intval($digit)] . self::UNASSIGNED;
        }
        $pattern .= '$/mi';
        return $pattern;
    }

    /**
     * Return possible Major System matches for a given number.
     *
     * @param int $number
     * @return array
     */
    public function getMatches(int $number)
    {
        // We need to be able to combine chunks of numbers as lists of words
        $wordLists = [];
        $createWordList = function (array $numberParts) use (&$createWordList, &$wordLists) {
            foreach ($numberParts as $number) {
                $pattern = $this->getPattern(intval($number));
                $results = $this->searchWordList($pattern);
                if (empty($results)) {
                    // If no result was found, the number was too large. We will break it into two
                    // chunks and process each separately:
                    $strNumber = strval($number);
                    if (strlen($strNumber) > 1) {
                        $pieces = str_split($strNumber);
                        $left = intval(implode(array_slice($pieces, 0, floor(count($pieces)/2))));
                        $right = intval(implode(array_slice($pieces, floor(count($pieces)/2))));
                        $createWordList([$left, $right]);
                    }
                } else {
                    // If a result was found, these results can simply be added:
                    $wordLists[$number] = $results;
                }
            }
        };

        $createWordList([$number]);

        // Now combine one result from each array dimension into a single string.
        // First, get information about each dimension:
        $loopValues = [];
        $largest = 0;
        $largestKey = '';
        foreach (array_keys($wordLists) as $numberPiece) {
            $size = count($wordLists[$numberPiece]);
            if ($size > $largest) {
                $largest = $size;
                $largestKey = $numberPiece;
            }
            $loopValues[] = [
                'key' => $numberPiece,
                'size' => $size,
                'current' => 0,
            ];
        }

        // Next, loop over each dimension, using the largest as the max output
        // (it would be less helpful to do a cartesian product of all dimensions).
        // Smaller dimensions just cycle through.
        $result = [];
        for ($i = 0; $i < count($wordLists[$largestKey]); $i++) {
            $nextResult = '';
            foreach ($loopValues as &$loop) {
                $nextResult .= ' ' . $wordLists[$loop['key']][$loop['current']];
                $loop['current']++;
                if ($loop['current'] === $loop['size']) {
                    $loop['current'] = 0;
                }
            }
            $result[] = trim($nextResult);
        }

        return $result;
    }
}
