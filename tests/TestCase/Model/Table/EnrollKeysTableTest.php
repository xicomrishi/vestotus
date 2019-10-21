<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EnrollKeysTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EnrollKeysTable Test Case
 */
class EnrollKeysTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EnrollKeysTable
     */
    public $EnrollKeys;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.enroll_keys',
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
        $config = TableRegistry::exists('EnrollKeys') ? [] : ['className' => 'App\Model\Table\EnrollKeysTable'];
        $this->EnrollKeys = TableRegistry::get('EnrollKeys', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EnrollKeys);

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
