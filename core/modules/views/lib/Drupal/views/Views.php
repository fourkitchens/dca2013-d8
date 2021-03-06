<?php

/**
 * @file
 * Contains \Drupal\views\Views.
 */

namespace Drupal\views;

use Drupal;

/**
 * Static service container wrapper for views.
 */
class Views {

  /**
   * Returns the views data service.
   *
   * @return \Drupal\views\ViewsDataCache
   *   Returns a views data cache object.
   */
  public static function viewsData() {
    return Drupal::service('views.views_data');
  }

  /**
   * Returns the view executable factory service.
   *
   * @return \Drupal\views\ViewExecutableFactory
   *   Returns a views executable factory.
   */
  public static function executableFactory() {
    return Drupal::service('views.executable');
  }

  /**
   * Returns the view analyzer.
   *
   * @return \Drupal\views\Analyzer
   *   Returns a view analyzer object.
   */
  public static function analyzer() {
    return Drupal::service('views.analyzer');
  }

  /**
   * Returns the plugin manager for a certain views plugin type.
   *
   * @param string $type
   *   The plugin type, for example filter.
   *
   * @return \Drupal\views\Plugin\ViewsPluginManager
   */
  public static function pluginManager($type) {
    return Drupal::service('plugin.manager.views.' . $type);
  }

}
