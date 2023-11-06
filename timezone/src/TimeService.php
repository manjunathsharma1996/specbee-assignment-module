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
    $city = $config->get('city');
    $timezone = $config->get('timezone');
    $customTimezone = new \DateTimeZone($timezone);
    $currentTime = new \DateTime('now', $customTimezone);
    $formattedTime = $currentTime->format('h:i A');
    $week_name = $currentTime->format('l');
    $date = $currentTime->format('jS F Y');

    $time_details = [];
    $time_details['time'] = $formattedTime;
    $time_details['week'] = $week_name;
    $time_details['date'] = $date;
    $time_details['country'] = $country;
    $time_details['city'] = $city;

    return $time_details;
  }
}