<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * Class AlertBootstrap
 * @package App\Services
 */
class AlertBootstrap implements AlertBootstrapInterface
{
    const ALERT_PRIMARY = "primary";
    const ALERT_SECONDARY = "secondary";
    const ALERT_SUCCESS = "success";
    const ALERT_DANGER = "danger";
    const ALERT_WARNING = "warning";
    const ALERT_INFO = "info";
    const ALERT_LIGHT = "light";
    const ALERT_DARK = "dark";

    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * AlertBootstrap constructor.
     * @param FlashBagInterface $flashBag
     */
    public function __construct(FlashBagInterface $flashBag)
    {
        $this->flashBag = $flashBag;
    }

    /**
     * @param string $message
     */
    public function primary(string $message): void
    {
        $this->flashBag->add(self::ALERT_PRIMARY, $message);
    }

    /**
     * @param string $message
     */
    public function secondary(string $message): void
    {
        $this->flashBag->add(self::ALERT_SECONDARY, $message);
    }

    /**
     * @param string $message
     */
    public function success(string $message): void
    {
        $this->flashBag->add(self::ALERT_SUCCESS, $message);
    }

    /**
     * @param string $message
     */
    public function danger(string $message): void
    {
        $this->flashBag->add(self::ALERT_DANGER, $message);
    }

    /**
     * @param string $message
     */
    public function warning(string $message): void
    {
        $this->flashBag->add(self::ALERT_WARNING, $message);
    }

    /**
     * @param string $message
     */
    public function info(string $message): void
    {
        $this->flashBag->add(self::ALERT_INFO, $message);
    }

    /**
     * @param string $message
     */
    public function light(string $message): void
    {
        $this->flashBag->add(self::ALERT_LIGHT, $message);
    }

    /**
     * @param string $message
     */
    public function dark(string $message): void
    {
        $this->flashBag->add(self::ALERT_DARK, $message);
    }
}
