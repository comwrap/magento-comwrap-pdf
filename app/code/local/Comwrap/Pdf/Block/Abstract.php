<?php
/**
 * Class Comwrap_Pdf_Block_Abstract
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 *
 *
 * @license GPL 2.0
 * @package Comwrap/Pdf/Block
 * @author Thomas Spigel <tspigel@comwrap.com>
 * @version 1.0
 */
abstract class Comwrap_Pdf_Block_Abstract extends Mage_Core_Block_Template
{


	public function _construct()
	{
		$this->setArea('frontend');
		Mage::getSingleton('core/app_emulation');

		return parent::_construct();
	}

	public function renderView()
	{
		$this->setScriptPath(Mage::getBaseDir('design'));

		$html = $this->fetchView($this->getTemplateFile());

		/* @var $_pdf Comwrap_Pdf_Model_Resource_Abstract */
		$_pdf = Mage::getModel('comwrap_pdf/resource_' . $this->getPdfType());

		return $_pdf->render($html);
	}


	/**
	 * Alias for renderView()
	 *
	 * Some core functions will call this one for rendering the pdf. It returns the binary PDF object,
	 * as the Zend_PDF->render() class does
	 *
	 * @return string
	 */
	public function render()
	{
		return $this->renderView();
	}

    /**
     * Retrieve subtotal price include tax html formated content
     *
     * @param Varien_Object $item
     * @return string
     */
    public function displayShippingPriceInclTax($order)
    {
        $shipping = $order->getShippingInclTax();
        if ($shipping) {
            $baseShipping = $order->getBaseShippingInclTax();
        } else {
            $shipping       = $order->getShippingAmount()+$order->getShippingTaxAmount();
            $baseShipping   = $order->getBaseShippingAmount()+$order->getBaseShippingTaxAmount();
        }
        return $this->helper('adminhtml/sales')->displayPrices($order, $baseShipping, $shipping, false, ' ');
    }


	public function startEmulateEnvironment($storeId)
	{
		if(!$storeId) throw new Exception('Incorrect store ID while rendering the PDF');

		$_emulator = Mage::getSingleton('core/app_emulation');
		$parameters = $_emulator->startEnvironmentEmulation($storeId);

		$this->setCurrentAppParameters($parameters);
		return $this;
	}

	public function stopEmulateEnvironment()
	{
		$_emulator = Mage::getSingleton('core/app_emulation');
		$_emulator->stopEnvironmentEmulation($this->getCurrentAppParameters());

		return $this;
	}
}