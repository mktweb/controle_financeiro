<?php
require_once('connection.php');

class Usuarios
{
    public $connection;

    public function __construct()
    {
        $connection = new Connection();
        $this->connection = $connection->connection();
    }

    private function run($sql)
    {
        try {
            return $this->connection->query($sql);
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function create($nome, $email, $senha)
    {
        $sql = "INSERT INTO `usuarios` (`nome`, `email`, `senha`)
            VALUES ('$nome', '$email', '$senha')";
        
        return $this->run($sql)->fetchObject();
    }

    public function update($id, $params)
    {
        $sql = "UPDATE `usuarios`
            SET " . $params . "
            WHERE `id` = " . $id . ";";

        return $this->run($sql)->fetchObject();
    }

    public function delete($id)
    {
        $sql = "DELETE `usuarios`
            WHERE `id` = " . $id . ";";

        return $this->run($sql)->fetchObject();
    }

    public function get($param, $valor)
    {
        $sql = "SELECT *
            FROM `usuarios`
            WHERE `" . $param . "` = '" . $valor ."';";

        return $this->run($sql)->fetchObject();
    }

    public function list($limit = null, $start = 0)
    {
        $sql = "SELECT *
        FROM `usuarios`";

        if ($limit) {
            $sql .= " LIMIT (" . $start . ", " . $limit . ");";
        } else {
            $sql .= ";";
        }

        return $this->run($sql)->fetchAll();
    }
}

?>