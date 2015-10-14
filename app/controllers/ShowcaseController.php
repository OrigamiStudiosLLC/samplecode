<?php

class ShowcaseController extends BaseController {

    public function __construct(GuzzleHttp\Client $client) {
        $this->client = $client;
    }
	
	/**
	* Get Feed from the Feed URL.
	*
	*/
	public function getFeed() {
        if (!filter_var($this->feedUrl, FILTER_VALIDATE_URL) === false):
            $response = $this->client->get($this->feedUrl);
            if ($response->getStatusCode() == 200):
                $headers = $response->getHeaders();
                if (isset($headers['Content-Type']) && $headers['Content-Type'][0] == 'application/json'):
                    $this->feed = $response->json();
                else:
                    throw new Exception('Response is not a valid json', 3);
                endif;
                return $this;
            endif;
        else:
            throw new Exception('Invalid Feed Url', 2);
        endif;
    }
	
	/**
	* Extracts Images From the Feed.
	*
	*/
	public function extractImages() {
        if (!is_null($this->feed) && is_array($this->feed)):
            $data = [];
            foreach ($this->feed as $key => $item):
                if (isset($item['headline']) && isset($item['cardImages'])):
                    $data[] = ['title' => $item['headline'], 'images' => $item['keyArtImages']];
                endif;
            endforeach;
            return $data;
        else:
            throw new Exception('Feed is empty',4);
        endif;
    }
}