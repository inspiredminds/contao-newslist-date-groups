<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Newslist Date Groups extension.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

namespace InspiredMinds\ContaoNewslistDateGroups\EventListener;

use Contao\FrontendTemplate;
use Contao\Module;
use Contao\ModuleNewsReader;
use InspiredMinds\ContaoNewslistDateGroups\Group\DateGroup;
use Symfony\Contracts\Service\ResetInterface;

class ParseArticlesListener implements ResetInterface
{
    private const DAY_GROUP = 'Ymd';
    private const MONTH_GROUP = 'Ym';
    private const YEAR_GROUP = 'Y';

    /**
     * @var array<string,array<string,DateGroup>>
     */
    private $groups;

    public function __construct()
    {
        $this->reset();
    }

    public function __invoke(FrontendTemplate $template, array $newsEntry, Module $module): void
    {
        if ($module instanceof ModuleNewsReader) {
            return;
        }

        $newsDate = (new \DateTimeImmutable())->setTimestamp((int) $newsEntry['date']);

        foreach ([self::DAY_GROUP, self::MONTH_GROUP, self::YEAR_GROUP] as $group) {
            $this->updateTemplate($template, $group, $newsDate);
        }
    }

    public function reset(): void
    {
        $this->groups = [
            self::DAY_GROUP => [],
            self::MONTH_GROUP => [],
            self::YEAR_GROUP => [],
        ];
    }

    private function updateTemplate(FrontendTemplate $template, string $group, \DateTimeImmutable $newsDate): void
    {
        $index = $newsDate->format($group);

        if (!isset($this->groups[$group][$index])) {
            $dateGroup = new DateGroup($newsDate, \count($this->groups[$group]) + 1);
            $this->groups[$group][$index] = $dateGroup;

            switch ($group) {
                case self::DAY_GROUP:
                    $template->dayGroup = $dateGroup;
                    break;
                case self::MONTH_GROUP:
                    $template->monthGroup = $dateGroup;
                    break;
                case self::YEAR_GROUP:
                    $template->yearGroup = $dateGroup;
                    break;
                default:
                    throw new \InvalidArgumentException('Unsupported group "'.$group.'".');
            }
        }
    }
}
