<?php
// source: C:\xampp\htdocs\titan\app\modules\Admin/templates/emailTemplate.latte

class Template492d9664f480bb4a81fca9ede1d17842 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('07711706c2', 'html')
;
// prolog Nette\Bridges\ApplicationLatte\UIMacros

// snippets support
if (empty($_l->extends) && !empty($_control->snippetMode)) {
	return Nette\Bridges\ApplicationLatte\UIMacros::renderSnippets($_control, $_b, get_defined_vars());
}

//
// main template
//
?>
<body style="background-color: #f5f5f5;">
 <div style=" width: 100%"> 
  <div style="width: 600px; padding:30px; border-radius: 6px 6px 6px 6px; background-color: #fff; border: 1px solid #e5e3e3;margin-left: auto ;
  margin-right: auto ;">
   <div style="float:left; width: 100%; margin-bottom: 25px"><img align="left" width="150px" src="http://screenshot.cz/QU/QUUU5/titan-logo.png"></div>
   <div>
    <p>Dear <?php echo Latte\Runtime\Filters::escapeHtml($data['customerFirstname'], ENT_NOQUOTES) ?>
 <?php echo Latte\Runtime\Filters::escapeHtml($data['customerSurname'], ENT_NOQUOTES) ?>,</p>
    <p>thanks for using the quote system on the Titan Storage website.</p>
    <p>If you would like use our quote system again please <a href="http://titanquote.lahivecreative.co.uk/default/show-prices?cart_id=<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($data['cart_id']), ENT_COMPAT) ?>">click here</a>.</p>
    <p>If you would like to speak to one of our friendly advisors about reserving a <?php echo Latte\Runtime\Filters::escapeHtml($data['productName'], ENT_NOQUOTES) ?> unit please call 0800 644 0018.</p>
    <p>Thanks,</br> Titan</p> 
   </div>
   
  </div>
  <div style="width: 600px; padding:0px 30px;margin-left: auto ;
  margin-right: auto ;">
   <p><a href="http://www.titanstorage.co.uk">www.titanstorage.co.uk</a></p>
   <p>Titan Storage Solutions, 9 Stirling Centre, Eastern Road, Bracknell, Berkshire, RG12 2PW.</br>
   Call us on 0800 644 0018</p>
   <p>To unsubscribe from all future emails please click here.</p>
  </div>
 <div>
</body><?php
}}