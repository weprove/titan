<?php

namespace Nette\Addons\SuggestInput;

class SuggestMessageRecipient extends \Nette\Addons\SuggestInput\DbSuggester
{

    public function getSuggestions($query, $wholeQuery = FALSE)
    {
		//$query = 
		$matches = $this->connection->table($this->table)
			->select($this->column)
				->where($this->where, $query);

		$this->matches = array();
		foreach ($matches as $match)
			$this->matches[] = $match[$this->column];

		return $this->matches;
    }
}

/* ?> omitted intentionally */

