<?php
// source: C:\xampp\htdocs\titan\app\modules\Admin/templates/sidebar.latte

class Templated5133f3693b7636aa9f93a05edf9f2b8 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('c9bf5b47f7', 'html')
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
<?php if ($user->isInRole('admin')) { ?>						<li>
                            <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Admin:Default:viewUsers"), ENT_COMPAT) ?>">Users</a>
                        </li>
<?php } if ($user->isAllowed('Admin:Store')) { ?>						<li>
                            <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Admin:Store:viewStores"), ENT_COMPAT) ?>">Stores</a>
                        </li>
<?php } if ($user->isAllowed('Admin:Order')) { ?>						<li>
                            <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Admin:Order:"), ENT_COMPAT) ?>">Reservations</a>
                        </li>
<?php } if ($user->isAllowed('Admin:Chase')) { ?>						<li>
                            <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Admin:Chase:"), ENT_COMPAT) ?>">Nurture Quotes</a>
                        </li>
<?php } if ($user->isAllowed('Admin:Chase', 'viewEmailTemplates')) { ?>						<li>
                            <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Admin:Chase:viewEmailTemplates"), ENT_COMPAT) ?>">Email templates</a>
                        </li>
<?php } ?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
			<!-- /.navbar-static-side --><?php
}}