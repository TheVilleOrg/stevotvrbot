<?php

namespace StevoTVRBot;

abstract class Bot
{
    private $db;

    public function __destruct()
    {
        if ($this->db)
        {
            $this->db->close();
        }
    }

    public abstract function exec();

    protected final function db(): \mysqli
    {
        if (!$this->db)
        {
            $this->db = new \mysqli(Config::DBHOST, Config::DBUSER, Config::DBPASS, Config::DBNAME);
        }

        return $this->db;
    }

    protected final function authorize(): bool
    {
        if (filter_input(INPUT_GET, 'secret') !== Config::SECRET)
        {
            header($_SERVER['SERVER_PROTOCOL'] . ' 401 Unauthorized');
            echo '401 Unauthorized';

            return false;
        }

        return true;
    }
}
