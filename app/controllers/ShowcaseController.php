<?php

class ShowcaseController extends BaseController {

    public function __construct(GuzzleHttp\Client $client) {
        $this->client = $client;
    }


}
