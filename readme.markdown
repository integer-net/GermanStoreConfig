German Store Configuration for Magento CE
=====================
A preconfigured Magento CE installation for German Merchants

Facts
-----
- version: 1.0.0
- [On GitHub](https://github.com/integer-net/GermanStoreConfig)
- [direct download link](https://github.com/integer-net/GermanStoreConfig/archive/master.zip)

Description
-----------
This package is an extended Magento CE 1.7.0.2.
It provides a slightly modified installation process, a form to enter all relevant store data in one place which
is displayed on first admin user login. On completion of the form, caches are disabled and indices are refreshed.

A few useful and preconfigured modules are shipped with the distribution:
- German Language Pack
- FireGento_GermanSetup (for base settings and adjustments for the German market; will be called on form submit)
- FireGento_Pdf (to create better PDF invoices)
- DerModPro_BasePrice (for displaying the price per base unit, required in many cases according to German Laws)
- PRWD_Autoshipping (for displaying shipping costs in cart even when no shipping address is entered yet, see [this German blog entry](http://www.avs-webentwicklung.de/nc/blog/artikel/versandkosten-im-warenkorb-anzeigen.html))
- Phoenix_CashOnDelivery (Payment Method)
- Mage_Debit (Payment Method)
- IntegerNet_RemoveCustomerAccountLinks (for hiding unneeded links in customer account, see [this German blog entry](http://www.integer-net.de/benutzerkonto-magento-deaktivieren-von-menupunkten/))
- AvS_AdminNotificationAdvanced (for better handling of notifications, see [this German blog entry](http://www.avs-webentwicklung.de/nc/blog/artikel/magento-verbesserte-benachrichtigungen-im-admin-bereich.html))
- AvS_ScopeHint (to show conflicts in configuration, see [this German blog entry](http://www.avs-webentwicklung.de/nc/blog/artikel/warnung-bei-ueberschriebenen-konfigurations-optionen-kostenloses-magento-modul.html))
- Treynolds_Qconfig (to provide a quick search for the system configuration)
- Ikonoshirt_CustomAdminNotifications (to allow integration of additional news feeds)

On top, some core modules are disabled which are not needed for typical German Shops:
- Mage_Usa
- Mage_PaypalUk
- Mage_GoogleCheckout
- Mage_Authorizenet
- Mage_Centinel
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
1. Remove all files from your Magento installation
2. Delete the database

Support
-------
If you have any issues with this extension, open an issue on [GitHub](https://github.com/integer-net/GermanStoreConfig/issues).

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
(c) 2012-2013 integer_net GmbH

Thanks to
---------
- [Magento Inc.](http://www.magentocommerce.com/) for the Magento Community Edition
- Thomas Fleck and the [Netresearch App Factory](http://www.nr-apps.com) for ideas, cooperation, marketing and support
- the [FireGento team](https://github.com/firegento) for [GermanSetup](https://github.com/firegento/firegento-germansetup) and [FireGento_Pdf](https://github.com/firegento/firegento-pdf)
- Rico Neitzel and Daniel Sasse for the [German Language Pack](https://github.com/riconeitzel/German_LocalePack_de_DE)
- [Phoenix Media](http://www.phoenix-media.eu) and [ITABS](http://www.itabs.de) for the payment modules
- Fabian Blechschmidt for [ideas regarding the default configuration](https://github.com/Schrank/DefaultDeveloperConfig) and his [module for allowing additional admin news feeds](https://github.com/ikonoshirt/CustomAdminNotifications)