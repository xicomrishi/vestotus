<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SessionClassesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SessionClassesTable Test Case
 */
class SessionClassesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SessionClassesTable
     */
    public $SessionClasses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.session_classes',
        'app.sessions',
        'app.instructors',
        'app.courses',
        'app.course_chapters',
        'app.course_files',
        'app.assessments',
        'app.onlinetests',
        'app.questions',
        'app.users',
        'app.learners',
        'app.departments',
        'app.enroll_rules',
        'app.course_resources',
        'app.course_notifications',
        'app.enrollments',
        'app.test_results',
        'app.course_reviews',
        'app.venues',
        'app.countries',
        'app.states',
        'app.cities'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('SessionClasses') ? [] : ['className' => 'App\Model\Table\SessionClassesTable'];
        $this->SessionClasses = TableRegistry::get('SessionClasses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SessionClasses);

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
