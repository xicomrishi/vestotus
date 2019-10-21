<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AttendencesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AttendencesTable Test Case
 */
class AttendencesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AttendencesTable
     */
    public $Attendences;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.attendences',
        'app.students',
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
        'app.sessions',
        'app.session_classes',
        'app.venues',
        'app.countries',
        'app.states',
        'app.cities',
        'app.classes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Attendences') ? [] : ['className' => 'App\Model\Table\AttendencesTable'];
        $this->Attendences = TableRegistry::get('Attendences', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Attendences);

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
