<?php

namespace App\Game\Infrastructure\Http;
use App\Game\Infrastructure\Kernel as KernelInterface;
use App\Game\Infrastructure\Request as RequestInterface;
use App\Game\Infrastructure\Response as ResponseInterface;

class Kernel implements KernelInterface {

    public static function createWithDataSet(array $dataset): static {
        return new static($dataset);
    }
    private function __construct(private array $dataset) {
        // TODO: it's mandatory to bootstrap this application so that the data used is the one provided in the dataset :D
    }

    public function run(RequestInterface $request): ResponseInterface {

        // TODO: Pending implementation :D
        $response = New Response(200, 'hello tictactoe!');
        return $response;
    }
}
