<?php

/**
 * Adds a profile to an object, as well as fields to manage them.
 * Depends on and extends silverstripe-addressable
 * Depends uploadify
 *
 * This extensions also integrates with the {@link Geocoding} extension to
 * save co-ordinates on object write.
 *
 * @todo disable inherited functions that do not make sense no more
 * @package silverstripe-profileable
 * @package silverstripe-addressable
 */
class Profileable extends Addressable {
    
    public function __construct() {
		parent::__construct();
	}

    public function extraStatics() {
        return array('db' => array(
                'Name' => 'Varchar(255)',
                'Address' => 'Varchar(255)',
                'AddressAddition' => 'Varchar(255)',
                'Suburb' => 'varchar(64)',
                'State' => 'Varchar(64)',
                'Postcode' => 'Varchar(10)',
                'City' => 'varchar(64)',
                'Phone' => 'varchar(64)',
                'Fax' => 'varchar(64)',
                'Email' => 'varchar(64)',
                'Www' => 'varchar(64)',
                'Country' => 'Varchar(2)'
                ),
            'has_one' => array(
		"ProfilePicture" => "Image"
            ));
    }

    public function updateCMSFields($fields) {
        if ($fields->fieldByName('Root.Content')) {
            $tab = 'Root.Content.'. _t('Profileable.PROFILE', 'Profile');
        } else {
            $tab = 'Root.'. _t('Profileable.PROFILE', 'Profile');
        }

        $fields->addFieldsToTab($tab, $this->getProfileFields());
    }

    protected function getProfileFields() {
        $fields = array(
            new HeaderField('ProfileHeader', _t('Profileable.PROFILE', 'Profile')),
            new TextField('Name', _t('Profileable.NAME', 'Name')),
            new TextField('Address', _t('Addressable.ADDRESS', 'Address')),
            new TextField('AddressAddition', _t('Profilable.ADDRESSADDITION', 'Address Addition')),
            new TextField('Suburb', _t('Addressable.SUBURB', 'Suburb'))
            );

        $label = _t('Addressable.STATE', 'State');
        if (is_array($this->allowedStates)) {
            $fields[] = new DropdownField('State', $label, $this->allowedStates);
        } elseif (!is_string($this->allowedStates)) {
            $fields[] = new TextField('State', $label);
        }
        $fields[] = new TextField('City', _t('Profileable.CITY', 'City'));

        $postcode = new RegexTextField('Postcode', _t('Addressable.POSTCODE', 'Postcode'));
        $postcode->setRegex($this->postcodeRegex);
        $fields[] = $postcode;

        $label = _t('Addressable.COUNTRY', 'Country');
        if (is_array($this->allowedCountries)) {
            $fields[] = new DropdownField('Country', $label, $this->allowedCountries);
        } elseif (!is_string($this->allowedCountries)) {
            $fields[] = new CountryDropdownField('Country', $label);
        }
        
        $fields[] = new TextField('Phone', _t('Profileable.PHONE', 'Phone'));
        $fields[] = new TextField('Fax', _t('Profileable.FAX', 'Fax'));
        $fields[] = new EmailField('Email', _t('Profileable.EMAIL', 'E-Mail'));
        $fields[] = new TextField('Www', _t('Profileable.WWW', 'Homepage'));
        $fields[] = new ImageField ('ProfilePicture', _t('Profileable.PROFILEPICTURE', 'Profile Picture'));

        return $fields;
    }

    public function hasProfile() {
        return (
                $this->owner->Address
                && $this->owner->Suburb
                && $this->owner->State
                && $this->owner->Postcode
                && $this->owner->City
                && $this->owner->Country
                && $this->owner->Phone
                && $this->owner->Fax
                && $this->owner->Email
                && $this->owner->Www
                );
    }
    
    public function getFullProfile() {
		return sprintf('%s, %s, %s %d %s, %s, %s, %s',
			$this->owner->Address,
			$this->owner->Suburb,
			$this->owner->State,
			$this->owner->Postcode,
			$this->owner->City,
			$this->getCountryName(),
                        $this->owner->Phone,
                        $this->owner->Email,
			$this->owner->Www
			);
	}

    public function getFullProfileHTML() {
        return $this->owner->renderWith('Profile');
    }

    public function ProfileMap($width, $height) {
        $data = $this->owner->customise(array(
            'Width' => $width,
            'Height' => $height,
            'Address' => $this->getFullProfile()
                ));
        return $data->renderWith('AddressMap');
    }

}
