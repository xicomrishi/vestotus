<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CourseChaptersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CourseChaptersTable Test Case
 */
class CourseChaptersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CourseChaptersTable
     */
    public $CourseChapters;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.course_chapters',
        'app.courses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CourseChapters') ? [] : ['className' => 'App\Model\Table\CourseChaptersTable'];
        $this->CourseChapters = TableRegistry::get('CourseChapters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CourseChapters);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
