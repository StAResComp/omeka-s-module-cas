<?php

namespace Cas\Controller;

use Doctrine\ORM\EntityManager;
use Laminas\Authentication\AuthenticationService;
use Laminas\Mvc\Controller\AbstractActionController;

class LoginController extends AbstractActionController {

    protected $auth;
    protected $casServer;
    protected $casLoginPath;
    protected $casLoginParams;

    public function __construct(AuthenticationService $auth) {
        $this->auth = $auth;
        $options = $this->auth->getAdapter()->getOptions();
        $this->casServer = $options['cas_server'];
        $this->casLoginPath = $options['cas_login_path'];
        $this->casLoginParams = ['service' => $options['cas_service']];
    }

    public function casAction() {
        $casRequestQuery = http_build_query($this->casLoginParams);
        $casRequestUrl = $this->casServer.$this->casLoginPath.'?'.$casRequestQuery;
        return $this->redirect()->toUrl($casRequestUrl);
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
