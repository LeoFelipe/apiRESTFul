<?php
namespace Api\Helpers;


abstract class URIHelper
{
    public static $resource,
                  $resourceParams,
                  $arrayFilters = array(),
                  $arraySpecialParams = ['pagination', 'fields', 'order', 'format'];

    public static $arrayParams = [
        'format' => 'json',
        'fields' => [],
        'order' => ['id' => 'DESC'],
        'limit' => 50,
        'offset' => 0
    ];

    public static function getFormat()
    {
        return self::$arrayParams['format'];
    }

    public static function run($URIFull)
    {
        $explodeURIFull = explode('?', $URIFull);

        $explodeResourceFull  =
            (!isset($explodeURIFull[0]) || is_null($explodeURIFull[0]) || empty($explodeURIFull[0]) || $explodeURIFull[0] == 'classificados')
                ? ['classificados'] : explode('/', $explodeURIFull[0]);

        self::$resource = $explodeResourceFull[0];

        if (isset($explodeResourceFull[1]) && !(is_null($explodeResourceFull[1]) || empty($explodeResourceFull[1])))
            self::$resourceParams = $explodeResourceFull[1];
    }

    public static function setToArray($stringURI = null, $fieldsTable = null)
    {
        if (!empty($stringURI))
        {
            $explodeURI = explode('?', $stringURI);
            unset($explodeURI[0]);

            foreach ($explodeURI as $parseURI)
                if (substr($parseURI, 0, 1) == '*')
                    self::setFiltersToArray(substr($parseURI, 1), $fieldsTable);
                else
                    self::setParamsToArray($parseURI);
        }
    }

    public static function setParamsToArray($stringParams)
    {
        $explodeParams = explode('&', str_replace("?", '', $stringParams));

        foreach($explodeParams as $params) {
            $explodeOneParam = explode('=', $params);
            if (in_array($explodeOneParam[0], self::$arraySpecialParams)) {
                switch ($explodeOneParam[0]) {
                    case 'format':
                        self::$arrayParams['format'] = (!empty($explodeOneParam[1])) ? $explodeOneParam[1] : 'json';
                        break;
                    case 'fields':
                        self::$arrayParams['fields'] = (!empty($explodeOneParam[1])) ? explode(',', $explodeOneParam[1]) : [];
                        break;
                    case 'order':
                        if (!empty($explodeOneParam[1]))
                        {
                            $arrayOrderBy = explode(',', $explodeOneParam[1]);

                            foreach ($arrayOrderBy as $orderBy)
                                if (substr($orderBy, 0, 1) == '-')
                                    $order[substr($orderBy, 1)] = 'DESC';
                                else
                                    $order[$orderBy] = 'ASC';
                        } else
                            $order = ['id' => 'DESC'];

                        self::$arrayParams['order'] = $order;
                        break;
                    case 'pagination':
                        if (!empty($explodeOneParam[1])) {
                            $arrayPagination = explode(',', $explodeOneParam[1]);

                            if (!empty($arrayPagination[0]))
                                if ((int)$arrayPagination[0] == 0)
                                    $perPage = 50;
                                else
                                    $perPage = (((int)$arrayPagination[0]) > 100) ? 100 : (int)$arrayPagination[0];
                            else
                                $perPage = 50;

                            if (!empty($arrayPagination[1]))
                                if ((int)$arrayPagination[1] <= 1)
                                    $page = 1;
                                else
                                    $page = (int)$arrayPagination[1];
                            else
                                $page = 1;
                        } else {
                            $perPage = 50;
                            $page = 1;
                        }
                        self::$arrayParams['limit'] = $perPage;
                        self::$arrayParams['offset'] = (($page - 1) * $perPage);
                    break;
                }
            }
        }
    }

    public static function setFiltersToArray($stringFilters, $fieldsTable)
    {
        $explodeFilters = explode('&',  $stringFilters);

        foreach($explodeFilters as $filters)
        {
            $explodeOneFilter = explode('=', $filters);

            if (empty($explodeOneFilter[0]) || empty($explodeOneFilter[1]))
                continue;
            else
            {
                if (in_array($explodeOneFilter[0], array_keys($fieldsTable)))
                {
                    $valoresOR = explode(',', $explodeOneFilter[1]);
                    if (count($valoresOR) > 1) {
                        $valoresOR = FuncoesHelper::modifyNameKeysArray($explodeOneFilter[0], $valoresOR);
                        self::$arrayFilters[$explodeOneFilter[0]] = $valoresOR;
                    } else
                        self::$arrayFilters[$explodeOneFilter[0]] = $explodeOneFilter[1];
                }
            }
        }
    }
}