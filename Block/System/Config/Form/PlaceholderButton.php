<?php

namespace Devlat\RelatedProducts\Block\System\Config\Form;

use Magento\Config\Block\System\Config\Form\Field;

class PlaceholderButton extends Field
{
    const BUTTON_PLACEHOLDER_TEMPLATE = 'system/config/button/placeholder_button.phtml';

    protected function _prepareLayout()
    {
        //return parent::_prepareLayout(); // TODO: Change the autogenerated stub
        parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate(static::BUTTON_PLACEHOLDER_TEMPLATE);
        }
        return $this;
    }

    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $this->addData(
            [
                'id'            =>  'toggle_placeholder',
                'button_label'  =>  __('Enable'),
            ]
        );
        return $this->_toHtml();
    }
}