<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\Controller\Component;
use Cake\Mailer\Email;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['home','page','view','contact','faqs','getAjax','testgateway']);
        $this->set('form_templates', Configure::read('Templates'));
    }
    

    public function home()
    {
        $this->loadModel('MetaData');
        $getData = $this->MetaData->find('all')->toArray();
        $content = [];
        $i = 0;
        foreach($getData as $data)
        {   
            if($data['slug']=='testimonial')
            {
                $content['testimonials'][$i]['name'] = $data['title'];
                $content['testimonials'][$i]['content'] = $data['content'];
                $i++;
            }
            else
            {
            $content[$data['slug']]['title'] = $data['title'];
            $content[$data['slug']]['readmore'] = $data['readmore'];
            $content[$data['slug']]['content'] = $data['content'];
            }
            
        }
        
        $this->set(compact('content'));
    }

     public function view($slug = null)
    {
    	
    	$getPage = $this->Pages->get_page($slug);
    	if($getPage)
    	{
    		$this->set('page',$getPage);
    	}
    	else
    	{
    		$this->Flash->error('Page not found!');
    		$this->redirect(BASEURL);
    	}
    }

    public function faqs($slug = null)
    {
        $this->loadModel('MetaData');
        $data = $this->request->query;
        $conditions = [];
        $text = '';
        if($data)
        {
            $str = $data['search_faq'];
            if($str)
            {

             $str = preg_replace('/(<link[^>]+rel="[^"]*stylesheet"[^>]*>|<img[^>]*>|style="[^"]*")|<script[^>]*>.*?<\/script>|<style[^>]*>.*?<\/style>|<!--.*?-->/is', '', $str);
             $search = preg_replace("/[^a-zA-Z0-9\s]+/", " ", $str);
             $search = str_replace('|','',$search);
             $search = str_replace('/','',$search);
             $search=preg_replace('!\s+!', ' ', $search);
             $textexp = explode(' ',$search);
             $text = implode('|',$textexp);

             if($text)
             {
                $conditions['or'] = array('title REGEXP ("'.rtrim($text,'|').'")','content REGEXP ("'.rtrim($text,'|').'")');
             }
            }
        }
        if($text)
        {
            $searchtext = explode('|',$text);
            $searchtext = implode(' ',$searchtext);
        }
        else
        {
            $searchtext = '';
        }
        $faq = $this->MetaData->find('all',['conditions'=>['slug'=>'faq',$conditions]])->toArray();
        $this->set(compact('searchtext','faq'));
    }

    public function contact()
    {
        $this->loadModel('Settings');
        $data = $this->request->data;
        $setting = $this->Settings->find('all')->last();
        if($data)
        {
        $this->loadModel('Contacts');
        $contact = $this->Contacts->newEntity();
        $contact = $this->Contacts->patchEntity($contact,$data);

        if($this->Contacts->save($contact))
        {
            $email = new Email();
            $email->from(['support@vestotus.com' => 'Customer Support']);
            $content = '<table><tr><th>Name : </th><td>'.$data['name'].'</td></tr>
            <tr><th>Email : </th><td>'.$data['email'].'</td></tr>
            <tr><th>Phone : </th><td>'.$data['phone'].'</td></tr>
            <tr><th>Subject : </th><td>'.$data['subject'].'</td></tr>
            <tr><th>Message : </th><td>'.$data['comment'].'</td></tr>
            </table>';
            $email->emailFormat('html');
            $email->to($setting['contact_email']);
            $email->subject('Vestotus Website : Contact Request');
            $email->send($content);
            $this->Flash->success('Thank you for contacting us . Our Customer Support will contact you soon.');
            $this->redirect('');
        }
        else
        {
           
           $this->Flash->error('Please fix the errors below.');
        }
    }
    $this->set(compact('setting','contact'));
     
    }

    public function getAjax()
    {
        $this->autoRender = false;

        if($this->request->isajax())
        {
            $data = $this->request->data;
            $table_name = $data['table'];
            $conditions = $data['conditions'];
            $this->loadModel($table_name);
            $get = $this->$table_name->find('all',['conditions'=>[$conditions]])->toArray();
            $response['status'] = 'success';
            $response['data'] = $get;
            echo json_encode($response);
            exit;
        }
    }

    public function testgateway()
    {
        $this->autoRender = false; 
        $this->loadComponent('Authorize');
        $card['number'] = "4111111111111111";
        $card['exp_date'] = "2038-12";
        $card['cvv'] = "123";
        $payment['amount'] = 10;
        $payment['invoice_no'] = time();
        $payment['description'] = 'test description';
        $customer['first_name'] = 'Gaganpreet';
        $customer['last_name'] = 'Kaur';
        $customer['company'] = 'Xicom Technologies';
        $customer['address'] = 'test address';
        $customer['city'] = '';
        $customer['state'] = '';
        $customer['country'] = '';
        $customer['zipcode'] = '';
        $customer['id'] = '12';
        $customer['email'] = 'test@mailinator.com';
        $customer['last_name'] = 'Kaur';
        $customer['last_name'] = 'Kaur';
        $customer['last_name'] = 'Kaur';
        $customer['last_name'] = 'Kaur';
        $customer['last_name'] = 'Kaur';
        $auth = $this->Authorize->charge_card($card , $payment , $customer);
        print "<pre>";print_r($auth);exit;
    }
}
