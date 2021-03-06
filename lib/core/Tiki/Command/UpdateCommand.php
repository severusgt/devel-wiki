<?php
// (c) Copyright 2002-2016 by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id: UpdateCommand.php 64918 2017-12-15 18:34:34Z chealer $

namespace Tiki\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCommand extends Command
{
	protected function configure()
	{
		$this
			->setName('database:update')
			->setDescription('Update the database to the latest schema')
			->addOption(
				'auto-register',
				'a',
				InputOption::VALUE_NONE,
				'Record any failed patch as applied.'
			);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$autoRegister = $input->getOption('auto-register');
		$installer = new \Installer;
		$installed = $installer->tableExists('users_users');

		if ($installed) {
			$installer->update();
			$output->writeln('Update completed.');
			foreach (array_keys(\Patch::getPatches([\Patch::NEWLY_APPLIED])) as $patch) {
				$output->writeln("<info>Installed: $patch</info>");
			}
			foreach (array_keys(\Patch::getPatches([\Patch::NOT_APPLIED])) as $patch) {
				$output->writeln("<error>Failed: $patch</error>");

				if ($autoRegister) {
					\Patch::$list[$patch]->record();
				}
			}

			if (count($installer->executed)) {
				foreach ($installer->executed as $script) {
					$output->writeln("<info>Executed: $script</info>");
				}
			}

			$output->writeln('<info>Queries executed successfully: ' . count($installer->queries['successful']) . '</info>');

			if (count($installer->queries['failed'])) {
				foreach ($installer->queries['failed'] as $key => $error) {
					list( $query, $message, $patch ) = $error;

					$output->writeln("<error>Error $key in $patch\n\t$query\n\t$message</error>");
				}
			}

			$cachelib = \TikiLib::lib('cache');
			$cachelib->empty_cache();
		} else {
			$output->writeln('<error>Database not found.</error>');
		}
	}
}
