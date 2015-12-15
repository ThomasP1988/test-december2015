<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Event;

class WeatherCommand extends ContainerAwareCommand
{
    protected $city;
    protected $dispatcher;
    protected $weatherManager;
    protected $weatherYahooApi;

    protected function configure()
    {
        $this
            ->setName('weather')
            ->setDescription('get weather of a city')
            ->addArgument(
                'city',
                InputArgument::REQUIRED,
                'place where we want to see weather'
            )
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output) {
        $this->city = $input->getArgument('city');
        $this->dispatcher = $this->getContainer()->get('event_dispatcher');
        $this->weatherManager = $this->getContainer()->get('weather.manager');
        $this->weatherYahooApi = $this->getContainer()->get('weather.yahoo.api');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->dispatcher->addListener('temperature.changed', function (Event $event) use ($output) {
            $output->writeln($event->getMessage());
        });

        $this->dispatcher->addListener('condition.changed', function (Event $event) use ($output) {
            $output->writeln($event->getMessage());
        });

        $currentWeather = $this->weatherYahooApi
            ->requestWeather($this->city);

        $this->weatherManager
            ->setCurrentCondition($currentWeather)
            ->setPreviousCondition()
        ;

        if($this->weatherManager->hasPreviousCondition()) {
            $this->weatherManager->compare();
        }

        $output->writeln($currentWeather->__toString());
    }

}
