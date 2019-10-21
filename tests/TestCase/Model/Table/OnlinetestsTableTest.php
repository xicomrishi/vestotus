<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OnlinetestsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OnlinetestsTable Test Case
 */
class OnlinetestsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OnlinetestsTable
     */
    public $Onlinetests;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.onlinetests',
        'app.questions',
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
        $config = TableRegistry::exists('Onlinetests') ? [] : ['className' => 'App\Model\Table\OnlinetestsTable'];
        $this->Onlinetests = TableRegistry::get('Onlinetests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Onlinetests);

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
