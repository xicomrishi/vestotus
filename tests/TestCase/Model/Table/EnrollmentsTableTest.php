<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EnrollmentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EnrollmentsTable Test Case
 */
class EnrollmentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EnrollmentsTable
     */
    public $Enrollments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.enrollments',
        'app.courses',
        'app.course_chapters',
        'app.course_files',
        'app.enroll_rules',
        'app.course_resources',
        'app.users',
        'app.learners',
        'app.departments',
        'app.course_notifications'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Enrollments') ? [] : ['className' => 'App\Model\Table\EnrollmentsTable'];
        $this->Enrollments = TableRegistry::get('Enrollments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Enrollments);

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
