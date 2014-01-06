<?php

/**
 * DogeAPI Wrapper
 * 
 * Requirements: cURL
 * 
 * @author Jackson Palmer <hello@ummjackson.com>
 * @version 0.1
 */
 
class DogeAPI
{
    
    /**
     * Validate the given API key on instantiation
     */
     
    private $key;

    function __construct($key)
    {
        // Set api_key property
        $this->api_key = $key;

        // Test if the key is valid by doing a simple balance check
        $validate = $this->_request('GET', '&a=get_balance');
        
        // Return true/false if key is valid
        return $validate ? true : false;
    }

    /**
     * cURL GET request driver
     */

    private function _request($method, $path, $args = array())
    {
        // Generate cURL URL
        $url =  'https://www.dogeapi.com/wow/?api_key=' . $this->api_key . $path;

        // Check for args and build query string
        if (!empty($args)) {
            $url .= '&' . http_build_query($args);
        }

        // Initiate cURL and set headers/options
        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the cURL request
        $result = curl_exec($ch);
        curl_close($ch);

        // Spit back the response object or fail
        return $result ? json_decode($result) : false;        
    }

    /**
     * Public methods (DogeAPI abstraction layer)
     */

    // get_balance
    public function get_balance()
    {
        return $this->_request('GET', '&a=get_balance');
    }

    // withdraw
    public function withdraw($args = array())
    {
        return $this->_request('GET', '&a=withdraw', $args);
    }

    // get_new_address
    public function get_new_address($args = array())
    {
        return $this->_request('GET', '&a=get_new_address', $args);
    }

    // get_my_addresses
    public function get_my_addresses()
    {
        return $this->_request('GET', '&a=get_my_addresses');
    }

    // get_address_received
    public function get_address_received($args = array())
    {
        return $this->_request('GET', '&a=get_address_received', $args);
    }

    // get_address_by_label
    public function get_address_by_label($args = array())
    {
        return $this->_request('GET', '&a=get_address_by_label', $args);
    }

    // get_difficulty
    public function get_difficulty()
    {
        return $this->_request('GET', '&a=get_difficulty');
    }

    // get_current_block
    public function get_current_block()
    {
        return $this->_request('GET', '&a=get_current_block');
    }   

}
