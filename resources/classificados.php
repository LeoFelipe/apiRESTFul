<?php

use Api\Model\ClassificadosModel,
    Api\Helpers\URIHelper;

$app->group('/classificados', function () use ($app, $serializer, $em) {

    $classificados = new ClassificadosModel($em, 'Api\Entities\Classificado');

    /**
     * FindBy()
     */
    $app->get('(/)(:params)', function($params = null) use ($app, $serializer, $classificados){
        URIHelper::setToArray($params, $classificados->fieldsTable);
        $classificados = $classificados->findBy();

        $app->response->headers->set('Content-Type', 'application/'.URIHelper::getFormat());
        if (!empty($classificados))
            echo $serializer->serialize($classificados, URIHelper::getFormat());
        else
            echo $serializer->serialize(['No Records'], URIHelper::getFormat());
    });

    /**
     * Find()
     */
    $app->get('/:id(/:params)', function($id,$params) use ($app, $serializer, $classificados){
        URIHelper::setToArray($params, $classificados->fieldsTable);
        $classificado = $classificados->find($id);

        $app->response->headers->set('Content-Type', 'application/'.URIHelper::getFormat());
        if (!empty($classificado))
            echo $serializer->serialize($classificado, URIHelper::getFormat());
        else
            echo $serializer->serialize(['No Records'], URIHelper::getFormat());
    });

});