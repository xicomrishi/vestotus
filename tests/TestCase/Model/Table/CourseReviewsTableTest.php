<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CourseReviewsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CourseReviewsTable Test Case
 */
class CourseReviewsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CourseReviewsTable
     */
    public $CourseReviews;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.course_reviews',
        'app.users',
        'app.learners',
        'app.departments',
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
        'app.test_results'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CourseReviews') ? [] : ['className' => 'App\Model\Table\CourseReviewsTable'];
        $this->CourseReviews = TableRegistry::get('CourseReviews', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CourseReviews);

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
