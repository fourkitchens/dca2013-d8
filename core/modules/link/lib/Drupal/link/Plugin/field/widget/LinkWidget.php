<?php

/**
 * @file
 * Contains \Drupal\link\Plugin\field\widget\LinkWidget.
 */

namespace Drupal\link\Plugin\field\widget;

use Drupal\Component\Annotation\Plugin;
use Drupal\Core\Annotation\Translation;
use Drupal\field\Plugin\Type\Widget\WidgetBase;

/**
 * Plugin implementation of the 'link' widget.
 *
 * @Plugin(
 *   id = "link_default",
 *   module = "link",
 *   label = @Translation("Link"),
 *   field_types = {
 *     "link"
 *   },
 *   settings = {
 *     "placeholder_url" = "",
 *     "placeholder_title" = ""
 *   }
 * )
 */
class LinkWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(array $items, $delta, array $element, $langcode, array &$form, array &$form_state) {
    $instance = $this->instance;

    $element['url'] = array(
      '#type' => 'url',
      '#title' => t('URL'),
      '#placeholder' => $this->getSetting('placeholder_url'),
      '#default_value' => isset($items[$delta]['url']) ? $items[$delta]['url'] : NULL,
      '#maxlength' => 2048,
      '#required' => $element['#required'],
    );
    $element['title'] = array(
      '#type' => 'textfield',
      '#title' => t('Title'),
      '#placeholder' => $this->getSetting('placeholder_title'),
      '#default_value' => isset($items[$delta]['title']) ? $items[$delta]['title'] : NULL,
      '#maxlength' => 255,
      '#access' => $instance['settings']['title'] != DRUPAL_DISABLED,
    );
    // Post-process the title field to make it conditionally required if URL is
    // non-empty. Omit the validation on the field edit form, since the field
    // settings cannot be saved otherwise.
    $is_field_edit_form = ($element['#entity'] === NULL);
    if (!$is_field_edit_form && $instance['settings']['title'] == DRUPAL_REQUIRED) {
      $element['#element_validate'] = array(array($this, 'validateTitle'));
    }

    // Exposing the attributes array in the widget is left for alternate and more
    // advanced field widgets.
    $element['attributes'] = array(
      '#type' => 'value',
      '#tree' => TRUE,
      '#value' => !empty($items[$delta]['attributes']) ? $items[$delta]['attributes'] : array(),
      '#attributes' => array('class' => array('link-field-widget-attributes')),
    );

    // If cardinality is 1, ensure a label is output for the field by wrapping it
    // in a details element.
    if ($this->field['cardinality'] == 1) {
      $element += array(
        '#type' => 'fieldset',
      );
    }

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, array &$form_state) {
    $elements = parent::settingsForm($form, $form_state);

    $elements['placeholder_url'] = array(
      '#type' => 'textfield',
      '#title' => t('Placeholder for URL'),
      '#default_value' => $this->getSetting('placeholder_url'),
      '#description' => t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    );
    $elements['placeholder_title'] = array(
      '#type' => 'textfield',
      '#title' => t('Placeholder for link title'),
      '#default_value' => $this->getSetting('placeholder_title'),
      '#description' => t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
      '#states' => array(
        'invisible' => array(
          ':input[name="instance[settings][title]"]' => array('value' => DRUPAL_DISABLED),
        ),
      ),
    );

    return $elements;
  }

  /**
   * Form element validation handler for link_field_widget_form().
   *
   * Conditionally requires the link title if a URL value was filled in.
   */
  function validateTitle(&$element, &$form_state, $form) {
    if ($element['url']['#value'] !== '' && $element['title']['#value'] === '') {
      $element['title']['#required'] = TRUE;
      form_error($element['title'], t('!name field is required.', array('!name' => $element['title']['#title'])));
    }
  }
}

