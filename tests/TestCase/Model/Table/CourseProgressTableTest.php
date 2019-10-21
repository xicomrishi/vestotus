<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CourseProgressTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CourseProgressTable Test Case
 */
class CourseProgressTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CourseProgressTable
     */
    public $CourseProgress;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.course_progress',
        'app.courses',
        'app.course_chapters',
        'app.course_files',
        'app.enroll_rules',
        'app.course_resources',
        'app.users',
        'app.learners',
        'app.departments',
        'app.course_notifications',
        'app.enrollments',
        'app.lessions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CourseProgress') ? [] : ['className' => 'App\Model\Table\CourseProgressTable'];
        $this->CourseProgress = TableRegistry::get('CourseProgress', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CourseProgress);

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
