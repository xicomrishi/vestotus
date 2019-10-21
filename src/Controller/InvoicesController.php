<?php
namespace App\Controller;

use Cake\Core\Configure;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use MPDF;
use Cake\Controller\Component\RequestHandlerComponent;

class InvoicesController extends AppController
{
		public $paginate = [
	        'limit' =>5,
	        'order' => [
	            'id' => 'desc'
	        ]
	    ];
	    
		public function initialize()
	    {
	        parent::initialize();
	        $this->loadComponent('Paginator');
	        $this->loadComponent('FileUpload');
	        $this->loadComponent('Myemail');
	        $this->loadComponent('RequestHandler');
	        $this->set('templates', Configure::read('Templates'));
	    }
		public function beforeFilter(Event $event)
	    {
	        parent::beforeFilter($event);
	        $this->Auth->allow();
	        $this->loadModel('PurchaseOrders');
	        $this->loadModel('Users');
	        $this->loadModel('Vendors');
	        $this->loadModel('UserDetails');
	        

	    }

	    public function manage()
	    {
	    	$this->is_permission($this->Auth->user());
	    	$user_id = $this->Auth->user('id');
	    	$compID = $this->UserDetails->getCompanyID($user_id);
	    	$company_id = $compID['company_id'];
	    	$this->loadModel('UserSettings');
	    	$this->loadModel('Cvendors');
			$getCustomers = $this->Cvendors->getVendorByCompany($company_id);
			if($this->Auth->user('role')=='2')
			{
				$settings = $this->UserSettings->getSetting($this->Auth->user('id'));
			}
			else
			{
				$settings = $this->UserSettings->getSetting($this->Auth->user('addedby'));
			}
			$search = $this->request->query;
			if($this->Auth->user('role')=='4')
			{
				$this->loadModel('InvoiceApprovers');
				$getvendors = $this->InvoiceApprovers->getVendorsbyUser($this->Auth->user('id'));
			}
			if($this->Auth->user('role')=='4' )
			{
				$vendorsimp = implode(',',$getvendors);
				$conditions[] = "Invoices.vendor_id in ('".$vendorsimp."')"; 
			}
			else
			{
				//$conditions['PurchaseOrders.addedby'] = $this->Auth->user('id'); 
				$conditions = [];
			}

			if($search)
			{
				
				$status = $search['status'];
				$start_date = $search['start_date'];
				$end_date = $search['end_date'];
				$customer = $search['customer'];
				$po_number = $search['po_number'];
				$po_start = $search['po_start'];
				$po_end = $search['po_end'];
				$time_frame = $search['time_frame'];
				if($time_frame && !$start_date && !$end_date)
				{
				$explodetime = explode('-',$time_frame);
				if($explodetime[0]=='D')
				{
					$type = 'days';
					$start_date = $this->PurchaseOrders->getDatefromDays($explodetime[1],$type);

				}
				if($explodetime[0]=='M')
				{
					$type = 'months';
					$start_date = $this->PurchaseOrders->getDatefromDays($explodetime[1],$type);
					 
				}
				if($explodetime[0]=='Y')
				{
					$type = 'year';
					$start_date = $this->PurchaseOrders->getDatefromDays($explodetime[1]+1,$type);
					 
				}
				
				}
				if(@$search['record']):				
				$records = $search['record'];
				else:
				$records = 10;

				endif;
				if($status):
				$conditions['Invoices.action'] = $status;
				endif;
				if($start_date):
				$conditions['Invoices.created >= '] = $start_date;
				endif;
				if($end_date):
				$conditions['Invoices.created <= '] = $end_date;
				endif;
				if($customer):
				$conditions['Invoices.vendor_id'] = $customer ;
				endif;
				if($po_number):
				$conditions['Invoices.invoice_number ='] = $po_number;
				endif;
				if($po_start && $po_end):
				$conditions[] = 'Invoices.invoice_amount between '.$po_start.'  and '.$po_end ;
				
				endif;
				if($po_start && !$po_end):
				$conditions['Invoices.invoice_amount > '] = $po_start;
				endif;
				if($po_end && !$po_start):
				$conditions['Invoices.invoice_amount < '] = $po_end;
				endif;

				
			}
			else
			{
				$search = array('status'=>'','record'=>'','start_date'=>'','end_date'=>'','time_frame'=>'','po_start'=>'','po_end'=>'','customer'=>'','po_number'=>''); 
				//$conditions = [];
				$records = '10';
				
			}
			//echo $user_id;
			//pr($conditions);exit;
			$this->paginate = [
	        'limit' =>$records,
	        'order' => [
	            'Invoices.id' => 'desc'
	        ]
	    ];
	    if($settings['invoice_app_type'])
			{
				$conditions['invoice_level'] = $settings['invoice_app_type'];
			}
			
	    $qry = $this->Invoices->find('all',['conditions'=>['Invoices.status '=>'1','Invoices.action !='=>'draft','Invoices.company_id'=>$company_id,$conditions],'contain'=>['PurchaseOrders','Vendor','PayearlyOffers','Attachments']]);
	    //echo json_encode($qry->toArray());exit;
			$list = $this->paginate($qry);
			$this->set(compact('list','getCustomers','search'));
	    }
	    public function index($type=null)
	    {
	    	$this->is_permission($this->Auth->user());
	    	$user_id = $this->Auth->user('id');
	    	$session = $this->request->session();
			$getCustomers = $session->read('Company');
			$search = $this->request->query;
			$cond1 =[];
			$cond2 =[];
			/*if($type=='nonpo')
			{

				$usession['id'] = $this->Auth->user('id');
				$usession['invoice_type'] = $type;
				$this->Users->sesisonsave($usession);
				
			}
			else if($type=='po')
			{
				$usession['id'] = $this->Auth->user('id');
				$usession['invoice_type'] = 'po';
				$this->Users->sesisonsave($usession);
			}*/
			$gettype = $this->Users->getsession($this->Auth->user('id'));
			$gettype = $gettype->invoice_type;
			/*if($gettype=='nonpo')
			{
				$cond1[] = ['Invoices.po_id'=>0];
			}*/
			if($this->Auth->user('role')==3)
			{
				$vendors = $this->UserDetails->is_exists($this->Auth->user('id'));
				$cond1[]= ['Invoices.department_id in ('.$vendors['department_id'].')'];
				$cond2[]= ['PurchaseOrders.department_id in ('.$vendors['department_id'].')'];
				$vendors =  $this->Vendors->getbyUserId($vendors['vendor_id']);	
				$vendors_id = $vendors['id'];
			}
			else
			{
				$vendors =  $this->Vendors->getbyUserId($this->Auth->user('id'));	
				$vendors_id = $vendors['id'];
			}
			$companyId = $session->read('Company');
			$po_orders = $this->PurchaseOrders->find('all',['conditions'=>[$cond2,'PurchaseOrders.vendors'=>$vendors_id,'PurchaseOrders.status'=>'1','PurchaseOrders.action'=>'open','PurchaseOrders.company_id'=>$companyId['id']],'order' => [
	            'PurchaseOrders.id' => 'desc'
	        ],'fields'=>['PurchaseOrders.id','PurchaseOrders.po_num'] ])->toArray();
	        if($search)
			{
				$status = $search['status'];
				$start_date = $search['start_date'];
				$end_date = $search['end_date'];
				$customer = $search['customer'];
				$po_number = $search['po_number'];
				$po_start = $search['po_start'];
				$po_end = $search['po_end'];
				$time_frame = $search['time_frame'];
				if($time_frame && !$start_date && !$end_date)
				{
					$explodetime = explode('-',$time_frame);
				if($explodetime[0]=='D')
				{
					$type = 'days';
					$start_date = $this->PurchaseOrders->getDatefromDays($explodetime[1],$type);
				}
				if($explodetime[0]=='M')
				{
					$type = 'months';
					$start_date = $this->PurchaseOrders->getDatefromDays($explodetime[1],$type);
				}
				if($explodetime[0]=='Y')
				{
					$type = 'year';
					$start_date = $this->PurchaseOrders->getDatefromDays($explodetime[1]+1,$type);
					 
				}
				}
				if(@$search['record']):				
				$records = $search['record'];
				else:
				$records = 10;
				endif;
				if($status):
				$conditions['Invoices.action'] = $status;
				endif;
				if($start_date):
				$conditions['Invoices.created >= '] = $start_date;
				endif;
				if($end_date):
				$conditions['Invoices.created <= '] = $end_date;
				endif;
				if($customer):
				$conditions['Invoices.company_id'] = $customer ;
				endif;
				if($po_number):
				$conditions['Invoices.invoice_number ='] = $po_number;
				endif;
				if($po_start && $po_end):
				$conditions[] = 'Invoices.invoice_amount between '.$po_start.'  and '.$po_end ;
				endif;
				if($po_start && !$po_end):
				$conditions['Invoices.invoice_amount > '] = $po_start;
				endif;
				if($po_end && !$po_start):
				$conditions['Invoices.invoice_amount < '] = $po_end;
				endif;
			}
			else
			{
				$search = array('status'=>'','record'=>'','start_date'=>'','end_date'=>'','time_frame'=>'','po_start'=>'','po_end'=>'','customer'=>'','po_number'=>''); 
				$conditions = $cond1;
				$records = '10';
				
			}
			$this->paginate = [
		        'limit' =>$records,
		        'order' => [
		            'Invoices.id' => 'desc'
		        ]
	    	];
	    	//pr($conditions);exit;
	    	$company_id = $session->read('Company');
	    	$qry = $this->Invoices->find('all',['conditions'=>['Invoices.vendor_id'=>$vendors_id,'Invoices.company_id'=>$company_id['id'],'Invoices.company_id'=>$company_id['id'],'Invoices.status !='=>'2',$conditions] ,'contain'=>['Users','Companies']]);
	   		$list = $this->paginate($qry);
			$this->set(compact('list','getCustomers','search','po_orders','gettype'));
	    }

	    public function managePayEarly()
	    {

	    	$this->is_permission($this->Auth->user());
	    	$this->loadModel('UserSettings');
	    	$this->loadModel('Cvendors');
			if($this->Auth->user('role') == 3 || $this->Auth->user('role') == 5 || $this->Auth->user('role') == 4 )
            {
                $cus_settings = $this->UserSettings->getSetting($this->Auth->user('addedby'))   ;
            }
            else
            {
                $cus_settings = $this->UserSettings->getSetting($this->Auth->user('id'))   ;

            }
	    	
	    	if($cus_settings['pay_early_accept']!=='enabled') 
			{ 
				//$this->Flash->error('Payearly Offers are disabled.');
				$this->redirect(['action'=>'manage']);
			}
	    	$page = "managePayEarly";
			$this->loadModel('PayearlyOffers');
	    	$user_id = $this->Auth->user('id');
	    	$compID = $this->UserDetails->getCompanyID($user_id);
			$getCustomers = $this->Cvendors->getVendorByCompany($compID['company_id']);
			$todaydate = date('Y-m-d');
			
			$search = $this->request->query;
			$conditions['Invoices.pay_early'] = '1';
			if($search)
			{
				
				$status = $search['status'];
				$start_date = $search['start_date'];
				$end_date = $search['end_date'];
				$customer = $search['customer'];
				$po_number = $search['po_number'];
				$po_start = $search['po_start'];
				$po_end = $search['po_end'];
				$time_frame = $search['time_frame'];
				if($time_frame && !$start_date && !$end_date)
				{
				$explodetime = explode('-',$time_frame);
				if($explodetime[0]=='D')
				{
					$type = 'days';
					$start_date = $this->PurchaseOrders->getDatefromDays($explodetime[1],$type);

				}
				if($explodetime[0]=='M')
				{
					$type = 'months';
					$start_date = $this->PurchaseOrders->getDatefromDays($explodetime[1],$type);
					 
				}
				if($explodetime[0]=='Y')
				{
					$type = 'year';
					$start_date = $this->PurchaseOrders->getDatefromDays($explodetime[1]+1,$type);
					 
				}
				
				}
				if(@$search['record']):				
				$records = $search['record'];
				else:
				$records = 10;

				endif;
				if($status):
					if($status == 'open')
					{
						$conditions[]= 'PayearlyOffers.status IS NULL';
						$conditions[]= "Invoices.due_date >= CURDATE()";
					}
					else if($status == 'expired')
					{
						$conditions[]= "Invoices.due_date < CURDATE()";
						$conditions[]= 'PayearlyOffers.status IS NULL';

					}
					else
					{
						$conditions['PayearlyOffers.status'] = $status;
					}
				
				endif;
				if($start_date):
				$conditions['Invoices.created >= '] = $start_date;
				endif;
				if($end_date):
				$conditions['Invoices.created <= '] = $end_date;
				endif;
				if($customer):
				$conditions['Invoices.vendor_id'] = $customer ;
				endif;
				if($po_number):
				$conditions['Invoices.invoice_number ='] = $po_number;
				endif;
				if($po_start && $po_end):
				$conditions[] = 'Invoices.invoice_amount between '.$po_start.'  and '.$po_end ;
				
				endif;
				if($po_start && !$po_end):
				$conditions['Invoices.invoice_amount > '] = $po_start;
				endif;
				if($po_end && !$po_start):
				$conditions['Invoices.invoice_amount < '] = $po_end;
				endif;

				
			}
			else
			{
				$search = array('status'=>'','record'=>'','start_date'=>'','end_date'=>'','time_frame'=>'','po_start'=>'','po_end'=>'','customer'=>'','po_number'=>''); 
				//$conditions = [];
				$records = '10';
				
			}
			//echo $user_id;
			//echo json_encode($conditions);
			$this->paginate = [
	        'limit' =>$records,
	        'order' => [
	            'Invoices.id' => 'desc'
	        ]
	    ];
	    
	    $company_id = $this->UserDetails->is_exists($this->Auth->user('id'));

	    $qry = $this->Invoices->find('all',['conditions'=>['Invoices.company_id'=>$company_id['company_id'],'Invoices.status !='=>'2',$conditions],'contain'=>['Users','Companies','PayearlyOffers']]);
	   
			$list = $this->paginate($qry);
			$this->set(compact('list','getCustomers','search','page'));
	    }

