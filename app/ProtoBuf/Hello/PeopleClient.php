<?php
// GENERATED CODE -- DO NOT EDIT!

namespace App\ProtoBuf\Hello;

/**
 */
class PeopleClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \App\ProtoBuf\Hello\Hello $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SayHello(\App\ProtoBuf\Hello\Hello $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/People/SayHello',
        $argument,
        ['\App\ProtoBuf\Hello\Hello', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \App\ProtoBuf\Hello\Hello $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SayHelloAgain(\App\ProtoBuf\Hello\Hello $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/People/SayHelloAgain',
        $argument,
        ['\App\ProtoBuf\Hello\Hello', 'decode'],
        $metadata, $options);
    }

}
