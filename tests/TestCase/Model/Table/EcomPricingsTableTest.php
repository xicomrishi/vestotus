<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EcomPricingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EcomPricingsTable Test Case
 */
class EcomPricingsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EcomPricingsTable
     */
    public $EcomPricings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ecom_pricings',
        'app.courses',
        'app.course_chapters',
        'app.course_files',
        'app.assessments',
        'app.onlinetests',
        'app.questions',
        'app.users',
        'app.departments',
        'app.countries',
        'app.states',
        'app.cities',
        'app.learners',
        'app.enroll_rules',
        'app.course_resources',
        'app.course_notifications',
        'app.enrollments',
        'app.manager',
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
        $config = TableRegistry::exists('EcomPricings') ? [] : ['className' => 'App\Model\Table\EcomPricingsTable'];
        $this->EcomPricings = TableRegistry::get('EcomPricings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EcomPricings);

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
