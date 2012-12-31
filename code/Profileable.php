<?php

/**
 * Adds a profile to an object, as well as fields to manage them.
 * Depends on and extends silverstripe-addressable
 *
 * This extensions also integrates with the {@link Geocoding} extension to
 * save co-ordinates on object write.
 *
 * @package silverstripe-profileable
 * @package silverstripe-addressable
 */
class Profileable extends Addressable {

    public static $ProfilePictureAllowedTypes = array('jpg', 'gif', 'png');
    public static $ProfilePictureFolder = 'profilepictures';

    public function __construct() {
        parent::__construct();
    }

    public static $db = array(
        'ProfileName' => 'Varchar(255)',
        'Gender' => "Enum('m,f,u')",
        'AcademicTitle' => 'Varchar(20)',
        'Company' => 'Varchar(255)',
        'Position' => 'Varchar(255)',
        'Address' => 'Varchar(255)', //Street
        'AddressAddition' => 'Varchar(255)',
        'Suburb' => 'Varchar(64)',
        'State' => 'Varchar(255)',
        'Postcode' => 'Varchar(10)',
        'City' => 'Varchar(255)',
        'Phone' => 'Varchar(64)',
        'Fax' => 'Varchar(64)',
        //so we dont colide with member, if you want to decorate member
        'ProfileEmail' => 'Varchar(255)',
        'Www' => 'Varchar(255)',
        'Country' => 'Varchar(2)',
        'Description' => 'Text'
    );
    static $has_one = array(
        'ProfilePicture' => 'Image'
    );

    public function updateCMSFields(FieldList $fields) {
        if ($fields->fieldByName('Root.Content')) {
            $tab = 'Root.Content.' . _t('Profileable.PROFILE ', 'Profile');
        } else {
            $tab = 'Root.' . _t('Profileable.PROFILE ', 'Profile');
        }

        $fields->addFieldsToTab($tab, $this->getProfileFields());
    }

    protected function getProfileFields() {

        //TODO gender enum

        $postcode = new RegexTextField('Postcode', _t('Addressable.POSTCODE', 'Postcode'));
        $postcode->setRegex($this->postcodeRegex);

        $fields = array(
            new HeaderField('ProfileHeader', _t('Profileable.PROFILE', 'Profile')),
            new OptionsetField('Gender', _t('Profileable.GENDER', 'Gender'), array('m' => _t('Profileable.MASCULINE', 'masculine'), 'f' => _t('Profileable.FEMININE', 'feminine'), 'u' => _t('Profileable.UNKNOWN', 'unknown')), 'u'),
            new TextField('AcademicTitle', _t('Profileable.ACADEMICTITLE', 'Name')),
            new TextField('ProfileName', _t('Profileable.NAME', 'Name')),
            new TextField('Company', _t('Profileable.COMPANY', 'Company')),
            new TextField('Position', _t('Profileable.POSITION', 'Position')),
            new TextField('Address', _t('Addressable.ADDRESS', 'Address')),
            new TextField('AddressAddition', _t('Profileable.ADDRESSADDITION', 'Address Addition')),
            $postcode,
            new TextField('City', _t('Profileable.CITY', 'City')),
            new TextField('Suburb', _t('Addressable.SUBURB', 'Suburb'))
        );

        $label = _t('Addressable.STATE', 'State');
        if (is_array($this->allowedStates)) {
            $fields[] = new DropdownField('State', $label, $this->allowedStates);
        } elseif (!is_string($this->allowedStates)) {
            $fields[] = new TextField('State', $label);
        }

        $label = _t('Addressable.COUNTRY', 'Country');
        if (is_array($this->allowedCountries)) {
            $fields[] = new DropdownField('Country', $label, $this->allowedCountries);
        } elseif (!is_string($this->allowedCountries)) {
            $fields[] = new CountryDropdownField('Country', $label);
        }

        $fields[] = new TextField('Phone', _t('Profileable.PHONE', 'Phone'));
        $fields[] = new TextField('Fax', _t('Profileable.FAX', 'Fax'));
        $fields[] = new EmailField('ProfileEmail', _t('Profileable.EMAIL', 'E-Mail'));
        $fields[] = new TextField('Www', _t('Profileable.WWW', 'Homepage'));
        $profileUpload = new UploadField('ProfilePicture', _t('Profileable.PROFILEPICTURE', 'Profile Picture'));
        $profileUpload->allowedExtensions = self::$ProfilePictureAllowedTypes;
        $profileUpload->setFolderName(self::$ProfilePictureFolder);
        $profileUpload->setConfig('allowedMaxFileNumber', 1); 
        $fields[] = $profileUpload;
        $fields[] = new TextareaField('Description', _t('Profileable.DESCRIPTION', 'Description'));

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

    public function getFullName() {
        $n = array();
        switch ($this->owner->Gender) {
            case 'm':
                $n[] = _t('Profileable.MR', 'Mr');
                break;
            case 'f':
                $n[] = _t('Profileable.MS', 'Ms');
                break;
            default:
                break;
        }
        if (!empty($this->owner->AcademicTitle)) {
            $n[] = $this->owner->AcademicTitle;
        }
        //extends Member?
        if (isset($this->owner->FirstName) && isset($this->owner->Surname)) {
            $n[] = $this->owner->FirstName;
            $n[] = $this->owner->Surname;
        } else {
            $n[] = $this->owner->ProfileName;
        }
        return join(' ', $n);
    }

    public function getFullProfile() {
        return sprintf('%s, %s, %s %d %s, %s, %s, %s', $this->owner->Address, $this->owner->Suburb, $this->owner->State, $this->owner->Postcode, $this->owner->City, $this->getCountryName(), $this->owner->Phone, $this->owner->Email, $this->owner->Www
        );
    }

    public function getFullAddress() {
        return sprintf('%s, %s %d, %s', $this->owner->Address, $this->owner->Postcode, $this->owner->City, $this->getCountryName());
    }

    public function getFullProfileHTML() {
        return $this->owner->renderWith('Profile');
    }

    public function ProfileMap($width, $height) {
        $data = $this->owner->customise(array(
            'Width' => $width,
            'Height' => $height,
            'Address' => rawurlencode($this->getFullAddress())
                ));
        return $data->renderWith('AddressMap     

     ');
    }

}
