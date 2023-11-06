<?php 
namespace Drupal\timezone;

use Drupal\Core\Config\ConfigFactoryInterface;

class TimeService {
  protected $configFactory;

  public function __construct(ConfigFactoryInterface $configFactory) {
    $this->configFactory = $configFactory;
  }

  public function getConfig() {
    return $this->configFactory->getEditable('timezone.settings');
  }

  public function getTimeZone(){
    $config = $this->getConfig();
    $country = $config->get('country');
    $customTimezone = new \DateTimeZone('America/New_York');
    $currentTime = new \DateTime('now', $customTimezone);
    $formattedTime = $currentTime->format('Y-m-d H:i:s');
    return $formattedTime;
  }
}