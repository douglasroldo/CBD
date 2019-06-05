<?php

class Aula extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $cod_aula;

    /**
     *
     * @var string
     */
    public $conteudo_aula;

    /**
     *
     * @var integer
     */
    public $cLASSECod_Classe;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("cbs");
        $this->setSource("aula");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'aula';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Aula[]|Aula|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Aula|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
