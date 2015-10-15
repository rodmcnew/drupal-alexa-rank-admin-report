<?php
namespace Drupal\alexa_rank_admin_report\Controller;

use Drupal\Core\Controller\ControllerBase;
use SimpleAlexaRank\SimpleAlexaRank\SimpleAlexaRank;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ReportController extends ControllerBase
{
    /**
     * @var SimpleAlexaRank
     */
    protected $alexaRankApi;

    /**
     * Instantiates a new instance of this class.
     *
     * This is a factory method that returns a new instance of this class. The
     * factory should pass any needed dependencies into the constructor of this
     * class, but not the container itself. Every call to this method must return
     * a new instance of this class; that is, it may not implement a singleton.
     *
     * @param ContainerInterface $container
     * @return static
     */
    public static function create(ContainerInterface $container)
    {
        return new self($container->get('alexa_rank'));
    }

    /**
     * Constructor
     *
     * @param SimpleAlexaRank $alexaRankApi
     */
    public function __construct(SimpleAlexaRank $alexaRankApi)
    {
        $this->alexaRankApi = $alexaRankApi;
    }

    public function content()
    {
        $this->alexaRankApi = \Drupal::service('alexa_rank');

        $domain = $_SERVER['HTTP_HOST'];
        $rank = $this->alexaRankApi->getGlobalRank($domain);

        return array(
            '#type' => 'markup',
            '#markup' => t(
                '@domain is ranked @rank on the Alexa global ranking.',
                [
                    '@domain' => $domain,
                    '@rank' => $rank
                ]
            )
        );
    }
}
