<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class TipoUsuarioController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for tipo_usuario
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'TipoUsuario', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "Cod_tipo_usuario";

        $tipo_usuario = TipoUsuario::find($parameters);
        if (count($tipo_usuario) == 0) {
            $this->flash->notice("The search did not find any tipo_usuario");

            $this->dispatcher->forward([
                "controller" => "tipo_usuario",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $tipo_usuario,
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
     * Edits a tipo_usuario
     *
     * @param string $Cod_tipo_usuario
     */
    public function editAction($Cod_tipo_usuario)
    {
        if (!$this->request->isPost()) {

            $tipo_usuario = TipoUsuario::findFirstByCod_tipo_usuario($Cod_tipo_usuario);
            if (!$tipo_usuario) {
                $this->flash->error("tipo_usuario was not found");

                $this->dispatcher->forward([
                    'controller' => "tipo_usuario",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->Cod_tipo_usuario = $tipo_usuario->Cod_tipo_usuario;

            $this->tag->setDefault("Cod_tipo_usuario", $tipo_usuario->Cod_tipo_usuario);
            $this->tag->setDefault("Tipo_usuario", $tipo_usuario->Tipo_usuario);
            
        }
    }

    /**
     * Creates a new tipo_usuario
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "tipo_usuario",
                'action' => 'index'
            ]);

            return;
        }

        $tipo_usuario = new TipoUsuario();
        $tipo_usuario->tipoUsuario = $this->request->getPost("Tipo_usuario");
        

        if (!$tipo_usuario->save()) {
            foreach ($tipo_usuario->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tipo_usuario",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("tipo_usuario was created successfully");

        $this->dispatcher->forward([
            'controller' => "tipo_usuario",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a tipo_usuario edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "tipo_usuario",
                'action' => 'index'
            ]);

            return;
        }

        $Cod_tipo_usuario = $this->request->getPost("Cod_tipo_usuario");
        $tipo_usuario = TipoUsuario::findFirstByCod_tipo_usuario($Cod_tipo_usuario);

        if (!$tipo_usuario) {
            $this->flash->error("tipo_usuario does not exist " . $Cod_tipo_usuario);

            $this->dispatcher->forward([
                'controller' => "tipo_usuario",
                'action' => 'index'
            ]);

            return;
        }

        $tipo_usuario->tipoUsuario = $this->request->getPost("Tipo_usuario");
        

        if (!$tipo_usuario->save()) {

            foreach ($tipo_usuario->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tipo_usuario",
                'action' => 'edit',
                'params' => [$tipo_usuario->Cod_tipo_usuario]
            ]);

            return;
        }

        $this->flash->success("tipo_usuario was updated successfully");

        $this->dispatcher->forward([
            'controller' => "tipo_usuario",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a tipo_usuario
     *
     * @param string $Cod_tipo_usuario
     */
    public function deleteAction($Cod_tipo_usuario)
    {
        $tipo_usuario = TipoUsuario::findFirstByCod_tipo_usuario($Cod_tipo_usuario);
        if (!$tipo_usuario) {
            $this->flash->error("tipo_usuario was not found");

            $this->dispatcher->forward([
                'controller' => "tipo_usuario",
                'action' => 'index'
            ]);

            return;
        }

        if (!$tipo_usuario->delete()) {

            foreach ($tipo_usuario->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tipo_usuario",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("tipo_usuario was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "tipo_usuario",
            'action' => "index"
        ]);
    }

}
