<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EnrollRulesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EnrollRulesTable Test Case
 */
class EnrollRulesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EnrollRulesTable
     */
    public $EnrollRules;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.enroll_rules',
        'app.courses',
        'app.course_chapters',
        'app.course_files',
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
        $config = TableRegistry::exists('EnrollRules') ? [] : ['className' => 'App\Model\Table\EnrollRulesTable'];
        $this->EnrollRules = TableRegistry::get('EnrollRules', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EnrollRules);

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
