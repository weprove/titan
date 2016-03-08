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
					<div class="row">
						<div class="col-md-2">
							<a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("showSmallerSize!", array($cart_id, $prevSize)), ENT_COMPAT) ?>" class="btn btn-normal"> << Smaller size</a>
						</div>
						
						<div class="col-md-8">
<?php if (isset($cart)&&count($cart)>0) { ?>
								<h2>Offers for you</h2>
								
<?php if (isset($products)&&count($products)>0) { $iterations = 0; foreach ($products AS $product) { ?>
										<div class="row">
											<div class="col-md-6">
												<h2><?php echo Latte\Runtime\Filters::escapeHtml($product["productName"], ENT_NOQUOTES) ?></h2>
												<h3><?php echo Latte\Runtime\Filters::escapeHtml($product["productDescription"], ENT_NOQUOTES) ?></h3>
												<h4>Standart price per month: <?php echo Latte\Runtime\Filters::escapeHtml($product["productPricePerMonth"], ENT_NOQUOTES) ?></h4>
												<p>Standart price total: £ <?php echo Latte\Runtime\Filters::escapeHtml($product["standartTotalPrice"], ENT_NOQUOTES) ?></p>
											</div>
											
											<div class="col-md-6">
												<div class="row offer1">
<?php if ($product['promotionName']&&$product['promotionActive']) { ?>													<div class="col-md-12">
														<h4><?php echo Latte\Runtime\Filters::escapeHtml($product["promotionName"], ENT_NOQUOTES) ?></h4>
													</div>
<?php } ?>
													
													<div class="col-md-12">
<?php if ($product['cartSaleActive']) { ?>														<p> Save: £ <?php echo Latte\Runtime\Filters::escapeHtml($product["cartSale"], ENT_NOQUOTES) ?></p>
<?php } ?>
														<p>New total price: £ <?php echo Latte\Runtime\Filters::escapeHtml($product["cartPriceTotal"], ENT_NOQUOTES) ?></p>
														<a href="" class="btn btn-primary">Book now!</a>
													</div>
												</div>
												
<?php if ($product['cartSaleActive2']) { ?>												<div class="row offer2">
													<div class="col-md-12">
														Move in for £1 for the first month - minimum stay 2 months
													</div>	
													
													<div class="col-md-12">
														<p>New total price: £ <?php echo Latte\Runtime\Filters::escapeHtml($product["cartPriceTotal2"], ENT_NOQUOTES) ?></p>
														<a href="" class="btn btn-primary">Book now!</a>
													</div>											
												</div>
<?php } ?>
											</div>
										</div>
<?php $iterations++; } } } ?>
						</div> <!-- col-md-8 -->
						
						<div class="col-md-2">
							<a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("showBiggerSize!", array($cart_id, $prevSize)), ENT_COMPAT) ?>" class="btn btn-normal">Bigger size >> </a>
						</div>
						
					</div>
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