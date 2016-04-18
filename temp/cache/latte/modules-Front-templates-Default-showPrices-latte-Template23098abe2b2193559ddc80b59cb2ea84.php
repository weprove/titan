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
?>	<script>
		$(function(){
			$('.container').delegate('#frm-quoteForm-postalCode', 'change', function(){
				$.nette.ajax({
					url: <?php echo Latte\Runtime\Filters::escapeJs($_control->link("pscChange!")) ?>

				});
			});
		});
	</script>
	<div class="container">	
	<div class="row">
			<div class="panel-primary">
				<div class="col-md-12">	   

					<div class="row navigation-bar marginBottom1 dark">
						<a  class="smaller-link" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("showSmallerSize!", array($cart_id, $prevSize)), ENT_COMPAT) ?>">	
							<div class="col-md-6 smaller-offer">	
								show smaller units
							</div>	
						</a>	
						
							<a class="bigger-link" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("showBiggerSize!", array($cart_id, $prevSize)), ENT_COMPAT) ?>" >
							<div class="col-md-6 bigger-offer">
								show larger units
							</div>
						</a>
					</div>
				</div>
				
				<div class="col-md-12">	   

					<div class="row navigation-bar ">
							<div class="col-md-3 alignLeft">	
								Unit size
							</div>	
							<div class="col-md-3">	
								Promotion 1
							</div>	
							<div class="col-md-3">	
								Promotion 2
							</div>	
							<div class="col-md-3">
								Price thereafter
							</div>
					</div> 
				</div>
	
				
					<div class="row">
						<div class="col-md-12">
<?php if (isset($cart)&&count($cart)>0) { ?>
								
								
<?php if (isset($products)&&count($products)>0) { $iterations = 0; foreach ($products AS $product) { ?>
										<div class="row offer ">
											<div class="col-md-3 paddingAll30 column">
												<h2 class="steps"><?php echo Latte\Runtime\Filters::escapeHtml($product["productName"], ENT_NOQUOTES) ?></h2>										
											</div>
											
											<div class="col-md-3 column">
												<div class="row offer1">
<?php if ($product['promotionName']&&$product['promotionActive']) { ?>													<div class="col-md-12">
														<span class="steps"><?php echo Latte\Runtime\Filters::escapeHtml($product["promotionName"], ENT_NOQUOTES) ?></span>
													</div>
<?php } ?>
													
													<div class="col-md-12">
														<p>£<?php echo Latte\Runtime\Filters::escapeHtml($product['productPricePerMonthSale'], ENT_NOQUOTES) ?> a month</p>
														<p>(£<?php echo Latte\Runtime\Filters::escapeHtml(round($product['productPricePerMonthSale']/4, 2), ENT_NOQUOTES) ?> a week)</p>
														<p class="total-price">Total cost £<?php echo Latte\Runtime\Filters::escapeHtml($product["cartPriceTotal2"], ENT_NOQUOTES) ?> for dates selected</p>
<?php if ($product['productVacancy']<1) { ?>
															<p class="soldout">sold out</p>
															<a href="#" class="callus btn-book btn-primary">Call us now</a>
<?php } else { ?>
															<a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("order!", array($cart_id, $product["product_id"], 1)), ENT_COMPAT) ?>" target="_top" class="btn-book btn-primary">reserve now</a>
<?php } ?>
													</div> 
												</div>
											</div>
											<div class="col-md-3 column">	
												<div class="row offer2">
<?php if ($product['cartSaleActive2']) { ?>
														<div class="col-md-12">
															<span class="steps">Move in for £1 for the first month</span> 
															<h4>minimum stay 2 months</h4>
														</div>	
														
														<div class="col-md-12">
																														<p class="total-price">Total cost £<?php echo Latte\Runtime\Filters::escapeHtml($product["cartPriceTotal2"], ENT_NOQUOTES) ?> for dates selected</p>
<?php if ($product['productVacancy']<1) { ?>
																<p class="soldout">sold out</p>
																<a href="#" class="callus btn-book btn-red">Call us now</a>
<?php } else { ?>
																<a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("order!", array($cart_id, $product["product_id"], 2)), ENT_COMPAT) ?>" target="_top" class="btn-book btn-primary">reserve now</a>
<?php } ?>
														</div>	
<?php } else { ?>
														<div class="col-md-12">
															<span class="notApplicable">Not Applicable</span> 
														</div>	
<?php } ?>
												</div>
											</div>
											
											<div class="col-md-3 column">
												<div class="row offer2">
													<div class="col-md-12">
														<span class="steps">unit cost</span> 
													</div>	
													
													<div class="col-md-12">
														<p>£<?php echo Latte\Runtime\Filters::escapeHtml($product['productPricePerMonth'], ENT_NOQUOTES) ?> per month</p>
														<p>£<?php echo Latte\Runtime\Filters::escapeHtml($product['productPricePerMonthSale2']/4, ENT_NOQUOTES) ?> per week</p>
														
													</div>											
												</div>										
											</div>
											
										</div>
<?php $iterations++; } } } ?>
						</div> <!-- col-md-8 -->
							
							
						
					</div>
					
				<div class="col-md-12">	   

					<div class="row navigation-bar high5 marginBottom1">
					</div>
				</div>	
				<div class="col-md-12">	   

					<div class="row navigation-bar dark marginBottom5">
						<a  class="smaller-link" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("showSmallerSize!", array($cart_id, $prevSize)), ENT_COMPAT) ?>">	
							<div class="col-md-6 smaller-offer">	
								show smaller units
							</div>	
						</a>	
						
							<a class="bigger-link" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("showBiggerSize!", array($cart_id, $prevSize)), ENT_COMPAT) ?>" >
							<div class="col-md-6 bigger-offer">
								show larger units
							</div>
						</a>
					</div>
				</div>
					<div class="row">
								<div class="col-md-12">
								<p class="information">Prices exclude the cost of padlock and insurance and are valid for the next 14 days. We charge calendar monthly from the date of move in 
and all prices quoted are inclusive of VAT.</p>
<p class="li-information">* Move in for £1 for the first month - minimum stay 2 months</p>
<p class="li-information">* 50% off first month - minimum stay 2 month</p>
<p class="li-information">* 50% off for 2 months - minimum stay 1 month</p>
<p class="li-information">* 50% off for 3 months - minimum stay 1 month</p>
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