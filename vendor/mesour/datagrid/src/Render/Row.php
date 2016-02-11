<?php

namespace Mesour\DataGrid\Render;

use Mesour\DataGrid\Column;

/**
 * @author mesour <matous.nemec@mesour.com>
 * @package Mesour DataGrid
 */
abstract class Row extends Attributes {

	/**
	 * @var array
	 */
	protected $cells = array();

	protected $rowData;

	/**
	 * @var Body
	 */
	protected $body;

	public function __construct($rowData) {
		$this->rowData = $rowData;
	}

	public function addCell(Cell $cell) {
		$this->cells[] = $cell;
	}

	public function setBody(Body $body) {
		$this->body = $body;
	}

	abstract public function create();

}