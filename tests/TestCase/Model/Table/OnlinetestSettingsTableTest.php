<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OnlinetestSettingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OnlinetestSettingsTable Test Case
 */
class OnlinetestSettingsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OnlinetestSettingsTable
     */
    public $OnlinetestSettings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.onlinetest_settings',
        'app.tests',
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
        $config = TableRegistry::exists('OnlinetestSettings') ? [] : ['className' => 'App\Model\Table\OnlinetestSettingsTable'];
        $this->OnlinetestSettings = TableRegistry::get('OnlinetestSettings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OnlinetestSettings);

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
