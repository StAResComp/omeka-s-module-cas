<?php

namespace Cas;

use Omeka\Module\AbstractModule;
use Laminas\Mvc\MvcEvent;
use Laminas\Permissions\Acl\Acl as LaminasAcl;

class Module extends AbstractModule {

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $event) {
        parent::onBootstrap($event);
        $services = $this->getServiceLocator();
        $acl = $services->get('Omeka\Acl');
        $acl->allow(null, [Controller\Login::class], ['cas', 'casAuth']);
    }
}
