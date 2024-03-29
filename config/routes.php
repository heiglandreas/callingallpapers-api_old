<?php
// Routes
$app->get('/', function(
    \Psr\Http\Message\ServerRequestInterface $request,
    \Psr\Http\Message\ResponseInterface $response,
    array $args
) use ($app){
    return $this->view->render($response, [], 200, 'cfp/index.twig');
});
$app->get('/v1/cfp', function(
    \Psr\Http\Message\ServerRequestInterface $request,
    \Psr\Http\Message\ResponseInterface $response,
    array $args
) use ($app){
    $cpl = new \Callingallpapers\Api\PersistenceLayer\CfpPersistenceLayer(
        $app->getContainer()['pdo'],
        $app->getContainer()['logger']
    );
    $list = $cpl->select();

    $cfpMapper = new \Callingallpapers\Api\Entity\CfpListMapper();

    return $this->view->render($response, $cfpMapper->map($list), 200, 'cfp/list.twig');
});

$app->get('/v1/cfp/{hash}', function(
    \Psr\Http\Message\ServerRequestInterface $request,
    \Psr\Http\Message\ResponseInterface $response,
    array $args
) use ($app){

    $cpl = new \Callingallpapers\Api\PersistenceLayer\CfpPersistenceLayer(
        $app->getContainer()['pdo']
    );
    $list = $cpl->select($args['hash']);

    $cfpMapper = new \Callingallpapers\Api\Entity\CfpListMapper();

    return $this->view->render($response, $cfpMapper->map($list), 200, 'cfp/list.twig');
});

$app->post('/v1/cfp', function(
    \Psr\Http\Message\ServerRequestInterface $request,
    \Psr\Http\Message\ResponseInterface $response,
    array $args
) use ($app){
    $params = $request->getParsedBody();

    $cfpFactory = new \Callingallpapers\Api\Service\CfpFactory();
    $cfp = $cfpFactory->createCfp($params);

    $cpl = new \Callingallpapers\Api\PersistenceLayer\CfpPersistenceLayer(
        $app->getContainer()['pdo']
    );
    $cpl->insert($cfp);

    $uri = $request->getUri();
    $uri = $uri->withPath('v1/cfp/' . $cfp->getId());
    return $response->withRedirect((string)$uri, 201);
});


$app->put('/v1/cfp/{hash}', function (
    \Psr\Http\Message\ServerRequestInterface $request,
    \Psr\Http\Message\ResponseInterface $response,
    array $args
) use ($app){
    $params = $request->getParsedBody();

    $cfpFactory = new \Callingallpapers\Api\Service\CfpFactory();
    $cfp = $cfpFactory->createCfp($params);

    $cpl = new \Callingallpapers\Api\PersistenceLayer\CfpPersistenceLayer(
        $app->getContainer()['pdo']
    );
    $cpl->update($cfp, $args['hash']);

    $uri = $request->getUri();
    $uri = $uri->withPath('v1/cfp/' . $cfp->getId());
    return $response->withHeader('Location', (string)$uri)->withStatus(204);
});


$app->delete('/v1/cfp/{id}', function (
    \Psr\Http\Message\ServerRequestInterface $request,
    \Psr\Http\Message\ResponseInterface $response,
    array $args
) use ($app){
    $params = $request->getParsedBody();
    $cpl = new \Callingallpapers\Api\PersistenceLayer\CfpPersistenceLayer(
        $app->getContainer()['pdo']
    );
    $cpl->delete($params['hash']);

    return $response->withHeader('Content-Length', '0')->withStatus(204);
});
