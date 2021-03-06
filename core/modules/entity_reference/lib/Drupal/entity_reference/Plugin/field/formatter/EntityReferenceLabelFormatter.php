<?php

/**
 * @file
 * Contains \Drupal\entity_reference\Plugin\field\formatter\EntityReferenceLabelFormatter.
 */

namespace Drupal\entity_reference\Plugin\field\formatter;

use Drupal\Component\Annotation\Plugin;
use Drupal\Core\Annotation\Translation;
use Drupal\Core\Entity\EntityInterface;
use Drupal\entity_reference\Plugin\field\formatter\EntityReferenceFormatterBase;

/**
 * Plugin implementation of the 'entity reference label' formatter.
 *
 * @Plugin(
 *   id = "entity_reference_label",
 *   module = "entity_reference",
 *   label = @Translation("Label"),
 *   description = @Translation("Display the label of the referenced entities."),
 *   field_types = {
 *     "entity_reference"
 *   },
 *   settings = {
 *     "link" = TRUE
 *   }
 * )
 */
class EntityReferenceLabelFormatter extends EntityReferenceFormatterBase {

  /**
   * Overrides \Drupal\field\Plugin\Type\Formatter\FormatterBase::settingsForm().
   */
  public function settingsForm(array $form, array &$form_state) {
    $elements['link'] = array(
      '#title' => t('Link label to the referenced entity'),
      '#type' => 'checkbox',
      '#default_value' => $this->getSetting('link'),
    );

    return $elements;
  }

  /**
   * Overrides \Drupal\field\Plugin\Type\Formatter\FormatterBase::settingsSummary().
   */
  public function settingsSummary() {
    $summary = array();
    $summary[] = $this->getSetting('link') ? t('Link to the referenced entity') : t('No link');

    return implode('<br />', $summary);
  }

  /**
   * Overrides \Drupal\entity_reference\Plugin\field\formatter\EntityReferenceFormatterBase::viewElements().
   */
  public function viewElements(EntityInterface $entity, $langcode, array $items) {
    // Remove un-accessible items.
    parent::viewElements($entity, $langcode, $items);

    $elements = array();

    foreach ($items as $delta => $item) {
      if ($entity = $item['entity']) {
        $label = $entity->label();
        // If the link is to be displayed and the entity has a uri,
        // display a link.
        if ($this->getSetting('link') && $uri = $entity->uri()) {
          $elements[$delta] = array(
            '#type' => 'link',
            '#title' => $label,
            '#href' => $uri['path'],
            '#options' => $uri['options'],
          );
        }
        else {
          $elements[$delta] = array('#markup' => check_plain($label));
        }
      }
      else {
        // This is an "auto_create" item.
        $elements[$delta] = array('#markup' => $item['label']);
      }
    }

    return $elements;
  }
}
