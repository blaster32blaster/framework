<?php

/**
 * establish PDO db connection
 */
class connection
{
    /**
     * db connection creds
     *
     * @var array $config
     */
    private $config;

    /**
     * pdo instance
     *
     * @var PDO $pdo
     */
    private $pdo;

    public function __construct()
    {
        $tempConfig = include_once('config.php');
        $this->config = $tempConfig['database'];
        return $this->connect();
    }

    /**
     * get the pdo instance
     *
     * @return PDO
     */
    public function pdo() : PDO
    {
        return $this->pdo;
    }

    /**
     * make database connection
     *
     * @return void
     */
    public function connect() : void
    {
        $host = $this->config['host'];
        $db   = $this->config['db'];
        $user = $this->config['user'];
        $pass = $this->config['password'];
        $port = $this->config['port'];
        $charset = 'utf8mb4';

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}