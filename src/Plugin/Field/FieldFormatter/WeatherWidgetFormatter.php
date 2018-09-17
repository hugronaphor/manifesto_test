<?php

namespace Drupal\manifesto_test\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'WeatherWidget' formatter.
 *
 * @FieldFormatter(
 *   id = "weather_widget",
 *   label = @Translation("Weather Widget"),
 *   field_types = {
 *     "string"
 *   }
 * )
 */
class WeatherWidgetFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t('Displays the weather for the given Postcode.');
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

    foreach ($items as $delta => $item) {
      $element[$delta] = [
        '#theme' => 'manifesto_test_weather',
        '#attached' => [
          'library' => ['manifesto_test/weather_widget'],
          'drupalSettings' => ['postcode' => $item->value],
        ],
      ];

    }

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [] + parent::defaultSettings();
  }

}
