<?php

include_once 'Model.php';
include_once 'Contracts/ModelContract.php';

class Course extends Model implements ModelContract
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
        'id',
        'user_id',
        'value'
    ];

    /**
     * the table name
     *
     * @var string $tablename
     */
    public $tableName = 'course';

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
     * @return void
     */
    public function saveModel()
    {
        $this->save($this);
    }
}