	    public function view($id=null)
	    {
	    		$this->is_permission($this->Auth->user());
	    		$this->loadModel('UserSettings');
	    		$inlevel = '';
	    		if($this->Auth->user('role') == 2 || $this->Auth->user('role') == 4 )
	    		{
	    		$company_id = $this->UserDetails->getCompanyId($this->Auth->user('id'));
	    		$company_id = $company_id['company_id'];
	    		if($this->Auth->user('role')=='2')
				{
					$settings = $this->UserSettings->getSetting($this->Auth->user('id'));
				}
				else
				{
					$settings = $this->UserSettings->getSetting($this->Auth->user('addedby'));
				}
				$inv_level = $settings['invoice_app_type'];

				
				}
	    		else if($this->Auth->user('role') == 3 || $this->Auth->user('role') == 5)
	    		{
	    			$session = $this->request->session();
	    			$vendor_company = $session->read('Company');
	    			$company_id = $vendor_company['id'];
	    		}
	    		else
	    		{
	    			$company_id = 0;
	    		}
	    		if($this->Auth->user('role')==3):
	    		
	    			$vendor = $this->Vendors->getbyUserId($this->Auth->user('addedby'));
	    			$vendor_id = $vendor['id'];
	    		elseif($this->Auth->user('role')==5):
	    			$vendor = $this->Vendors->getbyUserId($this->Auth->user('id'));
	    			$vendor_id = $vendor['id'];
	    			else:
	    			$vendor_id = null;
	    		endif;
	    		$invoice = $this->Invoices->is_exists($id,$this->Auth->user('id'),$this->Auth->user('role'),$company_id,$vendor_id,$inv_level);
	    		
	    		if(!$invoice)
	    		{

	    			if($this->Auth->user('role')== 2 || $this->Auth->user('role')== 4 )
	    			{
	    				
	    				return $this->redirect(['action'=>'manage']);
	    				exit;
	    			}
		    		else
		    		{

						return $this->redirect(['action'=>'index']);	
						exit;
		    		}

		    		
		    	}
		    	else
		    	{
	    		if($invoice['action']=='new' && $this->Auth->user('role')=='2')
	    		{
	    			$getinv = $this->Invoices->setStatusopen($invoice['id']);
	    			$invoice['action']='Open';
	    		}

	    		$getnext = '';
	    		$getprevious = '';
	    		//$invgetrow = $this->Invoices->getTotalInvoices($this->Auth->user('id'),$this->Auth->user('role'),$company_id,$vendor_id);
	    		$appprogress = '';
	    		$this->loadModel('SetApprovers');
	    		$this->loadModel('InvoiceApprovers');
	    		$this->loadModel('ApprovedInvoices');
	    		$this->loadModel('InvoiceComments');

	    		$total_no_approval = 0;
	    		$total_no_comments = $this->InvoiceComments->total_comments($invoice['id']);
	    		if($invoice['invoice_level']=='singlelevel')
	    		{
	    			if($invoice['action']=='open')
	    			{
	    				$approgress = 0;
	    			}
	    			else if ($invoice['action']=='approved' || $invoice['action']=='denied' || $invoice['action']=='hold')
	    			{
	    				$approgress = 100;
	    			}
	    		}
	    		
	    		elseif($invoice['invoice_level']=='multilevel')
	    		{
	    			$getApprovers = $this->SetApprovers->getApprovers($invoice['id']);
					if(count($getApprovers) > 0)
					{
						$ttlapp = count($getApprovers);
						$total_no_approval = $ttlapp;
						
					
					}
					else
					{
						$getApprovers = $this->InvoiceApprovers->getApprovers($invoice['vendor_id']);
						if(count($getApprovers)>0)
					{
						
						$ttlapp = count($getApprovers);
						$total_no_approval = $ttlapp;
					}
					else
					{
						if ($invoice['action']=='approved' || $invoice['action']=='denied' || $invoice['action']=='hold')
	    			{
	    				$ttlapp = 100;
	    			}
	    			else
	    			{
						$ttlapp = 0;
	    			}
					}
					}
					$appnum = $this->ApprovedInvoices->getttlApp($invoice['id']);
					if($ttlapp>0)
					{
					$approgress = (1 + $appnum)/(1 + $ttlapp ) * 100;
					}
					else
					{
					$approgress = (1/$ttlapp ) * 100;	
					}
	    		}

	    		$now = strtotime(date('Y-m-d'));
				$your_date = strtotime($invoice['invoice_date']->format('Y-m-d'));
				$datediff = $now - $your_date;
				$did = floor($datediff / (60 * 60 * 24));
				$ptd = explode('-',$invoice['payment_terms']);
				$ptd = $ptd[0];
				$percentage = 100 * $did/$ptd;
				
	    		if($invoice['action']=='new')
	    		{
	    			$content = 'Pending';
	    			$approgress =0;
	    		}
	    		else if ($invoice['action']=='open')
	    		{
	    			$content = "Approving";
	    			$approgress = round($percentage);
	    			if($approgress > 100)
	    			{
	    				$approgress = 90;
	    			}
	    		}
	    		else if ($invoice['action']=='approved')
	    		{
	    			$content = 'Approved';
	    			$approgress = 100;
	    		}
	    		else if ($invoice['action']=='denied')
	    		{
	    			$content = 'Denied';
	    			$approgress = 100;
	    		}
	    		else if ($invoice['action']=='canceled')
	    		{
	    			$content = 'Canceled';
	    			$approgress = 100;
	    		}
	    		else if ($invoice['action']=='written_off')
	    		{
	    			$content = 'Written Off';
	    			$approgress = 100;
	    		}
	    		$approgress = round($approgress,2);
	    		$this->loadModel('UserSettings');
	    		if($this->Auth->user('role')=='2')
				{
					$settings = $this->UserSettings->getSetting($this->Auth->user('id'));
					if($settings['invoice_app_type'])
					{
						$conditions['invoice_level'] = $settings['invoice_app_type'];
					}
				}
				else
				{
					//$settings = $this->UserSettings->getSetting($this->Auth->user('addedby'));
				}
				
	    		//echo $approgress;exit;
	    		if(!$invoice)
	    		{
	    			$this->Flash->success(__('You are not authorised to view this invoice .'));
	    			$this->redirect($this->referer());
	    		}
	    		else
	    		{
	    			
	    			$getnext = $this->Invoices->getnextprevious($invoice['id'],$this->Auth->user('id'),$this->Auth->user('role'),$company_id,$vendor_id,'next',$inv_level);
	    			$getprevious = $this->Invoices->getnextprevious($invoice['id'],$this->Auth->user('id'),$this->Auth->user('role'),$company_id,$vendor_id,'previous',$inv_level);

	    			@$getnext = $getnext[0]['invoice_number'];
	    			@$getprevious = $getprevious[0]['invoice_number'];

	    			$ttl = $this->Invoices->getTotalInvoices($this->Auth->user('id'),$this->Auth->user('role'),$company_id,$vendor_id,$inv_level);
	    			$cur_page = $this->Invoices->get_curpageno($this->Auth->user('id'),$this->Auth->user('role'),$company_id,$vendor_id,$invoice['id'],$inv_level);
	    			$user_id = $this->Auth->user('id');
	    			if($user_id== $invoice['customer_id'])
	    			{
	    				$invoice['customer_view'] = '1';
	    			}
	    			else if($user_id== $invoice['addedby'])
	    			{
	    				$invoice['admin_view'] = '1';
	    			}
	    		}
	    		
	    		$this->set(compact('invoice','getnext','getprevious','ttl','approgress','cur_page','total_no_approval','total_no_comments','content'));
	    	}
		}

