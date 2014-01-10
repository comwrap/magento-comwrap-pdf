<?php

class Comwrap_Pdf_TestController extends Mage_Core_Controller_Front_Action
{
	public function invoiceAction()
	{
		echo Mage::getDesign()->getSkinBaseDir();
		/* @var $_block Comwrap_Pdf_Block_Invoice */
		$_block = $this->getLayout()->createBlock('comwrap_pdf/invoice');


		//$pdf = Mage::getModel('pdf/sales_order_pdf_invoice')->getPdf();
		return $this->_prepareDownloadResponse(
			'invoice.pdf', $_block->renderView(),
			'application/pdf'
		);
	}
}