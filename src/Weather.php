<?php

namespace Drupal\manifesto_test;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;

/**
 * Class Weather.
 */
class Weather {

  /**
   * API URI.
   *
   * @var string
   */
  private $baseURI = 'https://samples.openweathermap.org/data/2.5/weather';

  /**
   * Openweathermap APP ID.
   *
   * @var string
   */
  private $appID = 'b6907d289e10d714a6e88b30761fae22';

  /**
   * Country code.
   *
   * @var string
   */
  private $countryCode = 'uk';

  /**
   * Make a request to the Weather API and get the Weather state.
   *
   * @param string $postcode
   *   The passed Postcode.
   *
   * @return string|false
   *   Either the weather state or FALSE if it failed
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function getWeather($postcode) {

    $client = new Client();

    try {
      $response = $client->request('GET', $this->buildUri($postcode));
      $body = $response->getBody();
      $data = json_decode($body, TRUE);
      if (!empty($data['weather'][0]['main'])) {
        return $data['weather'][0]['main'];
      }
    }
    catch (RequestException $e) {
      watchdog_exception('manifesto_test', $e);
    }

    return FALSE;
  }

  /**
   * Construct Remote APU URI.
   *
   * @param string $postcode
   *   The passed Postcode.
   *
   * @return string
   *   Remote URI.
   */
  private function buildUri($postcode) {

    $query = http_build_query([
      'appid' => $this->appID,
      'zip' => "$postcode,$this->countryCode",
    ]);

    return $this->baseURI . '?' . $query;
  }

}
