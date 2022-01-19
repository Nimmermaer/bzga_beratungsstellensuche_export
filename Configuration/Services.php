<?php

declare(strict_types=1);

use Bzga\BzgaBeratungsstellensucheExport\Command\ExportCommand;
use Bzga\BzgaBeratungsstellensucheExport\Command\ExportToFileCommand;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->private()
        ->autowire()
        ->autoconfigure();
    $services->load('Bzga\\BzgaBeratungsstellensucheExport\\', __DIR__ . '/../Classes/')->exclude([
        __DIR__ . '/../Classes/Domain/Model',
    ]);

    // Add commands
    $services->set('console.command.beratungsstellensuche_export', ExportCommand::class)
        ->tag('console.command', [
            'command' => 'bzga:beratungsstellensuche:export',
            'schedulable' => true,
        ]);
    $services->set('console.command.beratungsstellensuche_export-to-file', ExportToFileCommand::class)
        ->tag('console.command', [
            'command' => 'bzga:beratungsstellensuche:export-to-file',
            'schedulable' => true,
        ]);
};
