<?php

class Classe extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $cod_Classe;

    /**
     *
     * @var string
     */
    public $classe;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("cbs");
        $this->setSource("classe");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'classe';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Classe[]|Classe|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Classe|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
