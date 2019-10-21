<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TestResultsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TestResultsTable Test Case
 */
class TestResultsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TestResultsTable
     */
    public $TestResults;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.test_results',
        'app.tests',
        'app.users',
        'app.learners',
        'app.departments',
        'app.courses',
        'app.course_chapters',
        'app.course_files',
        'app.assessments',
        'app.enroll_rules',
        'app.course_resources',
        'app.course_notifications',
        'app.enrollments'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('TestResults') ? [] : ['className' => 'App\Model\Table\TestResultsTable'];
        $this->TestResults = TableRegistry::get('TestResults', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TestResults);

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
