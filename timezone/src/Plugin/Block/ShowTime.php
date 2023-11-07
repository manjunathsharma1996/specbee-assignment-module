<?php
namespace Drupal\timezone\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a custom plugin block.
 *
 * @Block(
 *   id = "show_time",
 *   admin_label = @Translation("Show Time"),
 * )
 */
class ShowTime extends BlockBase implements ContainerFactoryPluginInterface{

  protected $container;

  /**
   * Constructs a new MyCustomBlock instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param ContainerInterface $container
   *   The service container.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ContainerInterface $container) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->container = $container;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Access the service container and get a service.
    $time_service = $this->container->get('timezone.timeservice');

    // Use the service to perform tasks.
    $time_details = $time_service->getTimeZone();

    return [
      '#theme' => 'show_time',
      '#time' => $time_details['time'],
      '#week_name' => $time_details['week'],
      '#date' => $time_details['date'],
      '#country' => $time_details['country'],
      '#city' => $time_details['city'],
      '#cache' => [
        'tags' => ['config:timezone.settings'],
        'contexts' => ['route','time'],
      ],
    ];
  }
}

