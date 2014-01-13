Comwrap_Pdf
===========

A Magento module based on the PHP library for converting html files to PDF [mPDF](http://www.mpdf1.com/mpdf/index.php).

Comwrap_Pdf is a drop-in-replacement for the standard Zend_Pdf method of generating the PDF invoices/shipments/creditmemos with a more convenient method - with it, you can use the normal phtml templates, written in html/css/php. The html will then be 'converted' to pdf through the mPDF library.

This module is great for projects where pdf files need to be customized, as it gives the possibility for frontend developers to create the design instead, so no more backend development is needed for that matter.


The module should work 'as-is' and spit out pdfs which look almost like the default magento ones. 

**Current Module version**: 1.1.0

**Current mPDF version**: 5.6

**Tested under Magento versions**: 1.8.0


## Supported:
  * invoice, shipment and creditmemo PDFs overriden with their (p)html counterparts. Full drop-in replacement of the original magento PDFs
  * multistore (multilocale etc) and bulk creation of pdf files from admin
  * configurable/grouped products shown with their options (did not yet test fully with bundled products)
  * layout.xml block configuration
  * logos, images, barcodes, many css3 options, many html tags


## Installation

You have two ways to install it: with **composer** or **manually**.

### Composer installation

With composer, add this code to your composer.json in your magento root:

```json
  {
    "minimum-stability":"dev",
    "require":{
      "magento-hackathon/magento-composer-installer": "*",
      "comwrap/magento-comwrap-pdf": "*"
    },
    "repositories": [
      {
        "type": "git",
        "url": "https://github.com/magento-hackathon/magento-composer-installer"
      },
      {
        "type": "git",
        "url": "https://github.com/comwrap/magento-comwrap-pdf"
      }
    ],
    "extra": {
      "magento-root-dir": "./",
      "magento-deploystrategy": "copy"
    }
  }
```
Afterwards, run ``/path/to/composer install`` once to install it.

### Manual installation

If you want to install it manually, copy the files to design and code respectively.

## Usage

### For frontend developers (the styling part)

Please take a look first on the [mPDF manual](http://mpdf1.com/manual/index.php) to see what's supported.

The default template files are located in ``app/design/frontend/base/default/template/comwrap/pdf/``. Edit or override these phtml files in your own theme to match your needs. Every of these templates is getting it's own objects on load. For the invoice you can get the array of objects with ``$this->getInvoice()``, in shipment with ``$this->getShipment()``, and in the creditmemo with ``$this->getCreditmemo()``.

The objects are put into arrays because of the mass pdf download feature of the magento invoice admin grid. When doing mass pdf download, every invoice/shipping/creditmemo is put on a separate pdf page.


### For backend developers (under the hood)

This module is overriding the following core models:

* Comwrap_Pdf_Model_Sales_Order_Pdf_Invoice
* Comwrap_Pdf_Model_Sales_Order_Pdf_Shipment
* Comwrap_Pdf_Model_Sales_Order_Pdf_Creditmemo


Normally the models initialize a Zend_Pdf object and draw all informations through it. This snippet is taken from ``Mage_Adminhtml_Controller_Sales_Invoice``:
```php
public function printAction()
{
   if ($invoiceId = $this->getRequest()->getParam('invoice_id')) {
       if ($invoice = Mage::getModel('sales/order_invoice')->load($invoiceId)) {
           $pdf = Mage::getModel('sales/order_pdf_invoice')->getPdf(array($invoice));
           $this->_prepareDownloadResponse('invoice'.Mage::getSingleton('core/date')->date('Y-m-d_H-i-s').
               '.pdf', $pdf->render(), 'application/pdf');
       }
   }
   else {
       $this->_forward('noRoute');
   }
}
```

As you can see, the 'sales/order_pdf_invoice' model is called with the method getPdf. This function returns a Zend_Pdf object. Afterwards the download is prepared and the render method of Zend_Pdf is called.

Our module overrides first the getPdf method of the sales/order_pdf_* models, where a block for the currently called type of pdf (invoice/shipment/creditmemo) is created and returned. So in matter of fact you're getting a normal block object back on getPdf().

The block ``(Comwrap_Pdf_Block_[Creditmemo|Invoice|Shipment])`` returned works like a normal block, with one exception: when the ``render()`` (or ``renderView()``) method is called, the fetched html is passed through the resource model to the mPDF object and returned as binary PDF.



