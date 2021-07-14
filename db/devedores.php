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
     * Método para criar devedor
     */
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

    /**
     * Método para editar devedor
     */
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

    /**
     * Método para deletar devedor
     */
    public function delete($id)
    {
        $sql = "DELETE FROM `devedores`
            WHERE `id` = " . $id . ";";

        return $this->run($sql);
    }

    /**
     * Método para resgatar devedores
     */
    public function get($param, $valor)
    {
        $sql = "SELECT *
            FROM `devedores`
            WHERE `" . $param . "` = '" . $valor ."';";

        return $this->run($sql)->fetchObject();
    }

    /**
     * Método para contar devedores
     */
    public function count()
    {
        $sql = "SELECT COUNT(id) AS qtd
        FROM `devedores`;";

        return $this->run($sql)->fetchObject();
    }

    /**
     * Método para contar total da divida
     */
    public function sum()
    {
        $sql = "SELECT SUM(valor) AS total
        FROM `devedores`;";

        return $this->run($sql)->fetchObject();
    }

    /**
     * Método para listar devedores com paginação
     */
    public function list($limit = null, $start = 0)
    {
        $sql = "SELECT *
        FROM `devedores`";

        if ($limit) {
            $sql .= " LIMIT " . ($start * 20) . ", " . $limit . ";";
        } else {
            $sql .= ";";
        }

        return $this->run($sql)->fetchAll();
    }

    /**
     * Método para filtrar devedores
     */
    public function filter($limit, $campo, $order_by = 'asc')
    {
        $sql = "SELECT *
        FROM `devedores`
        ORDER BY " . $campo . "  " . $order_by . "
        LIMIT 0, " . $limit . ";";

        return $this->run($sql)->fetchAll();
    }
}

?>