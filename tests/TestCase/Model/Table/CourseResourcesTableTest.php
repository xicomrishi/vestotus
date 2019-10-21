<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CourseResourcesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CourseResourcesTable Test Case
 */
class CourseResourcesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CourseResourcesTable
     */
    public $CourseResources;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.course_resources',
        'app.courses',
        'app.course_chapters',
        'app.course_files',
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
        $config = TableRegistry::exists('CourseResources') ? [] : ['className' => 'App\Model\Table\CourseResourcesTable'];
        $this->CourseResources = TableRegistry::get('CourseResources', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CourseResources);

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
