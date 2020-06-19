<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Newslist Date Groups extension.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

namespace InspiredMinds\ContaoNewslistDateGroups\Group;

final class DateGroup
{
    /**
     * @var \DateTimeImmutable
     */
    private $date;

    /**
     * @var int
     */
    private $index;

    public function __construct(\DateTimeImmutable $date, int $index)
    {
        $this->date = $date;
        $this->index = $index;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getIndex(): int
    {
        return $this->index;
    }
}
