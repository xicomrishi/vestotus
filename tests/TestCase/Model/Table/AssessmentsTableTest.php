<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AssessmentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AssessmentsTable Test Case
 */
class AssessmentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AssessmentsTable
     */
    public $Assessments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.assessments',
        'app.chapters',
        'app.courses',
        'app.course_chapters',
        'app.course_files',
        'app.enroll_rules',
        'app.course_resources',
        'app.users',
        'app.learners',
        'app.departments',
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
        $config = TableRegistry::exists('Assessments') ? [] : ['className' => 'App\Model\Table\AssessmentsTable'];
        $this->Assessments = TableRegistry::get('Assessments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Assessments);

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
