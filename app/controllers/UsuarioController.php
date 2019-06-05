<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class UsuarioController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for usuario
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Usuario', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "Cod_usuario";

        $usuario = Usuario::find($parameters);
        if (count($usuario) == 0) {
            $this->flash->notice("The search did not find any usuario");

            $this->dispatcher->forward([
                "controller" => "usuario",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $usuario,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a usuario
     *
     * @param string $Cod_usuario
     */
    public function editAction($Cod_usuario)
    {
        if (!$this->request->isPost()) {

            $usuario = Usuario::findFirstByCod_usuario($Cod_usuario);
            if (!$usuario) {
                $this->flash->error("usuario was not found");

                $this->dispatcher->forward([
                    'controller' => "usuario",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->Cod_usuario = $usuario->Cod_usuario;

            $this->tag->setDefault("Cod_usuario", $usuario->Cod_usuario);
            $this->tag->setDefault("Login_usuario", $usuario->Login_usuario);
            $this->tag->setDefault("Senha_usuario", $usuario->Senha_usuario);
            $this->tag->setDefault("Nome_usuario", $usuario->Nome_usuario);
            $this->tag->setDefault("Idade_usuario", $usuario->Idade_usuario);
            $this->tag->setDefault("Endereco_usuario", $usuario->Endereco_usuario);
            $this->tag->setDefault("CIDADECod_cidade", $usuario->CIDADECod_cidade);
            $this->tag->setDefault("TIPO_USUARIOCod_tipo_usuario", $usuario->TIPO_USUARIOCod_tipo_usuario);
            
        }
    }

    /**
     * Creates a new usuario
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "usuario",
                'action' => 'index'
            ]);

            return;
        }

        $usuario = new Usuario();
        $usuario->loginUsuario = $this->request->getPost("Login_usuario");
        $usuario->senhaUsuario = $this->request->getPost("Senha_usuario");
        $usuario->nomeUsuario = $this->request->getPost("Nome_usuario");
        $usuario->idadeUsuario = $this->request->getPost("Idade_usuario");
        $usuario->enderecoUsuario = $this->request->getPost("Endereco_usuario");
        $usuario->cIDADECodCidade = $this->request->getPost("CIDADECod_cidade");
        $usuario->tIPOUSUARIOCodTipoUsuario = $this->request->getPost("TIPO_USUARIOCod_tipo_usuario");
        

        if (!$usuario->save()) {
            foreach ($usuario->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "usuario",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("usuario was created successfully");

        $this->dispatcher->forward([
            'controller' => "usuario",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a usuario edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "usuario",
                'action' => 'index'
            ]);

            return;
        }

        $Cod_usuario = $this->request->getPost("Cod_usuario");
        $usuario = Usuario::findFirstByCod_usuario($Cod_usuario);

        if (!$usuario) {
            $this->flash->error("usuario does not exist " . $Cod_usuario);

            $this->dispatcher->forward([
                'controller' => "usuario",
                'action' => 'index'
            ]);

            return;
        }

        $usuario->loginUsuario = $this->request->getPost("Login_usuario");
        $usuario->senhaUsuario = $this->request->getPost("Senha_usuario");
        $usuario->nomeUsuario = $this->request->getPost("Nome_usuario");
        $usuario->idadeUsuario = $this->request->getPost("Idade_usuario");
        $usuario->enderecoUsuario = $this->request->getPost("Endereco_usuario");
        $usuario->cIDADECodCidade = $this->request->getPost("CIDADECod_cidade");
        $usuario->tIPOUSUARIOCodTipoUsuario = $this->request->getPost("TIPO_USUARIOCod_tipo_usuario");
        

        if (!$usuario->save()) {

            foreach ($usuario->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "usuario",
                'action' => 'edit',
                'params' => [$usuario->Cod_usuario]
            ]);

            return;
        }

        $this->flash->success("usuario was updated successfully");

        $this->dispatcher->forward([
            'controller' => "usuario",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a usuario
     *
     * @param string $Cod_usuario
     */
    public function deleteAction($Cod_usuario)
    {
        $usuario = Usuario::findFirstByCod_usuario($Cod_usuario);
        if (!$usuario) {
            $this->flash->error("usuario was not found");

            $this->dispatcher->forward([
                'controller' => "usuario",
                'action' => 'index'
            ]);

            return;
        }

        if (!$usuario->delete()) {

            foreach ($usuario->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "usuario",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("usuario was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "usuario",
            'action' => "index"
        ]);
    }

}
