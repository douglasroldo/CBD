<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class ClasseController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for classe
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Classe', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "Cod_Classe";

        $classe = Classe::find($parameters);
        if (count($classe) == 0) {
            $this->flash->notice("The search did not find any classe");

            $this->dispatcher->forward([
                "controller" => "classe",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $classe,
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
     * Edits a classe
     *
     * @param string $Cod_Classe
     */
    public function editAction($Cod_Classe)
    {
        if (!$this->request->isPost()) {

            $classe = Classe::findFirstByCod_Classe($Cod_Classe);
            if (!$classe) {
                $this->flash->error("classe was not found");

                $this->dispatcher->forward([
                    'controller' => "classe",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->Cod_Classe = $classe->Cod_Classe;

            $this->tag->setDefault("Cod_Classe", $classe->Cod_Classe);
            $this->tag->setDefault("Classe", $classe->Classe);
            
        }
    }

    /**
     * Creates a new classe
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "classe",
                'action' => 'index'
            ]);

            return;
        }

        $classe = new Classe();
        $classe->classe = $this->request->getPost("Classe");
        

        if (!$classe->save()) {
            foreach ($classe->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "classe",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("classe was created successfully");

        $this->dispatcher->forward([
            'controller' => "classe",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a classe edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "classe",
                'action' => 'index'
            ]);

            return;
        }

        $Cod_Classe = $this->request->getPost("Cod_Classe");
        $classe = Classe::findFirstByCod_Classe($Cod_Classe);

        if (!$classe) {
            $this->flash->error("classe does not exist " . $Cod_Classe);

            $this->dispatcher->forward([
                'controller' => "classe",
                'action' => 'index'
            ]);

            return;
        }

        $classe->classe = $this->request->getPost("Classe");
        

        if (!$classe->save()) {

            foreach ($classe->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "classe",
                'action' => 'edit',
                'params' => [$classe->Cod_Classe]
            ]);

            return;
        }

        $this->flash->success("classe was updated successfully");

        $this->dispatcher->forward([
            'controller' => "classe",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a classe
     *
     * @param string $Cod_Classe
     */
    public function deleteAction($Cod_Classe)
    {
        $classe = Classe::findFirstByCod_Classe($Cod_Classe);
        if (!$classe) {
            $this->flash->error("classe was not found");

            $this->dispatcher->forward([
                'controller' => "classe",
                'action' => 'index'
            ]);

            return;
        }

        if (!$classe->delete()) {

            foreach ($classe->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "classe",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("classe was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "classe",
            'action' => "index"
        ]);
    }

}
