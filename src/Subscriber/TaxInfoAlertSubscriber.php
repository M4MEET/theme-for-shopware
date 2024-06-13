<?php declare(strict_types=1);

/**
 * Namespace for the ThemeBattronGmbh plugin.
 */
namespace ThemeBattronGmbh\Subscriber;

use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Shopware\Storefront\Page\Product\ProductPageLoadedEvent;
use ThemeBattronGmbh\Struct\TaxInfoConfigStruct;
use Psr\Log\LoggerInterface;

/**
 * Class TaxInfoAlertSubscriber
 *
 * This class implements the EventSubscriberInterface and is used to handle the ProductPageLoadedEvent.
 * It subscribes to the ProductPageLoadedEvent and defines the method onProductPageLoaded to handle the event.
 */
class TaxInfoAlertSubscriber implements EventSubscriberInterface
{
    /**
     * @var SystemConfigService The service for system configuration.
     */
    private SystemConfigService $systemConfigService;

    /**
     * @var LoggerInterface The logger service.
     */
    private LoggerInterface $logger;

    /**
     * TaxInfoAlertSubscriber constructor.
     *
     * @param SystemConfigService $systemConfigService The service for system configuration.
     * @param LoggerInterface $logger The logger service.
     */
    public function __construct(SystemConfigService $systemConfigService, LoggerInterface $logger)
    {
        $this->systemConfigService = $systemConfigService;
        $this->logger = $logger;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array The event names to listen to.
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ProductPageLoadedEvent::class => 'onProductPageLoaded',
        ];
    }

    /**
     * Handles the ProductPageLoadedEvent.
     *
     * This method is called whenever a product page is loaded. It fetches the tax entity ID from the system configuration,
     * logs the tax entity ID, and if the tax entity ID is not null, it creates a new TaxInfoConfigStruct with the tax entity ID
     * and adds it as an extension to the product page. If the tax entity ID is null, it logs a warning.
     *
     * @param ProductPageLoadedEvent $event The event object.
     */
    public function onProductPageLoaded(ProductPageLoadedEvent $event): void
    {
        $configProductTaxId = $this->systemConfigService->get('ThemeBattronGmbh.config.taxEntity');
        $this->logger->info('Config Product Tax ID:', ['configProductTaxId' => $configProductTaxId]);

        if ($configProductTaxId) {
            $taxInfoConfigStruct = new TaxInfoConfigStruct($configProductTaxId);
            $event->getPage()->addExtension('configProductTaxId', $taxInfoConfigStruct);
            $this->logger->info('TaxInfoConfigStruct added:', ['taxInfoConfigStruct' => $taxInfoConfigStruct]);
        } else {
            $this->logger->warning('Config Product Tax ID is null or not set.');
        }
    }
}