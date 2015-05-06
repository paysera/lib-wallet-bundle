<?php

namespace Paysera\Bundle\WalletBundle\State;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Paysera_WalletApi_State_StatePersisterInterface as StatePersisterInterface;

class StatePersister implements StatePersisterInterface
{
    protected $session;
    protected $prefix;

    /**
     * @param SessionInterface $session
     * @param string $prefix
     */
    public function __construct(SessionInterface $session, $prefix)
    {
        $this->session = $session;
        $this->prefix = $prefix;
    }

    /**
     * Saves parameter
     *
     * @param string $name
     * @param mixed $value
     */
    public function saveParameter($name, $value)
    {
        $this->session->set($this->prefix . '.' . $name, $value);
    }

    /**
     * Gets saved parameter
     *
     * @param string $name
     * @param mixed $default
     *
     * @return mixed
     */
    public function getParameter($name, $default = null)
    {
        return $this->session->get($this->prefix . '.' . $name, $default);
    }
}
