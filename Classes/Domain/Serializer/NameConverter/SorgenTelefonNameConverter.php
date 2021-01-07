<?php

/*
 * This file is part of the "bzga_beratungsstellensuche_export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Bzga\BzgaBeratungsstellensucheExport\Domain\Serializer\NameConverter;

use BadMethodCallException;
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
    public static $mapNames = [
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
        'description' => 'Besonderheiten',
        'consulting_agreement' => 'Beratungsschein',
        'etb_competence' => 'Beratungsfachkraft vertrauliche Geburt',
        'etb_district' => 'Landkreis',
        'etb_country' => 'Land',
        'etb_contact_person_telephone' => 'Telefon zentrale Ansprechperson',
    ];

    /**
     * @inheritDoc
     */
    public function normalize($propertyName): string
    {
        $propertyName = GeneralUtility::camelCaseToLowerCaseUnderscored($propertyName);

        $propertyName = static::$mapNames[$propertyName] ?? $propertyName;

        return $propertyName;
    }

    /**
     * @inheritDoc
     */
    public function denormalize($propertyName)
    {
        throw new BadMethodCallException('This function is not implemented yet');
    }

    public function getProperties(): array
    {
        return array_map(
            '\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToLowerCamelCase',
            array_keys(static::$mapNames)
        );
    }
}
