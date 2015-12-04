<?php

/***********************
 * Slim
 **********************/
$app = new \Slim\Slim();


/***********************
 * Serializer
 **********************/
use Symfony\Component\Serializer\Serializer,
    Symfony\Component\Serializer\Encoder\XmlEncoder,
    Symfony\Component\Serializer\Encoder\JsonEncoder,
    Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

$encoders = array(new XmlEncoder(), new JsonEncoder());
$normalizers = array(new ObjectNormalizer());
$serializer = new Serializer($normalizers, $encoders);


/***********************
 * Doctrine
 **********************/
use Doctrine\ORM\EntityManager,
    Doctrine\ORM\Configuration;

$isDevMode = true;
if ($isDevMode)
    $cache = new \Doctrine\Common\Cache\ArrayCache;
else
    $cache = new \Doctrine\Common\Cache\ApcCache;

$config = new Configuration;
$config->setMetadataCacheImpl($cache);
$driverImpl = $config->newDefaultAnnotationDriver(__DIR__ . DS . 'src/Entities');
$config->setMetadataDriverImpl($driverImpl);
$config->setQueryCacheImpl($cache);
$config->setProxyDir(__DIR__ . DS . 'src/Proxies');
$config->setProxyNamespace('Api\Proxies');

if ($isDevMode)
    $config->setAutoGenerateProxyClasses(true);
else
    $config->setAutoGenerateProxyClasses(false);

// Parâmetros de Configuração do Banco de Dados
$conn = parse_ini_file(CONFIG . DS . 'config.ini');

// Obtendo o Entity Manager
$em = EntityManager::create($conn, $config);