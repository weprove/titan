<?php

namespace Base\Presenters;

use Nette,
	Nette\Application\Responses\JsonResponse,
	Nette\Application\Responses\TextResponse,
	Nette\Diagnostics\Debugger,
	Nette\Application\UI\Form,
	Nette\Mail\Message,
	Nette\Environment;


abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	public $mode;
	/** @var Models\User */
    protected $userModel;
	/** @var Models\Message */
    protected $messageModel;

	public $mailer;

	public function startup(){
		
		parent::startup();
		
		\Kdyby\Replicator\Container::register();
		
		$this->mailer = new \Nette\Mail\SendmailMailer;
	}
	
	protected function beforeRender()
	{
		$this->template->viewName = $this->getView();
		$this->template->root = isset($_SERVER['SCRIPT_FILENAME']) ? realpath(dirname(dirname($_SERVER['SCRIPT_FILENAME']))) : NULL;

		$a = strrpos($this->getName(), ':');
		if ($a === FALSE) {
			$this->template->moduleName = '';
			$this->template->presenterName = $this->getName();
		} else {
			$this->template->moduleName = substr($this->getName(), 0, $a + 1);
			$this->template->presenterName = substr($this->getName(), $a + 1);
		}
		
		//pokud jde o FRONT
		if($this->template->moduleName == 'Front:'){

		
		}
	}
	
	public function getDeviceType(){
		$tablet_browser = 0;
		$mobile_browser = 0;
		 
		if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
			$tablet_browser++;
		}
		 
		if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
			$mobile_browser++;
		}
		 
		if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
			$mobile_browser++;
		}
		 
		$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
		$mobile_agents = array(
			'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
			'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
			'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
			'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
			'newt','noki','palm','pana','pant','phil','play','port','prox',
			'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
			'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
			'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
			'wapr','webc','winw','winw','xda ','xda-');
		 
		if (in_array($mobile_ua,$mobile_agents)) {
			$mobile_browser++;
		}
		 
		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
			$mobile_browser++;
			//Check for tablets on opera mini alternative headers
			$stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
			if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
			  $tablet_browser++;
			}
		}
		 
		if ($tablet_browser > 0) {
		   // do something for tablet devices
			return 'tablet';
		}
		else if ($mobile_browser > 0) {
		   // do something for mobile devices
			return 'mobile';
		}
		else {
		   // do something for everything else
			return 'desktop';
		} 
	}

	protected function createComponentBreadCrumb()
	{
		$breadCrumb = new \Alnux\NetteBreadCrumb\BreadCrumb();
		$breadCrumb->addLink('Dashboard', $this->link(':Admin:Default:'), 'glyphicons glyphicons-display');

		return $breadCrumb;
	}
	
	public function injectUser(\App\Model\User $userModel)
    {
        $this->userModel = $userModel;
    }
	
	public function injectMessage(\App\Model\Message $messageModel)
    {
        $this->messageModel = $messageModel;
    }
	
	public function curl($url, $post = "", $header = array()) {
		$curl = curl_init();
		$userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
		curl_setopt($curl, CURLOPT_URL, $url);
		
		if(count($header)>0)
			curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
	
		//The URL to fetch. This can also be set when initializing a session with curl_init().
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		//TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
		//The number of seconds to wait while trying to connect.
		if ($post != "") {
			curl_setopt($curl, CURLOPT_POST, 5);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
		}
		curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
		//The contents of the "User-Agent: " header to be used in a HTTP request.
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
		//To follow any "Location: " header that the server sends as part of the HTTP header.
		curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
		//To automatically set the Referer: field in requests where it follows a Location: redirect.
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		//The maximum number of seconds to allow cURL functions to execute.
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		//To stop cURL from verifying the peer's certificate.
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		$contents = curl_exec($curl);
		curl_close($curl);
		return $contents;
	}
	
	public function toFloat($string){
		$string = preg_replace("/[^0-9.]/", "", $string);
		$string = floatval($string);
		
		return $string;
	}
	
	//funcke stejna jako v auction presenteru
	/*public function handleDownloadFile($business_case_attachment_id){
		$attachment = $this->businessCaseModel->getAttachment($business_case_attachment_id);
		
		if($attachment){
			//musime zjistit zda byl dokument jiz publikovan
			if($attachment->bcaVisible){
				$this->prepareAttachment($attachment);
			}
			else{
				//neverejna priloha
				$attachment = $this->businessCaseModel->getNonPublicAttachment($business_case_attachment_id, $this->user->identity->client);
				if($attachment){
					$this->prepareAttachment($attachment);
				}
			}
		}
	}*/
	
    public function resizeImage($imgSrc, $pathToThumbs, $thumbWidth = 60, $thumbHeight = 60){
        //Your Image
         if(empty($pathToThumbs))
            $pathToThumbs = WWW_DIR . "/files/thumbs/";
            
        //getting the image dimensions
        list($width, $height) = getimagesize($imgSrc);
        
        if (!is_dir($pathToThumbs)) {
            @mkdir($pathToThumbs);
        }

        $ext = pathinfo($imgSrc, PATHINFO_EXTENSION);
        $filename = pathinfo($imgSrc, PATHINFO_FILENAME);
        $newFilename = $filename.".".$ext;
         
        //saving the image into memory (for manipulation with GD Library)
        $xt = strtolower($ext);
        
        if(($xt == 'jpg') || ($xt == 'jpeg'))
            $myImage = imagecreatefromjpeg($imgSrc);
        elseif($xt == 'png')
            $myImage = imagecreatefrompng($imgSrc);
        elseif($xt == 'gif')
            $myImage = imagecreatefromgif($imgSrc);

        //setting the crop size
        if($height > $width){
			//prohodime sirku a vysku v pomeru 3:4
			$thumb = imagecreatetruecolor($thumbHeight, $thumbWidth);
			imagecopyresampled($thumb, $myImage, 0, 0, 0, 0, $thumbHeight, $thumbWidth, $width, $height);
		}
		else{
			$thumb = imagecreatetruecolor($thumbWidth, $thumbHeight);
			imagecopyresampled($thumb, $myImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);
		}
        
		       
        imagejpeg( $thumb, "{$pathToThumbs}{$newFilename}" );
        
        return TRUE;
    }
	
	public function handleDownloadUserAttachment($user_attachment_id){
		if($this->user->isInrole("guest")||$this->user->isInrole("ucastnik")){
			$this->redirect(":Front:Default:");
		}
		
		//metoda zabezpecena proti neopravnenemu pristupu
		if($this->user->isInRole('admin'))
			$attachment = $this->userModel->getUserAttachment($user_attachment_id);
		else
			$attachment = $this->userModel->getUserAttachment($user_attachment_id, $this->user->identity->client);
		
		$file = WWW_DIR.$attachment->path.$attachment->hashName;
		
		if(file_exists($file)){
			$this->sendResponse(new \Nette\Application\Responses\FileResponse($file));
		}
		exit;	
	}

}
