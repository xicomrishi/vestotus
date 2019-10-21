<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CourseNotificationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CourseNotificationsTable Test Case
 */
class CourseNotificationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CourseNotificationsTable
     */
    public $CourseNotifications;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.course_notifications',
        'app.courses',
        'app.course_chapters',
        'app.course_files',
        'app.enroll_rules',
        'app.course_resources',
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
        $config = TableRegistry::exists('CourseNotifications') ? [] : ['className' => 'App\Model\Table\CourseNotificationsTable'];
        $this->CourseNotifications = TableRegistry::get('CourseNotifications', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CourseNotifications);

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
