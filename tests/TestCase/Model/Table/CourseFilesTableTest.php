<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CourseFilesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CourseFilesTable Test Case
 */
class CourseFilesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CourseFilesTable
     */
    public $CourseFiles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.course_files',
        'app.courses',
        'app.course_chapters',
        'app.enroll_rules',
        'app.users',
        'app.learners',
        'app.departments'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CourseFiles') ? [] : ['className' => 'App\Model\Table\CourseFilesTable'];
        $this->CourseFiles = TableRegistry::get('CourseFiles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CourseFiles);

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
