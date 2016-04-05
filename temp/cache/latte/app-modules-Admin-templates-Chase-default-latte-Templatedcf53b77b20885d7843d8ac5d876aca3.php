<?php
// source: C:\xampp\htdocs\titan\app\modules\Admin/templates/Chase/default.latte

class Templatedcf53b77b20885d7843d8ac5d876aca3 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('58684f4628', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block scripts
//
if (!function_exists($_b->blocks['scripts'][] = '_lb04c36fa084_scripts')) { function _lb04c36fa084_scripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;Latte\Macros\BlockMacrosRuntime::callBlockParent($_b, 'scripts', get_defined_vars()) ?>
	<script type="text/javascript">
		$(function(){
			$(".viewCartDialogTrigger").click(function(e){
				e.preventDefault();
				var url = $(this).attr('href');
				$.ajax({
					url: url,
					success: function(data) {
					  $("#cartDetailDialog").html(data);
					  $("#cartDetailDialog").dialog({ 'width':600, 'height':250 });
					}
				});
			});
		});
	</script>
<?php
}}

//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb9b52851bb1_content')) { function _lb9b52851bb1_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>		<div id="cartDetailDialog"></div>
		
	<ul class="nav nav-tabs marginTop20">
		<li class="active"><a href="#chase" data-toggle="tab">Chase Clients</a>
		</li>
		<li><a href="#sentemails" data-toggle="tab">Sent Emails</a>
		</li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane fade in active" id="chase">
<?php $_l->tmp = $_control->getComponent("chaseGrid"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
		</div>
		<div class="tab-pane fade" id="sentemails">
			send
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
call_user_func(reset($_b->blocks['scripts']), $_b, get_defined_vars())  ?>

<?php call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars()) ; 
}}