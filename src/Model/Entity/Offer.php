<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Offer Entity
 *
 * @property string $id
 * @property string $name
 * @property string $requirements
 * @property string $description
 * @property float $epc
 * @property string $click_url
 * @property string $support_url
 * @property string $preview_url
 * @property \Cake\I18n\FrozenTime $created
 */
class Offer extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'requirements' => true,
        'description' => true,
        'epc' => true,
        'click_url' => true,
        'support_url' => true,
        'preview_url' => true,
        'created' => true,
    ];
}
