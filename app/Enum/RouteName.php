<?php

declare(strict_types=1);

namespace App\Enum;

/**
 * @api
 * @todo make unused public cost work with Laravel and PHPStan
 */
final class RouteName
{
    /**
     * @var string
     */
    public const CONTACT = 'contact';

    /**
     * @var string
     */
    public const ABOUT = 'about';

    /**
     * @var string
     */
    public const HOMEPAGE = 'homepage';

    /**
     * @var string
     */
    public const POST_DETAIL = 'post_detail';

    /**
     * @var string
     */
    public const RSS = 'rss';

    /**
     * @var string
     */
    public const BLOG = 'blog';

    /**
     * @var string
     */
    public const BOOKS = 'books';

    /**
     * @var string
     */
    public const BOOK_DETAIL = 'book-detail';

    /**
     * @var string
     */
    public const POST_IMAGE = 'post-image';
}