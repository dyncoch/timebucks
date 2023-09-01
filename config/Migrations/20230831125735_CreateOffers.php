<?php
use Migrations\AbstractMigration;

class CreateOffers extends AbstractMigration
{

    public $autoId = false;

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('offers');
        $table->addColumn('id', 'integer', [
            'autoIncrement' => true,
            'default' => null,
            'null' => false,
            'limit' => 11
        ]);
        $table->addColumn('name', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('requirements', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('description', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('epc', 'double', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('click_url', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('support_url', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('preview_url', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addPrimaryKey([
            'id',
        ]);
        $table->create();
    }
}
