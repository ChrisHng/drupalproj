<?php

namespace Drupal\logger\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\monolog\Logger\Logger;
use Drupal\monolog\Logger\Processor\CurrentUserProcessor;
use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\StreamHandler;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class AlohaController
 *
 * @package loggerImp\Controller
 */
class AlohaController extends ControllerBase {

    private $warningHandler;
    private $errorHandler;
    private $nativeMailerHandler;

    public static function create(ContainerInterface $container)
    {
        return new static(
          $container->get('monolog.handler.slack_warnings'),
          $container->get('monolog.handler.slack_errors'),
          $container->get('monolog.handler.pushover_warnings')
        );
    }

    public function __construct(HandlerInterface $warningHandler, HandlerInterface $errorHandler, HandlerInterface $nativeMailerHandler)
    {
        $this->warningHandler = $warningHandler;
        $this->errorHandler = $errorHandler;
        $this->nativeMailerHandler = $nativeMailerHandler;
    }

    /**
     * Display something
     */
    public function content() {

        $this->nativeMailerHandler->handle($this->getMessage(550, 'This is a Pushover test'));

        return [
            '#markup' => '<h1>Aloha everyone</h1>'
        ];
    }

    public function getMessage($errorLevel, $message) {
        return array(
          'message' => $message,
          'context' => ['class' => 'AlohaController'],
          'level' => $errorLevel,
          'level_name' => Logger::getLevelName($errorLevel),
          'channel' => 'monolog_test',
          'datetime' => \DateTime::createFromFormat('U.u', sprintf('%.6F', microtime(true))),
          'extra' => []
        );
    }
}
