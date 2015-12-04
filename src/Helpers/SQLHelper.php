<?php
namespace Api\Helpers;

abstract class SQLHelper
{
    public static function createParams()
    {
        $exp_idx = [];
        $exp_val = [];
        $filters = URIHelper::$arrayFilters;

        foreach($filters as $key => $value)
        {
            $qtdValue = count($value);

            for($i=0; $i<$qtdValue; $i++)
            {
                $exp_idx[] = $key;
                $exp_val[] = $value;
            }
        }
        return array_combine($exp_idx, $exp_val);
    }

    public static function createStringWhere($fieldsTable, $alias)
    {
        $filters = URIHelper::$arrayFilters;
        $where = '';
        $cont = 0;

        foreach($filters as $key => $value)
        {
            $qtdValue = count($value);
            if ($cont > 0)
                $where .= ' AND (';
            else
                $where .= ' (';

            for($i=0; $i<$qtdValue; $i++)
            {
                if ($i == 0 && $qtdValue > 1)
                    $where .= '(';

                if (is_array($value))
                    $paramKey = $key.$i;
                else
                    $paramKey = $key;

                switch ($fieldsTable[$key])
                {
                    case 'number':
                        $where .= "{$alias}.{$key} = :{$paramKey}";
                    break;
                    case 'string':
                        $where .= "{$alias}.{$key} LIKE :{$paramKey}";
                    break;
                }

                if ($qtdValue > 1)
                    $where .= ')';

                if ($i < $qtdValue-1)
                    $where .= ' OR (';

                $cont++;
            }
            $where .= ') ';
        }
        return $where;
    }

    public static function createStringWhereParams($fieldsTable)
    {
        $filters = URIHelper::$arrayFilters;
        $params = [];

        foreach($filters as $key => $value) {
            if (is_array($value))
            {
                foreach ($value as $newKey => $newvalue) {
                    switch ($fieldsTable[$key])
                    {
                        case 'number':
                            $params[$newKey] = $newvalue;
                        break;
                        case 'string':
                            $params[$newKey] = '%'.$newvalue.'%';
                        break;
                    }
                }
            }
            else
            {
                switch ($fieldsTable[$key])
                {
                    case 'number':
                        $params[$key] = $value;
                    break;
                    case 'string':
                        $params[$key] = '%'.$value.'%';
                    break;
                }
            }
        }
        return $params;
    }

    public static function createStringFields($fieldsTable, $alias)
    {
        $fields = [];
        foreach(URIHelper::$arrayParams['fields'] as $field)
            if (in_array($field, array_keys($fieldsTable)))
                $fields[] = $alias.'.'.$field;

        return implode(', ',$fields);
    }

    public static function createStringOrderBy($fieldsTable, $alias)
    {
        $orderby = [];
        foreach(URIHelper::$arrayParams['order'] as $key => $value)
            if (in_array($key, array_keys($fieldsTable)))
                $orderby[] = "{$alias}.{$key} {$value}";

        return implode(', ',$orderby);
    }
}