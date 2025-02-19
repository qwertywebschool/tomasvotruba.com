<?php

declare(strict_types=1);

namespace App\Entity;

use App\Http\Controllers\PostController;
use DateTimeInterface;

/**
 * @api used in blade templates = @todo fix in tomasvotruba/unused-public
 */
final class Post
{
    public function __construct(
        private readonly int $id,
        private readonly string $title,
        private readonly string $slug,
        private readonly DateTimeInterface $dateTime,
        private readonly string $perex,
        private readonly string $content,
        private readonly ?DateTimeInterface $updatedAt,
        private readonly ?string $updatedMessage,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getClearTitle(): string
    {
        return str_replace(['&nbsp;', '?'], [' ', ''], $this->title);
    }

    public function getPerex(): string
    {
        return $this->perex;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getDateTime(): DateTimeInterface
    {
        return $this->dateTime;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function isUpdated(): bool
    {
        return $this->updatedAt instanceof DateTimeInterface;
    }

    public function getUpdatedMessage(): ?string
    {
        return $this->updatedMessage;
    }

    public function getYear(): int
    {
        return (int) $this->dateTime->format('Y');
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getAbsoluteUrl(): string
    {
        return action(PostController::class, [
            'slug' => $this->slug,
        ]);
    }
}
