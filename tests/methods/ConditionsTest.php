<?php

class ConditionsTest extends PHPUnit\Framework\TestCase {

    /**
     * CSV
     * The parseCSV object
     *
     * @access protected
     * @var parseCSV
     */
    protected $csv;

    /**
     * Setup
     * Setup our test environment objects
     *
     * @access public
     */
    public function setUp() {
        $this->csv = new parseCSV();
    }

    public function testNotDanBrown() {
        $this->csv->conditions = 'author does not contain dan brown';

        $this->_compareWithExpected([
            'The Killing Kind',
            'The Third Secret',
            'The Last Templar',
            'The Traveller',
            'Crisis Four',
            'Prey',
            'The Broker (Paperback)',
            'Without Blood (Paperback)',
            'State of Fear (Paperback)',
            'The Rule of Four (Paperback)',
        ]);
    }

    public function testRating() {
        $this->csv->conditions = 'rating < 3';
        $this->_compareWithExpected([
            'The Killing Kind',
            'The Third Secret',
        ]);

        $this->csv->conditions = 'rating >= 5';
        $this->_compareWithExpected([
            'The Traveller',
            'Prey',
            'State of Fear (Paperback)',
            'Digital Fortress : A Thriller (Mass Market Paperback)',
            'Angels & Demons (Mass Market Paperback)',
        ]);
    }

    public function testTitleContainsSecretOrCode() {
        $this->csv->conditions = 'title contains code OR title contains SECRET';

        $this->_compareWithExpected([
            'The Third Secret',
            'The Da Vinci Code (Hardcover)',
        ]);
    }

    protected function _compareWithExpected($expected) {
        $this->csv->auto(__DIR__ . '/../../examples/_books.csv');
        $actual = array_map(function ($row) {
            return $row['title'];
        }, $this->csv->data);
        $this->assertEquals($expected, $actual);
    }
}
