<?php
// source: C:\xampp\htdocs\titan\app\modules\Admin/templates/Order/showLeftCart.latte

class Template4ef6960d3e062209436bc5d53b9cbfa6 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('5e36b05431', 'html')
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
<div class="row">
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-12"><b>Name:</b> <?php echo Latte\Runtime\Filters::escapeHtml($order->customerFirstname, ENT_NOQUOTES) ?>
 <?php echo Latte\Runtime\Filters::escapeHtml($order->customerSurname, ENT_NOQUOTES) ?></div>
			<div class="col-md-12"><b>Tel.:</b> <?php echo Latte\Runtime\Filters::escapeHtml($order->customerPhone, ENT_NOQUOTES) ?></div>
			<div class="col-md-12"><b>Unit details:</b> <?php echo Latte\Runtime\Filters::escapeHtml($order->mainProductName, ENT_NOQUOTES) ?></div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-12"></div>
			<div class="col-md-12"><b>Email:</b> <?php echo Latte\Runtime\Filters::escapeHtml($order->customerEmail, ENT_NOQUOTES) ?></div>
			<div class="col-md-12"><b>Duration:</b> <?php echo date("d/m/y", strtotime($order->leaseFrom)) ?>
 to <?php echo date("d/m/y", strtotime($order->leaseTo)) ?></div>
			<div class="col-md-12"></div>
		</div>
	</div>
</div><?php
}}