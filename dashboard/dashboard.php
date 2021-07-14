<?php
require_once('../db/devedores.php');

class Dashboard
{
    public $devedores;

    /**
     * Construtor
     * 
     * Verifica se o usuário está logado
     */
    public function __construct()
    {
        session_start();

        if (!$_SESSION['email'])
            header('Location: ../index.php');
        
        $this->devedores = new Devedores();
    }

    /**
     * Método da página inicial
     */
    public function index()
    {
        $count_devedores = $this->devedores->count();
        $total_divida = $this->devedores->sum();
        $ultimos = $this->devedores->filter(5, 'id', 'desc');
        $maiores = $this->devedores->filter(5, 'valor', 'desc');
        $this->view('inicial', [
            'qtd_devedores' => $count_devedores, 
            'total_divida' => $total_divida,
            'ultimos_cadastros' => $ultimos,
            'maiores_dividas' => $maiores
        ]);
    }

    /**
     * Método de listar devedores
     */
    public function listar()
    {
        $start = $_GET['start'] ?? 0; 
        $devedores = $this->devedores->list(20, $start);
        $count_devedores = $this->devedores->count();
        $this->view('listar', [
            'devedores' => $devedores,
            'qtd_devedores' => $count_devedores
        ]);
    }

    /**
     * Método da página de adicionar devedores
     */
    public function adicionar()
    {
        if ($_POST['cpf_cnpj']) {
            $_POST['cpf_cnpj'] = preg_replace('/\D/', '', $_POST['cpf_cnpj']);
            $_POST['nascimento'] = date('Y-m-d', strtotime( str_replace("/", "-", $_POST['nascimento']) ));
            $_POST['data_vencimento'] = date('Y-m-d', strtotime( str_replace("/", "-", $_POST['data_vencimento']) ));
            $_POST['valor'] = preg_replace('/\./', '', $_POST['valor']);
            $_POST['valor'] = preg_replace('/\,/', '.', $_POST['valor']);
            try {
                $this->devedores->create($_POST);

                $_SESSION['alert'] = 'success';
                $_SESSION['mensagem'] = 'Devedor cadastrado com sucesso.';

                header('Location: /dashboard?page=listar');
            } catch (\Throwable $th) {
                $_SESSION['alert'] = 'danger';
                $_SESSION['mensagem'] = 'Erro ao cadastrar devedor. Tente novamente mais tarde.';
                
                $this->view('adicionar');
            }
        } else {
            $this->view('adicionar');
        }
    }

    /**
     * Método da página de editar devedores
     */
    public function editar()
    {
        $devedor = $this->devedores->get('id', $_GET['id']);

        if ($_POST['cpf_cnpj']) {
            $data['nome'] = $_POST['nome'];
            $data['cpf_cnpj'] = preg_replace('/\D/', '', $_POST['cpf_cnpj']);
            $data['nascimento'] = date('Y-m-d', strtotime( str_replace("/", "-", $_POST['nascimento']) ));
            $data['endereco'] = $_POST['endereco'];
            $data['descricao_titulo'] = $_POST['descricao_titulo'];
            $data['data_vencimento'] = date('Y-m-d', strtotime( str_replace("/", "-", $_POST['data_vencimento']) ));
            $data['valor'] = preg_replace('/\./', '', $_POST['valor']);
            $data['valor'] = preg_replace('/\,/', '.', $data['valor']);
            try {
                $this->devedores->update($_POST['id'], $data);

                $_SESSION['alert'] = 'success';
                $_SESSION['mensagem'] = 'Devedor editado com sucesso.';

                header('Location: /dashboard?page=listar');
            } catch (\Throwable $th) {
                $_SESSION['alert'] = 'danger';
                $_SESSION['mensagem'] = 'Erro ao editar devedor. Tente novamente mais tarde.';
                
                $this->view('editar', ['devedor' => $devedor]);
            }
        } else {
            $devedor = $this->devedores->get('id', $_GET['id']);
            $this->view('editar', ['devedor' => $devedor]);
        }
    }

    /**
     * Método de remover devedores
     */
    public function remover()
    {
        try {
            $this->devedores->delete($_GET['id']);

            $_SESSION['alert'] = 'success';
            $_SESSION['mensagem'] = 'Devedor removdo com sucesso.';
        } catch (\Throwable $th) {
            $_SESSION['alert'] = 'danger';
            $_SESSION['mensagem'] = 'Erro ao remover devedor. Tente novamente mais tarde.';
        }

        header('Location: /dashboard?page=listar');
    }

    /**
     * Método da página de visualizar devedores
     */
    public function visualizar()
    {
        try {
            $devedor = $this->devedores->get('id', $_GET['id']);

            $this->view('visualizar', ['devedor' => $devedor]);
        } catch (\Throwable $th) {
            $_SESSION['alert'] = 'danger';
            $_SESSION['mensagem'] = 'Devedor não encontrado.';
            header('Location: /dashboard?page=listar');
        }
    }

    /**
     * Método que converte as views
     */
    private function view($arquivo, $array = null)
    {
        if (!is_null($array)) {
            foreach ($array as $var => $value) {
                ${$var} = $value;
            }
        }
        ob_start();
        include "{$arquivo}.php";
        ob_flush();
    }

}

?>