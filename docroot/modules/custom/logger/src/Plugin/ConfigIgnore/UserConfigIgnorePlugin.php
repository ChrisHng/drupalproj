<?php

namespace Drupal\logger\Plugin\ConfigIgnore;

use Drupal\Core\Plugin\PluginBase;
use Drupal\config_ignore_keys\Plugin\ConfigurationIgnorePluginInterface;

/**
 * Null config ignore plugin.
 *
 * @ConfigurationIgnorePlugin(
 *   id = "user_config_ignorexxx",
 *   description = "The configuration for ignoring iuzar",
 * )
 */
class UserConfigIgnorePlugin extends PluginBase implements ConfigurationIgnorePluginInterface {

  /**
   * {@inheritdoc}
   */
  public function getConfigurations() {
      return [
        "user.mail" => ['register_no_approval_required.body'],
      ];
  }

}
