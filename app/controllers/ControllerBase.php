<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{

    protected function initialize()
    {
        $this->tag->prependTitle('CBS| ');
        $this->view->setTemplateAfter('main');
    }
}
