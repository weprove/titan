<?php
namespace Helpers;

class LayoutGenerator extends \Nette\Object
{
	/**
	 * @inject
	 * @var \App\Model\BusinessCase */
	public $model;
	
	public function wordToPdf($attachment){
		$this->model->getBcStates();
		
		print_r($model->getBcStates());exit;
		$save = false;
		if(isset($attachment)&&count($attachment)>0){
			if($attachment->ext == "doc" || $attachment->ext == "docx"){
				//vime, ze jde o layout (.doc, .docx)
				//JDEME GENEROVAT
				
				$word = new \COM("Word.Application") or die (Debugger::log("COM.Word Could not initialise Object (attachment_id = $attachment->business_case_attachment_id)."));
				// set it to 1 to see the MS Word window (the actual opening of the document)
				$word->Visible = 0;
				// recommend to set to 0, disables alerts like "Do you want MS Word to be the default .. etc"
				$word->DisplayAlerts = 0;
				// open the word 2007-2013 document 
				$word->Documents->Open(WWW_DIR.$attachment->path.$attachment->hashName);
				//$root = realpath($_SERVER["DOCUMENT_ROOT"]);
				/*print_r(WWW_DIR.$attachment->path.$attachment->hashName);
				print_r($word->Documents->Open(WWW_DIR.$attachment->path.$attachment->hashName));exit;*/
				
				$hashNameWithoutExt = pathinfo($attachment->hashName)['filename'];
				// save it as word 2003
				$word->ActiveDocument->SaveAs(WWW_DIR.$attachment->path."2013_".$attachment->hashName);
				// convert word 2007-2013 to PDF
				$save = $word->ActiveDocument->ExportAsFixedFormat(WWW_DIR.$attachment->path.$hashNameWithoutExt.'.pdf', 17, false, 0, 0, 0, 0, 7, true, true, 2, true, true, false);
				// quit the Word process
				$word->Quit(false);
				// clean up
				unset($word);
			}//ext if	
		}
		return ($save)?true:false;
	}
	
	protected function getMailMerge( &$wts, $index, $dataarray )
	{
	  $loop = true;
	  $startfield = false;
	  $setval = false;
	  $counter = $index;
	  $newcount = 0;
	  while( $loop )
	  {
		if( $wts->item( $counter )->attributes->item(0)->nodeName == 'w:fldCharType' )
		{
		  $nodeName = '';
		  $nodeValue = '';
		  switch( $wts->item( $counter )->attributes->item(0)->nodeValue )
		  {
			case 'begin':
			  if( $startfield )
			  {
				$counter = getMailMerge( $wts, $counter, $dataarray );
			  }
			  $startfield = true;
			  if( $wts->item( $counter )->parentNode->nextSibling )
			  {
				$nodeName = $wts->item( $counter )->parentNode->nextSibling->childNodes->item(1)->nodeName;
				$nodeValue = $wts->item( $counter )->parentNode->nextSibling->childNodes->item(1)->nodeValue;
			  } else {
				// No sibling
				// check next node
				$nodeName = $wts->item( $counter + 1 )->parentNode->previousSibling->childNodes->item(1)->nodeName;
				$nodeValue = $wts->item( $counter + 1 )->parentNode->previousSibling->childNodes->item(1)->nodeValue;
			  }
			  if( $nodeValue == 'date \@ "MMMM d, yyyy"' )
			  {
				$setval = true;
				$newval = date( "F j, Y" );
			  }
			  if( substr( $nodeValue, 0, 11 ) == ' MERGEFIELD' )
			  {
				$setval = true;
				$newval = $dataarray[ strtolower( str_replace( '"', '', trim( substr( $nodeValue, 12 ) ) ) ) ];
			  }
			  $counter++;
			  break;
			case 'separate':
			  if( $wts->item( $counter )->parentNode->nextSibling )
			  {
				$nodeName = $wts->item( $counter )->parentNode->nextSibling->childNodes->item(1)->nodeName;
				$nodeValue = $wts->item( $counter )->parentNode->nextSibling->childNodes->item(1)->nodeValue;
			  } else {
				// No sibling
				// check next node
				$nodeName = $wts->item( $counter + 1 )->parentNode->previousSibling->childNodes->item(1)->nodeName;
				$nodeValue = $wts->item( $counter + 1 )->parentNode->previousSibling->childNodes->item(1)->nodeValue;
			  }
			  if( $setval )
			  {
				$wts->item( $counter )->parentNode->nextSibling->childNodes->item(1)->nodeValue = $newval;
				$setval = false;
				$newval = '';
			  }
			  $counter++;
			  break;
			case 'end':
			  if( $startfield )
			  {
				$startfield = false;
			  }
			  $loop = false;
		  }
		}
	  }
	  return $counter;
	}

}