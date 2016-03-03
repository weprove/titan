<?php
// source: C:\xampp\htdocs\titan\app\modules\Front/templates/Default/showPrices.latte

class Templatef1636ce2e74af0ace096ea1ea08ad9c2 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('8f53e0b573', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb9604a74000_content')) { function _lb9604a74000_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>	<div class="row">
		<div class="col-md-12">    
			<div class="panel-primary">
				<div class="panel-body">
<?php if (isset($cart)&&count($cart)>0) { ?>
						<h2>Offer for you</h2>
						<div class="row">
							<div class="col-md-12">
								//product name offer1
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12">
								//Promo sale off (50% etc)
								//promot valid X months
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12">
								cartId: <?php echo Latte\Runtime\Filters::escapeHtml($cart->cart_id, ENT_NOQUOTES) ?> <br>
								storeId: <?php echo Latte\Runtime\Filters::escapeHtml($cart->store_id, ENT_NOQUOTES) ?> <br>
								productId: <?php echo Latte\Runtime\Filters::escapeHtml($cart->product_id, ENT_NOQUOTES) ?> <br>
								leaseFrom: <?php echo Latte\Runtime\Filters::escapeHtml($cart->leaseFrom, ENT_NOQUOTES) ?> <br>
								leaseTo: <?php echo Latte\Runtime\Filters::escapeHtml($cart->leaseTo, ENT_NOQUOTES) ?> <br>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12">
								CartPrice: £ <?php echo Latte\Runtime\Filters::escapeHtml($cart->cartPrice, ENT_NOQUOTES) ?> <br>
								CartSale: £ <?php echo Latte\Runtime\Filters::escapeHtml($cart->cartSale, ENT_NOQUOTES) ?> <br>
								CartPriceTotal: £ <?php echo Latte\Runtime\Filters::escapeHtml($cart->cartPriceTotal, ENT_NOQUOTES) ?>

							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6">
								<a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("order!", array($cart_id)), ENT_COMPAT) ?>" class="btn btn-primary">Order >></a>
							</div>
						</div>
<?php } ?>
				</div>
			</div>
		</div>
	</div>
<?php
}}

//
// end of blocks
//

// template extending

$_l->extends = empty($_g->extended) && isset($_control) && $_control instanceof Nette\Application\UI\Presenter ? $_control->findLayoutTemplateFile() : NULL; $_g->extended = TRUE;

if ($_l->extends) { ob_start();}

// prolog Nette\Bridges\ApplicationLatte\UIMacros

// snippets support
if (empty($_l->extends) && !empty($_control->snippetMode)) {
	return Nette\Bridges\ApplicationLatte\UIMacros::renderSnippets($_control, $_b, get_defined_vars());
}

//
// main template
//
if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars()) ; 
}}