<?php

class Cidade extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $cod_cidade;

    /**
     *
     * @var string
     */
    public $cidade;

    /**
     *
     * @var string
     */
    public $uF_cidade;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("cbs");
        $this->setSource("cidade");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'cidade';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Cidade[]|Cidade|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Cidade|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
