<?php

namespace App\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Table;
use Cake\Event\Event;
use Cake\ORM\Entity;
use App\Utility\EncryptionTrait;

class Offers extends Table {

    use EncryptionTrait;

    public function initialize(array $config)
    {
        $this->setTable('offers');
    }

    public function beforeSave(Event $event, Entity $entity, $options) {

        debug($event); debug($entity); debug($options);

        $key = Configure::read('Security.encryptionKey');

        $entity->name = $this->encrypt($entity->name, $key);
        $entity->requirements = $this->encrypt($entity->requirements, $key);
        $entity->description = $this->encrypt($entity->description, $key);
        $entity->ecpc = $this->encrypt($entity->ecpc, $key);
        $entity->click_url = $this->encrypt($entity->click_url, $key);

        // Unset the plaintext fields if you don't want them saved in the DB
        //$entity->unsetProperty(['name', 'requirements', 'description', 'ecpc', 'click_url']);
    }
}

