<?php


namespace BZga\BzgaBeratungsstellensucheExport\Command;

use TYPO3\CMS\Extbase\Mvc\Controller\CommandController;
use BZgA\BzgaBeratungsstellensucheExport\Domain\Serializer\NameConverter\SorgenTelefonNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use BZgA\BzgaBeratungsstellensucheExport\Domain\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;

class ExportCommandController extends CommandController
{

    /**
     * @var \BZgA\BzgaBeratungsstellensuche\Domain\Repository\EntryRepository
     * @inject
     */
    protected $entryRepository;

    /**
     * Export entries to defined format
     *
     * @param string $type
     */
    public function exportCommand($type = 'csv')
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        // @TODO: Create factory for the type
        $nameConverter = new SorgenTelefonNameConverter();
        $normalizer = new ObjectNormalizer($classMetadataFactory, $nameConverter);
        $normalizer->setIgnoredAttributes();


        $serializer = new Serializer(
            array(
                $normalizer,
            ),
            array(
                new CsvEncoder('|'),
            )
        );
        $csvString = $serializer->serialize($this->entryRepository->findAll()->toArray(), 'csv', array('groups' => array('address')));
        \TYPO3\CMS\Core\Utility\DebugUtility::debug($csvString);
    }

}