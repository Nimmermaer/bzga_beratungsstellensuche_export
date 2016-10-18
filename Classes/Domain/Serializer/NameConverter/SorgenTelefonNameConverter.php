<?php


namespace BZgA\BzgaBeratungsstellensucheExport\Domain\Serializer\NameConverter;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SorgenTelefonNameConverter implements NameConverterInterface
{

    /**
     * @var array
     */
    protected $mapNames = array(
        'external_id' => 'ID_intern',
        'title' => 'Name',
        'additional_address' => 'Adressenzusatz',
        'street' => 'Straße mit Hausnummer',
        'zip' => 'PLZ',
        'city' => 'Ort',
        'quarter' => 'Ortsteil',
        'state_etb' => 'Bundesland',
        'directions' => 'Anfahrt (ÖPNV)',
        'hotline' => 'Telefonnummer (Beratung)',
        'telephone' => 'Telefonnummer (Büro)',
        'mobile' => 'Mobil-Nr',
        'institution' => 'Träger',
        'notice' => 'Öffnungszeiten',
        'availability' => 'Telefonische Erreichbarkeit',
        'email_client' => 'Email der Einrichtung für Klienten',
        'email' => 'Email der Einrichtung für Notruf',
        'telefax' => 'Fax',
        'website' => 'Internet-Adresse',
        'list_of_categories' => 'Angebotsprofil',
        'type' => 'Art der Einrichtung',
        'description_etb' => 'Besonderheiten',
        'consulting_agreement' => 'Beratungsschein',
        'competence' => 'Beratungsfachkraft vertrauliche Geburt',
        'district' => 'Landkreis',
        'country' => 'Land',
        'contact_person_telephone' => 'Telefon zentrale Ansprechperson',
    );

    /**
     * @param string $propertyName
     * @throws \BadMethodCallException
     */
    public function normalize($propertyName)
    {
        $propertyName = GeneralUtility::camelCaseToLowerCaseUnderscored($propertyName);
        if (isset($this->mapNames[$propertyName])) {
            $propertyName = $this->mapNames[$propertyName];
        }

        return $propertyName;
    }

    /**
     * @param string $propertyName
     * @return mixed|string
     */
    public function denormalize($propertyName)
    {
        throw new \BadMethodCallException('This function is not implemented yet');
    }


}