ABOUT:
=========
 * @version 1.6
 * @author WeDoWeb.com.au | contact@wedoweb.com.au
 * @copyright (c) 2014

Linking multiple products into series is now easier than ever.
Here's what you need: Product Series Extension

With this extension, you can now link multiple products into a collection or series.
Customers can see images and links to other products in the same series or collection with the one they are viewing.

Please note that this module is an alternate version of Color Series, only one can be used at a time not both.
You can update from Color Series to Product Series but all existing colors will be lost.

FEATURES:
==================
This mod enhances your OpenCart store with the ability to:
- Create Product Series that link to multiple products.
- Assign images to items in a series.
- Products in the same series are displayed in category and product pages.
Whenever viewing any product, users can also see all other products in the same series

DEMO:
==================
Front-end
http://wedoweb.com.au/pds/index.php?route=product/category&path=59

Admin (demo/demo)
http://wedoweb.com.au/pds/admin

COMPATIBILITY:
==================
- OpenCart 1.5.0-2, MijoShop
- Support OpenCart multi-store. You want Striped products to be visible only on your Women Store, Plain ones - only Men Store, and Colourful ones - on both? Sure you can.
- Export/Import extension
- Shoppica2 theme, RGen Cupid, Ribbon... themes
- Compatible with most themes
PLUS
Customising the mod to work with your theme (custom or not) is provided at no extra cost

FRESH INSTALL (OPENCART):
==================
-If you have not, install VqMod on your OpenCart store. The latest version can be downloaded from http://code.google.com/p/vqmod/
-Make sure VqMod has been installed completely and is running by browsing to YOUR_SITE/vqmod/install. It must displays VQMOD ALREADY INSTALLED!
-Upload admin, catalog, vqmod folders to your OpenCart store directory (no core files will be overwritten)
-If you use Export/Import extension, also upload extra/product_series_export_import.xml to vqmod/xml folder
-Enable permission: System/User/User Groups/Top Administrator, enable access and modify permissions for module/pds
-IMPORTANT: Go to Extensions/Modules and choose to install Product Series
-Choose to Edit Product Series and configure as needed

FRESH INSTALL (MIJOSHOP):
==================
-Upload admin, catalog and vqmod folders to components\com_mijoshop\opencart (no core files will be overwritten, so no need to worry)
-Go to Administration/Components/Mijoshop/Dashboard
-Go to Modules and choose to install Product Series
-Go to System/User/User Groups/Top Administrator, and enable access and modify permissions for module/pds
-Go back to Modules and choose to edit Product Series, configure as needed

UPDATE FROM AN OLDER VERSION:
==================
-Upload admin, catalog and vqmod folders to your OpenCart store directory
-If you use Export/Import extension, also upload extra/product_series_export_import.xml to vqmod/xml folder
-Go to Admin/Extensions/Modules and choose to edit Product Series
-Configure as needed

UPGRADE FROM COLOR SERIES MOD:
==================
-Upload admin, catalog, pds and vqmod folders to your OpenCart store directory, select to overwrite existing files (no core files will be overwritten, only old files from Color Series mod)
-Delete all xml files that has name start with "color_series" in vqmod\xml
-Open YOUR_STORE_SITE/pds/update (e.g http://awesomestore.com/pds/update) using your browser.
There will be a SUCCESS message indicating the mod has been updated successfully.
-Delete pds folder
-Enable permission: System/User/User Groups/Top Administrator, enable access and modify permissions for module/pds
-Go to Extensions/Modules and choose to install Product Series
-Choose to Edit Product Series and configure as needed

HOW TO USE:
==================
+ CREATE A SERIES FROM EXISTING PRODUCTS:
- From Product List page, select one or more products to be added to the new Series (by checking the checkboxes on the left)
- Click "Create Series" button on the top right
- A new Series will be created and added to the list

OR

- Insert a New Product or Edit an existing one
- Enter all the require data (name, description, prices, images etc)
- Under Product Series Tab, select "This product Represents a Series"

+ ADD PRODUCTS TO AN EXISTING SERIES:
- Insert a New Product or Edit an existing one
- Enter all the require data (name, description, prices, images etc)
- Under Product Series Tab, select "This product Belongs to a Series"
- Select a Series Image (optional)
- Choose a Series to link to

+ EXAMPLE: you want a Series with 2 items: CoolNo1 and CoolNo2
- Select CoolNo1 and CoolNo2 from Product List
- Click "Create Series"
- A new Series will be created and named "CoolNo1 Series" (" Series" is appended to the first selected product's name)
- Rename the Series as needed.

OTHER LANGUAGES:
==================
Please find the guide to create new language files for a module on
http://blog.arvixe.com/opencart-translate-module-to-native-language/

You will need to copy and edit 3 files:
admin\language\english\catalog\pds.php
admin\language\english\module\pds.php
catalog\language\english\product\pds.php

SUPPORT:
==================
contact@wedoweb.com.au

CHANGELOG:
==================
v.1.6 (23/11/2014)
- OpenCart 2 compatible
- Code optimised
- RGen, Shoppica, Ultimatum, Lexux Royal themes compatible
- Bug fixes
v.1.5 (24/11/2013)
- Fix bugs
- Make compatible with Export Import (http://www.opencart.com/index.php?route=extension/extension/info&extension_id=17)
- Make compatible with Universum theme
v.1.4 (27/10/2013)
- Update: If "Allow purchasing Series Products" is enabled, then include Series Products under "In the same series" in product page
v.1.3 (28/09/2013)
- Add Thumbnail Hover Effect on Category page
v.1.2.2 (19/5/2013)
- Add MijoShop compatible version
- Fix minor bugs
v.1.2.1 (21/4/2013)
- Fix minor bugs
v.1.2 (31/3/2013)
- Add Control Panel (under Extensions/Modules/Product Series)
- Add option to allow customers to purchase Series Products
- Make compatible with Rgen Cupid theme
v.1.1.4 (28/2/2013)
- Make compatible with Total Import Pro
- Sort products in series by sort_order values
v.1.1.3
- Make compatible with OpenCart 1.5.5
v.1.1.2
- Make compatible with Ribbon theme (http://themeforest.net/item/ribbon-opencart-theme/1934645)
- Make compatible with Shoppica2 theme
- Make compatible with OpenCart 1.5.0-1.5.1
v.1.1.1
- Bugs fix
v.1.1
- New feature: Creating Product Series from product list
v.1
- Initial release

POWERED BY:
==================
Image Preview by Alen Grakalic (http://grakalic.com) 