<?php
// source: C:\xampp\htdocs\titan\app\modules\Front/templates/Default/viewSizeEstimator.latte

class Template514c4c45bb64f2f6372eb22537c5e586 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('cd57fed4cb', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block scripts
//
if (!function_exists($_b->blocks['scripts'][] = '_lbaae0ddf239_scripts')) { function _lbaae0ddf239_scripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;Latte\Macros\BlockMacrosRuntime::callBlockParent($_b, 'scripts', get_defined_vars()) ;
}}

//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb0248279208_content')) { function _lb0248279208_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?><div class="container">
	<div class="row">
		<div class="col-md-12"> 
			<div class="table-sizeestimator">
	<table>
		<thead>
			<tr>
			<th>Unit Size Sqft</th>
			<th>Approx Size    LxWxH</th>
			<th>Equates to</th>
			<th>Equivalent rooms in house</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>16</td>
				<td>4 x 4 x 7</td>
				<td>Large Triple Wardrobe</td>
				<td>Storage for approx 30 medium storage boxes</td>
			</tr>
			<tr class="alt">
				<td>25</td>
				<td>5 x 5 x 7</td>
				<td>1/4 Single Garage or Small Van</td>
				<td>Single bedroom contents</td>
			</tr>
			<tr>
				<td>35</td>
				<td>7 x 5 x 7</td>
				<td>1/3 Single Garage</td>
				<td>Double bedroom contents</td>
			</tr>
			<tr class="alt">
				<td>50</td>
				<td>10 x 5 x 7</td>
				<td>1/2 Single Garage or Transit Van</td>
				<td>Average 1 bedroom flat contents</td>
			</tr>
			<tr>
				<td>75</td>
				<td>10 x 7.5 x 7</td>
				<td>3/4 Single Garage or Luton van</td>
				<td>Average 2 bedroom flat contents</td>
			</tr>
			<tr class="alt">
				<td>100</td>
				<td>10 x 10 x 7</td>
				<td>Small Single Garage</td>
				<td>Average 2 bedroom house contents</td>
			</tr>
			<tr>
				<td>125</td>
				<td>10 x 12.5 x 7</td>
				<td>Large Single Garage</td>
				<td>Average 3 bedroom house contents</td>
			</tr>
			<tr class="alt">
				<td>150</td>
				<td>15 x 10 x 7</td>
				<td>1 1/2 Single Garage</td>
				<td>Large 3 bedroom house contents</td>
			</tr>
			<tr>
				<td>175</td>
				<td>17.5 x 10 x 7</td>
				<td>Small Double Garage</td>
				<td>Average 4 bedroom house contents</td>
			</tr>
			<tr class="alt">
				<td>200</td>
				<td>20 x 10 x 7</td>
				<td>Double Garage</td>
				<td>Large 4 bedroom house contents</td>
			</tr> 
		</tbody>
	</table>
</div>	
		 </div>	
	</div> <!-- row end-->
		
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
call_user_func(reset($_b->blocks['scripts']), $_b, get_defined_vars())  ?>


<?php call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars())  ?>





<?php
}}