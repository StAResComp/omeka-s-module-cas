<?php

namespace Cas\Controller;

use Doctrine\ORM\EntityManager;
use Laminas\Authentication\AuthenticationService;
use Laminas\Mvc\Controller\AbstractActionController;

class LoginController extends AbstractActionController {

    protected $auth;

    public function __construct(AuthenticationService $auth) {
        $this->auth = $auth;
    }

    public function casAction() {
        $loginUrl = $this->auth->getAdapter()->getCasLoginUrl();
        return $this->redirect()->toUrl($loginUrl);
    }

    public function casAuthAction() {

        $request = $this->getRequest();
        $ticket = $request->getQuery('ticket');
        $adapter = $this->auth->getAdapter();
        $adapter->setTicket($ticket);

        $result = $this->auth->authenticate();

        if ($result->isValid()) {
            return $this->redirect()->toRoute('admin');
        }
        else {
            $this->messenger()->addError('CAS authentication failed');
            return $this->redirect->toRoute('');
        }
    }
}
