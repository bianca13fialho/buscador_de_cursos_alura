<?php

namespace Bianca13fialho\BuscadorCursosAlura;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{

    private $httpClient;
    private $crawler;

    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }

    public function buscar(string $url): array
    {
        $resposta = $this->httpClient->request('GET', $url);

        $html = $resposta->getBody();

        $this->crawler->addHtmlContent($html);

        $elementos = $this->crawler->filter('.card-curso__nome');
        $cursos = [];

        foreach ($elementos as $elemento) {
            $cursos[] = $elemento->textContent;
        }

        return $cursos;
    }
}
