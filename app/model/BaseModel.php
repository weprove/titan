<?php

namespace App\Model;

use Nette,
	Nette\Utils\Strings,
	Nette\Security\Passwords,
	Nette\Database\SqlLiteral,
	Nette\Diagnostics\Debugger;


/**
 * Users management.
 */
class Base extends Nette\Object
{
	/*const
		TABLE_NAME = 'users',
		COLUMN_ID = 'id',
		COLUMN_NAME = 'username',
		COLUMN_PASSWORD_HASH = 'password',
		COLUMN_ROLE = 'role';*/


	/** @var Nette\Database\Context */
	protected $db;
	
	/** @var string */
    protected $tableName;


	public function __construct(Nette\Database\Context $database)
	{
		$this->db = $database;
		$this->tableName = $this->tableNameByClass(get_class($this));
		//$this->db->connection->onQuery[] = callback($this,"logMods");
	}

    /**
     * Určí tabulku dle názvu třídy
     * @param string
     * @return string
     * @result: Pages => pages, ArticleTag => article_tag
     */
    private function tableNameByClass($className)
    {
        $tableName = explode("\\", $className);
        $tableName = lcfirst(array_pop($tableName));

        $replace = array(); // A => _a
        foreach (range("A", "Z") as $letter) {
            $replace[$letter] = "_" . strtolower($letter);
        }

        return strtr($tableName, $replace);
    }
}