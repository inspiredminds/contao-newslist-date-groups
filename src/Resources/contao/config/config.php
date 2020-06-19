<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Newslist Date Groups extension.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

use InspiredMinds\ContaoNewslistDateGroups\EventListener\ParseArticlesListener;

$GLOBALS['TL_HOOKS']['parseArticles'][] = [ParseArticlesListener::class, '__invoke'];
