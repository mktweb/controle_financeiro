<?php
require_once('connection.php');

class Devedores
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

    public function create($data)
    {
        $nome = $data['nome'];
        $cpf_cnpj = $data['cpf_cnpj'];
        $nascimento = $data['nascimento'];
        $endereco = $data['endereco'];
        $descricao_titulo = $data['descricao_titulo'];
        $valor = $data['valor'];
        $data_vencimento = $data['data_vencimento'];
        
        $sql = "INSERT INTO `devedores` (`nome`, `cpf_cnpj`, `nascimento`, `endereco`, `descricao_titulo`, `valor`, `data_vencimento`)
            VALUES ('$nome', $cpf_cnpj, '$nascimento', '$endereco', '$descricao_titulo', '$valor', '$data_vencimento');";

        return $this->run($sql);
    }

    public function update($id, $params)
    {
        $set = "`nome`='{$params['nome']}', 
        `cpf_cnpj`={$params['cpf_cnpj']}, 
        `nascimento`='{$params['nascimento']}', 
        `endereco`='{$params['endereco']}', 
        `descricao_titulo`='{$params['descricao_titulo']}', 
        `valor`='{$params['valor']}', 
        `data_vencimento`='{$params['data_vencimento']}'";

        $sql = "UPDATE `devedores`
            SET " . $set . "
            WHERE `id` = " . $id . ";";

        return $this->run($sql);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM `devedores`
            WHERE `id` = " . $id . ";";

        return $this->run($sql);
    }

    public function get($param, $valor)
    {
        $sql = "SELECT *
            FROM `devedores`
            WHERE `" . $param . "` = '" . $valor ."';";

        return $this->run($sql)->fetchObject();
    }

    public function list($limit = null, $start = 0)
    {
        $sql = "SELECT *
        FROM `devedores`";

        if ($limit) {
            $sql .= " LIMIT " . $start . ", " . $limit . ";";
        } else {
            $sql .= ";";
        }

        return $this->run($sql)->fetchAll();
    }
}

?>