		public function add($po_num=null,$id=null)
		{
			$invoice = $this->Invoices->newEntity();
			$this->is_permission($this->Auth->user());
			$this->loadModel('UserSettings');
			$this->loadModel('Departments');
			$this->loadModel('PoAttachments');
			$this->loadModel('PurchaseProducts');
			$session = $this->request->session();
        	$refer = $this->request->query;
        	$companyId = $session->read('Company');
          	@$referer =  $refer['q'];
          	$cond1 = [];
        	if($this->Auth->user('role')==3)
			{
			$vendors = $vendors = $this->UserDetails->is_exists($this->Auth->user('id'));
			$getDpt = $this->Departments->getVendorDpt($companyId['id'],$vendors['department_id']);
			$vendors_id = $vendors['vendor']['id'];
			$cond1[] = ['PurchaseOrders.department_id in ('.$vendors['department_id'].')'];
			}
			else
			{
			$vendors = $vendors = $this->Vendors->getbyUserId($this->Auth->user('id'));	
			$getDpt = $this->Departments->getVendorDpt($companyId['id']);
			$vendors_id = $vendors['id'];
			}
			$settings = $this->UserSettings->getSetting($this->Auth->user('addedby'));
			$currency = $settings['currency'];
			$payment_terms_setting = $settings['payment_terms'];
			if($id)
			{
				$record = 'old';
				$invoice= $this->Invoices->get($id,['contain'=>['Attachments','Products','PurchaseOrders','PurchaseOrders.PurchaseProducts']]);
			}
			else
			{
				$record = 'new';
			}
			if($this->Auth->user('role')==3)
			{
				$vendors = $this->UserDetails->getVendorId($this->Auth->user('id'));
				$vendorId = $vendors['vendor']['id'];
			}
			else if($this->Auth->user('role')==5)
			{
				 $vendorLog = $this->Auth->user('id');
				 $vendorId = $this->Vendors->getbyUserId($vendorLog);
				 $vendorId = $vendorId['id'];
			}
			if($po_num!=='non_po')
			{
				$getOrder = $this->PurchaseOrders->getPurchaseOrder($vendors['vendor']['id'],$po_num);
			}
			else
			{
				$getOrder = [];
			}
			$this->loadModel('Companies');
			$user = $this->Users->getUser($this->Auth->user('id'));
			@$company_id = $this->UserDetails->getCompanyId($getOrder['company_id']);
			$getCompany = $this->Companies->getCompany($session->read('Company.id'));
			$getLast = $this->Invoices->getLastInvoice($this->Auth->user('id'));
			$getcontacts = $this->Users->getVendorsUsers($this->Auth->user('id'),$getCompany['id']);
			$getvendors = $this->Users->getCompanyVendors($this->Auth->user('id'),$getCompany['id']);
			$vendor_details = $this->Vendors->get($vendors_id,['contain'=>'Departments']);
			
			$po_orders = $this->PurchaseOrders->find('all',['conditions'=>[$cond1,'PurchaseOrders.vendors'=>$vendorId,'PurchaseOrders.status'=>'1','PurchaseOrders.action'=>'open','PurchaseOrders.company_id'=>$companyId['id']],'order' => [
	            'PurchaseOrders.id' => 'desc'
	        ],'fields'=>['PurchaseOrders.id','PurchaseOrders.po_num'] ])->toArray();
	        @$getappinv = $this->Invoices->getApprovedInv($getOrder['id']);
			if(count($po_orders) == 1 && !$po_num)
	        {
	        	$this->redirect(['action'=>'add',$po_orders[0]['po_num']]);
	        }
			if($getOrder)
			{
				$exists = $this->Invoices->exists($po_num);
				if($exists)
				{
					//$invoice = $this->Invoices->get($exists['id'],['contain'=>['Attachments']]);
				}
				$record = 'new';
				$data = $this->request->data;
				$img = array();
			}
			else
			{
				//$this->redirect(['controller'=>'PurchaseOrders','action'=>'manage_purchase']);
			}
			if($this->request->data)
			{
					$data = $this->request->data;
					//pr($data);exit;
					if($data['deleted_pid'])
					{
						$exp = explode(',',$data['deleted_pid']);
						foreach($exp as $id)
						{
							if($id)
							{
								echo $this->PurchaseProducts->deletebyid($id);
							}
						}

					}
					if(@$data['action_button']=='Save' || $data['pay_early']=='1')
					{
						$data['action'] = 'draft';
					}
					else
					{
						$data['action'] = 'new';
						$data['cus_arival_date'] = date('Y-m-d H:i:s');
					}
					$data['addedby'] = $this->Auth->user('id');
					$data['tax_percentage'] = $data['taxselect'];
					if($data['attach_files'])
					{
						$attimg = array();
						$i = 0;
						foreach($data['attach_files'] as $files1)
						{	
							if($files1['tmp_name']):
								/*if($data['file_names'][$i])
								{
									$fname = $data['file_names'][$i];
								}
								else
								{
									$fname = '';
								}*/
							$img = $this->FileUpload->upload($files1,'');
							$attimg[$i]['file'] = $img['filename'];
							@$attimg[$i]['name'] = $data['file_names'][$i];
							endif;
							$i++;
						}
					}
					if(@$data['att_files'])
					{
						$tttl = count($data['att_files']);
						$datafile = array();
						for($i=0;$i < $tttl ; $i ++)
						{
						$datafile[$i]['id'] = $data['att_files'][$i];						
						$datafile[$i]['name'] = $data['file_names'][$i];						
						$this->PoAttachments->updatename($datafile);
						}
					}
					//pr($attimg);exit;
					$data['logo'] = $data['logo_saved'];
					$data['status'] = 1;
					$data['subtotal'] = $data['grand_total'];
					$data['tax_percentage'] = $data['taxselect'];
					if($data['delivery_date'])
					{
						$data['delivery_date'] = date('Y-m-d',strtotime($data['delivery_date']));
					}
					$data['due_date'] = date('Y-m-d',strtotime($data['due_date']));
					$data['invoice_date'] = date('Y-m-d',strtotime($data['invoice_date']));
					$session = $this->request->session();
					$company_id = $session->read('Company');
	    			$company_id = $company_id['id'];
	    			$data['company_id'] = $company_id;
	    			$getinvoice_type = $this->UserSettings->getSetting($data['customer_id']);
	    			$data['invoice_level'] = $getinvoice_type['invoice_app_type'];
	    			if($data['deliver_select'])
	    			{
					$data['department_id'] = $data['deliver_select'];
					}
					else
					{
						$data['department_id'] = $data['department_id'];
					}
					//pr($invoice);exit;
					if($data['action_button']=='Send')
					{
						$invoice = $this->Invoices->patchEntity($invoice, $data);
						
					}
					elseif($data['action_button'] =='Save')
					{
						$invoice = $this->Invoices->patchEntity($invoice, $data,['validate' => false]);
						
					}
					//pr($invoice);exit;
					if($this->Invoices->save($invoice))
					{
						if($data['credit_applied'] > 0)
						{
							$this->loadModel('CreditNotes');
							$this->loadModel('CreditHistory');
							$ttlcrn = count($data['creditNote']);
							for($j = 0 ; $j < $ttlcrn; $j++)
							{
								$getcrn = $this->CreditNotes->get($data['creditNote'][$j]);
								$creditdata['balance'] = $getcrn['total'] - $data['crnam_used'][$j] ;
								$getcrn = $this->CreditNotes->patchEntity($getcrn,$creditdata);
								if($this->CreditNotes->save($getcrn))
								{
									$newhistory = $this->CreditHistory->newEntity();
									$history['invoice_id'] = $invoice['id'];
									$history['customer_id'] = $invoice['customer_id'];
									$history['vendor_id'] = $invoice['vendor_id'];
									$history['crn_id'] = $getcrn['id'];
									$history['amount_used'] = $data['crnam_used'][$j];
									$newhistory = $this->CreditHistory->patchEntity($newhistory,$history);
									$this->CreditHistory->save($newhistory);
								}
							}
						}
						
						if($data['Recurring'] && $data['recurring_invoice'] ==1 )
						{
							$this->loadModel('RecurringInvoices');
							if($invoice['recurring_id']>0)
							{
								$newinv = $this->RecurringInvoices->get($invoice['recurring_id']);
							}
							else
							{
								$newinv = $this->RecurringInvoices->newEntity();
							}
							$rdata['customer_id'] = $invoice['customer_id'];
							$rdata['recurring_inv_num'] = $invoice['Recurring']['invoice_no'];
							if($invoice['po_id'] > 0)
							{
							$rdata['po_id'] = $invoice['po_id'];
							$rdata['invoice_type'] = 'po';
							}
							else
							{
							$rdata['po_id'] = 0;
							$rdata['invoice_type'] = 'non-po';
							}
							$rdata['invoice_id'] = $invoice['id'];
							$rdata['payment_period'] = $data['Recurring']['payment_period'];
							$rdata['company_id'] = $data['Recurring']['company_id'];
							$rdata['start_on'] = date('Y-m-d',strtotime($data['Recurring']['start_on']));
							$rdata['end_on'] = date('Y-m-d',strtotime($data['Recurring']['end_on']));
							$rdata['vendor_id'] = $invoice['vendor_id'];
							$rdata['amount'] = $invoice['invoice_amount'];
							$rdata['status'] = $data['Recurring']['status'];
							$rdata['refrence'] = $data['Recurring']['refrence'];
							$rdata['occurrences'] = $data['Recurring']['occurrences'];
							$rdata['remaining'] = $data['Recurring']['occurrences'];
							@$rdata['no_end_date'] = $data['Recurring']['no_end_date'];
							$rdata['addedby'] = $this->Auth->user('id');
							$newinv = $this->RecurringInvoices->patchEntity($newinv,$rdata);
							//pr($newinv);exit;
							$this->RecurringInvoices->save($newinv);
							$invoice['recurring_id'] = $newinv->id;
							$this->Invoices->save($invoice);
							
						}

							if($invoice['status']==1 && $invoice['po_id'])
							{
								$this->loadModel('InvoiceApprovers');
								$this->loadModel('SetApprovers');
								$chkApp = $this->InvoiceApprovers->checkautoLink($invoice['po_id']);
								$arr = [];
								if($chkApp)
								{
									foreach($chkApp as $app)
									{
										
										$dt['addedby'] = $app['addedby'];
										$dt['inv_id'] = $invoice['id'];
										$dt['user_id'] = $app['user_id'];
										$dt['priority'] = $app['priority'];
										$setApp = $this->SetApprovers->add($dt);
										
									}

								}
							}
							
							$count = count(@$data['pquantity']);
							for($i=0;$i < $count;$i++)
							{
								if(!@$data['discount'][$i])
								{
									$data['discount'][$i] = 0;
								}
								$prod = $this->PurchaseProducts->newEntity();
								if(@$data['pid'][$i]>0)
								{
								$prod = $this->PurchaseProducts->get($data['pid'][$i]);	
								}
								$prod['addedby'] = $this->Auth->user('id');
								$prod['unit'] = $data['unit_no'][$i];
								$prod['quantity'] = $data['pquantity'][$i];
								$prod['description'] = $data['pdescription'][$i];
								$prod['unit_price'] = $data['punit_price'][$i];
								@$prod['discount'] = $data['discount'][$i];
								$pdata['total_cost'] = $data['ptotal_cost'][$i];
								@$pdata['dis_total'] = $data['ptotal_cost'][$i]*$data['discount'][$i]/100;
								$pdata['inv_id'] = $invoice->id;
								$prod  = $this->PurchaseProducts->patchEntity($prod,$pdata);
								//pr($prod);
								$this->PurchaseProducts->save($prod); 
								//pr($dv);
								
							}
					//echo 'hello2';
					$new_invoice = $invoice->id;
					@$total_items = count($data['unit_no']);
					if($attimg)
					{
						foreach($attimg as $imgs)
						{
							
							$poatt = $this->PoAttachments->newEntity();
							$attdata['attachment'] = $imgs['file'];
							$attdata['user_id'] = $this->Auth->user('id');
							$attdata['po_id'] = $getOrder['id'];
							$attdata['invoice_id'] = $invoice->id;
							$attdata['type'] = "invoice";
							$attdata['name'] = $imgs['name'];
							$poatt = $this->PoAttachments->patchEntity($poatt,$attdata);
							$this->PoAttachments->save($poatt);
						}
					}
					
						if($record=='new')
						{	
						$emailData['id'] = $invoice->invoice_number;
						$emailData['name'] = $invoice['customer_name'];
						if($data['po_num'])
						{
						$emailData['po_num'] = $invoice['po_num'];
						}
						else
						{
						$emailData['po_num'] = '';	
						}
						$emailData['email'] = $this->Users->getEmail($invoice['customer_id']);

						
						$chk = $this->Myemail->new_invoice($emailData);
						}

					

						 $this->Flash->success(__('Invoice created!'));
						 if($invoice['recurring_invoice'] == 1)
							{
								$this->redirect(['action'=>'recurringInvoices']);	
							}
						 else if($refer['q'] && $refer['q']=='poinv')
							{
								$this->redirect(['controller'=>'PurchaseOrders','action'=>'manage_purchase']);	
							}

							else
							{
						  		$this->redirect(['action'=>'index']);	
							}
					}
					else
					{
						$this->Flash->error(__('error'));
					}

				}


			$departments = $this->UserDetails->get_fadmin_departments($getCompany['id']);
			if($this->Auth->user('role')==3)
			{
				$signature = $this->UserDetails->getSigLogo($this->Auth->user('id'));
			}
			else
			{
				$signature = $this->Vendors->getSigLogo($this->Auth->user('id'));
			}

			$backurl = parse_url($this->referer(), PHP_URL_PATH);
			if(strpos($backurl, 'add/') !== false)
			{
				$backurl = substr($backurl, 0, strpos($backurl, "add/")+3);
			}
			$currentreferer = parse_url(BASEURL, PHP_URL_PATH).'invoices/add/'.$po_num;
			$currentreferer1 = parse_url(BASEURL, PHP_URL_PATH).'invoices/add';
			if($backurl !== $currentreferer && $backurl !== $currentreferer1)
			{
				$session->write('backurl',$backurl);
			}
			$backurl = $session->read('backurl');
			$lastpage = substr($backurl,strrpos($backurl,'/') + 1);
			$this->set(compact('getOrder','invoice','img','currency','getLast','getcontacts','getvendors','signature','po_orders','vendor_details','getCompany','payment_terms_setting','getDpt','getappinv','referer','po_num','lastpage'));
		}

