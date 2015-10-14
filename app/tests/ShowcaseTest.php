<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ShowcaseText
 *
 * @author kas
 */
class ShowcaseTest extends TestCase {

    function testMissingFeedUrl() {
        $response = $this->action('GET', 'ShowcaseController@renderShowcase', []);
        $expectedResponse = json_encode(array('responseCode' => 1, 'response' => 'Missing Feed url'));
        $this->assertJsonStringEqualsJsonString(
                $expectedResponse, $response->getContent()
        );
    }

    function testInvlidFeedUrl() {
        $response = $this->action('GET', 'ShowcaseController@renderShowcase', ['feed_url' => 'asda']);
        $expectedResponse = json_encode(array('responseCode' => 2, 'response' => 'Invalid Feed Url'));
        $this->assertJsonStringEqualsJsonString(
                $expectedResponse, $response->getContent()
        );
    }

    //http://s3.amazonaws.com/vodassets/showcase.json
    function testInvlidJsonResponse() {
        $response = $this->action('GET', 'ShowcaseController@renderShowcase', ['feed_url' => 'http://google.com']);
        $expectedResponse = json_encode(array('responseCode' => 3, 'response' => 'Response is not a valid json'));
        $this->assertJsonStringEqualsJsonString(
                $expectedResponse, $response->getContent()
        );
    }

    function testResponse() {
        $response = $this->action('GET', 'ShowcaseController@renderShowcase', ['feed_url' => 'http://s3.amazonaws.com/vodassets/showcase.json']);
        $response = json_decode($response->getContent());
        $this->assertEquals(200,$response->responseCode);
    }

}
