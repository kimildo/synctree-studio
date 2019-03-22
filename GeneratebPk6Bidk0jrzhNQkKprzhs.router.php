<?php

$app->group('/GenbPk6Bidk0jrzhNQkKprzhs', function () {

    $this->post('/secure/getCommand', 'controllers\generated\usr\owner_nntuple_com\GeneratebPk6Bidk0jrzhNQkKprzhsController:getCommand')->setName('getCommand');
    $this->get('', 'controllers\generated\usr\owner_nntuple_com\GeneratebPk6Bidk0jrzhNQkKprzhsController:main')->setName('main');
    $this->get('/', 'controllers\generated\usr\owner_nntuple_com\GeneratebPk6Bidk0jrzhNQkKprzhsController:main')->setName('main');

})->add(new \middleware\Common($app->getContainer(), APP_ENV === APP_ENV_PRODUCTION));