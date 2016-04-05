<?php
// source: C:\xampp\htdocs\titan\app\modules\Front/templates/Default/default.latte

class Template39b77a3de2319a70c72bd89103b6059e extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('f7362ef087', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block scripts
//
if (!function_exists($_b->blocks['scripts'][] = '_lbcc3720135d_scripts')) { function _lbcc3720135d_scripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;Latte\Macros\BlockMacrosRuntime::callBlockParent($_b, 'scripts', get_defined_vars()) ?>
	<script type="text/javascript" src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/jquery.ajaxform.js"></script>
	<script type="text/javascript" src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/jquery.nette.dependentselectbox.js"></script>
	<script type="text/javascript" src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/dependentselectbox.ajax.js"></script>
	<script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=true'></script>
	<script type='text/javascript'>
	$(function() {
		$( "#frm-quoteForm-leaseFrom" ).datepicker({
			defaultDate: "+1w",
			dateFormat: 'dd/mm/yy',
			changeMonth: true,
			numberOfMonths: 3,
			onClose: function( selectedDate ) {
				$( "#frm-quoteForm-leaseTo" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#frm-quoteForm-leaseTo" ).datepicker({
			defaultDate: "+1w",
			dateFormat: 'dd/mm/yy',
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
if (!function_exists($_b->blocks['content'][] = '_lb92a73d93f9_content')) { function _lb92a73d93f9_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?><div id="ifrainer" class="container">
	<div class="row">
		<div class="col-md-12">    
		  <div class="panel-primary">
			<div class="panel-body">
			
<?php if (isset($step2)) { ?>
			<div class="row">
				<div class="col-md-6" ><div class="backlink"><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Front:Default:default"), ENT_COMPAT) ?>" class="btn btn-primary customerFormSubmit button"> << Back to step 1</a></div> 
<?php $_l->tmp = $_control->getComponent("customerForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
				</div>	
				
				<div class="col-md-6" > 
<?php if (isset($store->storeName)) { ?>					<div class="storeDetails">
					<h2><?php echo Latte\Runtime\Filters::escapeHtml($store->storeName, ENT_NOQUOTES) ?></h2>
					<img class="storeImage" src="http://www.herringtonstorage.co.uk/userfiles/image/Category_Images/Storage-box-warehouse.jpg">
					
					<h3>Description</h3>
<?php if (isset($store->storeDescription)) { ?>					<p>
						<?php echo $store->storeDescription ?>

					</p>
<?php } ?>
					
					<h3>Contact</h3>
<?php if (isset($store->storeAddress)) { ?>					<p>
						<?php echo $store->storeAddress ?>

					</p>
<?php } if (isset($store->storePhone)) { ?>
						<p><?php echo $store->storePhone ?></p>
<?php } ?>
					
<?php if (isset($store->storeEmail)) { ?>
						<p><?php echo Latte\Runtime\Filters::escapeHtml($store->storeEmail, ENT_NOQUOTES) ?></p>
<?php } ?>
						
					<h3>Open hours</h3>
<?php if (isset($store->storeOpenHours)) { ?>					<p>
						<?php echo $store->storeOpenHours ?>

					</p>
<?php } ?>
				</div>
<?php } ?>
			</div>   
<?php } else { ?>
				
			<div class="row" id="row-step-1">
				
<div id="<?php echo $_control->getSnippetId('productsSnippet') ?>"><?php call_user_func(reset($_b->blocks['_productsSnippet']), $_b, $template->getParameters()) ?>
</div>				</div>
			
			</div>
			<div class="row" id="row-step-1">
				
				<div class="grey col-md-6">	
					<span class="estimator-description">Not sure how much space you need? View our <u><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Default:viewSizeEstimator"), ENT_COMPAT) ?>">size estimator</a></u>.</span>			
				</div>
			</div>
			</div>
		 

			  
			</div>
		</div>
		
	</div> <!-- row end-->
		
</div>        
        
<?php } ?>

<?php
}}

//
// block _productsSnippet
//
if (!function_exists($_b->blocks['_productsSnippet'][] = '_lb947e7aaca6__productsSnippet')) { function _lb947e7aaca6__productsSnippet($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v; $_control->redrawControl('productsSnippet', FALSE)
?>						<?php echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $_form = $_control["quoteForm"], array()) ?>

				<div class="grey col-md-4">			
					<h2 class="step1">Find your store</h2>
					<?php echo $_form["postalCode"]->getControl() ?>

					<?php echo $_form["store_id"]->getControl() ?>

					<div>
						<div id="dependentTrigger">
							<?php echo $_form["store_id_submit"]->getControl() ?>

						</div>
					</div>
				</div>
				<div class="grey col-md-4">
					<h2 class="step1">What size and for how long?</h2>
						<div class="center-form">
							<?php echo $_form["main_product_id"]->getControl() ?>

							<?php echo $_form["leaseFrom"]->getControl() ?>

							<?php echo $_form["leaseTo"]->getControl() ?>

						</div>
				</div>
				<div class="grey col-md-4">
					<h2 class="step1">Request a quote</h2>
							<?php echo $_form["submit"]->getControl() ?>

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