		public function customerApprovals($invoice_num=null)
		{
			$this->is_permission($this->Auth->user());
			$this->loadModel('InvoiceApprovers');
			$this->loadModel('SetApprovers');
			$this->loadModel('ApprovedInvoices');
			$this->loadModel('Departments');
			$approvers = $this->InvoiceApprovers->newEntity();
			$invoice = $this->Invoices->getDetails($invoice_num);
			//$paginate_qry = $this->ApprovedInvoices->find('all',['conditions'=>['invoice_id'=>$invoice['id']],'contain'=>'Users'])->toArray();
			//
			$this->loadModel('InvoiceComments');
	    		$total_no_approval = 0;
	    		$total_no_comments = $this->InvoiceComments->total_comments($invoice['id']);
	    		
			if($this->Auth->user('role') == 2 || $this->Auth->user('role') == 4 )
			{
				$company_id = $this->UserDetails->getCompanyId($this->Auth->user('id'));
				$company_id = $company_id['company_id'];
			}
			else if($this->Auth->user('role') == 3 || $this->Auth->user('role') == 5)
			{
				$session = $this->request->session();
				$vendor_company = $session->read('Company');
				$company_id = $vendor_company['id'];
			}
			else
			{
				$company_id = 0;
			}
			if($this->Auth->user('role')==3):
			
				$vendor = $this->Vendors->getbyUserId($this->Auth->user('addedby'));
				$vendor_id = $vendor['id'];
			elseif($this->Auth->user('role')==5):
				$vendor = $this->Vendors->getbyUserId($this->Auth->user('id'));
				$vendor_id = $vendor['id'];
				else:
				$vendor_id = null;
			endif;
			$departments = $this->Departments->getList($this->Auth->user('id'));
			//$getApprovers = $this->SetApprovers->getApprovers($invoice['id']);
			$paginate_qry = $this->SetApprovers->find('all',['conditions'=>['SetApprovers.inv_id'=>$invoice['id']],'contain'=>['Users'],'order'=>'SetApprovers.priority = 0, SetApprovers.priority ASC']);
				//$getList = $this->paginate(@$paginate_qry);
			$getList = $paginate_qry->toArray();
				
			

			$getprevious = '';
			$getnext = '';
			$ttl ='';
			$total_no_approval = count(@$getList);
			if($invoice)
			{
				$this->loadModel('UserSettings');
				if($this->Auth->user('role')=='2' || $this->Auth->user('role')=='4') 
				{
					if($this->Auth->user('role')=='4')
					{
						$setid = $this->Auth->user('addedby');
					}
					else 
					{
						$setid = $this->Auth->user('id');
					}
					$settings = $this->UserSettings->getSetting($setid);
					$inv_level = '';
					if($settings['invoice_app_type'])
					{
						$inv_level = $settings['invoice_app_type'];
					}
				} 
				$getnext = $this->Invoices->getnextprevious($invoice['id'],$this->Auth->user('id'),$this->Auth->user('role'),$company_id,$vendor_id,'next',$inv_level);
	    			$getprevious = $this->Invoices->getnextprevious($invoice['id'],$this->Auth->user('id'),$this->Auth->user('role'),$company_id,$vendor_id,'previous',$inv_level);

	    			@$getnext = $getnext[0]['invoice_number'];
	    			@$getprevious = $getprevious[0]['invoice_number'];
				$ttl = $this->Invoices->getTotalInvoices($this->Auth->user('id'),$this->Auth->user('role'),$company_id,$vendor_id,$inv_level);
				//echo $company_id;exit;
				$getUsers = $this->Users->find('all',['conditions'=>['Users.status'=>'1','UserDetails.company_id'=>$company_id,'Users.role'=>'4'],'contain'=>['UserDetails','UserDetails.tbl_department']])->toArray();
				$cur_page = $this->Invoices->get_curpageno($this->Auth->user('id'),$this->Auth->user('role'),$company_id,$vendor_id,$invoice['id']);
				$ausers = [];
				$i = 0;
				if($this->Auth->user('role')=='4')
				{
				$validateUserforAction = $this->SetApprovers->checkApprover($invoice['id'],$this->Auth->user('id'));
					if(!$validateUserforAction)
					{
						$validateUserforAction = $this->InvoiceApprovers->checkApprover($invoice['addedby'],$this->Auth->user('id'));
						
					}
					//pr($validateUserforAction);exit;
					if($validateUserforAction)
					{
						$priority = $validateUserforAction['priority']; 
						$getVendors = $this->SetApprovers->getPriorityUsers($invoice['id'],$priority);
						if(!$getVendors)
						{
							$getVendors = $this->InvoiceApprovers->getPriorityUsers($invoice['addedby'],$priority);
						}
						$this->loadModel('ApprovedInvoices');

						$checkActions = $this->ApprovedInvoices->checkActionsbyUsers($getVendors,$invoice['id']);
						$check_user_comment =  $this->ApprovedInvoices->status_updated_by_user($this->Auth->user('id'),$invoice['id']);
						if(count($checkActions) == 0 && $check_user_comment == 0 )
						{
							$action = 'permitted';
						}
						else
						{
							$action = 'denied';
						}

					}else
						{
							$action = 'denied';
						}
				}
				
				else
				{
					$validateUserforAction ='';
					$action ='';
				}

				foreach($getUsers as $users)
				{

					$ausers[$i]['email'] = $users['email']; 
					$ausers[$i]['id'] = $users['id']; 
					$ausers[$i]['fullname'] = $users['fullname'];
					$ausers[$i]['department'] = $users['user_detail']['tbl_department']['department_name']; 
					$ausers[$i]['department_id'] = $users['user_detail']['tbl_department']['id']; 
					$checkApprovers = $this->SetApprovers->checkApprover($invoice['id'],$users['id']);
					if($checkApprovers)
					{
						$ausers[$i]['priority'] = $checkApprovers['priority']; 
					}
					$i++;
				}

$this->set(compact('getUsers','approvers','invoice','getApprovers','getList','ausers','action','departments','getnext','getprevious','ttl','cur_page'));

				
			}
			else
			{
				$this->Flash->error(__('Invoice not found!'));
				//$this->redirect($this->referer());
			}
			if($this->request->data)
			{

				/*if($getApprovers)
					{
						$this->InvoiceApprovers->delApprovers($invoice['vendor_id']);
						$this->SetApprovers->delApprovers($invoice['id']);
					}*/
				
				$i = 1;
				$users = $this->request->data['user_id'];
				if($invoice['po_id'] > 0)
				{
				$getlast = $this->InvoiceApprovers->getLastApprovers($invoice['po_id']);
				
				if($getlast)
				{
					$priority = $getlast['priority']+1;
				}
				else
				{
					$priority = 1;
				}
				$approvers = $this->InvoiceApprovers->newEntity();
				$data['addedby'] = $this->Auth->user('id');
				$data['vendor_id'] = $this->request->data['vendor_id'];
				$data['po_id'] = $this->request->data['po_id'];
				$data['user_id'] = $users;
				$data['priority'] = $priority;
				$approvers = $this->InvoiceApprovers->patchEntity($approvers,$data);
				$this->InvoiceApprovers->save($approvers);
				}
				$getlast = $this->SetApprovers->getLastApprovers($invoice['id']);
				if($getlast)
				{
					$priority = $getlast[0]['priority'] + 1;
				}
				else
				{
					$priority = 1;
				}
				$data['addedby'] = $this->Auth->user('id');
				$data['vendor_id'] = $this->request->data['vendor_id'];
				$data['po_id'] = $this->request->data['po_id'];
				$data['user_id'] = $users;
				$data['priority'] = $priority;
				$data['inv_id'] = $invoice['id'];
				//echo json_encode($data);exit;
				$this->SetApprovers->add($data);
				$getuser = $this->Users->get($data['user_id']);
				$edata['name'] = $getuser['fullname'];
				$edata['email'] = $getuser['email'];
				$edata['link'] = 'Invoices/view/'.$invoice_num;
				$email = $this->Myemail->approvers_notify('',$edata);
				$this->Flash->success(__('Approver added .'));
				$this->redirect(['action'=>'customerApprovals',$invoice_num]);
				

			}
			
		
		$this->set(compact('total_no_comments','total_no_approval'));
		}

		public function invoiceComments($invoice_num=null)
		{
			$this->is_permission($this->Auth->user());
			$this->loadModel('InvoiceApprovers');
			$this->loadModel('SetApprovers');
			$this->loadModel('InvoiceComments');
			$this->loadModel('Vendors');
			$this->loadModel('UserDetails');
			if($this->Auth->user('role') == 2 || $this->Auth->user('role') == 4 )
    		{
    		$company_id = $this->UserDetails->getCompanyId($this->Auth->user('id'));
    		$company_id = $company_id['company_id'];
    		}
    		else if($this->Auth->user('role') == 3 || $this->Auth->user('role') == 5)
    		{
    			$session = $this->request->session();
    			$vendor_company = $session->read('Company');
    			$company_id = $vendor_company['id'];
    		}
    		else
    		{
    			$company_id = 0;
    		}
    		if($this->Auth->user('role')==3):
    			$vendor = $this->Vendors->getbyUserId($this->Auth->user('addedby'));
    			$vendor_id = $vendor['id'];
    		elseif($this->Auth->user('role')==5):
    			$vendor = $this->Vendors->getbyUserId($this->Auth->user('id'));
    			$vendor_id = $vendor['id'];
    			else:
    			$vendor_id = null;
    		endif;
			$comments = $this->InvoiceComments->newEntity();
			$total_no_approval = 0;
	    	$total_no_comments = 0;
			$invoice = $this->Invoices->getDetails($invoice_num);
			$getApprovers = $this->SetApprovers->getApprovers($invoice['id']);
			if(count($getApprovers) > 0)
			{
				$total_no_approval = count($getApprovers);
			}
			else
			{
				$getApprovers = $this->InvoiceApprovers->getApprovers($invoice['vendor_id']);
				if(count($getApprovers)>0)
				{
						
					$ttlapp = count($getApprovers);
					$total_no_approval = $ttlapp;
				}
			}
			$getApprovers = $this->SetApprovers->getApprovers($invoice['id']);
			if(!$getApprovers)
			{
				$getApprovers = $this->InvoiceApprovers->getApprovers($invoice['addedby']);
				if(!$getApprovers)
			{
				$getApprovers = '';
			}

			}
			$ttl = 0;
			$getnext = '';
			$getprevious = '';
			$appid = array();
    		foreach($getApprovers as $app)
    		{
    			if($this->Auth->user('id')!==$app['user_id'])
    			{
    				$appid[] = $app['user_id'];
    			}
    		}
			if($invoice)
			{
				$this->loadModel('UserSettings');
				if($this->Auth->user('role')=='2' || $this->Auth->user('role')=='4') 
				{
					if($this->Auth->user('role')=='4')
					{
						$setid = $this->Auth->user('addedby');
					}
					else 
					{
						$setid = $this->Auth->user('id');
					}
					$settings = $this->UserSettings->getSetting($setid);
					$inv_level = '';
					if($settings['invoice_app_type'])
					{
						$inv_level = $settings['invoice_app_type'];
					}
				} 
				$getnext = $this->Invoices->getnextprevious($invoice['id'],$this->Auth->user('id'),$this->Auth->user('role'),$company_id,$vendor_id,'next',$inv_level);
	    			$getprevious = $this->Invoices->getnextprevious($invoice['id'],$this->Auth->user('id'),$this->Auth->user('role'),$company_id,$vendor_id,'previous',$inv_level);

	    			@$getnext = $getnext[0]['invoice_number'];
	    			@$getprevious = $getprevious[0]['invoice_number'];
				$ttl = $this->Invoices->getTotalInvoices($this->Auth->user('id'),$this->Auth->user('role'),$company_id,$vendor_id,$inv_level);
				$cur_page = $this->Invoices->get_curpageno($this->Auth->user('id'),$this->Auth->user('role'),$company_id,$vendor_id,$invoice['id'],$inv_level);
				
				if($this->Auth->user('role')==2)
				{
					$cond1['Users.addedby']=$this->Auth->user('id');
				}
				else
				{
					
					$cond1['UserDetails.department_id']= $invoice['department_id'];
				}
				$getUsers = $this->Users->find('all',['conditions'=>[$cond1,'Users.status'=>'1','Users.role'=>'4'],'contain'=>['UserDetails'],'order'=>['Users.fullname'=>'ASC']])->toArray();
				//pr($getUsers);exit;
				$this->set(compact('cur_page','appid','getUsers','comments','invoice','getApprovers','getprevious','getnext','ttl'));
			}
			else
			{
				$this->Flash->error(__('Invoice not found!'));
				$this->redirect($this->referer());
			}
			if($this->request->data)
			{
				
				$data = $this->request->data;
				if(isset($data['notify_user']) && count($data['notify_user']) > 0)
					{
						$appc = [];
						$othersc = [];
						foreach($data['notify_user'] as $users)
							{
								/*if(in_array($users,$appid))
								{
									$appc[] = $users;
								}
								else
								{*/
									$othersc[] = $users;
								//}
							
							}
					}
					$appc = [];
					if($data['copy_appvr'] == '1')
					{
						$appc = $appid;
					}
				
				$data['user_id'] = $this->Auth->user('id');
				$data['invoice_id'] = $invoice['id'];
				$data['app_copied'] = implode('|',$appc);
				$data['other_copied'] = implode('|',$othersc);
				$data['copy_approvals'] = $data['copy_appvr'];
				$comments = $this->InvoiceComments->patchEntity($comments,$data);
				//echo json_encode($comments);exit;
				if($this->InvoiceComments->save($comments))
				{
					
					if(isset($data['copy_appvr']) && $data['copy_appvr']=='1')
					{
							/*foreach($getApprovers as $users)
							{
							$getuser = $this->Users->get($users['user_id']);
							$edata['name'] = $getuser['fullname'];
							$edata['email'] = $getuser['email'];
							$edata['link'] = 'Invoices/view/'.$invoice_num;
							$email = $this->Myemail->comment_notify($edata);
							}*/
					}
					if(isset($data['notify_user']) && count($data['notify_user']) > 0)
					{
						foreach($data['notify_user'] as $users)
							{
							$getuser = $this->Users->get($users);
							$edata['name'] = $getuser['fullname'];
							$edata['email'] = $getuser['email'];
							$edata['link'] = 'Invoices/view/'.$invoice_num;
							$email = $this->Myemail->comment_notify($edata);
							
							}
					}
				}

				$this->Flash->success(__('Comments submitted.'));
			}

			$datatable = $this->InvoiceComments->find('all',['conditions'=>['invoice_id'=>$invoice['id']],'contain'=>'Users','order'=>['InvoiceComments.created'=>'desc']])->toArray();
			$total_no_comments = count($datatable);

			$this->set(compact('datatable','total_no_comments','total_no_approval'));
		}

		public function actionByUser()
		{
			$this->autoRender = false;
			$data = $this->request->data;
			$this->loadModel('ApprovedInvoices');
			$actions = $this->ApprovedInvoices->newEntity();
			$data['user_id'] = $this->Auth->user('id');
			$data['status'] = $data['action'];
			$actions = $this->ApprovedInvoices->patchEntity($actions,$data);
			if($this->ApprovedInvoices->save($actions))
			{
				$this->Flash->success(__('Invoice Status updated.'));
				$this->redirect(['action'=>'customerApprovals',$data['invoice_num']]);
			}

		}

		public function preview()
		{
			//$this->is_permission($this->Auth->user());
			if($this->request->data)
			{
				$data = $this->request->data;
				//pr($data);exit;
				$this->set('invoice',$data);
			}
			else
			{
				$this->redirect($this->referrer());
			}
		}

