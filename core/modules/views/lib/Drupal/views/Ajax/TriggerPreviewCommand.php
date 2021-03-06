<?php

/**
 * @file
 * Contains \Drupal\views\Ajax\TriggerPreviewCommand.
 */

namespace Drupal\views\Ajax;

use Drupal\Core\Ajax\CommandInterface;

/**
 * Provides an AJAX command for triggering the views live preview.
 *
 * This command is implemented in Drupal.ajax.prototype.commands.viewsTriggerPreview.
 */
class TriggerPreviewCommand implements CommandInterface {

  /**
   * Implements \Drupal\Core\Ajax\CommandInterface::render().
   */
  public function render() {
    return array(
      'command' => 'viewsTriggerPreview',
    );
  }

}
