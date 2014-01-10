Pdf templating module for magento
==================================

A Magento module based on [mPDF](http://www.mpdf1.com/mpdf/index.php) which is a drop-in-replacement for the standard Zend_Pdf method of generating the PDF invoices/shipments/creditmemos with a more convenient method - with it, you can use the normal phtml templates, written in html/css/php. The html will then be 'converted' to pdf through the mPDF library.

This module is great for projects where pdf files need to be customized, as it gives the possibility for frontend developers to create the design instead, so no more backend development is needed for that matter.


The module should work 'as-is' and spit out pdfs which look almost like the default magento ones. 


## Supported:
  * invoice, shipment and creditmemo PDFs overriden with their (p)html counterparts. Full replacement of the original magento PDFs
  * multistore (multilocale etc) and bulk creation of pdf files from admin
  * configurable/grouped products shown with their options (did not yet test fully with bundled products)
  * layout.xml block configuration
  * logos, images, barcodes, many css options, many html tags


## Installation

You have two ways to install it: with composer or manually.

With composer, add this code to your composer.json in your magento root:

```
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

If you want to install it manually, copy the files to design and code respectively.

## Usage

Please take a look first on the [mPDF manual](http://mpdf1.com/manual/index.php) to see what's supported.

The default template files are located in app/design/frontend/base/default/template/comwrap/pdf/. Edit or override these phtml files in your own theme to match your needs. Every of these templates is getting it's own objects on load. For the invoice you can get the array of objects with $this->getInvoice(), in shipment with $this->getShipment(), and in the creditmemo with $this->getCreditmemo()