		public function action($id=null,$action = null)
		{
			$this->autoRender = false;
			$userid= $this->Auth->user('id');
			$this->loadModel('UserSettings');
			$this->loadModel('ApprovedInvoices');
			$this->loadModel('Vendors');
			
				$inv = $this->Invoices->get($id);
				if($action=='approved')
			{

				$inv = $this->Invoices->get($id);
				$today = date('Y-m-d');
				$inv_last_date = $inv['due_date']->format('Y-m-d');
				$vendorId = $this->Vendors->get($inv['vendor_id']);
				$vendor_settings = $this->UserSettings->getSetting($vendorId['user_id']);
				$cus_settings = $this->UserSettings->getSetting($inv['customer_id']);
    	

				    	if($cus_settings && $cus_settings['pay_early_accept'])
				    	{
				    		$cus_offer = $cus_settings['pay_early_accept'];
				    	}
				    	if($vendor_settings && $vendor_settings['pay_early_accept'])
				    	{
				    		$vendor_offer = $vendor_settings['pay_early_accept'];
				    	}
				    	if($vendor_offer=='enabled' && $cus_offer == 'enabled')
				    	{
				    		$response = 'enabled';
				    	}
				    	else
				    	{
				    		$response = 'disabled';
				    	}
						
				if($inv_last_date > $today && $response == 'enabled')
				{
					$data['pay_early'] = '1';
					$inv = $this->Invoices->patchEntity($inv,$data);
					if($this->Invoices->save($inv))
					{
						
						$getUser = $this->Users->get($inv['addedby']);
						$edata = ['type'=>'pay_early_vendor','to_email'=>$getUser['email']];
						$replace = ['{name}'=>$getUser['fullname'],'{invoice_num}'=>$inv['prefix'].$inv['invoice_number']];

						$email = $this->Myemail->send_email($edata,$replace);
						
						
						
					}

				}
				
			}
				$inv_date = $inv['created']->format('Y-m-d');
				
			$del = $this->Invoices->action($id,$action);
			$status['user_id'] = $userid;
			$status['addedby'] = $this->Auth->user('id');
			$status['status'] = $action;
			$status['invoice_id'] = $id;
			$getdel = $this->ApprovedInvoices->add($status);
			//pr($getdel);exit;
			if($del['status'] == 'success')
			{
				if($action=='approved')
			{
						$getUser = $this->Users->get($inv['addedby']);

						$edata = ['type'=>'invoice_aproved_notification','to_email'=>$getUser['email']];
						$replace = ['{name}'=>$getUser['fullname'],'{invoice_num}'=>$inv['invoice_number']];
						$email = $this->Myemail->send_email($edata,$replace);
			}

				$this->Flash->success(__('Status of invoice updated!'));

				if($this->Auth->user('role')== '3')
				{
				$this->redirect($this->referer());
				}
				else
				{
				$this->redirect($this->referer());	
				}
			}
			else
			{
				echo 'dsds';
			}


		
	}

		public function actionbycus($id=null,$inv_num,$action=null,$userid=null,$last = 0)
		{

			$this->autoRender = false;
			$this->loadModel('UserSettings');
			$this->loadModel('ApprovedInvoices');
			$this->loadModel('InvoiceApprovers');
			$this->loadModel('SetApprovers');
			$this->loadModel('Vendors');
			$getinvoice = $this->Invoices->get($id);
			$lastapp = $this->SetApprovers->getLastApprovers($id);
			$lastapp = $lastapp[0];
			/*if(!$lastapp)
			{
				$lastapp = $this->InvoiceApprovers->getLastApprovers($getinvoice['vendor_id']);
			}*/
			$app = $this->ApprovedInvoices->newEntity();
			$data['invoice_id'] = $id;
			$data['status'] = $action;
			$data['user_id'] = $userid;
			$data['addedby'] = $this->Auth->user('id');
			$app = $this->ApprovedInvoices->patchEntity($app,$data);
			//pr($app);exit;
			if($this->ApprovedInvoices->save($app))
			{
				if(($action=='approved' || $action=='denied') && $lastapp['user_id'] == $userid)
				{
					
					$dt['action'] = $action;
					
					
					if($action=='approved')
					{
					$today = date('Y-m-d');
					$inv_last_date = $getinvoice['due_date']->format('Y-m-d');
					$vendorId = $this->Vendors->get($getinvoice['vendor_id']);
					$vendor_settings = $this->UserSettings->getSetting($vendorId['user_id']);
					$cus_settings = $this->UserSettings->getSetting($getinvoice['customer_id']);
    		


				    	if($cus_settings && $cus_settings['pay_early_accept'])
				    	{
				    		$cus_offer = $cus_settings['pay_early_accept'];
				    	}
				    	if($vendor_settings && $vendor_settings['pay_early_accept'])
				    	{
				    		$vendor_offer = $vendor_settings['pay_early_accept'];
				    	}
				    	if($vendor_offer=='enabled' && $cus_offer == 'enabled')
				    	{
				    		$response = 'enabled';
				    	}
				    	else
				    	{
				    		$response = 'disabled';
				    	}
						//echo $response;exit;
				if($inv_last_date > $today && $response == 'enabled')
				{
					$dt['pay_early'] = '1';
					$getinvoice = $this->Invoices->patchEntity($getinvoice,$dt);
					if($this->Invoices->save($getinvoice))
					{
						
						$getUser = $this->Users->get($vendorId['user_id']);
						$edata = ['type'=>'pay_early_vendor','to_email'=>$getUser['email']];
						$replace = ['{name}'=>$getUser['fullname'],'{invoice_num}'=>$inv['prefix'].$inv['invoice_number']];

						$email = $this->Myemail->send_email($edata,$replace);
						
						
						
					}

				}
				else
			{
				$getinvoice = $this->Invoices->patchEntity($getinvoice,$dt);
				$this->Invoices->save($getinvoice);
			}

			}
			else
			{
				$getinvoice = $this->Invoices->patchEntity($getinvoice,$dt);
				$this->Invoices->save($getinvoice);
			}
			
				}
				$this->Flash->success(__('Invoice updated!'));
				$this->redirect(['action'=>'CustomerApprovals',$inv_num]);
			}
			else
			{
				$this->Flash->success(__('Invoice Updated!'));
				$this->redirect(['action'=>'CustomerApprovals',$inv_num]);
			}
			$this->redirect($this->referer());

		}

		public function addAttachments()
		{
			$this->autoRender = false;
			$data = $this->request->data;
			//pr($data);exit;
			if($data['attach_files'])
				{
					$attimg = array();
					foreach($data['attach_files'] as $files1)
					{	
						if($files1['tmp_name']):
						$img = $this->FileUpload->upload($files1,'');
						$attimg = $img['filename'];
						$poatt = $this->PoAttachments->newEntity();
							$attdata['attachment'] = $attimg;
							$attdata['user_id'] = $this->Auth->user('id');
							$attdata['po_id'] = $data['po_id'];
							$attdata['type'] = 'po';
							$poatt= $this->PoAttachments->patchEntity($poatt,$attdata);
							$this->PoAttachments->save($poatt);
							endif;
					}

					
					
				}	

				$this->Flash->success(__('Attachments Uploaded!'));
				if($this->Auth->user('role')== '3')
				{
				$this->redirect($this->referer());
				}
				else
				{
				$this->redirect(['action'=>'index']);	
				}
		}

		public function poMessage($id=null)
		{
			$this->loadModel('Messages');
			$data = $this->PurchaseOrders->get($id);
			$message = $this->Messages->newEntity();
			$posteddata = $this->request->data;

			$msg = '';
			if($posteddata)
			{
				
				$message = $this->Messages->patchEntity($message,$posteddata);
				if($this->Messages->save($message))
				{
					$this->Flash->set('Message sent!.',['element'=>'success']);
					$msg['status'] = 'done';
					
				}
				else
				{
					$msg['status'] = 'error';
					$err = $message->errors();
					foreach($err as $key=>$vals)
					{
						$msg['errors'][$key] = $vals['_empty'].'<br>'.@$vals['custom'];
						
					}
				}
				echo json_encode($msg);exit;
			}
			
			$this->set(compact('data'));


		}
		public function download($id=null)
	    {
	    	
	    		
	    		$invoice = $this->Invoices->find('all',['conditions'=>['invoice_number'=>$id],'contain'=>['Vendor','PurchaseOrders','PurchaseOrders.PurchaseProducts','Users','Attachments','Departments','Products']])->last();



	    		
	    		if(!$invoice)
	    		{
	    			$this->Flash->success(__('You are not authorised to view this invoice .'));
	    			$this->redirect($this->referer());
	    		}
	    		else
	    		{
	    			$user_id = $this->Auth->user('id');
	    			if($user_id== $invoice['customer_id'])
	    			{
	    				$invoice['customer_view'] = '1';
	    			}
	    			else if($user_id== $invoice['addedby'])
	    			{
	    				$invoice['admin_view'] = '1';
	    			}
	    		}
	    		$this->set(compact('invoice'));
		}

		public function downloadinv($inv_num=null)
		{
			require ( ROOT.'/vendor'.DS.'pdfcrowd'.DS.'pdfcrowd.php' );

			ob_start();
	        require_once(ROOT.'/vendor'.DS.'MPDF'.DS.'mpdf.php');
	        $mpdf=new \mPDF(); 
	        $url = BASEURL.'invoices/download/'.$inv_num;
	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, $url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	        $data = curl_exec($ch);
	        curl_close($ch);
	       // echo $data;exit;
	        $mpdf->AddPage();
	        $mpdf->WriteHTML($data);
	        $mpdf->Output();
	        exit;
      
		}

		public function invMessage($id=null)
		{
			$this->loadModel('Messages');
			$this->loadModel('Threads');
			$data = $this->Invoices->get($id);
			$message = $this->Messages->newEntity();
			$posteddata = $this->request->data;

			$msg = '';
			if($posteddata)
			{
				 $thread = $this->Threads->is_exists($posteddata['sender'],$posteddata['receiver']);
        
        if($thread['id'])
        {
            $posteddata['thread_id']=$thread['id'];
        }
        else
        {
            $newthread = $this->Threads->add($posteddata['sender'],$posteddata['receiver']);

            if($newthread['status'] == 'success')
            {
                $posteddata['thread_id']=$newthread['id'];
            }
        }
				$message = $this->Messages->patchEntity($message,$posteddata);
				if($this->Messages->save($message))
				{
					$this->Flash->set('Message sent!.',['element'=>'success']);
					$msg['status'] = 'done';
					
				}
				else
				{
					$msg['status'] = 'error';
					$err = $message->errors();
					foreach($err as $key=>$vals)
					{
						$msg['errors'][$key] = $vals['_empty'].'<br>'.@$vals['custom'];
						
					}
				}
				echo json_encode($msg);exit;
			}
			
			$this->set(compact('data'));
		}

		public function invAtt($id=null)
		{
			$this->loadModel('Messages');
			$data = $this->Invoices->get($id,['contain'=>'Attachments']);
			
			
			$this->set(compact('data'));
		}


		public function generateInv($digit = null)
		{
			$this->autoRender = false;
			$ponum = $this->Invoices->find('all')->last();
			$ponum_new = '';
			$rand = '';
			if($digit)
			{ 
				$checkpo = strlen($ponum['id']);
				if($checkpo > $digit)
				{
					$characters = '0123456789';
				    $charactersLength = strlen($characters);
				    for ($i = 0; $i < $digit; $i++) {
				        $ponum_new .= $characters[rand(0, $charactersLength - 1)];
				    }
				}
				else
				{
				$digit = $digit - $checkpo;
				$ponum_new = $ponum['id'];
				$characters = '0123456789';
			    $charactersLength = strlen($characters);
			    $rand = '';
			    for ($i = 0; $i < $digit; $i++) {
			        $rand .= $characters[rand(0, $charactersLength - 1)];
			    }
				}
			    
			}
			else
			{
				$rand = rand(0,10000);
			}
			echo $ponum_new.$rand;
		}

		public function validateinvnum($ponum = null)
		{
			$this->autoRender = false;
			$ponum = $this->Invoices->check_inv($ponum);
			if($ponum > 0)
			{
				$status = 'error';
			}
			else
			{
				$status = 'good';
			}
			echo $status;
			
		}

