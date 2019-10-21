<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CourseImagesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CourseImagesTable Test Case
 */
class CourseImagesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CourseImagesTable
     */
    public $CourseImages;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.course_images',
        'app.users',
        'app.departments',
        'app.countries',
        'app.states',
        'app.cities',
        'app.learners'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CourseImages') ? [] : ['className' => 'App\Model\Table\CourseImagesTable'];
        $this->CourseImages = TableRegistry::get('CourseImages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CourseImages);

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
