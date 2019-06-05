<?php

class TipoUsuario extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $cod_tipo_usuario;

    /**
     *
     * @var string
     */
    public $tipo_usuario;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("cbs");
        $this->setSource("tipo_usuario");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tipo_usuario';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TipoUsuario[]|TipoUsuario|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TipoUsuario|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
