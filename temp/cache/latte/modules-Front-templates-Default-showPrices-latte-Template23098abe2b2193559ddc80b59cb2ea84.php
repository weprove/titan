<?php
// source: C:\wamp\www\titan\titan\app\modules\Front/templates/Default/showPrices.latte

class Template23098abe2b2193559ddc80b59cb2ea84 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('729578424b', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb363e0529b1_content')) { function _lb363e0529b1_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>	<div class="container">	
	<div class="row">
		<div class="col-md-12">    
			<div class="panel-primary">
				<div class="marginBottom10 paddingAll4">
					
					<div class="row">
						<a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("showSmallerSize!", array($cart_id, $prevSize)), ENT_COMPAT) ?>">
							<div class="col-md-2 left-btn">
							Smaller size
							</div>
						</a>
						<div class="col-md-8 navigation-bar">YOUR SPECIAL OFFERS
						</div>
						<a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("showBiggerSize!", array($cart_id, $prevSize)), ENT_COMPAT) ?>" >
							<div class="col-md-2 right-btn">
							Bigger size
							</div>
						</a>
					</div>
				</div>	
				
					
					<div class="row">
								<div class="col-md-12">
<?php if (isset($cart)&&count($cart)>0) { ?>
								
								
<?php if (isset($products)&&count($products)>0) { $iterations = 0; foreach ($products AS $product) { ?>
										<div class="row offer marginBottom10">
											<div class="col-md-4 offer-arrow">
												<h2 class="steps"><?php echo Latte\Runtime\Filters::escapeHtml($product["productName"], ENT_NOQUOTES) ?></h2>
												<h3><?php echo Latte\Runtime\Filters::escapeHtml($product["productDescription"], ENT_NOQUOTES) ?></h3>
												<h4>Standart price per month: £ <?php echo Latte\Runtime\Filters::escapeHtml($product["productPricePerMonth"], ENT_NOQUOTES) ?></h4>
												<h4 class="marginBottom20">Standart price total: £ <?php echo Latte\Runtime\Filters::escapeHtml($product["standartTotalPrice"], ENT_NOQUOTES) ?></h4>
											</div>
											
											<div class="col-md-4">
												<div class="row offer1">
<?php if ($product['promotionName']&&$product['promotionActive']) { ?>													<div class="col-md-12 steps">
														<h4><?php echo Latte\Runtime\Filters::escapeHtml($product["promotionName"], ENT_NOQUOTES) ?></h4>
													</div>
<?php } ?>
													
													<div class="col-md-12">
<?php if ($product['cartSaleActive']) { ?>														<p> Save: £ <?php echo Latte\Runtime\Filters::escapeHtml($product["cartSale"], ENT_NOQUOTES) ?></p>
<?php } ?>
														<p class="total-price">New total price: <strong>£ <?php echo Latte\Runtime\Filters::escapeHtml($product["cartPriceTotal"], ENT_NOQUOTES) ?></strong></p>
														<a href="" class="btn btn-primary quoteFormBook quoteFormSubmit">Book now!</a>
													</div> 
												</div>
												
<?php if ($product['cartSaleActive2']) { ?>												<div class="row offer2">
													<div class="col-md-12">
														<span class="steps">Move in for £1 for the first month</span> 
														<p class="steps">minimum stay 2 months</p>
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