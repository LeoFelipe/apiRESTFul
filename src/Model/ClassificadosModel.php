<?php
namespace Api\Model;

use Api\Entities\Classificado,
    Api\Helpers\SQLHelper,
    Api\Helpers\URIHelper;

class ClassificadosModel extends Model
{
    private $alias = 'c';
    public $fieldsTable = [
        'id' => 'number',
        'titulo' => 'string',
        'anuncio' => 'string',
        'idPedido' => 'number'
    ];

    public function findBy()
    {
        $fields = (URIHelper::$arrayParams['fields']) ? SQLHelper::createStringFields($this->fieldsTable, $this->alias) : $this->alias;
        $orderBy = SQLHelper::createStringOrderBy($this->fieldsTable, $this->alias);
        $where = SQLHelper::createStringWhere($this->fieldsTable, $this->alias);
        $params = SQLHelper::createStringWhereParams($this->fieldsTable);

        $repoClassificados = $this->getEM()->getRepository($this->getEntity());
        return $repoClassificados->getBy($fields, $orderBy, $where, $params);
    }

}