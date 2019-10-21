<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;

class FileUploadComponent extends Component
{

 
public function image_upload($data,$fnames=null,$path='uploads/')
{

    $file_tmp = $data['tmp_name'];
    // $ext = $this->get_ext($data['name']);
    $ext = pathinfo($data['name'],PATHINFO_EXTENSION);
    // echo $ext; die;
    $filename = 'Vestotus-'.time().$data['name'];
    $ext = strtolower($ext);
    if($ext == 'png' || $ext == 'jpg' || $ext == 'gif' || $ext == 'jpeg' || $ext == 'tif')
    {

    

    if($fnames)
    {
        $fname = explode('.',$fnames);
        $filename = $fnames[0].'.'.$ext;
    }
    $path = realpath($path).'/';
    if(move_uploaded_file($file_tmp,$path.$filename))
    {
        $msg = array('status'=>'success','filename'=>$filename,'path'=>$path.$filename);
    }
    else
    {
        $msg = array('status'=>'error','message'=>'Issue');
    }
}
else
{
    $msg = array('status'=>'error','message'=>'Invalid Image!');
    
}

return $msg;
}

public function upload($data,$path='uploads/')
{
    $file_tmp = $data['tmp_name'];
    $ext = $this->get_ext($data['name']);
    $filename = time().$data['name'];
    if(move_uploaded_file($file_tmp,$path.$filename))
    {
        $msg = array('status'=>'success','filename'=>$filename,'path'=>$path.$filename);
    }
    else
    {
        $msg = array('status'=>'error','message'=>'Issue');
    }


return $msg;
}

function get_ext($file)
{
return substr($file, strpos($file, ".")+1);
}

function delete_file($file)
{
    
 return unlink(WWW_ROOT.$file);
}

public function create_image($data)
{
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);
        $imgname = time().'.png';
        if(file_put_contents(WWW_ROOT.'uploads/'.$imgname, $data))
        {
            $msg = array('msg'=>'success','filename'=>$imgname);
        }
        else
        {
            $msg = array('msg'=>'error');
        }
        return $msg;
}

public function valid_video($data)
{
    $file = $data['name'];
     $ext = explode('.',$file);
    $last = count($ext)-1;
    $ext = $ext[$last];
    if($ext == 'mp4' || $ext == 'avi' )
    {
        return "success";
    }
    else
    {
        return "fail";
    }

}

public function valid_audio($data)
{
    $file = $data['name'];
    $ext = explode('.',$file);
    $last = count($ext)-1;
    $ext = $ext[$last];
    if($ext == 'mp3' )
    {
        return "success";
    }
    else
    {
        return "fail";
    }

}

public function valid_ppt($data)
{
    $file = $data['name'];
    $ext = explode('.',$file);
    $last = count($ext)-1;
    $ext = $ext[$last];
    if($ext == 'ppt' || $ext=='pptx')
    {
        return "success";
    }
    else
    {
        return "fail";
    }

}



}


?>