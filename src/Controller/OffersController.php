<?php
/**
 * Offers Controller
 * @author Lucas Fonseca Martins
 */

namespace App\Controller;

use App\Controller\AppController;
use App\Utility\EncryptionTrait;
use Cake\Core\Configure;

/**
 * Offers Controller
 *
 *
 * @method \App\Model\Entity\Offer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OffersController extends AppController
{
    use EncryptionTrait;

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        // Get the key
        $key = Configure::read('Security.encryptionKey');

        // Get the offers
        $encryptedOffers = $this->paginate($this->Offers);

        // Decrypt the offers
        $offers = [];
        foreach ($encryptedOffers as $offer) {
            $offers[] = [
                'name' => html_entity_decode($this->decrypt($offer->name, $key), ENT_QUOTES, 'UTF-8'),
                'requirements' => html_entity_decode($this->decrypt($offer->requirements, $key), ENT_QUOTES, 'UTF-8'),
                'description' => html_entity_decode($this->decrypt($offer->description, $key), ENT_QUOTES, 'UTF-8'),
                'ecpc' => $offer->epc, // epc is already a number and doesn't need decoding.
                'click_url' => html_entity_decode($this->decrypt($offer->click_url, $key), ENT_QUOTES, 'UTF-8')
            ];
        }

        // Set the offers to the view
        $this->set(compact('offers'));
    }

    /**
     * View method
     *
     * @param string|null $id Offer id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $offer = $this->Offers->get($id, [
            'contain' => [],
        ]);

        $this->set('offer', $offer);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $offer = $this->Offers->newEntity();
        if ($this->request->is('post')) {
            $offer = $this->Offers->patchEntity($offer, $this->request->getData());
            if ($this->Offers->save($offer)) {
                $this->Flash->success(__('The offer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The offer could not be saved. Please, try again.'));
        }
        $this->set(compact('offer'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Offer id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $offer = $this->Offers->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $offer = $this->Offers->patchEntity($offer, $this->request->getData());
            if ($this->Offers->save($offer)) {
                $this->Flash->success(__('The offer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The offer could not be saved. Please, try again.'));
        }
        $this->set(compact('offer'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Offer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $offer = $this->Offers->get($id);
        if ($this->Offers->delete($offer)) {
            $this->Flash->success(__('The offer has been deleted.'));
        } else {
            $this->Flash->error(__('The offer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
