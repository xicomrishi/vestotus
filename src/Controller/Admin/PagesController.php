<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Core\Configure;


/**
 * Admin/badges Controller
 *
 * @property \App\Model\Table\Admin/badgesTable $Admin/badges
 */
class PagesController extends AppController
{

    public $paginate = [
            'limit' =>5,
            'order' => [
                'Pages.id' => 'desc'
            ]
        ];
        public function initialize()
        {
            parent::initialize();
            $this->loadComponent('Paginator');
            $this->loadComponent('FileUpload');
        }
        public function beforeFilter(Event $event)
        {
            parent::beforeFilter($event);
            $this->Auth->allow();
            $this->set('form_templates', Configure::read('Templates'));
        }
    public function index()
    {
        $this->isAuthorized($this->Auth->user());
        $pages = $this->Pages->find('all')->toArray();

        $this->set(compact('pages'));
        $this->set('_serialize', ['pages']);
    }

    /**
     * View method
     *
     * @param string|null $id Admin/badge id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->isAuthorized($this->Auth->user());
        $pages = $this->Pages->get($id, [
            'contain' => []
        ]);

        $this->set('pages', $Pages);
        $this->set('_serialize', ['admin/badge']);
    }

   
    public function update($id = null)
    {
         $this->isAuthorized($this->Auth->user());
         $chk = $this->Pages->get_page($id);

         if($chk)
         {

         $page = $this->Pages->get($chk['id']);
        }
        else
        {
         $page = $this->Pages->newEntity();   
        }
         if($this->request->data)
         {
            $data = $this->request->data;
            
            if($data['banner']['name'])
            {
                if($page['banner'])
                {
                    $this->FileUpload->delete_file('uploads/'.$page['banner']);
                }
                $result = $this->FileUpload->image_upload($data['banner'],'');
                if($result['status']=='success')
                {
                    $data['banner'] = $result['filename'];
                }
                

            }
            else
            {
                $data['banner'] = $page['banner'];
            }
            
            $page = $this->Pages->patchEntity($page,$data);
            
            if($this->Pages->save($page))
            {
                $this->Flash->success('Page updated.');
                $this->redirect(['action'=>'index']);
            }
            else
            {

            }
         }
         $this->set('page',$page);
    }

    public function settings()
    {
        $this->isAuthorized($this->Auth->user());
        $this->loadModel('Settings');
        $setting = $this->Settings->get('1');
        $data = $this->request->data;
        if($data)
        {
            $setting = $this->Settings->patchEntity($setting,$data);
            if($this->Settings->save($setting))
            {
                $this->Flash->success('Settings Updated.');
            }
            else
            {

            }
        }
        $this->set('setting',$setting);
    }

    public function banner()
    {
        $this->isAuthorized($this->Auth->user());
       $this->loadModel('Settings');
        $setting = $this->Settings->get('1');
        $data = $this->request->data;
        if($data)
        {
            $img = explode(',',$setting['banners']);
            foreach($data['file'] as $files)
            {
                if($files['name']!=='')
                {
                    
                    $imgup = $this->FileUpload->upload($files,'');
                    if($imgup['status']=='success')
                    {
                        $img[] = $imgup['filename'];
                    }
                }
            }
            
            $data['banners'] = implode(',',$img);
            $setting = $this->Settings->patchEntity($setting,$data);
            if($this->Settings->save($setting))
            {
                $this->Flash->success('Settings Updated.');
                $this->redirect(['action'=>'banner']);
            }
            else
            {

            }
        }
        $this->set('setting',$setting);


    }

    public function del_banner($img=null)
    {
        $this->autoRender = false;
        $this->loadModel('Settings');
        if($img)
        {
            $del = $this->FileUpload->image_delete('uploads/'.$img);
            if($del)
            {
                $set = $this->Settings->get('1');
                $banners = explode(',',$set['banners']);
                $newbanner = [];
                foreach($banners as $ban)
                {
                    if($ban!==$img)
                    {
                        $newbanner[] = $ban;
                    }
                }
                $data['banners']=implode(',',$newbanner);
                $set = $this->Settings->patchEntity($set,$data);
                if($this->Settings->save($set))
                {
                    $this->Flash->success('Banner Deleted.');
                    $this->redirect(['action'=>'banner']);
                }
                else
                {
                    $this->Flash->success('Try again.');
                    $this->redirect(['action'=>'banner']);
                }
            }

        }
    }

    public function profile()
    {
      $this->isAuthorized($this->Auth->user());
      $this->loadModel('Users');
      $profile = $this->Users->get($this->Auth->user('id'));
      $data = $this->request->data;
      if($data)
      {
        if($data['passwrd'] || $data['cpassword'])
        {
            $data['password'] = $data['passwrd'];
            $data['confirm_password'] = $data['cpassword'];
        } 
        
        $profile = $this->Users->patchEntity($profile,$data);
        //pr($profile);exit;
        if($this->Users->save($profile))
        {
            $this->Flash->success('Profile Updated');
            $this->redirect(['action'=>'profile']);
        }
        else
        {
            //$this->Flash->error('Profile Updated');
        }
      }
      $this->set(compact('profile'));
    }

    public function cms()
    {
        
        $this->loadModel('MetaData');
      $this->isAuthorized($this->Auth->user());
        $pages = $this->MetaData->find('all',['conditions'=>['slug not in ("testimonial","faq")']])->toArray();

        $this->set(compact('pages'));
        $this->set('_serialize', ['pages']);
    }

    public function home($id = null)
    {
        $this->loadModel('MetaData');
         $this->isAuthorized($this->Auth->user());
         $chk = $this->MetaData->getBySlug($id);

         if($chk)
         {

         $page = $this->MetaData->get($chk['id']);
        }
        else
        {
         $page = $this->MetaData->newEntity();   
        }
         if($this->request->data)
         {
            $data = $this->request->data;
           
            
            $page = $this->MetaData->patchEntity($page,$data);
            
            if($this->MetaData->save($page))
            {
                $this->Flash->success('Content updated.');
                $this->redirect(['action'=>'cms']);
            }
            else
            {

            }
         }
         $this->set('page',$page);
    }

    public function manageTestimonials()
    {
         $this->loadModel('MetaData');
        $this->isAuthorized($this->Auth->user());
        $pages = $this->MetaData->find('all',['conditions'=>['slug'=>'testimonial']])->toArray();

        $this->set(compact('pages'));
        $this->set('_serialize', ['pages']);
    }

    public function addTestimonials($id = null)
    {
       $this->loadModel('MetaData');
         $this->isAuthorized($this->Auth->user());
         if($id)
         {

         $page = $this->MetaData->get($id);
        }
        else
        {
         $page = $this->MetaData->newEntity();   
        }
         if($this->request->data)
         {
            $data = $this->request->data;
            $data['slug'] = 'testimonial';
            
            $page = $this->MetaData->patchEntity($page,$data);
            
            if($this->MetaData->save($page))
            {
                $this->Flash->success('Testimonial updated.');
                $this->redirect(['action'=>'manageTestimonials']);
            }
            else
            {

            }
         }
         $this->set('page',$page);
    }

    public function manageFaqs()
    {
         $this->loadModel('MetaData');
        $this->isAuthorized($this->Auth->user());
        $pages = $this->MetaData->find('all',['conditions'=>['slug'=>'faq']])->toArray();

        $this->set(compact('pages'));
        $this->set('_serialize', ['pages']);
    }

    public function addFaq($id = null)
    {
       $this->loadModel('MetaData');
         $this->isAuthorized($this->Auth->user());
         if($id)
         {

         $page = $this->MetaData->get($id);
        }
        else
        {
         $page = $this->MetaData->newEntity();   
        }
         if($this->request->data)
         {
            $data = $this->request->data;
            $data['slug'] = 'faq';
            
            $page = $this->MetaData->patchEntity($page,$data);
            
            if($this->MetaData->save($page))
            {
                $this->Flash->success('Testimonial updated.');
                $this->redirect(['action'=>'manageFaqs']);
            }
            else
            {

            }
         }
         $this->set('page',$page);
    }

}
