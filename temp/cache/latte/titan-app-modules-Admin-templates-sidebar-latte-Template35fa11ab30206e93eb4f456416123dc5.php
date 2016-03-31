<?php
// source: C:\wamp\www\titan\titan\app\modules\Admin/templates/sidebar.latte

class Template35fa11ab30206e93eb4f456416123dc5 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('6988e095d8', 'html')
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
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Admin:Default:default"), ENT_COMPAT) ?>">Dashboard</a>
                        </li>
						<li>
                            <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Admin:Store:viewStores"), ENT_COMPAT) ?>">Stores</a>
                        </li>
						<li>
                            <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Admin:Order:"), ENT_COMPAT) ?>">Orders</a>
                        </li>
						<li>
                            <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Admin:Chase:"), ENT_COMPAT) ?>">Chasing clients</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
			<!-- /.navbar-static-side --><?php
}}