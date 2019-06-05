<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class CidadeController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for cidade
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Cidade', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "Cod_cidade";

        $cidade = Cidade::find($parameters);
        if (count($cidade) == 0) {
            $this->flash->notice("The search did not find any cidade");

            $this->dispatcher->forward([
                "controller" => "cidade",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $cidade,
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
     * Edits a cidade
     *
     * @param string $Cod_cidade
     */
    public function editAction($Cod_cidade)
    {
        if (!$this->request->isPost()) {

            $cidade = Cidade::findFirstByCod_cidade($Cod_cidade);
            if (!$cidade) {
                $this->flash->error("cidade was not found");

                $this->dispatcher->forward([
                    'controller' => "cidade",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->Cod_cidade = $cidade->Cod_cidade;

            $this->tag->setDefault("Cod_cidade", $cidade->Cod_cidade);
            $this->tag->setDefault("Cidade", $cidade->Cidade);
            $this->tag->setDefault("UF_cidade", $cidade->UF_cidade);
            
        }
    }

    /**
     * Creates a new cidade
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "cidade",
                'action' => 'index'
            ]);

            return;
        }

        $cidade = new Cidade();
        $cidade->cidade = $this->request->getPost("Cidade");
        $cidade->uFCidade = $this->request->getPost("UF_cidade");
        

        if (!$cidade->save()) {
            foreach ($cidade->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "cidade",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("cidade was created successfully");

        $this->dispatcher->forward([
            'controller' => "cidade",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a cidade edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "cidade",
                'action' => 'index'
            ]);

            return;
        }

        $Cod_cidade = $this->request->getPost("Cod_cidade");
        $cidade = Cidade::findFirstByCod_cidade($Cod_cidade);

        if (!$cidade) {
            $this->flash->error("cidade does not exist " . $Cod_cidade);

            $this->dispatcher->forward([
                'controller' => "cidade",
                'action' => 'index'
            ]);

            return;
        }

        $cidade->cidade = $this->request->getPost("Cidade");
        $cidade->uFCidade = $this->request->getPost("UF_cidade");
        

        if (!$cidade->save()) {

            foreach ($cidade->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "cidade",
                'action' => 'edit',
                'params' => [$cidade->Cod_cidade]
            ]);

            return;
        }

        $this->flash->success("cidade was updated successfully");

        $this->dispatcher->forward([
            'controller' => "cidade",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a cidade
     *
     * @param string $Cod_cidade
     */
    public function deleteAction($Cod_cidade)
    {
        $cidade = Cidade::findFirstByCod_cidade($Cod_cidade);
        if (!$cidade) {
            $this->flash->error("cidade was not found");

            $this->dispatcher->forward([
                'controller' => "cidade",
                'action' => 'index'
            ]);

            return;
        }

        if (!$cidade->delete()) {

            foreach ($cidade->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "cidade",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("cidade was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "cidade",
            'action' => "index"
        ]);
    }

}
