<?php
namespace App\Model;

use Nette\Object,
	Nette\Database\SqlLiteral,
	Nette\Diagnostics\Debugger;
/**
 * Message model.
 */
class Message extends Base
{ 
	public function getMessage($internal_message_id, $user_id){
		return $this->db->table("internal_message")->select("internal_message.*")->where("internal_message_id = ? AND recipient_id = ?", $internal_message_id, $user_id)->fetch();
	}
	
	public function saveInternalMessage($values){
		$r = $this->db->query("INSERT INTO internal_message", $values);
		
		return ($r)?true:false;
	}
	
	public function getUserIdByName($user_id, $name, $surname){
		$r = $this->db->table("contact")->select("contact.user_id")->where("contact_owner_id = ? AND user_id.name LIKE ? AND user_id.surname LIKE ?", $user_id, "%$name%", "%$surname%")->limit(1)->fetch();
		
		return (isset($r["user_id"]))?$r["user_id"]:false;
	}
	
	public function getSavedResponses($user_id){
		return $this->db->table("saved_response")->select("*")->where("user_id = ?", $user_id)->fetchAll();
	}
	
	public function getAllMessages($user_id){
		return $this->db->table("internal_message")->select("internal_message.sender_id, internal_message.internalMessageAdDate, internal_message.internal_message_id, internal_message.internalMessageReaded, internal_message.reply_to_message_id, internal_message.internalMessageContent, internal_message.internalMessageTitle, internal_message.recipient_id, sender_id.name, sender_id.surname, sender_id.profileThumbnail")
		->where("recipient_id = ?", $user_id)->fetchAll();
	}
	
	public function insertSavedResponse($values){
		return $this->db->query("INSERT INTO saved_response", $values);
	}
}
