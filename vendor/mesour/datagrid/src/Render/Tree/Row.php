<?php

namespace Mesour\DataGrid\Render\Tree;

use Mesour\DataGrid\Column,
    Mesour\DataGrid\Render,
    \Nette\Utils\Html;

/**
 * @author mesour <matous.nemec@mesour.com>
 * @package Mesour DataGrid
 */
class Row extends Render\Row {

	public function create() {
		$li = Html::el('li', $this->attributes);
		$container = Html::el('div');
		foreach ($this->cells as $cell) {
			$container->add($cell->create());
		}
		$li->add($container);
		if (!is_null($this->body)) {
			$li->add($this->body->create());
		}
		return $li;
	}

}