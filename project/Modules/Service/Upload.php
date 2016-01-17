<?php
namespace Modules\Service;
use Model\Upload as UploadModel;
use Core\Str;
use Dflydev\ApacheMimeTypes\PhpRepository;
class Upload{
	
	public $table;
	public $upload_dir = "upload";
	public $allowMime = ['image/jpg','image/png','image/gif','image/jpeg'];
	public $obj;
	public $mime;
	function __construct(){
		$this->obj = new UploadModel;
		$this->mime = new PhpRepository;
	}
	
	function hashAction(){
		$gid = cookie('guest');
		$fs = json_decode($_POST['files']);
		$i = 0;
		foreach($fs as $f){
			$gid = $gid.$f->fileId;
			$hash = $f->fileHash;
			$one = $this->obj->findOne(['hash'=>$hash]);
			if($one){
				$flag = true;
			}else{
				$flag =  false;
			}
			$data[$i]['id'] = $f->fileId;
			$data[$i]['onserver'] = $flag;
			$data[$i]['hash'] = $hash;
			$i++;
		}
	
		echo json_encode($data);
	}
	function indexAction(){
		$hash = $_POST['hash'];
		$chunk = $_POST['chunk'];
		$chunks = $_POST['chunks'];
		$ret['fileNameReturn'] = $n = $_POST['fileNameReturn'];
			
		if(!in_array($mime,$this->allowMime)){
	
		}
			
		if($hash){
			$one = (array)$this->obj->findOne(['hash'=>$hash]);
			if($one){
				unset($one['_id'],$one['uid'],$one['time']);
				exit(json_encode($one+$ret));
					
			}
		}
		$mime = $_FILES['file']['type'];
		$size = $_FILES['file']['size'];
		$mr = $this->mime->findExtensions($mime);
		$ext = $mr[1]?:$mr[0];
		///
		$dir = '/'.$this->upload_dir.'/'.date('Ymd');
		
		if(!is_dir(WEB.$dir)) mkdir(WEB.$dir,0777,true);
		/////////
		$name = $dir.'/'.Str::rand(8).".".$ext;
		
		$filePath = WEB.$name;
		
		if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
			$contentType = $_SERVER["HTTP_CONTENT_TYPE"];
				
			if (isset($_SERVER["CONTENT_TYPE"]))
				$contentType = $_SERVER["CONTENT_TYPE"];
					
				// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
				if (strpos($contentType, "multipart") !== false) {
					if (isset($_FILES['file']['tmp_name'])  && is_uploaded_file($_FILES['file']['tmp_name'])) {
						// Open temp file
						$out = fopen($filePath, $chunk == 0 ? "wb" : "ab");
						if ($out) {
							// Read binary input stream and append it to temp file
							$in = fopen($_FILES['file']['tmp_name'], "rb");
							if ($in) {
								while ($buff = fread($in, 4096))
									fwrite($out, $buff);
							} else{
							}
							fclose($in);
							fclose($out);
							@unlink($_FILES['file']['tmp_name']);
						}
					}
				}else {
					$out = fopen($filePath, $chunk == 0 ? "wb" : "ab");
					if ($out) {
						$in = fopen("php://input", "rb");
						if ($in) {
							while ($buff = fread($in, 4096))
								fwrite($out, $buff);
						} else{
						}
						fclose($in);
						fclose($out);
					}
				}
				 
				if(($chunk && ($_POST['chunk']+1) != $_POST['chunks'])){
					exit(json_encode(['error'=>1,'msg'=>'分块上传进行中']));
				}
				$data = array(
						'name'       =>$name,
						'extension'  => $ext,
						'mime'       => $mime,
						'size'       => $size,
						'hash'        => $hash,
				);
					
				$uid = cookie('id');
				if($uid){
					$data['uid'] = $uid;
				}
				 
				$nid = $this->obj->insert($data);
					
				if(!$hash){
					$this->obj->update(['_id'=>$nid],['hash'=>$h1]);
					$data['hash'] = $h1;
				}
				exit(json_encode($data+$ret));
	}
	
	
	
}