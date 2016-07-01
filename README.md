SilverStripe Profileable Module
===============================

The Profileable module adds typical profile fields like address, email, profilepicture, etc to an object by extending the addressable module.
It inherits all functionality from the addressable module like automatic geocoding.

Requirements
------------
*  SilverStripe 3+
*  Addressable: https://github.com/ajshort/silverstripe-addressable

Quick Usage Overview
--------------------
Install the Addressable module first!
In order to add profile + address fields (name, address, suburb, city, postcode and
country, city, phone, fax, email, www, picture) to an object, simply apply to `Profileable` extension:

    Object::add_extension('Object', 'Profileable');

Run *dev/build* and you will have a Profile tab in your backend for the extended Object.

To render the Profile just call this in your template:
    $getFullProfileHTML
This will render the profile in semantic hContact mircroformat markup.

To configure the ProfilePicture Upload set this in your _config.php:

    Profileable::$ProfilePictureAllowedTypes = array('png');
    Profileable::$ProfilePictureFolder = 'youruploaddir';

You can use all functionality from the addressable module like:
**automatic geocoding**

    Object::add_extension('Object', 'Geocodable');

Or in _config.yml:

    MyPage:
      extensions:
        - Profileable
        - Geocodable

**define a global set of allowed states or countries**

    Profileable::set_allowed_countries(array('DE'=>'Deutschland'));

**render a GoogleMap**

    $ProfileMap(300,200)


--------------------------------------------------------------------
Released under
MIT License
(i.e., do whatever you want with this and use at your own risk)
