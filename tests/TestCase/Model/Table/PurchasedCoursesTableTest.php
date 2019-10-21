<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PurchasedCoursesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PurchasedCoursesTable Test Case
 */
class PurchasedCoursesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PurchasedCoursesTable
     */
    public $PurchasedCourses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.purchased_courses',
        'app.users',
        'app.departments',
        'app.countries',
        'app.states',
        'app.cities',
        'app.learners',
        'app.courses',
        'app.course_chapters',
        'app.course_files',
        'app.assessments',
        'app.onlinetests',
        'app.questions',
        'app.enroll_rules',
        'app.course_resources',
        'app.course_notifications',
        'app.enrollments',
        'app.test_results',
        'app.course_reviews',
        'app.sessions',
        'app.instructors',
        'app.session_classes',
        'app.venues'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PurchasedCourses') ? [] : ['className' => 'App\Model\Table\PurchasedCoursesTable'];
        $this->PurchasedCourses = TableRegistry::get('PurchasedCourses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PurchasedCourses);

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
