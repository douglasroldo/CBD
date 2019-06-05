<?php

class Usuario extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $cod_usuario;

    /**
     *
     * @var string
     */
    public $login_usuario;

    /**
     *
     * @var string
     */
    public $senha_usuario;

    /**
     *
     * @var string
     */
    public $nome_usuario;

    /**
     *
     * @var integer
     */
    public $idade_usuario;

    /**
     *
     * @var string
     */
    public $endereco_usuario;

    /**
     *
     * @var integer
     */
    public $cIDADECod_cidade;

    /**
     *
     * @var integer
     */
    public $tIPO_USUARIOCod_tipo_usuario;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("cbs");
        $this->setSource("usuario");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'usuario';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Usuario[]|Usuario|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Usuario|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
