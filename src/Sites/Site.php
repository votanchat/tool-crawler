<?php
namespace ChatVo\ToolCrawler\Sites;

abstract class Site{
    static string $url;
    abstract public function getCategories(): array;
    abstract public function getLinks(string $category): array;
    abstract public function getKeyWord(string $link): string;
}