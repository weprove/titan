<?php
namespace App\Model;

use Nette\Object,
	Nette\Database\SqlLiteral,
	Nette\Diagnostics\Debugger;
/**
 * user authenticator.
 */
class User extends Base
{ 
	
	public function getSalutationPairs(){
		return $this->db->query("SELECT salutation_id, salutationName FROM salutation")->fetchPairs();
	}
	
	public function toggleUserApproval($user_id, $activated = 1){
		return $this->db->query("UPDATE user SET activated = ? WHERE user_id = ? ", $activated, $user_id);
	}
	
	public function getUserSelection(){
		return $this->db->table('user')->select("user.user_id, role_id.roleName, user.name, user.surname, user.email, user.organizationName, user.activated");
	}
	
	
	public function getListDefaults($key, $table, $user_id){
		$key = new SqlLiteral($key);
		$table = new SqlLiteral($table);
		
		return $this->db->query("SELECT ".$key."_id FROM ".$table." WHERE user_id = ?", $user_id)->fetchPairs();
	}
	
	public function getUserProfileData($user_id){
		//nesmi byt vybrano heslo atd!
		$r = $this->db->table("user")->select("user.*, location_id.locationName, doctor_level_id.doctorLevelShortName")->where("user_id = ?", $user_id)->fetch();
		return ($r)?$r:array();
	}
	
	public function getUserProfileThumbnail($user_id){
		$r = $this->db->query("SELECT profileThumbnail FROM user WHERE user_id = ?", $user_id)->fetch();
		return (isset($r['profileThumbnail']))?$r['profileThumbnail']:false;
	}
	
	public function getUserData($user_id){
		$r = $this->db->table("user")->select("*, location_id.locationName, doctor_level_id.doctorLevelName, speciality_id.speciality_name, speciality_level_id.speciality_level_name")->where("user_id = ?", $user_id)->fetch();
		return ($r)?$r:array();
	}
	
	public function updateMyProfile($values, $user_id){
		$r = $this->db->query("UPDATE user SET", $values, "WHERE user_id = ?", $user_id);
		return ($r)?true:false;
	}
	 

	public  function updateUserAccount($values, $user_id){
		//budeme updatovat
		$r = $this->db->query("UPDATE user SET", $values, "WHERE user_id = ?", $user_id);
		
		return (count($r)>0)?true:false;
    } 
	
	public function getRoleName($id){
        $result = $this->db->query("SELECT roleName FROM role WHERE role_id = ?", $id)->fetch();
        return (empty($result))? array():$result;
    }  
	
    public function getUserEmail($id){
        $result = $this->db->query("SELECT email FROM user WHERE user_id = ?", $id)->fetch();
        return (empty($result))? array():$result;
    }  
	
    public function updateUserRole($values){
        
        $result = $this->db->query('UPDATE user SET role_id = ?',$values['role_id'], 'WHERE user_id = ?', $values['user_id']);
        return (count($result))?TRUE:FALSE;
    }  
	
	public function deactivate($user_id){
        return $this->db->query('UPDATE user SET ? WHERE user_id = ?', array('activated'=>0), $user_id);
    }  
	
    public function getRoles(){
        $result = $this->db->query("SELECT role_id, roleName FROM role")->fetchPairs("role_id", "roleName");
        return $result;
    }    
	