		public function payEarly()
		{
			$this->is_permission($this->Auth->user());
			$this->loadModel('UserSettings');
			$this->loadModel('Vendors');
			
			if($this->Auth->user('role') == 3 )
            {
                $cus_settings = $this->UserSettings->getSetting($this->Auth->user('addedby'))   ;
            }
            else
            {
                $cus_settings = $this->UserSettings->getSetting($this->Auth->user('id'))   ;

            }
            $cus_offer = '';
            $vendor_settings = $this->UserSettings->getSetting($this->Auth->user('id'));
			if($cus_settings && $cus_settings['pay_early_accept'])
            {
                $cus_offer = $cus_settings['pay_early_accept'];
            }
            if($vendor_settings && $vendor_settings['pay_early_accept'])
            {
                $vendor_offer = $vendor_settings['pay_early_accept'];
            }
            if(@$vendor_offer=='enabled' && $cus_offer == 'enabled')
            {
                $settings = 'enabled';
            }
            else
            {
                $settings = 'disabled';
            }
	    	
	    	if($settings=='disabled') 
			{ 
				$this->Flash->error('Payearly Offers are disabled.');
				$this->redirect(['action'=>'index']);
			}
			
			$this->loadModel('PayearlyOffers');
	    	$user_id = $this->Auth->user('id');
			$getCustomers = $this->Invoices->getFilterCustomers($this->Auth->user('id'),$this->Auth->user('role'));
			$todaydate = date('Y-m-d');
			
			$search = $this->request->query;
			$conditions['Invoices.pay_early'] = '1';
			if($search)
			{
				
				$status = $search['status'];
				$start_date = $search['start_date'];
				$end_date = $search['end_date'];
				$customer = $search['customer'];
				$po_number = $search['po_number'];
				$po_start = $search['po_start'];
				$po_end = $search['po_end'];
				$time_frame = $search['time_frame'];
				if($time_frame && !$start_date && !$end_date)
				{
				$explodetime = explode('-',$time_frame);
				if($explodetime[0]=='D')
				{
					$type = 'days';
					$start_date = $this->PurchaseOrders->getDatefromDays($explodetime[1],$type);

				}
				if($explodetime[0]=='M')
				{
					$type = 'months';
					$start_date = $this->PurchaseOrders->getDatefromDays($explodetime[1],$type);
					 
				}
				if($explodetime[0]=='Y')
				{
					$type = 'year';
					$start_date = $this->PurchaseOrders->getDatefromDays($explodetime[1]+1,$type);
					 
				}
				
				}
				if(@$search['record']):				
				$records = $search['record'];
				else:
				$records = 10;

				endif;
				if($status):
					if($status == 'open')
					{
						$conditions[]= 'PayearlyOffers.status IS NULL';
						$conditions[]= "Invoices.due_date >= CURDATE()";
					}
					else if($status == 'expired')
					{
						$conditions[]= "Invoices.due_date < CURDATE()";
						$conditions[]= 'PayearlyOffers.status IS NULL';

					}
					else
					{
						$conditions['PayearlyOffers.status'] = $status;
					}
				endif;
				if($start_date):
				$conditions['Invoices.created >= '] = $start_date;
				endif;
				if($end_date):
				$conditions['Invoices.created <= '] = $end_date;
				endif;
				if($customer):
				$conditions['Invoices.company_id'] = $customer ;
				endif;
				if($po_number):
				$conditions['Invoices.invoice_number ='] = $po_number;
				endif;
				if($po_start && $po_end):
				$conditions[] = 'Invoices.invoice_amount between '.$po_start.'  and '.$po_end ;
				endif;
				if($po_start && !$po_end):
				$conditions['Invoices.invoice_amount > '] = $po_start;
				endif;
				if($po_end && !$po_start):
				$conditions['Invoices.invoice_amount < '] = $po_end;
				endif;
			}
			else
			{
				$search = array('status'=>'','record'=>'','start_date'=>'','end_date'=>'','time_frame'=>'','po_start'=>'','po_end'=>'','customer'=>'','po_number'=>''); 
				//$conditions = [];
				$records = '10';
				
			}
			//echo $user_id;
			//echo json_encode($conditions);exit;
			$this->paginate = [
	        'limit' =>$records,
	        'order' => [
	            'Invoices.id' => 'desc'
	        ]
	    ];
	    $session = $this->request->session();
	    $company = $session->read('Company');
	    $getCustomers = $session->read('Company');
	    if($this->Auth->user('role')==3)
			{
				$vendors = $this->UserDetails->getVendorId($this->Auth->user('id'));
				$vendors =  $this->Vendors->getbyUserId($vendors['vendor_id']);	
				$vendors_id = $vendors['id'];
			}
			else
			{
				$vendors =  $this->Vendors->getbyUserId($this->Auth->user('id'));	
				$vendors_id = $vendors['id'];
			}

	    $qry = $this->Invoices->find('all',['conditions'=>['Invoices.vendor_id'=>$vendors_id,'Invoices.company_id'=>$company['id'],$conditions],'contain'=>['Users','Companies','PayearlyOffers']]);
	    
			$list = $this->paginate($qry);
			$this->set(compact('list','getCustomers','search','getCustomers','search'));
		}

	public function payearlyOffer($inv_id = null)
    {
    	$this->is_permission($this->Auth->user());
    	$this->loadModel('PayearlyOffers');
    	$this->loadModel('UserSettings');
    	$qrystr = $this->request->query;
    	$inv = $this->Invoices->find('all',['conditions'=>['invoice_number'=>$inv_id],'contain'=>['PayearlyOffers']])->last();
    	$settings = $this->UserSettings->getSetting($this->Auth->user('addedby'));
    	$paymentTerms = $inv['payment_terms'];
    	$today = date('Y-m-d');
    	if($inv['due_date']->format('Y-m-d') < $today)
    	{
    		$this->Flash->error('Invoice Expired !');
    		$this->redirect(['action'=>'index']);
    	}
    	if($settings['discount'])
    	{
    		$IR = $settings['discount'];
    	}
    	else
    	{
    		$IR = 1;
    	}
    	$payearly = $this->PayearlyOffers->newEntity();
    	$chk = $this->PayearlyOffers->is_exist($inv['id']);
    	if($chk)
    	{
    	$payearly = $this->PayearlyOffers->get($chk['id']);
    	$inv_last_date = $inv['due_date']->format('Y-m-d');
    	$PTD = $inv['payment_terms'];
    	}
    	if($this->request->data)
    	{
    		$data = $this->request->data;
    		$data['status'] = 'closed';
    		$payearly = $this->PayearlyOffers->patchEntity($payearly,$data);
    		//pr($payearly);exit;
    		if($this->PayearlyOffers->save($payearly))
    		{
    			$inv = $this->Invoices->get($inv['id']);
    			$dtinv['action'] = 'open';
    			$inv = $this->Invoices->patchEntity($inv,$dtinv);
    			$this->Invoices->save($inv);

    			$this->Flash->success('Offer has saved and sent to the customer.');
    			if($qrystr && $qrystr['type']=='new')
    			{
    			$this->redirect(['action'=>'index']);	
    			}
    			else
    			{
    			$this->redirect(['action'=>'payEarly']);
    			}
    		}
    		else
    		{
    			$this->Flash->error('Opps , try again .');
    		}
    	}
    	
    	$this->set(compact('inv','payearly','IR','paymentTerms'));	
    	
    }

    public  function getDepartmentbyID($dpt_id=null)
    {
    	$this->autoRender = false;
    	$this->loadModel('Departments');
    	$dpts = $this->Departments->get($dpt_id);
    	echo json_encode($dpts);
    }

    public function checkPayearlyOffer($dpt_id=null)
    {
    	$this->autoRender = false;
    	$this->loadModel('Departments');
    	$this->loadModel('UserSettings');
    	$getCustomerID = $this->Departments->getOwner($dpt_id);
    	$cus_settings = $this->UserSettings->getSetting($getCustomerID);
    	$vendor_settings = $this->UserSettings->getSetting($this->Auth->user('id'));

    	if($cus_settings && $cus_settings['pay_early_accept'])
    	{
    		$cus_offer = $cus_settings['pay_early_accept'];
    	}
    	if($vendor_settings && $vendor_settings['pay_early_accept'])
    	{
    		$vendor_offer = $vendor_settings['pay_early_accept'];
    	}
    	if($vendor_offer=='enabled' && $cus_offer == 'enabled')
    	{
    		$response = 'enabled';
    	}
    	else
    	{
    		$response = 'disabled';
    	}
    	echo $response;

    }

    public function dptusers($department_id = null,$inv_id=null,$vendor_id=null)
    {
    	$this->autoRender = false;
    	$this->loadModel('UserDetails');
    	$this->loadModel('SetApprovers');
    	$this->loadModel('InvoiceApprovers');
    	if($department_id !=='all')
    	{
    	$user = $this->UserDetails->find('all',['conditions'=>['UserDetails.department_id'=>$department_id,'Users.status'=>'1','Users.role'=>'4'],'contain'=>['Users']])->toArray();
    	}
    	else
    	{
    	$user = $this->UserDetails->find('all',['conditions'=>['Users.addedby'=>$this->Auth->user('id'),'Users.status'=>'1','Users.role'=>'4'],'contain'=>['Users']])->toArray();
    	}
    	$list = [];
    	$i = 0;
    	foreach($user as $usr){
    		$checkApprovers = $this->SetApprovers->checkApprover($inv_id,$usr['user_id']);
    		
					if(!$checkApprovers)
					{
						$checkApprovers = $this->InvoiceApprovers->checkApprover($vendor_id,$usr['user_id']);
						
					}
					
					if($checkApprovers)
					{
				//			$list[$i]['priority'] = $checkApprovers['priority']; 
					}
					else
					{
    		$list[$i]['id']=$usr['user_id'];
    		$list[$i]['name']=$usr['user']['fullname'];
    		}
    		
    		$i++;

    	}
    	echo json_encode($list);

    }

    public function autolink($po_id=null,$type=null)
    {
    	$this->autoRender = false;
    	$this->loadModel('InvoiceApprovers');
    	$getApprovers = $this->InvoiceApprovers->find('all',['conditions'=>['po_id'=>$po_id]])->toArray();
    	//pr($getApprovers);exit;
		foreach($getApprovers as $delapp)
    	{
    		$get = $this->InvoiceApprovers->get($delapp['id']);
    		if($type=='unlink')
    		{
    			$data['auto_link'] = 0;
    		}
    		else
    		{
    			$data['auto_link'] = 1;
    		}
    		$get = $this->InvoiceApprovers->patchEntity($get,$data);
    		if($this->InvoiceApprovers->save($get))
    		{
    			$this->Flash->success('P.O auto link updated!');
    			$this->redirect($this->referer());
    		}
    	}
	}

    public function resetApprovals($vendor_id,$invoice_id)
    {
    	$this->autoRender = false;
    	$this->loadModel('InvoiceApprovers');
    	$this->loadModel('SetApprovers');
    	$getApprovers = $this->InvoiceApprovers->find('all',['conditions'=>['vendor_id'=>$vendor_id]])->toArray();

    	foreach($getApprovers as $delapp)
    	{
    		$get = $this->InvoiceApprovers->get($delapp['id']);
    		$this->InvoiceApprovers->delete($get);
    	}
    	$setApprovers = $this->SetApprovers->find('all',['conditions'=>['inv_id'=>$invoice_id]])->toArray();
    	//pr($setApprovers);
    	foreach($setApprovers as $delapp1)
    	{
    		$get1 = $this->SetApprovers->get($delapp1['id']);
    		$this->SetApprovers->delete($get1);
    	}
    	$this->Flash->success('Approval actions reset.');
    	echo 'success';
    }

    public function setorderofinvoice()
    {
    	$this->autoRender = false;
    	$this->loadModel('InvoiceApprovers');
    	$this->loadModel('SetApprovers');
    	$data = $this->request->data;
    	if($data)
    	{
    		$i = 1;
    		$vendor_id = $data['vendor_id'];
    		$inv_id = $data['inv_id'];
    		$autoresert = $this->InvoiceApprovers->resetAutolink($data['vendor_id']);
    		//$getApprovers = $this->InvoiceApprovers->find('all',['conditions'=>['vendor_id'=>$vendor_id,'user_id'=>$userid]])->last();
    	//	echo json_encode($data);exit;
    	foreach($data['user_id'] as $userid)
		{
			$getApprovers = $this->InvoiceApprovers->find('all',['conditions'=>['vendor_id'=>$vendor_id,'user_id'=>$userid]])->last();
			//pr($getApprovers);exit;
    		$get = $this->InvoiceApprovers->get($getApprovers['id']);

    		$data1['priority'] = $i;
    		//pr($data1);exit;
    		$get = $this->InvoiceApprovers->patchEntity($get,$data1);
    		$this->InvoiceApprovers->save($get);

    		$setApprovers = $this->SetApprovers->find('all',['conditions'=>['user_id'=>$userid,'inv_id'=>$inv_id]])->last();
    		$set = $this->SetApprovers->get($setApprovers['id']);
    		$data1['priority'] = $i;
    		$set = $this->SetApprovers->patchEntity($set,$data1);
    		$this->SetApprovers->save($set);

    		$i++;
    	}
    	

    }
    $this->Flash->success('done');
    $this->redirect($this->referer());
    }

