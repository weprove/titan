<?php
// source: C:\wamp\www\titan\app\modules\Front/templates/Default/default.latte

class Templatea8b1ba426da55c164237adf3dd88b961 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('27a401005e', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block scripts
//
if (!function_exists($_b->blocks['scripts'][] = '_lbfc093765d7_scripts')) { function _lbfc093765d7_scripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;Latte\Macros\BlockMacrosRuntime::callBlockParent($_b, 'scripts', get_defined_vars()) ?>
	<script type="text/javascript" src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/jquery.nette.dependentselectbox.js"></script>
	<script type="text/javascript" src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/dependentselectbox.ajax.js"></script>
	<script type="text/javascript" src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/jquery.ajaxform.js"></script>
	<script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=true'></script>
	<script type='text/javascript'>
	$(function() {
		$( "#frm-quoteForm-leaseFrom" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 3,
			onClose: function( selectedDate ) {
				$( "#frm-quoteForm-leaseTo" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#frm-quoteForm-leaseTo" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 3,
			onClose: function( selectedDate ) {
				$( "#frm-quoteForm-leaseFrom" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
	});
	</script>
<?php
}}

//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb2b2ac7fb34_content')) { function _lb2b2ac7fb34_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?><div class="container">
	<div class="row">
		<div class="col-md-12">    
		  <div class="panel-primary">
			<div class="panel-body">
			
<?php if (isset($step2)) { ?>
			<div class="row">
				<div class="col-md-6" ><div class="backlink"><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Front:Default:default"), ENT_COMPAT) ?>" class="btn btn-primary backBtn"> << Back to step 1</a></div> 
<?php $_l->tmp = $_control->getComponent("customerForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
				</div>	
				
				<div class="col-md-6" > 
					<div class="storeDetails"><p class="lead">This is an example of shops name.</p>
					<img class="storeImage" src="http://www.herringtonstorage.co.uk/userfiles/image/Category_Images/Storage-box-warehouse.jpg"><p>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec justo diam, elementum a ultricies et, volutpat sed urna. Donec id fermentum turpis. Mauris lobortis tincidunt augue quis dictum. In eu ligula at sapien volutpat consectetur. Praesent nec consectetur mi, nec lacinia augue.
					<a href="#">Show more...</a>   </p>
				</div>
			</div>   
<?php } else { ?>
				
			<div class="row" id="row-step-1">
				
<div id="<?php echo $_control->getSnippetId('productsSnippet') ?>"><?php call_user_func(reset($_b->blocks['_productsSnippet']), $_b, $template->getParameters()) ?>
</div>				</div>
			
			</div>
					
			
			</div>
		 

			  
			</div>
		</div>
		
	</div> <!-- row end-->
		<div class="estimator-row row">
			<div class="panel-body margin15">
					<div class="col-md-6">	
					 
					<span class="steps">Size estimator for: 125 sq. ft.</span><p class="estimator-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent placerat erat vitae dui feugiat tempus. Aliquam vitae porta est, eget pretium elit. Fusce vitae luctus mauris. Donec non feugiat est, id elementum nulla. Integer molestie lorem sed sapien ullamcorper vestibulum. Vestibulum malesuada lobortis dui convallis tristique. Sed mauris nisl, ullamcorper vitae purus eu, pharetra congue nulla. In cursus aliquet erat.</p>
					</div>
					<div class="col-md-6 estimator-img">	
					<span class=""><img src="images/125sq.png"></span>
					</div>
			
			</div>			
		</div>
</div>        
        
<?php } ?>

<?php
}}

//
// block _productsSnippet
//
if (!function_exists($_b->blocks['_productsSnippet'][] = '_lb04c62914ce__productsSnippet')) { function _lb04c62914ce__productsSnippet($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v; $_control->redrawControl('productsSnippet', FALSE)
?>						<?php echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $_form = $_control["quoteForm"], array()) ?>

				<div class="grey col-md-3">			
					<span class="steps">1. find your store</span>
					<?php echo $_form["store_id"]->getControl() ?>

				</div>
				<div class="grey arrow col-md-1">
				</div>
				<div class="grey col-md-4">
					<span class="steps">2. what size & for how long</span>
						<div class="center-form">
							<?php echo $_form["product_id"]->getControl() ?>

							<?php echo $_form["leaseFrom"]->getControl() ?>

							<?php echo $_form["leaseTo"]->getControl() ?>

						</div>
				</div>
				<div class="arrow col-md-1">
				</div>
				<div class="grey col-md-3">
					<span class="steps">3. request quote</span>
							<?php echo $_form["submit"]->getControl() ?>

					</span>
						<?php echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd($_form) ?>

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
call_user_func(reset($_b->blocks['scripts']), $_b, get_defined_vars())  ?>


<?php call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars())  ?>





<?php
}}