<?php

class IndexController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Bem vindo!!');
        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->request->isPost()) {
            $this->flash->notice('Ensina o menino no caminho em que se deve andar para que no futuro não se desvie!!');
        }
    }
}
