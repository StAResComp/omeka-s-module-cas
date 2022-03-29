<?php

namespace Cas\Authentication;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Laminas\Authentication\Adapter\AbstractAdapter;
use Laminas\Authentication\Result;

class CasAdapter extends AbstractAdapter {

    protected $repository;
    protected $options;
    private $casValidationParams = [
        'ticket' => '',
        'service' => ''
    ];

    public function __construct(EntityManager $manager)
    {
        $this->setRepository($manager->getRepository('Omeka\Entity\User'));
    }

    public function authenticate() {

    $casRequestQuery = http_build_query($this->casValidationParams);
    $casRequestUrl = $this->options['cas_server'].$this->options['cas_validate_path'].'?'.$casRequestQuery;
    $response = file_get_contents($casRequestUrl);

    $responseData = simplexml_load_string($response);
        foreach($responseData->getDocNamespaces() as $strPrefix => $strNamespace) {
            $responseData->registerXPathNamespace($strPrefix,$strNamespace);
        }

        $username = (string)$responseData->xpath("//cas:user")[0];
        $this->setIdentity($username);

        $user = $this->repository->findOneBy(['email' => $this->identity.'@'.$this->options['cas_email_domain']]);

        if (!$user || !$user->isActive()) {
            return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, null,
                ['User not found.']);
        }

        return new Result(Result::SUCCESS, $user);
    }

    public function setRepository(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getRepository()
    {
        return $this->repository;
    }

    public function setOptions($options) {
        $this->options = $options;
        $this->casValidationParams['service'] = $this->options['cas_service'];
    }

    public function getOptions() {
        return $this->options;
    }

    public function setTicket(string $ticket) {
        $this->casValidationParams['ticket'] = $ticket;
    }
}
