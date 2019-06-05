<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class AulaController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for aula
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Aula', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "Cod_aula";

        $aula = Aula::find($parameters);
        if (count($aula) == 0) {
            $this->flash->notice("The search did not find any aula");

            $this->dispatcher->forward([
                "controller" => "aula",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $aula,
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
     * Edits a aula
     *
     * @param string $Cod_aula
     */
    public function editAction($Cod_aula)
    {
        if (!$this->request->isPost()) {

            $aula = Aula::findFirstByCod_aula($Cod_aula);
            if (!$aula) {
                $this->flash->error("aula was not found");

                $this->dispatcher->forward([
                    'controller' => "aula",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->Cod_aula = $aula->Cod_aula;

            $this->tag->setDefault("Cod_aula", $aula->Cod_aula);
            $this->tag->setDefault("Conteudo_aula", $aula->Conteudo_aula);
            $this->tag->setDefault("CLASSECod_Classe", $aula->CLASSECod_Classe);
            
        }
    }

    /**
     * Creates a new aula
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "aula",
                'action' => 'index'
            ]);

            return;
        }

        $aula = new Aula();
        $aula->conteudoAula = $this->request->getPost("Conteudo_aula");
        $aula->cLASSECodClasse = $this->request->getPost("CLASSECod_Classe");
        

        if (!$aula->save()) {
            foreach ($aula->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "aula",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("aula was created successfully");

        $this->dispatcher->forward([
            'controller' => "aula",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a aula edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "aula",
                'action' => 'index'
            ]);

            return;
        }

        $Cod_aula = $this->request->getPost("Cod_aula");
        $aula = Aula::findFirstByCod_aula($Cod_aula);

        if (!$aula) {
            $this->flash->error("aula does not exist " . $Cod_aula);

            $this->dispatcher->forward([
                'controller' => "aula",
                'action' => 'index'
            ]);

            return;
        }

        $aula->conteudoAula = $this->request->getPost("Conteudo_aula");
        $aula->cLASSECodClasse = $this->request->getPost("CLASSECod_Classe");
        

        if (!$aula->save()) {

            foreach ($aula->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "aula",
                'action' => 'edit',
                'params' => [$aula->Cod_aula]
            ]);

            return;
        }

        $this->flash->success("aula was updated successfully");

        $this->dispatcher->forward([
            'controller' => "aula",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a aula
     *
     * @param string $Cod_aula
     */
    public function deleteAction($Cod_aula)
    {
        $aula = Aula::findFirstByCod_aula($Cod_aula);
        if (!$aula) {
            $this->flash->error("aula was not found");

            $this->dispatcher->forward([
                'controller' => "aula",
                'action' => 'index'
            ]);

            return;
        }

        if (!$aula->delete()) {

            foreach ($aula->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "aula",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("aula was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "aula",
            'action' => "index"
        ]);
    }

}
