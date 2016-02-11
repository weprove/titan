<?php
use Nette\Utils\Html,
	Nette\Forms\Controls\SelectBox,
	Nette\Forms\Controls\RadioList,
	Nette\Forms\Controls\Checkbox,
	Nette\Forms\Controls\DatePicker,
	Nette\Diagnostics\Debugger;
/**
 * Vykresli form bez inputu a buttonu
 * Renders Forms as twitter bootsrap tables (no buttons, no inputs).
 * It's enchanced version of another author renderer, but this one is't suffering on duplicated form fields and empty form groups etc.
 */
class ZobrazForm extends \Nette\Forms\Rendering\DefaultFormRenderer {

    /**
     * bez hlavicky
     * @return string
     */
    public function renderBegin() {
        return '';
    }

		/**
	 * Renders group of controls.
	 * @param  Nette\Forms\Container|Nette\Forms\ControlGroup
	 * @return string
	 */
	public function renderControls($parent)
	{
		if (!($parent instanceof Nette\Forms\Container || $parent instanceof Nette\Forms\ControlGroup)) {
			throw new Nette\InvalidArgumentException('Argument must be Nette\Forms\Container or Nette\Forms\ControlGroup instance.');
		}

		$container = $this->getWrapper('controls container');
		$container->class("table table-striped");

		$buttons = NULL;
		foreach ($parent->getControls() as $control) {	
			$myControlVal = $control->isFilled();
			
			if(empty($myControlVal)){
				continue;
			}
			
			if ($control->getOption('rendered') || $control instanceof Nette\Forms\Controls\HiddenField || $control->getForm(FALSE) !== $this->form) {
				// skip
			} elseif ($control instanceof Nette\Forms\Controls\Button) {
				$buttons[] = $control;

			} else {
				if ($buttons) {
					$container->add($this->renderPairMulti($buttons));
					$buttons = NULL;
				}
				$container->add($this->renderPair($control));
			}
		}

		if ($buttons) {
			$container->add($this->renderPairMulti($buttons));
		}

		$s = '';
		if (count($container)) {
			$s .= "\n" . $container . "\n";
		}
		//echo count($container)."<br>";
		
		return $s;
	}
	
	/**
	 * Renders 'control' part of visual row of controls.
	 * @return string
	 */
	public function renderControl(Nette\Forms\IControl $control)
	{		
		$body = $this->getWrapper('control container');
		if ($this->counter % 2) {
			$body->class($this->getValue('control .odd'), TRUE);
		}

		$description = $control->getOption('description');
		if ($description instanceof Html) {
			$description = ' ' . $description;

		} elseif (is_string($description)) {
			$description = ' ' . $this->getWrapper('control description')->setText($control->translate($description));

		} else {
			$description = '';
		}

		if ($control->isRequired()) {
			$description = $this->getValue('control requiredsuffix') . $description;
		}

		$control->setOption('rendered', TRUE);
		
		if ($control instanceof SelectBox || $control instanceof RadioList) {
			$items = $control->getItems();
			$value = ($control->getValue() == 0 ? 'Nevybráno' : $items[$control->getValue()]);
			$el = Html::el('span', array('id' => $control->getHtmlId()."_readonly"))->setText($value);
		} elseif ($control instanceof Checkbox) {
			$el = $control->getControl();
		} elseif ($control instanceof DatePicker) {
			$el = Html::el('span', array('id' => $control->getHtmlId()."_readonly"))->setText(date('d.m.Y', strtotime($control->getValue())));
		} else {
			$el = Html::el('span', array('id' => $control->getHtmlId()."_readonly"))->setHtml($control->getValue());
		}
		
		//$el = $control->getControl();
		if ($el instanceof Html && $el->getName() === 'input') {
			$el->class($this->getValue("control .$el->type"), TRUE);
		}
		return $body->setHtml($el . $description . $this->renderErrors($control));
	}
	
    /**
     * bez paticky
     * @return string
     */
    public function renderEnd() {
        return '';
    }

    /**
     * Renders single visual row.
     * @param  IFormControl
     * @return string
     */
    public function renderPair(Nette\Forms\IControl $control) {
        $pair = $this->getWrapper('pair container');
		
		$container = $this->getWrapper('controls container');
		
		//Debugger::dump($control);exit;
		
		//Debugger::dump($control->parent);exit;
		
        if ($control instanceof FileUpload) {

        } 
		else {
			//echo get_class($control)."<br>";
			$pair->add($this->renderLabel($control));
			$pair->add($this->renderControl($control));
        }
		
        $pair->class($this->getValue($control->getOption('required') ? 'pair .required' : 'pair .optional'), TRUE);
        $pair->class($control->getOption('class'), TRUE);
        if (++$this->counter % 2)
            $pair->class($this->getValue('pair .odd'), TRUE);
        $pair->id = $control->getOption('id');
        return $pair->render(0);
    }

    /**
     * nezobrazuj client script
     * @return null
     */
    public function getClientScript() {
        return null;
    }

	/**
	 * Renders single visual row of multiple controls.
	 * @param  Nette\Forms\IControl[]
	 * @return string
	 */
	public function renderPairMulti(array $controls)
	{
		$s = array();
		foreach ($controls as $control) {
			if (!$control instanceof Nette\Forms\IControl) {
				throw new Nette\InvalidArgumentException('Argument must be array of Nette\Forms\IControl instances.');
			}
            if ($control instanceof SubmitButton) {

            } elseif ($control instanceof ImageButton) {

            } elseif ($control instanceof Button) {
                $s[] = (string) $control->getControl();
            }
		}
		$pair = $this->getWrapper('pair container');
		$pair->add($this->renderLabel($control));
		$pair->add($this->getWrapper('control container')->setHtml(implode(' ', $s)));
		return $pair->render(0);
	}
	
	/**
	 * Renders form body.
	 * @return string
	 */
	public function renderBody()
	{
		$s = $remains = '';

		$defaultContainer = $this->getWrapper('group container');
		$translator = $this->form->getTranslator();

		foreach ($this->form->getGroups() as $group) {
			if (!$group->getControls() || !$group->getOption('visual')) {
				continue;
			}

			$container = $group->getOption('container', $defaultContainer);
			$container = $container instanceof Html ? clone $container : Html::el($container);

			$id = $group->getOption('id');
			if ($id) {
				$container->id = $id;
			}

			$s .= "\n" . $container->startTag();

			$text = $group->getOption('label');
			
			$pom = 0;
			
			foreach($group->getControls() AS $control){
				$fill = $control->isFilled();
				$valu = $control->getLabel();
				if(!empty($fill))
					$pom++;
			}
			
			if($pom>0){
				if ($text instanceof Html) {
					$s .= $this->getWrapper('group label')->add($text);

				} elseif (is_string($text)) {
					if ($translator !== NULL) {
						$text = $translator->translate($text);
					}
					$s .= "\n" . $this->getWrapper('group label')->setText($text) . "\n";
				}
			}

			$text = $group->getOption('description');
			if ($text instanceof Html) {
				$s .= $text;

			} elseif (is_string($text)) {
				if ($translator !== NULL) {
					$text = $translator->translate($text);
				}
				$s .= $this->getWrapper('group description')->setText($text) . "\n";
			}

			$s .= $this->renderControls($group);

			$remains = $container->endTag() . "\n" . $remains;
			if (!$group->getOption('embedNext')) {
				$s .= $remains;
				$remains = '';
			}
			
			$pom = 0;
		}
		
		$s .= $remains . $this->renderControls($this->form);

		$container = $this->getWrapper('form container');
		$container->setHtml($s);
		return $container->render(0);
	}
}