<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LearnersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LearnersTable Test Case
 */
class LearnersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LearnersTable
     */
    public $Learners;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.learners',
        'app.users',
        'app.user_details',
        'app.vendors'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Learners') ? [] : ['className' => 'App\Model\Table\LearnersTable'];
        $this->Learners = TableRegistry::get('Learners', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Learners);

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
