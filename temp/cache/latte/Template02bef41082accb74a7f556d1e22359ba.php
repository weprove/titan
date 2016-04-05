<?php
class Template02bef41082accb74a7f556d1e22359ba extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('f6d6b0897f', 'html')
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
<div style="width: 100%;">
<div style="width: 600px; padding: 30px; border-radius: 6px 6px 6px 6px; background-color: #fff; border: 1px solid #e5e3e3; margin-left: auto; margin-right: auto;">
<div style="float: left; width: 100%; margin-bottom: 25px;"><img src="http://screenshot.cz/QU/QUUU5/titan-logo.png" alt="" width="150px" align="left"></div>
<div>
<p>Dear <?php echo Latte\Runtime\Filters::escapeHtml($data['customerFirstname'], ENT_NOQUOTES) ?>
 <?php echo Latte\Runtime\Filters::escapeHtml($data['customerSurname'], ENT_NOQUOTES) ?>,</p>
<p>thanks for using the quote system on the Titan Storage website.</p>
<p>If you would like use our quote system again please <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link('\/\/:Front:Default:showPrices', array($data['cart_id'])), ENT_COMPAT) ?>">click here</a>.</p>
<p>If you would like to speak to one of our friendly advisors about reserving a <?php echo Latte\Runtime\Filters::escapeHtml($data['productName'], ENT_NOQUOTES) ?> unit please call 0800 644 0018.</p>
<p>Thanks, Titan</p>
</div>
</div>
<div style="width: 600px; padding: 0px 30px; margin-left: auto; margin-right: auto;">
<p><a href="http://www.titanstorage.co.uk">www.titanstorage.co.uk</a></p>
<p>Titan Storage Solutions, 9 Stirling Centre, Eastern Road, Bracknell, Berkshire, RG12 2PW. Call us on 0800 644 0018</p>
<p>To unsubscribe from all future emails please click here.</p>
</div>
<div>&nbsp;</div>
</div><?php
}}