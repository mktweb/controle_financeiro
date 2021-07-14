<?php

require_once('../db/devedores.php');

class Dashboard
{
    public $devedores;

    public function __construct()
    {
        session_start();
        if (!$_SESSION['email'])
            header('Location: ../index.php');
        $this->devedores = new Devedores();
    }

    public function index()
    {
        $this->view('inicial');
    }

    public function listar()
    {
        $start = $_GET['start'] ?? 0; 
        $devedores = $this->devedores->list(20, $start);
        $count_devedores = count($devedores);
        $this->view('listar', [
            'devedores' => $devedores,
            'qtd_devedores' => $count_devedores
        ]);
    }

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

    public function view($arquivo, $array = null)
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