<?php

namespace ChatVo\ToolCrawler\Sites;

use ChatVo\ToolCrawler\Sites\Site;
use Curl\Curl;

class Appliancesradar extends Site
{
    static string $url = 'https://appliancesradar.com';

    private $curl;

    public function __construct()
    {
        $this->curl = new Curl();
    }

    public function getCategories(): array
    {   
        $this->curl->get(static::$url);

        if ($this->curl->isSuccess()) {
            $header_link = explode('rel="" target=""> About</a>', $this->curl->response)[0];
            $re = '/<a class="nav-sub-link" href="(.*?)"/ms';
            preg_match_all($re, $header_link, $matches);
        }
        return $matches[1];
    }

    public function getLinks(string $category): array
    {   
        echo "getPage $category"."\n";
        $this->curl->get($category);

        $links = array();

        //get index of category
        if ($this->curl->isSuccess()) {
            $re = '/<a class="page-link fw600" href="(.*?)\?page=([0-9]+)"/ms';
            preg_match_all($re, $this->curl->response, $matches);

            if (isset($matches[2]) && count($matches[2]) > 1)
                $maxPage = max($matches[2]);
            else
                $maxPage = 1;
            for ($i = 1; $i <= $maxPage; $i++) {
                $url = $category . '?page=' . $i;
                echo "getLinks $url"."\n";

                $this->curl->get($url);
                if ($this->curl->isSuccess()) {
                    $re = '/<a class="viewdetail-img review-image" href="(.*?)"/ms';
                    preg_match_all($re, $this->curl->response, $matches);
                    $links = array_merge($links, $matches[1]);
                }
            }
        }

        return $links;
    }

    public function getKeyWord(string $link): string
    {
        $keyword = str_replace(['-', '/'], [' ', ''], $link);

        return ucfirst($keyword);
    }
}
