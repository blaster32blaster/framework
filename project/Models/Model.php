<?php

/**
 * base model class
 */
class Model
{
    /**
     * a connection
     *
     * @var connection $connection
     */
    private $connection;

    public function __construct(connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * save the child model
     *
     * @param Model $model
     * @return int
     */
    public function save(Model $model) : int
    {
        $trace = debug_backtrace();
        $class = $trace[1]['class'];

        if (!$this->doesModelExist($class)) {
            $this->createModelTable($class);
        }

        try {
            return $this->insertRows($model);
        } catch (PDOException $e) {
            return(json_encode(['msg' => $e->getMessage(), 'stack' => $e->getTraceAsString()]));
        }        
    }

    /**
     * insert model row
     *
     * @param Model $model
     * @return integer
     */
    private function insertRows(Model $model) : int
    {
        $fields = [];
        $bindings = [];
        $bindingKeys = [];

        foreach ($model->fields as $key => $field) {
            if ($field === $model->primaryKey) {
                $fields[] = $field;
                $bindingKeys[] = ':' . $key;
                $bindings[$key] = null;
                continue;
            }

            $fields[] = $field;
            $bindingKeys[] = ':' . $key;
            $bindings[$key] = $model->$field;
        }
        
        if (empty($fields)) {
            $fields = '';
        }
        $statement = $this->connection->pdo()->prepare('INSERT INTO ' . $model->tableName . ' (' . implode(',',$fields) . ') VALUES ('. implode(',',$bindingKeys) .')');

        $statement->execute($bindings);

        return $this->connection->pdo()->lastInsertId();
    }

    /**
     * does the table exist?
     *
     * @return boolean
     */
    private function doesModelExist(string $class) : bool
    {
        try {
            $class = new $class($this->connection);
            $result = $this->connection->pdo()->query("SELECT 1 FROM ". $class->tableName . " LIMIT 1");
            return true;
        } catch (PDOException $e) {
            return false;
        }
        return false;
    }

    /**
     * create a table if not exists
     *
     * @param string $class
     * @return void
     */
    private function createModelTable(string $class) : void
    {
        $class = new $class($this->connection);

        $columns = $class->primaryKey . " INT(11) AUTO_INCREMENT PRIMARY KEY";
        foreach ($class->fields as $field) {
            if ($field !== $class->primaryKey) {
                $columns .= ", " . $field . " VARCHAR( 150 ) NOT NULL";
            }
        }

        try {
            $createTable = $this->connection->pdo()->prepare(
                "CREATE TABLE IF NOT EXISTS $class->tableName ($columns)"
            );
            $createTable->execute();
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), 0, $e);
        }            
    }
}