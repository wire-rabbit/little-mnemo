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
    public function getWordBatch(int $batchSize = 1000)
    {
        $batchValue = '';
        $path = storage_path('app/words.txt');
        if (file_exists($path)) {
            $handle = fopen($path, 'r');
            $count = 0;
            while (!feof($handle)) {
                $nextLine = fgets($handle);
                $count++;
                if ($nextLine === false || $count === $batchSize) {
                    $count = 0;
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
            preg_match_all($pattern, $batch, $matches);
            $results = array_merge($results, $matches[0]);
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
        $pattern = $this->getPattern($number);
        $results = $this->searchWordList($pattern);
        return $results;
    }

}
