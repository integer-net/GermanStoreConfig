German Distribution for Magento (GDM)
=====================
A preconfigured Magento CE installation for German Merchants

Facts
-----
- version: 0.1.0 (beta)
- [On GitHub](https://github.com/avstudnitz/GDM)
- [direct download link](https://github.com/avstudnitz/GDM/archive/master.zip)

Description
-----------
This package is an extended Magento CE 1.7.0.2.
It provides a slightly modified installation process, a form to enter all relevant store data in one place which
is displayed on first admin user login. On completion of the form, caches are disabled and indices are refreshed.

A few useful and preconfigured modules are shipped with the distribution:
- German Language Pack
- FireGento_GermanSetup (for base settings and adjustments for the German market; will be called on form submit)
- FireGento_Pdf (to create better PDF invoices)
- PRWD_Autoshipping (for displaying shipping costs even when no shipping address is entered yet)
- Phoenix_CashOnDelivery (Payment Method)
- Mage_Debit (Payment Method)
- IntegerNet_RemoveCustomerAccountLinks (for hiding unneeded links in customer account)
- AvS_AdminNotificationAdvanced (for better handling of notifications)
- AvS_ScopeHint (to show conflicts in configuration)

On top, some core modules are disabled which are not needed for typical German Shops:
- Mage_Usa
- Mage_PaypalUk
- Mage_GoogleCheckout
- Mage_Tag
- Mage_ProductAlert
- Mage_Authorizenet
- Mage_Centinel
- Mage_Compiler
- Mage_XmlConnect

Requirements
------------
- PHP >= 5.2.0
- MySQL >= 5.0.0

Installation Instructions
-------------------------
1. Clone the repository or copy the contents of the ZIP file to your htdocs directory
2. Run Installation process as usual
3. Log into admin, fill out and submit displayed form

Uninstallation
--------------
1. Remove all extension files from your Magento installation
2. Delete the database

Support
-------
If you have any issues with this extension, open an issue on [GitHub](https://github.com/avstudnitz/GDM/issues).

Contribution
------------
Any contribution is highly appreciated. The best way to contribute code is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

Developer
---------
Andreas von Studnitz, Christian Philipp, integer_net GmbH
[http://www.integer-net.de](http://www.integer-net.de)
[@integer_net](https://twitter.com/integer_net)

Licence
-------
[OSL - Open Software Licence 3.0](http://opensource.org/licenses/osl-3.0.php)

Copyright
---------
(c) 2012 integer_net GmbH
