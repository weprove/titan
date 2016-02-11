<?php
namespace App\Model;

use Nette\Object,
	Nette\Database\SqlLiteral,
	Nette\Diagnostics\Debugger;
/**
 * user authenticator.
 */
class File extends Base
{ 
    public function registerVideo($values){

			preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $values['attachmentUrl'], $matches);
			
			if(isset($matches[1]))
				$values['attachmentThumbUrl'] = "http://img.youtube.com/vi/".$matches[1]."/0.jpg";
			else
				$values['attachmentThumbUrl'] = '';
				
			$values['attachmentAdDate'] = new SqlLiteral('NOW()');
			$values['attachment_type_id'] = 3;
			$values['attachmentPublic'] = 1;
				
			$result = $this->db->query('INSERT INTO attachment', $values);
             
			return ($result)?$this->db->getInsertId():FALSE;
	}
	
    public function registerAttachment($values){
        
        $user_id = $values['user_id'];
		$type = (empty($values['attachment_type_id']))?1:$values['attachment_type_id'];
        unset($values['user_id'], $values['attachment_type_id']);
   
        $file_id = $this->registerFile($values);
        
        if(isset($file_id)){
             $p = array(
                "file_id" => $file_id,
                "user_id" => $user_id,
				"attachmentPublic" => 0,
				"attachment_type_id" => $type
             );
			 //pokud je to galerie tak vzdy verejne
			 if(isset($type)&&$type == 2){
				$p['attachmentPublic'] = 1;
			 }
			 
             $result = $this->db->query('INSERT INTO attachment', $p);
             
             return ($result)?$this->db->getInsertId():FALSE;
        }
        else{
            return false;
        }
    }
	
	public function registerFile($values){
		$r = $this->db->query('INSERT INTO file', $values);
		
		return ($r)?$this->db->getInsertId():FALSE;
	}
	
	public  function changeAttachmentName($line_id, $new_value){
		
		$r = $this->db->query("UPDATE attachment SET attachmentName = ? WHERE attachment_id = ?", $new_value, $line_id);
			
		return (count($r)>0)?true:false;
	}
	
	public function changeAttachmentOrder($newOrder){   
		$counter = 1;
		$query = "";
		foreach ($newOrder as $recordIDValue) {
			  $queryString = "UPDATE attachment SET attachmentDisplayOrder = " . $counter;  
			  $queryString .= " WHERE attachment_id = " . (int)$recordIDValue. ";";
			  $query .=  $queryString;
			  $counter ++;
		}
		
        $result = $this->db->query($query);
        return (count($result)>0)?TRUE:FALSE;
    }  
	
	public function deleteAttachment($item_id){
		$signAsDeleted = $this->db->query("UPDATE file f LEFT JOIN attachment bca ON f.file_id = bca.file_id SET fileDeleted = 1 WHERE bca.attachment_id = ? ", $item_id);
		if(count($signAsDeleted)>0){
			$r = $this->db->query("DELETE FROM attachment WHERE attachment_id = ? ", $item_id);
		}
		else{
			$r = array();
		}
			
		return (count($r)>0)?true:false;	
	}
	
	public  function changeAttachmentVisibility($attachment_id){
		
		$r = $this->db->query("UPDATE attachment SET attachmentPublic = !attachmentPublic  WHERE attachment_id = ?", $attachment_id);
			
		return (count($r)>0)?true:false;
	}

	public  function getAttachments($user_id){
		$selection = $this->db->table('attachment');
		$selection->select('attachment_id, attachmentPublic, attachmentName, file_id.originalName, file_id.ext, DATE_FORMAT(attachmentAdDate, ?) AS attachmentAdDate', '%Y-%m-%d %H:%i:%s');
		$selection->where('user_id = ? AND attachment_type_id = ?', $user_id, 1);
		return $selection;
	}
	
	public  function getPublicAttachments($user_id){
		$selection = $this->db->table('attachment');
		$selection->select('attachment_id, attachmentPublic, attachmentName, file_id.originalName, file_id.ext, DATE_FORMAT(attachmentAdDate, ?) AS attachmentAdDate', '%Y-%m-%d %H:%i:%s');
		$selection->where('user_id = ? AND attachment_type_id = ? AND attachmentPublic = 1 ', $user_id, 1);
		return $selection;
	}
	
	public  function getAttachment($attachment_id){
		return $this->db->query("SELECT bca.*, f.hashName, f.path, f.ext FROM attachment bca 
		LEFT JOIN file f ON bca.file_id = f.file_id
		WHERE bca.attachment_id = ? ", $attachment_id)->fetch();
	}	
	
	public function getImages($user_id){
		return $this->db->table("attachment")->select("*, file_id.*")->where("user_id = ? AND attachment_type_id = ?", $user_id, 2)->order("attachmentDisplayOrder ASC, attachmentAdDate DESC")->fetchAll();
	}
	
	public function getVideos($user_id){
		return $this->db->table("attachment")->select("*")->where("user_id = ? AND attachment_type_id = ?", $user_id, 3)->order("attachmentDisplayOrder ASC, attachmentAdDate DESC")->fetchAll();
	}
}