    public function delApprovals($vendor_id=null,$inv_id=null,$user_id=null,$po_id=null)
    {
    	$this->autoRender = false;
    	$this->loadModel('InvoiceApprovers');
    	$this->loadModel('SetApprovers');
    	$this->loadModel('ApprovedInvoices');
    	$this->loadModel('UserSettings');
    	$this->loadModel('Vendors');
    	if($vendor_id && $inv_id && $user_id)
    	{
    		$getApprovers = $this->InvoiceApprovers->find('all',['conditions'=>['vendor_id'=>$vendor_id,'user_id'=>$user_id]])->last();
    		$getdel = $this->InvoiceApprovers->get($getApprovers['id']);
    		//$this->InvoiceApprovers->delete($getdel);
    		if($po_id)
    		{
    			$this->InvoiceApprovers->resetAutolink($po_id);
    		}
    		$setApprovers = $this->SetApprovers->find('all',['conditions'=>['inv_id'=>$inv_id,'user_id'=>$user_id]])->last();
    		if($setApprovers):
    		$getdel1 = $this->SetApprovers->get($setApprovers['id']);
    		$this->SetApprovers->delete($getdel1);
    		endif;
    		$lastapp = $this->SetApprovers->getLastApprovers($inv_id);
    		$getlaststatus = $this->ApprovedInvoices->getAction($inv_id,$lastapp[0]['user_id']);
    		if($getlaststatus)
    		{
    			//echo json_encode($getlaststatus);
    			$getinvoice = $this->Invoices->get($inv_id);
    			if(($getlaststatus['status']=='approved' || $getlaststatus['status']=='denied') && $lastapp[0]['user_id'] == $getlaststatus['user_id'])
				{
					$dt['action'] = $getlaststatus['status'];
					if($getlaststatus['status']=='approved')
					{
					$today = date('Y-m-d');
					$inv_last_date = $getinvoice['due_date']->format('Y-m-d');
					$vendorId = $this->Vendors->get($getinvoice['vendor_id']);
					$vendor_settings = $this->UserSettings->getSetting($vendorId['user_id']);
					$cus_settings = $this->UserSettings->getSetting($getinvoice['customer_id']);
    		


				    	if($cus_settings && $cus_settings['pay_early_accept'])
				    	{
				    		$cus_offer = $cus_settings['pay_early_accept'];
				    	}
				    	if($vendor_settings && $vendor_settings['pay_early_accept'])
				    	{
				    		$vendor_offer = $vendor_settings['pay_early_accept'];
				    	}
				    	if($vendor_offer=='enabled' && $cus_offer == 'enabled')
				    	{
				    		$response = 'enabled';
				    	}
				    	else
				    	{
				    		$response = 'disabled';
				    	}
						//echo $response;exit;
				if($inv_last_date > $today && $response == 'enabled')
				{
					$dt['pay_early'] = '1';
					$getinvoice = $this->Invoices->patchEntity($getinvoice,$dt);
					if($this->Invoices->save($getinvoice))
					{
						
						$getUser = $this->Users->get($vendorId['user_id']);
						$edata = ['type'=>'pay_early_vendor','to_email'=>$getUser['email']];
						$replace = ['{name}'=>$getUser['fullname'],'{invoice_num}'=>$inv['prefix'].$inv['invoice_number']];

						$email = $this->Myemail->send_email($edata,$replace);
						
						
						
					}

				}
				else
			{
				$getinvoice = $this->Invoices->patchEntity($getinvoice,$dt);
				$this->Invoices->save($getinvoice);
			}

			}
			else
			{
				$getinvoice = $this->Invoices->patchEntity($getinvoice,$dt);
				$this->Invoices->save($getinvoice);
			}
			
				}
    		}
    		$this->Flash->success('Approver removed.');
    		$this->redirect($this->referer());

    	}
    }

    public function AppProgress($inv_id=null)
    {
    			$appprogress = '';
	    		$this->loadModel('SetApprovers');
	    		$this->loadModel('InvoiceApprovers');
	    		$this->loadModel('ApprovedInvoices');
	    		$invoice = $this->Invoices->get($inv_id);
	    		/*if($invoice['invoice_level']=='singlelevel')
	    		{
	    			if($invoice['action']=='open')
	    			{
	    				$approgress = 0;
	    			}
	    			else if ($invoice['action']=='approved' || $invoice['action']=='denied' || $invoice['action']=='hold')
	    			{
	    				$approgress = 100;
	    			}
	    		}
	    		elseif($invoice['invoice_level']=='multilevel')
	    		{
	    			$getApprovers = $this->SetApprovers->getApprovers($invoice['id']);
					if(count($getApprovers) > 0)
					{
						$ttlapp = count($getApprovers);
						
					
					}
					else
					{
						$getApprovers = $this->InvoiceApprovers->getApprovers($invoice['vendor_id']);
						if(count($getApprovers)>0)
					{
						
						$ttlapp = count($getApprovers);
					}
					else
					{
						if ($invoice['action']=='approved' || $invoice['action']=='denied' || $invoice['action']=='hold')
	    			{
	    				$ttlapp = 100;
	    			}
	    			else
	    			{
						$ttlapp = 0;
	    			}
					}
					}
					$appnum = $this->ApprovedInvoices->getttlApp($invoice['id']);
					if($ttlapp>0)
					{
					$approgress = (1 + $appnum)/(1 + $ttlapp ) * 100;
					}
					else
					{
					$approgress = (1/$ttlapp ) * 100;	
					}
	    		}*/
	    		//$approgress = round($approgress,2);
	    	$this->loadModel('InvoiceApprovers');
			$this->loadModel('SetApprovers');
			$this->loadModel('ApprovedInvoices');
			$this->loadModel('Departments');
			$approvers = $this->InvoiceApprovers->newEntity();
			$invoice = $this->Invoices->getDetails($invoice['invoice_number']);
			//$paginate_qry = $this->ApprovedInvoices->find('all',['conditions'=>['invoice_id'=>$invoice['id']],'contain'=>'Users'])->toArray();
			//
			//pr($invoice);exit;
			$this->loadModel('InvoiceComments');
	    		$total_no_approval = 0;
	    		$total_no_comments = $this->InvoiceComments->total_comments($invoice['id']);
	    		
			if($this->Auth->user('role') == 2 || $this->Auth->user('role') == 4 )
	    		{
	    		$company_id = $this->UserDetails->getCompanyId($this->Auth->user('id'));
	    		$company_id = $company_id['company_id'];
	    		}
	    		else if($this->Auth->user('role') == 3 || $this->Auth->user('role') == 5)
	    		{
	    			$session = $this->request->session();
	    			$vendor_company = $session->read('Company');
	    			$company_id = $vendor_company['id'];
	    		}
	    		else
	    		{
	    			$company_id = 0;
	    		}
	    		if($this->Auth->user('role')==3):
	    		
	    			$vendor = $this->Vendors->getbyUserId($this->Auth->user('addedby'));
	    			$vendor_id = $vendor['id'];
	    		elseif($this->Auth->user('role')==5):
	    			$vendor = $this->Vendors->getbyUserId($this->Auth->user('id'));
	    			$vendor_id = $vendor['id'];
	    			else:
	    			$vendor_id = null;
	    		endif;
			
			$departments = $this->Departments->getList($this->Auth->user('id'));
			$getApprovers = $this->SetApprovers->getApprovers($invoice['id']);
			//pr($getApprovers);exit;
			if(count($getApprovers) == 0)
			{
				
			$getApprovers = $this->InvoiceApprovers->getApprovers($invoice['vendor_id']);

				if(count($getApprovers) == 0 )
			{
				
				$getApprovers = [];
			}
			else
			{
				$list = $this->InvoiceApprovers->find('all',['conditions'=>['InvoiceApprovers.vendor_id'=>$invoice['vendor_id']],'contain'=>['Users'],'order'=>'InvoiceApprovers.priority = 0,InvoiceApprovers.priority ASC'])->toArray();
				//$getList = $this->paginate(@$paginate_qry);
				//$getList = $paginate_qry->toArray();
			}
			
			}
			else
			{
				$list = $this->SetApprovers->find('all',['conditions'=>['SetApprovers.inv_id'=>$invoice['id']],'contain'=>['Users'],'order'=>'SetApprovers.priority = 0, SetApprovers.priority ASC'])->toArray();
				//$getList = $this->paginate(@$paginate_qry);
				
				
			}

			//pr($list);exit;
			if($invoice)
			{
				$this->loadModel('UserSettings');
				if($this->Auth->user('role')=='2' || $this->Auth->user('role')=='4') 
				{
					if($this->Auth->user('role')=='4')
					{
						$setid = $this->Auth->user('addedby');
					}
					else 
					{
						$setid = $this->Auth->user('id');
					}
					$settings = $this->UserSettings->getSetting($setid);
					$inv_level = '';
					if($settings['invoice_app_type'])
					{
						$inv_level = $settings['invoice_app_type'];
					}
				} 
				


				
			}
			else
			{
				$this->Flash->error(__('Invoice not found!'));
				//$this->redirect($this->referer());
			}
			//pr($list);exit;
			$this->set(compact('total_no_comments','total_no_approval','list','invoice'));
	    		
    }

    public function delete($inv_id)
    {
    	$this->autoRender = false;
    	$this->loadModel('PurchaseProducts');
    	$this->loadModel('PoAttachments');	
    	$inv = $this->Invoices->get($inv_id);
    	if($this->Invoices->delete($inv))
    	{
    		$pp = $this->PurchaseProducts->deletebyinv($inv_id);
    		$att = $this->PoAttachments->deletebyinv($inv_id);
			$this->Flash->success('Invoices Deleted.');
    		$this->redirect($this->referer());
    	}
    	else
    	{
    		$this->Flash->error('Try again.');
    		$this->redirect($this->referer());
    	}
    }

    public function commentspr($invoice_num = null)
    {

			
			$this->loadModel('InvoiceApprovers');
			$this->loadModel('SetApprovers');
			$this->loadModel('InvoiceComments');


			$comments = $this->InvoiceComments->newEntity();
			//$chk = $this->Invoices->valid_customer($invoice_num);
			$invoice = $this->Invoices->getDetails($invoice_num);
			$getApprovers = $this->SetApprovers->getApprovers($invoice['id']);
			if(!$getApprovers)
			{
				$getApprovers = $this->InvoiceApprovers->getApprovers($invoice['addedby']);
				if(!$getApprovers)
			{
				$getApprovers = '';
			}

			}
			if($this->Auth->user('role') > 1)
	    		{
	    		$company_id = $this->UserDetails->getCompanyId($this->Auth->user('id'));
	    		$company_id = $company_id['company_id'];
	    		}
	    		else
	    		{
	    			$company_id = null;
	    		}
	    		if($this->Auth->user('role')==3):
	    			$vendor = $this->UserDetails->getVendorId($this->Auth->user('id'));
	    			$vendor_id = $vendor['vendor_id'];
	    		else:
	    			$vendor_id = null;
	    		endif;
			//pr($getApprovers);exit;

			$ttl = 0;
			$getnext = '';
			$getprevious = '';
			$appid = array();
	    		foreach($getApprovers as $app)
	    		{
	    			$appid[] = $app['user_id'];
	    		}
			
				$getnext = $this->Invoices->getnextprevious($invoice['id'],$this->Auth->user('id'),$this->Auth->user('role'),$company_id,$vendor_id,'next');
	    			$getprevious = $this->Invoices->getnextprevious($invoice['id'],$this->Auth->user('id'),$this->Auth->user('role'),$company_id,$vendor_id,'previous');

	    			@$getnext = $getnext[0]['invoice_number'];
	    			@$getprevious = $getprevious[0]['invoice_number'];
				$ttl = $this->Invoices->getTotalInvoices($this->Auth->user('id'),$this->Auth->user('role'),$company_id,$vendor_id);
				$cur_page = $this->Invoices->get_curpageno($this->Auth->user('id'),$this->Auth->user('role'),$company_id,$vendor_id,$invoice['id']);
				$getUsers = $this->Users->find('all',['conditions'=>['Users.status'=>'1','Users.addedby'=>$this->Auth->user('id'),'Users.role'=>'4'],'contain'=>['UserDetails'],'order'=>['Users.fullname'=>'ASC']])->toArray();
				//pr($getUsers);exit;
				$this->set(compact('cur_page','appid','getUsers','comments','invoice','getApprovers','getprevious','getnext','ttl'));
			
			

			$datatable = $this->InvoiceComments->find('all',['conditions'=>['invoice_id'=>$invoice['id']],'contain'=>'Users','order'=>['created'=>'desc']])->toArray();


			$this->set('datatable',$datatable);
    }

    public function invattDel($id = null)
	{
		$this->autoRender = false;
		$this->loadModel('PoAttachments');
		if($id)
		{
			$getdata = $this->PoAttachments->get($id);
			$filedel = $this->FileUpload->image_delete('uploads/'.$getdata['attachment']);
			
			if($this->PoAttachments->delete($getdata))
			{
				$msg = 'success';
			}
			else
			{
				$msg = 'error';
			}
			
		}
		echo $msg;
	}

