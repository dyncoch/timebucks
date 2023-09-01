<?php
/**
 * Offers Model
 * @author Lucas Fonseca Martins
 */
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\Entity;
use App\Utility\EncryptionTrait;

/**
 * Offers Model
 *
 * @method \App\Model\Entity\Offer get($primaryKey, $options = [])
 * @method \App\Model\Entity\Offer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Offer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Offer|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Offer saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Offer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Offer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Offer findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class Offers extends Table
{
    use EncryptionTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('offers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        // Validate 'id'
        $validator
            ->numeric('id')
            ->requirePresence('id', 'create')  // Ensure 'id' is present when creating
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);  // Ensure 'id' is unique

        // Validate 'name'
        $validator
            ->scalar('name')
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        // Validate 'requirements'
        $validator
            ->scalar('requirements')
            ->requirePresence('requirements', 'create')
            ->notEmptyString('requirements');

        // Validate 'description'
        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        // Validate 'epc'
        $validator
            ->scalar('epc')
            ->requirePresence('epc', 'create')
            ->notEmptyString('epc');

        // Validate 'click_url'
        $validator
            ->scalar('click_url')
            ->requirePresence('click_url', 'create')
            ->notEmptyString('click_url');

        // Validate 'support_url'
        $validator
            ->scalar('support_url')
            ->requirePresence('support_url', 'create')
            ->notEmptyString('support_url');

        // Validate 'preview_url'
        $validator
            ->scalar('preview_url')
            ->requirePresence('preview_url', 'create')
            ->notEmptyString('preview_url');

        return $validator;
    }

    /**
     * Before saving an entity encrypt the fields
     * @param Event $event
     * @param Entity $entity
     * @param $options
     * @return void
     */
    public function beforeSave(Event $event, Entity $entity, $options) {

        // Get the key
        $key = Configure::read('Security.encryptionKey');

        // Encrypt the fields
        $entity->name = $this->encrypt($entity->name, $key);
        $entity->requirements = $this->encrypt($entity->requirements, $key);
        $entity->description = $this->encrypt($entity->description, $key);
        $entity->click_url = $this->encrypt($entity->click_url, $key);
        $entity->support_url = $this->encrypt($entity->support_url, $key);
        $entity->preview_url = $this->encrypt($entity->preview_url, $key);

    }
}
