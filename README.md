Contao 4 Tracking Manager Bundle
================================


About
-----
With this extension you can easily add SVG icons from an icon-sprite file to your website via Contao Inserttags.


Installation
------------------

Install with ```composer require slashworks/contao-simple-svg-icons```.  
After updating the database, select the SVG icon sprite file in the settings of your theme. Use the new field **icon files** to select the SVG icon sprite file. The icons you can use are taken from this file.  
For an easy start, download the [example-sprite.svg][example-sprite-file] and place it inside the files folder of your contao installation.  

An SVG icon sprite file is a collection of multiple SVG icons, defined within a ```<symbol>```.  
The menu icon for example looks like this:
```html
<symbol viewBox="0 0 24 24" id="ic_menu_24px">
    <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
</symbol>
```
The important part for using this icon is the **id** of the symbol.
  
For further information about creating your own SVG icon sprite file you can check out [A Guide to Create and Use SVG Sprites](https://w3bits.com/svg-sprites/).


Usage
-----


Licensing
---------

This contao module is licensed under the terms of the LGPLv3.


Credits
-------

