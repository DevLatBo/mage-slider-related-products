<?php

namespace Devlat\RelatedProducts\Controller\Adminhtml\Catalog;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Config\Model\ResourceModel\Config;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\FileSystemException;
use Magento\Store\Model\ScopeInterface;
use Devlat\RelatedProducts\Model\Config as PlaceholderConfig;
use Psr\Log\LoggerInterface as PsrLoggerInterface;

class ProductImage extends Action
{
    /**
     * @var JsonFactory
     */
    private JsonFactory $jsonFactory;
    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;
    /**
     * @var Config
     */
    private Config $config;
    /**
     * @var PlaceholderConfig
     */
    private PlaceholderConfig $placeholderConfig;
    /**
     * @var PsrLoggerInterface
     */
    private PsrLoggerInterface $logger;
    /**
     * @var string
     */
    private string $configPathCatalog;
    /**
     * @var string
     */
    private string $pathValue;

    /**
     * @param JsonFactory $jsonFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param Config $config
     * @param Context $context
     * @param PlaceholderConfig $placeholderConfig
     * @param PsrLoggerInterface $logger
     * @param string $configPathCatalog
     * @param string $pathValue
     */
    public function __construct(
        JsonFactory $jsonFactory,
        ScopeConfigInterface $scopeConfig,
        Config $config,
        Context $context,
        PlaceholderConfig $placeholderConfig,
        PsrLoggerInterface $logger,
        string $configPathCatalog = "",
        string $pathValue = ""
    )
    {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->scopeConfig = $scopeConfig;
        $this->config = $config;
        $this->placeholderConfig = $placeholderConfig;
        $this->logger = $logger;
        $this->configPathCatalog = $configPathCatalog;
        $this->pathValue = $pathValue;
    }

    /**
     * Add/Remove the custom placeholder image.
     * @return Json
     * @throws FileSystemException
     */
    public function execute(): Json
    {
        $this->logger->info(
            __("Ajax request started for placeholder image.")
        );
        $resultJson = null;
        $request = $this->getRequest();
        $resultJson = $this->jsonFactory->create();
        $resultJson->setData(
            [
                'message' => 'No data, it is not a Ajax Request'
            ]
        );
        if ($request->isXmlHttpRequest()) {
            $placeholderConfig = $this->scopeConfig->getValue($this->configPathCatalog, ScopeInterface::SCOPE_STORE);
            if (empty($placeholderConfig)) {
                $this->placeholderConfig->setPlaceholderImage();
                $resultJson->setData(
                    [
                        'message' => __('Placeholder Image has been set successfully.')
                    ]
                );
            }
            if ($placeholderConfig === $this->pathValue) {
                $this->config->saveConfig(
                    $this->configPathCatalog,
                    NULL,
                    'default',
                    0);
                $resultJson->setData(
                    [
                        'message' => __('Placeholder image has been removed.')
                    ]
                );
            }
        }
        $this->logger->info(
            __("Ajax Request successful.")
        );
        return $resultJson;
    }

    /**
     * Defines permissions by Checking the access control (ACL).
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('Devlat_RelatedProducts::related');
    }
}
