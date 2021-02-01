<?php

include_once 'Model.php';
include_once 'Contracts/ModelContract.php';

class User extends Model implements ModelContract
{
    /**
     * a connection
     *
     * @var connection $connection
     */
    private $connection;

    /**
     * the table fields
     *
     * @var array
     */
    public $fields = [
        'id'
    ];

    /**
     * the table name
     *
     * @var string $tablename
     */
    public $tableName = 'user';

    /**
     * the primary key
     *
     * @var string $primaryKey
     */
    public $primaryKey = 'id';

    public function __construct(connection $connection)
    {
        $this->connection = $connection;
        parent::__construct($this->connection);
    }

    /**
     * save a model instance
     *
     * @return int
     */
    public function saveModel() : int
    {
        return $this->save($this);
    }
}