    public  function selectHash($email){
      $result =  $this->db->query('SELECT uh.user_hash_id as hash
       FROM user_hash uh LEFT JOIN user u ON uh.user_id = u.user_id WHERE u.user_id = (SELECT user_id FROM user WHERE email = ?)', $email)->fetch();
      if($result){
        $newGenerationTime =   $this->db->query('UPDATE user_hash SET generationTime = NOW() WHERE user_hash_id = ?', $result['hash']);
      }
      else{
        $helpers =  new \Helpers\Helpers;
        $hash = $helpers->newUserHash($email);
        $arr = array(
          'user_hash_id' => $hash,
          'generationTime' => new SqlLiteral('NOW()'),
          'user_id' =>   $this->db->query('SELECT user_id FROM user WHERE email = ?', $email)->fetch()
        );
        $result =  $this->db->query('INSERT INTO user_hash', $arr);  
        unset($result);
        $result = array();
        $result['hash'] = $hash;
      }
      return (isset($result['hash'])&&!empty($result['hash']))?$result['hash']:FALSE; 
    }
	
    public  function addHash($email, $userId){ 
		$helpers =  new \Helpers\Helpers;
		$hash = $helpers->newUserHash($email);
		$arr = array(
		'user_hash_id' => $hash,
		'generationTime' => new SqlLiteral('NOW()'),
		'user_id' =>  $userId
		);
		$result =  $this->db->query('INSERT INTO user_hash', $arr);
		return $hash;
    }  
	
    public  function activateUser($hash){
      $result =  $this->db->table('user_hash')->select('user_id')->where('user_hash_id =? AND generationTime >= DATE_SUB(CURDATE(),INTERVAL 14 DAY)', $hash)->fetch();
      if($result){
        $activation =  $this->db->query('UPDATE user SET activated = 1 WHERE user_id = ?', $result['user_id']);
      }
      else{
      	$activation = FALSE;
      }
      return ($activation)?TRUE:FALSE;
    } 
	
    public  function deleteHash($hash){
        $this->db->query('DELETE FROM user_hash WHERE user_hash_id = ?', $hash);
    } 
	
	public function userHasFinishedRegistration($email){
		$r = $this->db->table('user')->select("finishedRegistration, activated")->where("email = ?", $email)->fetch();
		return ($r)?$r:array();
	}
	
    public  function changePassword($password, $email){
        $result =  $this->db->query("UPDATE user SET password = ?", $password, "WHERE email = ?", $email);
        return (count($result)>0) ? TRUE:FALSE;
    }
    //last Login
    public  function setActiveFlag($userId){
         $this->db->query("UPDATE user SET lastActivity = NOW(), isLoggedIn = 1 WHERE user_id = ?", $userId);
    }
	
    public  function setLogoutFlag($userId){
         $this->db->query("UPDATE user SET isLoggedIn = 0 WHERE user_id = ?", $userId);
    }
	
    public  function getAccountData($userId){
        $result =  $this->db->query("SELECT * FROM user u WHERE user_id = ?", $userId)->fetch();
		unset($result['password']);
        return ($result) ? $result:FALSE;
    }  
	
    public  function checkCode($userId, $hash){
        $result =  $this->db->query("
          SELECT COUNT(*) FROM smsAuthorization
          WHERE user_id = ? AND hash = ?", $userId, $hash)->fetch();
        if($result>0){
            $result =  $this->db->query("UPDATE user SET authorized = 1 WHERE user_id = ?", $userId);
        }
        return ($result) ? TRUE:FALSE;
    }
	
	public  function addCode($mobil, $userId, $hash){
        $result =  $this->db->query('INSERT INTO smsAuthorization (mobil, hash, user_id, odeslano) VALUES(?, ?, ?, 1)', $mobil, $hash, $userId);
        return ($result) ? TRUE:FALSE;
    }
	
    public  function isUserAuthorized($userId){
        $result =  $this->db->query("SELECT authorized FROM user WHERE user_id = ?", $userId)->fetch();
        return ($result) ? TRUE:FALSE;
    }   	
	
    public  function findByEmail($email){
        $row =  $this->db->table("user")->select("name, surname, username, password, email, user.user_id AS id, role_id.roleName AS role")->where("user.email = ?",$email)->fetch();

        return ($row) ? $row : NULL;
    }
	
    /*dostuopnost uziv. jmena*/
    public  function isUsernameAvailable($username){
        $row =  $this->db->table("user")->select("user_id")->where("username = ?", $username->getValue())->fetch();
        return ($row) ? FALSE : TRUE;
    }
	
    /*dostupnost prihlasovaciho emailu, existuje uz?*/
    public  function isEmailAvailable($email){
        $row =  $this->db->table("user")->select("user_id")->where("email = ?", $email->getValue())->fetch();
        return ($row) ? FALSE : TRUE;
    }  
	
    public  function emailExists($email){
        $row =  $this->db->table("user")->select("user_id")->where("email = ?", $email)->fetch();
        return ($row) ? TRUE : FALSE;
    }
	
    public  function usernameExists($username){
        $row =  $this->db->table("user")->select("user_id")->where("username = ?", $username)->fetch();
        return ($row) ? TRUE : FALSE;
    } 
	
    public function registerUser($values, $role_id = 2){
		$values["role_id"] = $role_id;
		unset($values["passwordCheck"], $values["agreeToTerms"]);
		  
		$r =  $this->db->query('INSERT INTO user', $values);
		$id =  $this->db->getInsertId();
	  
		return ($r)?$id:FALSE;
    }  
	
	public function registerInvitedUser($values, $role_id = 2){
		$values["role_id"] = $role_id;
	  
		unset($values["passwordCheck"], $values["agreeToTerms"]);
	  
		$r =  $this->db->query('INSERT INTO user', $values);
		$id =  $this->db->getInsertId();
	  
		return ($r)?$id:FALSE;
	} 
}
