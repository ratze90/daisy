<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;


/**
 * Words Controller
 *
 * @property \App\Model\Table\WordsTable $Words
 */
class WordsController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $user_id = $this->request->session()->read('user_id');
        $user_role = $this->request->session()->read('user_role');
        if ($user_role=='student') {
            $this->redirect(['controller' => 'Users', 'action' => 'dashboard']);
        }
    }
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => []
        ];
        $this->set('words', $this->paginate($this->Words));
        $this->set('_serialize', ['words']);
    }

    /**
     * View method
     *
     * @param string|null $id Word id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $word = $this->Words->get($id, [
            'contain' => []
        ]);
        $this->set('word', $word);
        $this->set('_serialize', ['word']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $word = $this->Words->newEntity();
        if ($this->request->is('post')) {
            $word = $this->Words->patchEntity($word, $this->request->data);
            if ($this->Words->save($word)) {
                $this->Flash->success(__('The word has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The word could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('word'));
        $this->set('_serialize', ['word']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Word id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $word = $this->Words->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $word = $this->Words->patchEntity($word, $this->request->data);
            if ($this->Words->save($word)) {
                $this->Flash->success(__('The word has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The word could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('word'));
        $this->set('_serialize', ['word']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Word id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $word = $this->Words->get($id);
        if ($this->Words->delete($word)) {
            $this->Flash->success(__('The word has been deleted.'));
        } else {
            $this->Flash->error(__('The word could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
