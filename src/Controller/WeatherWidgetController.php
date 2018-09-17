<?php

namespace Drupal\manifesto_test\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\manifesto_test\Weather;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class WeatherWidgetController.
 *
 * @package Drupal\manifesto_test\Controller
 */
class WeatherWidgetController extends ControllerBase {

  /**
   * The Weather service.
   *
   * @var \Drupal\manifesto_test\Weather
   */
  private $weather;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {

    return new static(
      $container->get('manifesto_test.fetch_weather')
    );
  }

  /**
   * Constructs dependencies.
   *
   * @param \Drupal\manifesto_test\Weather $weather
   *   The Weather service.
   */
  public function __construct(Weather $weather) {
    $this->weather = $weather;
  }

  /**
   * Return the Weather state using manifesto_test.fetch_weather service.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The Request data.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   JSON object.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function getWeather(Request $request) {

    $postcode = $request->get('postcode');
    if (empty($postcode)) {
      return new JsonResponse(['error' => 'Postcode is missing.']);
    }

    if ($weatherState = $this->weather->getWeather($postcode)) {
      return new JsonResponse(['weatherState' => $weatherState]);
    }

  }

}
