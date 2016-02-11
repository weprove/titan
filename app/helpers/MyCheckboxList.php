<?php
use Nette\Web;

class MyCheckboxList extends CheckboxList
{
        private $baseLabel;

        protected function getBaseLabel()
        {
                if ($this->baseLabel === NULL)
                        $this->baseLabel = /*Nette\Web\*/Html::el('label');
                return $this->baseLabel;
        }

        public function getControl($key = NULL)
        {
                if ($key === NULL) {
                        $container = clone $this->container;
                        $separator = (string) $this->separator;

                } elseif (!isset($this->items[$key])) {
                        return NULL;
                }

                $control = parent::getControl();
                $control->name .= '[]';
                $id = $control->id;
                $counter = -1;
                $values = $this->value === NULL ? NULL : (array) $this->getValue();
                $label = $this->getBaseLabel();

                foreach ($this->items as $k => $val) {
                        $counter++;
                        if ($key !== NULL && $key != $k) continue; // intentionally ==

                        $control->id = $label->for = $id . '-' . $counter;
                        $control->checked = (count($values) > 0) ? in_array($k, $values) : false;
                        $control->value = $k;

                        if ($val instanceof /*Nette\Web\*/Html) {
                                $label->setHtml($val);
                        } else {
                                $label->setText($this->translate($val));
                        }

                        if ($key !== NULL) {
                                return (string) $control;
                        }

                        $container->add((string) $control . (string) $label . $separator);
                }

                return $container;
        }

        public function getLabel($key = NULL)
        {
                $control = parent::getControl();
        
                $id = $control->id;
                $counter = -1;
                $label = /*Nette\Web\*/Html::el('label');
        
                foreach ($this->items as $k => $val) {
                        $counter++;
                        if ($key != $k) continue;
                        $label->for = $id . '-' . $counter;
        
                        if ($val instanceof /*Nette\Web\*/Html) {
                                $label->setHtml($val);
                        } else {
                                $label->setText($this->translate($val));
                        }
        
                        return (string) $label;
                }
        }
}