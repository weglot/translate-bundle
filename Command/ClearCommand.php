<?php

namespace Weglot\TranslateBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CacheClearCommand extends Command
{
    protected static $defaultName = 'weglot:cache:clear';

    /**
     * @var null|ContainerBuilder
     */
    protected $container = null;

    /**
     * CacheClearCommand constructor.
     * @param $container
     */
    public function __construct($container)
    {
        $this->setContainer($container);

        parent::__construct();
    }

    /**
     * @param $container
     * @return $this
     */
    protected function setContainer($container)
    {
        $this->container = $container;

        return $this;
    }

    protected function getContainer()
    {
        return $this->container;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName(self::$defaultName)
            ->setDescription('Clear translations cache.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return bool
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $adapter = $this->getContainer()->get('weglot_translate.cache.translations');
        return $adapter->clear();
    }
}
