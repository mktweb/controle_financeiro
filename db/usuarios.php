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

    /**
     * Método auxiliar para executar query
     */
    private function run($sql)
    {
        try {
            return $this->connection->query($sql);
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Método para criar usuario
     */
    public function create($nome, $email, $senha)
    {
        $sql = "INSERT INTO `usuarios` (`nome`, `email`, `senha`)
            VALUES ('$nome', '$email', '$senha')";
        
        return $this->run($sql);
    }

    /**
     * Método para atualizar usuario
     */
    public function update($id, $params)
    {
        $sql = "UPDATE `usuarios`
            SET " . $params . "
            WHERE `id` = " . $id . ";";

        return $this->run($sql);
    }

    /**
     * Método para remover usuario
     */
    public function delete($id)
    {
        $sql = "DELETE `usuarios`
            WHERE `id` = " . $id . ";";

        return $this->run($sql);
    }

    /**
     * Método para resgartar usuario
     */
    public function get($param, $valor)
    {
        $sql = "SELECT *
            FROM `usuarios`
            WHERE `" . $param . "` = '" . $valor ."';";

        return $this->run($sql)->fetchObject();
    }

    /**
     * Método para listar todos os usuarios com paginacao
     */
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