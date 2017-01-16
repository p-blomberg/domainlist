<?php
namespace App\Helper;
use \App\Helper\AppException;

use \LibDNS\Messages\MessageFactory;
use \LibDNS\Messages\MessageTypes;
use \LibDNS\Records\QuestionFactory;
use \LibDNS\Records\ResourceQTypes;
use \LibDNS\Encoder\EncoderFactory;
use \LibDNS\Decoder\DecoderFactory;

class Resolver {
	public static $serverip = '8.8.8.8'; // FIXME: should be configurable
	public static $timeout = 3; // FIXME: should be configurable

	public static function resolve($resource_types, $name) {
		// Most of this is stolen from https://github.com/DaveRandom/LibDNS/blob/master/examples/AQuery.php

		// Create question record
		$question = (new QuestionFactory)->create(constant('\LibDNS\Records\ResourceQTypes::'.$resource_types));
		$question->setName($name);

		// Create request message
		$request = (new MessageFactory)->create(MessageTypes::QUERY);
		$request->getQuestionRecords()->add($question);
		$request->isRecursionDesired(true);

		// Encode request message
		$encoder = (new EncoderFactory)->create();
		$requestPacket = $encoder->encode($request);

		// Send request
		$socket = stream_socket_client("udp://".self::$serverip.":53");
		stream_socket_sendto($socket, $requestPacket);
		$r = [$socket];
		$w = $e = [];
		if (!stream_select($r, $w, $e, self::$timeout)) {
			throw new AppException("Request timeout");
		}

		// Decode response message
		$decoder = (new DecoderFactory)->create();
		$responsePacket = fread($socket, 512);
		$response = $decoder->decode($responsePacket);

		// Handle response
		if ($response->getResponseCode() !== 0) {
			throw new AppException("Server returned error code " . $response->getResponseCode());
		}
		$answers = $response->getAnswerRecords();

		return $answers;
	}
}
