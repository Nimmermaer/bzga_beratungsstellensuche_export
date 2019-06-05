<?php

namespace Bzga\BzgaBeratungsstellensucheExport\Domain\Serializer\NameConverter;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @author Sebastian Schreiber
 */
class SorgenTelefonNameConverter implements NameConverterInterface
{

    /**
     * @var array
     */
    protected $mapNames = [
        'external_id' => 'ID_intern',
        'title' => 'Name',
        'etb_additional_address' => 'Adressenzusatz',
        'street' => 'Straße mit Hausnummer',
        'zip' => 'PLZ',
        'city' => 'Ort',
        'etb_quarter' => 'Ortsteil',
        'etb_state' => 'Bundesland',
        'etb_directions' => 'Anfahrt (ÖPNV)',
        'hotline' => 'Telefonnummer (Beratung)',
        'telephone' => 'Telefonnummer (Büro)',
        'mobile' => 'Mobil-Nr',
        'institution' => 'Träger',
        'notice' => 'Öffnungszeiten',
        'etb_availability' => 'Telefonische Erreichbarkeit',
        'etb_email_client' => 'Email der Einrichtung für Klienten',
        'email' => 'Email der Einrichtung für Notruf',
        'telefax' => 'Fax',
        'website' => 'Internet-Adresse',
        'etb_categories' => 'Angebotsprofil',
        'etb_type' => 'Art der Einrichtung',
        'etb_description' => 'Besonderheiten',
        'consulting_agreement' => 'Beratungsschein',
        'etb_competence' => 'Beratungsfachkraft vertrauliche Geburt',
        'etb_district' => 'Landkreis',
        'etb_country' => 'Land',
        'etb_contact_person_telephone' => 'Telefon zentrale Ansprechperson',
    ];

    /**
     * @param string $propertyName
     * @throws \BadMethodCallException
     * @return string
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
     * @throws \BadMethodCallException
     */
    public function denormalize($propertyName)
    {
        throw new \BadMethodCallException('This function is not implemented yet');
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return array_map(
            '\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToLowerCamelCase',
            array_keys($this->mapNames)
        );
    }
}
