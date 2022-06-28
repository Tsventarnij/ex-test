<?php
namespace App\Command;

use App\Repository\TvSeriesMysqlRepo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\TvProgrammes as TvProgrammesService;

class TvProgrammes extends Command
{
    protected static $defaultName = 'app:tv-show';
    protected static $defaultDescription = 'Show next TV Series. Example --date="2022-06-29 10:30" --title="friends"';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $date = $input->getOption('date');
        $title = $input->getOption('title');
        $service = new TvProgrammesService(new TvSeriesMysqlRepo);
        $item = $service->getNext($date, $title);
        if ($item) {
            echo "$item->title on $item->channel at $item->time on $item->weekDay ($item->date)\n";
        }
        return SUCCESS;
    }

    protected function configure(): void
    {
        $this->setHelp('This command allows you to find tv show...')
            ->setDescription(self::$defaultDescription)
            ->addOption('date', 'd',InputArgument::OPTIONAL, 'Set date (YYYY-MM-DD HH:MM)', date("Y-m-d H:i"))
            ->addOption('title', 't',InputArgument::OPTIONAL, 'Show title', null);
    }
}