		public function export()
		{

	    	//$this->is_permission($this->Auth->user());
	    	$user_id = $this->Auth->user('id');
	    	$session = $this->request->session();
			$getCustomers = $session->read('Company');
			//pr($getCustomers);exit;
			$search = $this->request->query;
			$cond1 =[];
			$cond2 =[];
			if($this->Auth->user('role')==3)
			{
			$vendors = $this->UserDetails->is_exists($this->Auth->user('id'));
			$cond1[]= ['Invoices.department_id in ('.$vendors['department_id'].')'];
			$cond2[]= ['PurchaseOrders.department_id in ('.$vendors['department_id'].')'];
			$vendors =  $this->Vendors->getbyUserId($vendors['vendor_id']);	
			$vendors_id = $vendors['id'];
			}
			else
			{
			$vendors =  $this->Vendors->getbyUserId($this->Auth->user('id'));	
			$vendors_id = $vendors['id'];
			}
			$companyId = $session->read('Company');
			$po_orders = $this->PurchaseOrders->find('all',['conditions'=>[$cond2,'PurchaseOrders.vendors'=>$vendors_id,'PurchaseOrders.status'=>'1','PurchaseOrders.action'=>'open','PurchaseOrders.company_id'=>$companyId['id']],'order' => [
	            'PurchaseOrders.id' => 'desc'
	        ],'fields'=>['PurchaseOrders.id','PurchaseOrders.po_num'] ])->toArray();
	        
			if($search)
			{
				
				$status = $search['status'];
				$start_date = $search['start_date'];
				$end_date = $search['end_date'];
				$customer = $search['customer'];
				$po_number = $search['po_number'];
				$po_start = $search['po_start'];
				$po_end = $search['po_end'];
				$time_frame = $search['time_frame'];
				if($time_frame && !$start_date && !$end_date)
				{
				$explodetime = explode('-',$time_frame);
				if($explodetime[0]=='D')
				{
					$type = 'days';
					$start_date = $this->PurchaseOrders->getDatefromDays($explodetime[1],$type);

				}
				if($explodetime[0]=='M')
				{
					$type = 'months';
					$start_date = $this->PurchaseOrders->getDatefromDays($explodetime[1],$type);
					 
				}
				if($explodetime[0]=='Y')
				{
					$type = 'year';
					$start_date = $this->PurchaseOrders->getDatefromDays($explodetime[1]+1,$type);
					 
				}
				
				}
				if(@$search['record']):				
				$records = $search['record'];
				else:
				$records = 10;

				endif;
				if($status):
				$conditions['Invoices.action'] = $status;
				endif;
				if($start_date):
				$conditions['Invoices.created >= '] = $start_date;
				endif;
				if($end_date):
				$conditions['Invoices.created <= '] = $end_date;
				endif;
				if($customer):
				$conditions['Invoices.company_id'] = $customer ;
				endif;
				if($po_number):
				$conditions['Invoices.invoice_number ='] = $po_number;
				endif;
				if($po_start && $po_end):
				$conditions[] = 'Invoices.invoice_amount between '.$po_start.'  and '.$po_end ;
				
				endif;
				if($po_start && !$po_end):
				$conditions['Invoices.invoice_amount > '] = $po_start;
				endif;
				if($po_end && !$po_start):
				$conditions['Invoices.invoice_amount < '] = $po_end;
				endif;

				
			}
			else
			{
				$search = array('status'=>'','record'=>'','start_date'=>'','end_date'=>'','time_frame'=>'','po_start'=>'','po_end'=>'','customer'=>'','po_number'=>''); 
				$conditions = $cond1;
				$records = '10';
				
			}
			$company_id = $session->read('Company');
	    	$list = $this->Invoices->find('all',['conditions'=>['Invoices.vendor_id'=>$vendors_id,'Invoices.company_id'=>$company_id['id'],'Invoices.status !='=>'2',$conditions] ,'contain'=>['Users','Companies'],'order' => [
	            'Invoices.id' => 'desc'
	        ]])->toArray();
	   		$this->set(compact('list','getCustomers','search','po_orders'));
		}

		public function exportinvoice()
		{
			$user_id = $this->Auth->user('id');
	    	$compID = $this->UserDetails->getCompanyID($user_id);
	    	$this->loadModel('UserSettings');
			$getCustomers = $this->Invoices->getFilterCustomers($this->Auth->user('id'),$this->Auth->user('role'),$compID['company_id']);
			if($this->Auth->user('role')=='2')
			{
				$settings = $this->UserSettings->getSetting($this->Auth->user('id'));
			}
			else
			{
				$settings = $this->UserSettings->getSetting($this->Auth->user('addedby'));
			}

			
			$search = $this->request->query;
			if($this->Auth->user('role')=='4')
			{
				$this->loadModel('InvoiceApprovers');
				$getvendors = $this->InvoiceApprovers->getVendorsbyUser($this->Auth->user('id'));
			}
			if($this->Auth->user('role')=='4' )
			{
				$vendorsimp = implode(',',$getvendors);
				$conditions[] = "Invoices.vendor_id in ('".$vendorsimp."')"; 
			}
			else
			{
				//$conditions['PurchaseOrders.addedby'] = $this->Auth->user('id'); 
				$conditions = [];
			}

			if($search)
			{
				
				$status = $search['status'];
				$start_date = $search['start_date'];
				$end_date = $search['end_date'];
				$customer = $search['customer'];
				$po_number = $search['po_number'];
				$po_start = $search['po_start'];
				$po_end = $search['po_end'];
				$time_frame = $search['time_frame'];
				if($time_frame && !$start_date && !$end_date)
				{
				$explodetime = explode('-',$time_frame);
				if($explodetime[0]=='D')
				{
					$type = 'days';
					$start_date = $this->PurchaseOrders->getDatefromDays($explodetime[1],$type);

				}
				if($explodetime[0]=='M')
				{
					$type = 'months';
					$start_date = $this->PurchaseOrders->getDatefromDays($explodetime[1],$type);
					 
				}
				if($explodetime[0]=='Y')
				{
					$type = 'year';
					$start_date = $this->PurchaseOrders->getDatefromDays($explodetime[1]+1,$type);
					 
				}
				
				}
				if(@$search['record']):				
				$records = $search['record'];
				else:
				$records = 10;

				endif;
				if($status):
				$conditions['Invoices.action'] = $status;
				endif;
				if($start_date):
				$conditions['Invoices.created >= '] = $start_date;
				endif;
				if($end_date):
				$conditions['Invoices.created <= '] = $end_date;
				endif;
				if($customer):
				$conditions['Invoices.vendor_id'] = $customer ;
				endif;
				if($po_number):
				$conditions['Invoices.invoice_number ='] = $po_number;
				endif;
				if($po_start && $po_end):
				$conditions[] = 'Invoices.invoice_amount between '.$po_start.'  and '.$po_end ;
				
				endif;
				if($po_start && !$po_end):
				$conditions['Invoices.invoice_amount > '] = $po_start;
				endif;
				if($po_end && !$po_start):
				$conditions['Invoices.invoice_amount < '] = $po_end;
				endif;

				
			}
			else
			{
				$search = array('status'=>'','record'=>'','start_date'=>'','end_date'=>'','time_frame'=>'','po_start'=>'','po_end'=>'','customer'=>'','po_number'=>''); 
				//$conditions = [];
				$records = '10';
				
			}
			//echo $user_id;
			//pr($conditions);exit;
			$this->paginate = [
	        'limit' =>$records,
	        'order' => [
	            'Invoices.id' => 'desc'
	        ]
	    ];
	    $getCompany = $this->UserDetails->getCompanyID($this->Auth->user('id'));
	    $company_id = $getCompany['company_id'];
	    if($settings['invoice_app_type'])
			{
				$conditions['invoice_level'] = $settings['invoice_app_type'];
			}
			
	    $list = $this->Invoices->find('all',['conditions'=>['Invoices.status '=>'1','Invoices.action !='=>'draft','Invoices.company_id'=>$company_id,$conditions],'contain'=>['PurchaseOrders','Vendor','PayearlyOffers']])->toArray();
	    
			$this->set(compact('list','getCustomers','search'));
		}


	public function recurringInvoice($recurring_num=null)
	{
		$this->is_permission($this->Auth->user());
		$this->loadModel('RecurringInvoices');
		$session = $this->request->session();
		$recurring = $this->RecurringInvoices->newEntity();
		if(!$recurring_num)
		{
			$this->Flash->error('Invalid Recurring Invoice!');
			$this->redirect(['action'=>'RecurringInvoices']);
		}
		$chk = $this->RecurringInvoices->find('all',['conditions'=>['recurring_inv_num'=>$recurring_num]])->last();
		if($chk)
		{
			$recurring = $this->RecurringInvoices->get($chk['id'],['contain'=>['Companies']]);	
		}
		$data = $this->request->data;
		if($data)
		{
			//pr($data);exit;
			$data['addedby'] = $this->Auth->user('id');
			if($data['start_on']):
			$data['start_on'] = date('Y-m-d',strtotime($data['start_on']));
			else :
			$data['start_on'] = '';	
			endif;
			if($data['end_on']):
			$data['end_on'] = date('Y-m-d',strtotime($data['end_on']));
			else :
			$data['end_on'] = '';
			endif;

			$recurring = $this->RecurringInvoices->patchEntity($recurring,$data);
			if($data['end_on']=='' && !$data['no_end_date'])
			{
				$recurring->errors('end_on','Please select date or select No End Date .');
			}
			//pr($recurring);exit;
			if($this->RecurringInvoices->save($recurring))
			{
				$this->Flash->success('Invoice Updated!');
				$this->redirect(['action'=>'RecurringInvoices']);
			}
			else
			{
				$this->set(compact('inv','recurring'));
				$this->Flash->error('Please fix the errors');
			}
		}
		$this->set(compact('inv','recurring'));
	}

	public function recupopup($id=null)
	{
		$session = $this->request->session();
		$company = $session->read('Company');
		$this->loadModel('RecurringInvoices');
		if($id)
		{
			$recurring = $this->RecurringInvoices->get($id);
		}
		else
		{
			$recurring = $this->RecurringInvoices->newEntity();
		}
		$this->set(compact('company','recurring'));
	}

	public function recurringInvoices()
	{
			$this->is_permission($this->Auth->user());
			$this->loadModel('RecurringInvoices');
	    	$user_id = $this->Auth->user('id');
	    	$session = $this->request->session();
			$getCustomers = $session->read('Company');
			$search = $this->request->query;
			$cond1 =[];
			$cond2 =[];
			if($this->Auth->user('role')==3)
			{
			$vendors = $this->UserDetails->is_exists($this->Auth->user('id'));
			$cond1[]= ['Invoices.department_id in ('.$vendors['department_id'].')'];
			$cond2[]= ['PurchaseOrders.department_id in ('.$vendors['department_id'].')'];
			$vendors =  $this->Vendors->getbyUserId($vendors['vendor_id']);	
			$vendors_id = $vendors['id'];
			}
			else
			{
			$vendors =  $this->Vendors->getbyUserId($this->Auth->user('id'));	
			$vendors_id = $vendors['id'];
			}
			$companyId = $session->read('Company');
			$po_orders = $this->PurchaseOrders->find('all',['conditions'=>[$cond2,'PurchaseOrders.vendors'=>$vendors_id,'PurchaseOrders.status'=>'1','PurchaseOrders.action'=>'open','PurchaseOrders.company_id'=>$companyId['id']],'order' => [
	            'PurchaseOrders.id' => 'desc'
	        ],'fields'=>['PurchaseOrders.id','PurchaseOrders.po_num'] ])->toArray();
	        
			$this->paginate = [
		        'limit' =>20,
		        'order' => [
		            'Invoices.id' => 'desc'
		        ]
	    	];
	    	$company_id = $session->read('Company');
	    	$qry = $this->Invoices->find('all',['conditions'=>['Invoices.vendor_id'=>$vendors_id,'Invoices.company_id'=>$company_id['id'],'Invoices.recurring_invoice'=> 1,'Invoices.status'=> 1] ,'contain'=>['Companies','RecurringInv']]);
	    	//pr($qry->toArray());exit;
	    	$list = $this->paginate($qry);
			$this->set(compact('list','getCustomers','search','po_orders'));
	}


	public function recurringInvoiceDelete($id=null)
	{
		$this->autoRender = false;
		$this->loadModel('RecurringInvoices');
		$this->loadModel('UserDetails');
		if($this->Auth->user('role')==3)
		{
			$vendors = $this->UserDetails->is_exists($this->Auth->user('id'));
			$cond1[]= ['Invoices.department_id in ('.$vendors['department_id'].')'];
			$cond2[]= ['PurchaseOrders.department_id in ('.$vendors['department_id'].')'];
			$vendors =  $this->Vendors->getbyUserId($vendors['vendor_id']);	
			$vendors_id = $vendors['id'];
		}
		else
		{
			$vendors =  $this->Vendors->getbyUserId($this->Auth->user('id'));	
			$vendors_id = $vendors['id'];
		}
		$getrecurring = $this->RecurringInvoices->get($id,['conditions'=>['RecurringInvoices.vendor_id'=>$vendors_id]]);
		if($this->RecurringInvoices->delete($getrecurring))
		{
			$this->Flash->success('Recurring Invoice deleted.');
		}
		else
		{
			$this->Flash->error('Please try again.');
		}
		$this->redirect($this->referer());
	}

	function sessionsave($type=null)
	{
		$this->autoRender = false;
		$this->loadModel('Users');
		$session = $this->request->session();
		if($type=='nonpo')
			{

				$usession['id'] = $this->Auth->user('id');
				$usession['invoice_type'] = $type;
				echo $this->Users->sesisonsave($usession);
				
			}
			else if($type=='po')
			{
				$usession['id'] = $this->Auth->user('id');
				$usession['invoice_type'] = 'po';
				echo $this->Users->sesisonsave($usession);
			}

	}

	



}

