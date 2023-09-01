<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\Offers;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OffersTable Test Case
 */
class OffersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\Offers
     */
    public $Offers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Offers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Offers') ? [] : ['className' => Offers::class];
        $this->Offers = TableRegistry::getTableLocator()->get('Offers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Offers);

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
}
