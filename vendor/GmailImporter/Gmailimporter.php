<?php
namespace Google;

class GDataGmailer 
{

/*

$googleUri = Zend_Gdata_AuthSub::getAuthSubTokenUri('http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'],urlencode($scope),
0, 1);

echo "Click <a href='$googleUri'>here</a> to authorize this application.";

*/
var $email;
var $pwd;

 function __construct($email,$pwd)
 {
	 $this->email = $email;
	 $this->pwd = $pwd; 
 }
 
function GoogleContactsAuth(){

       
	   /*
	   Download from http://framework.zend.com/download/gdata .
	   TODO ---> Please change the myfolder to ur working directory of file 
	   */
		//ini_set('include_path','../Zend/');
		//set_include_path('Zend/'.get_include_path());
        //\Zend_Loader::registerAutoload();
		$autoloader = \Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace('Zend');
		//print_r(APP_DIR."/../vednor/Zend");exit;
		$autoloader->setZfPath(dirname(__FILE__)."\..\Zend", 'latest');
	
		
        $GoogleContactsService  = 'cp';

		try {
		    $GoogleContactsClient   = \Zend_Gdata_ClientLogin::getHttpClient($this->email,$this->pwd, $GoogleContactsService);
		}  catch (\Zend_Gdata_App_AuthException $ae) {
		   return '0';
		}

        $GoogleContactsClient   = \Zend_Gdata_ClientLogin::getHttpClient($this->email,$this->pwd, $GoogleContactsService);

        return $GoogleContactsClient;

}

function GoogleContactsAll($GoogleContactsClient ){

        $scope          = "http://www.google.com/m8/feeds/contacts/".$this->email."/";

        $gdata          = new \Zend_Gdata($GoogleContactsClient);

        $query          = new \Zend_Gdata_Query($scope.'full');

        $query->setMaxResults(10000);

        $feed           = $gdata->retrieveAllEntriesForFeed($gdata->getFeed($query));

        foreach ($feed as $entry){

                $contactName = $entry->title->text;

                $ext = $entry->getExtensionElements();

                foreach($ext as $extension){

                        if($extension->rootElement == "email"){

                                $attr=$extension->getExtensionAttributes();

                                $contactMail = $attr['address']['value'];

                        }else if($extension->rootElement == "phoneNumber"){

                                $contactPhone = $extension->text;

                        }else if($extension->rootElement == "postalAddress"){

                                $contactAddr = $extension->text;

                        }else if($extension->rootElement == "groupMembershipInfo"){

                                $UrlGroup       = $extension->extensionAttributes['href']['value'];

                                $arrGroupEx     = explode("/",$UrlGroup);

                                $contactGrp     = $arrGroupEx[(count($arrGroupEx)-1)];

                        }else if($extension->rootElement == "organization"){

                                $attr=$extension->getExtensionElements();

                                if($attr[0]->rootElement == "orgName"){

                                        $contactJob = $attr[0]->text;

                                }

                                if($attr[1]->rootElement == "orgTitle"){

                                        $contactPos = $attr[1]->text;

                                }

                        }

                        if($contactName==""){

                                $contactName = $contactMail;

                        }

                }

                $arrContactsData['contactMail']         = $contactMail;

                $arrContactsData['contactName']         = $contactName;

                $arrContactsData['contactPhone']        = $contactPhone;

                $arrContactsData['contactAddr']         = $contactAddr;

                $arrContactsData['contactJob']          = $contactJob;

                $arrContactsData['contactPos']          = $contactPos;

                $arrContactsData['contactGrp']          = $contactGrp;

                $arrContacts[] = $arrContactsData;

        }

        return $arrContacts;

}

function GoogleGroupsAll($GoogleContactsClient ){

        $scope          = "http://www.google.com/m8/feeds/groups/".$this->email."/";

        $gdata          = new \Zend_Gdata($GoogleContactsClient);

        $query          = new \Zend_Gdata_Query($scope.'full');

        $query->setMaxResults(10000);

        $feed           = $gdata->retrieveAllEntriesForFeed($gdata->getFeed($query));

        foreach ($feed as $entry){

                $arrGroupsData['groupName']     = $entry->title->text;

                $arrIdExplode                   = explode("/",$entry->id->text);

                $arrGroupsData['groupId']       = $arrIdExplode[(count($arrIdExplode)-1)];

                $GroupHref                      = $entry->link[1];

                if($GroupHref->rootElement == "link"){

                        $arrHrefExplode                 = explode("/",$GroupHref->href);

                        $arrGroupsData['groupHref']     = $arrHrefExplode[(count($arrHrefExplode)-1)];

                }

                $arrGroups[] = $arrGroupsData;

        }

        return $arrGroups;

}
}//end of class

 /*
	   Download GDATA  from http://framework.zend.com/download/gdata . 
	   Copy the Zend folder in library path of downloaded zip package
	 
	   TODO ---> in GoogleContactsAuth() function of this class, CHANGE  myfolder to Zend folder path
	   
	   If ur using  Zend Framework then no need to download GDATA . 
	   */
 
?> 