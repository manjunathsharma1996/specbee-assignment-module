<?php

namespace Drupal\timezone\Cache\Context;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Cache\Context\CacheContextInterface;
use Drupal\Core\Config\ConfigFactoryInterface;


/**
 * Defines the country cache context, for "time" caching.
 *
 * Cache context ID: 'time'.
 */
class TimeCacheContext implements CacheContextInterface {

  protected $configFactory;

  public function __construct(ConfigFactoryInterface $configFactory) {
    $this->configFactory = $configFactory;
  }

  /**
   * {@inheritdoc}
   */
  public static function getLabel() {
    return t('Time');
  }

  public function getConfig() {
    return $this->configFactory->getEditable('timezone.settings');
  }

  /**
   * {@inheritdoc}
   */
  public function getContext() {
    $config = $this->getConfig();
    $timezone = $config->get('timezone');
    $customTimezone = new \DateTimeZone($timezone);
    $currentTime = new \DateTime('now', $customTimezone);
    $formattedTime = $currentTime->format('h:i A');

    return $formattedTime;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheableMetadata() {
    return new CacheableMetadata();
  }

}
