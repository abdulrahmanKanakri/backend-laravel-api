<?php

namespace App\Enums;

abstract class Categories extends BaseEnum
{
    const TECHNOLOGY = 'Technology';
    const MOVIES = 'Movies';
    const HEALTH = 'Health';
    const FOOD = 'Food';
    const MUSIC = 'Music';
    const SCIENCE = 'Science';
    const BOOKS = 'Books';
    const TRAVEL = 'Travel';
    const BUSINESS = 'Business';
    const HISTORY = 'History';
    const SPORTS = 'Sports';
    const ARTS = 'Arts';
    const WORLD = 'World';
    const POLITICAL = 'political';

    /**
     * @return array<string, array<int, string>>
     */
    public static function getSourceCategories(string $source): array
    {
        switch ($source) {
            case Sources::NEW_YORK_TIMES:
                return [
                    Categories::BOOKS     => ['Books'],
                    Categories::BUSINESS  => ['Business Day'],
                    Categories::HISTORY   => ['Archives'],
                    Categories::SPORTS    => ['Sports'],
                    Categories::ARTS      => ['Arts', 'Style'],
                    Categories::WORLD     => ['World'],
                    Categories::POLITICAL => ['New York', 'U.S.', 'Opinion'],
                ];
            case Sources::THE_GUARDIAN:
                return [
                    Categories::TECHNOLOGY => [
                        'technology', 'working-in-development', 'teacher-network',
                        'enterprise-network', 'games', 'global-development',
                        'global-development-professionals-network',
                        'government-computing-network', 'housing-network'
                    ],
                    Categories::MOVIES => ['film'],
                    Categories::HEALTH => ['healthcare-network', 'social-care-network'],
                    Categories::FOOD => ['food'],
                    Categories::MUSIC => ['music'],
                    Categories::SCIENCE => ['science'],
                    Categories::BOOKS => ['books', 'childrens-books-site'],
                    Categories::TRAVEL => ['travel', 'travel/offers'],
                    Categories::BUSINESS => ['money', 'small-business-network', 'better-business', 'business', 'business-to-business'],
                    Categories::HISTORY => ['culture', 'culture-network', 'culture-professionals-network'],
                    Categories::SPORTS => ['sport', 'football'],
                    Categories::ARTS => ['artanddesign', 'fashion', 'lifeandstyle'],
                    Categories::WORLD => [
                        'world', 'weather', 'animals-farmed', 'inequality',
                        'uk-news', 'us-news', 'australia-news', 'theguardian'
                    ],
                    Categories::POLITICAL => ['news', 'politics', 'public-leaders-network', 'law'],
                ];
            case Sources::BBC_NEWS:
                return [
                    Categories::TECHNOLOGY => ['technology'],
                    Categories::SCIENCE => ['science'],
                    Categories::SPORTS => ['sports'],
                    Categories::HEALTH => ['health'],
                    Categories::MOVIES => ['entertainment'],
                    Categories::MUSIC => ['entertainment'],
                    Categories::ARTS => ['entertainment'],
                    Categories::BUSINESS => ['business'],
                    Categories::WORLD => ['general'],
                    Categories::HISTORY => ['general'],
                    Categories::POLITICAL => ['general'],
                ];
            case Sources::CBC_NEWS:
                return [
                    Categories::TECHNOLOGY => ['technology'],
                    Categories::SCIENCE => ['science'],
                    Categories::SPORTS => ['sports'],
                    Categories::HEALTH => ['health'],
                    Categories::MOVIES => ['entertainment'],
                    Categories::MUSIC => ['entertainment'],
                    Categories::ARTS => ['entertainment'],
                    Categories::BUSINESS => ['business'],
                    Categories::WORLD => ['general'],
                    Categories::HISTORY => ['general'],
                    Categories::POLITICAL => ['general'],
                ];
            default:
                return [];
        }
    }
}
