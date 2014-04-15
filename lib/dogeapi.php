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
     
    private $api_key;
    private $valid_key = false;
    /**
     * cURL GET request driver
     */

    private function _request($method, $path, $args = array(), $api_key=true)
    {
        
        $args['dev']='03kdkj94kfj39slk4'; ////03kdkj94kfj39slk4
        if($args['dev']=='YOUR-DEV-KEY-HERE') $args['dev']=''; //NOTE: Version 2 API calls won't work without this dev key.
           
        // Generate cURL URL
        if($api_key==true) $url =  'https://www.dogeapi.com/wow/v2/?api_key=' . $this->api_key . $path;
        else $url =  'https://www.dogeapi.com/wow/v2/?a=' . $path;

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
    * DogeAPI API Key Set, Get, and Validation
    */
    public function set_key($key)
    {
        $this->api_key = $key;
        return $this->validate_key();
    }

    public function get_key($key)
    {
        return $this->api_key;
    }

    private function validate_key()
    {
        // Test if the key is valid by doing a simple balance check
        $validate = $this->_request('GET', '&a=get_balance');
        
        // Return true/false if key is valid
        if ($validate == "Invalid API Key")
            $this->valid_key = false;
        else
            $this->valid_key = true;
        return $this->valid_key;
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

    // get_current_price
    public function get_current_price($api_key=false)
    {
        return $this->_request('GET', '&a=get_current_price');
    } 


//New actions in API V2 are below
//https://www.dogeapi.com/api_documentation_v2


    //Creates a new user identified by {USER_ID} and returns their payment address. Each user has only one payment address.
    // /wow/v2/?api_key={API_KEY}&a=create_user&user_id={USER_ID}
    public function create_user($args = array())
    {
        return $this->_request('GET', '&a=create_user&user_id=', $args);
    } 


    //get_user_address
    //Returns the payment address assigned to the user with a given {USER_ID}
    // /wow/v2/?api_key={API_KEY}&a=get_user_address&user_id={USER_ID}
    public function get_user_address($args = array())
    {
        return $this->_request('GET', '&a=get_user_address', $args);
    } 



//get_user_balance
//Returns the balance of the user with a given {USER_ID}.
// /wow/v2/?api_key={API_KEY}&a=get_user_balance&user_id={USER_ID}
    public function get_user_balance($args = array())
    {
        return $this->_request('GET', '&a=get_user_balance', $args);
    } 


// withdraw_from_user
// Withdraws {AMOUNT_DOGE} from {USER_ID} to {PAYMENT_ADDRESS}. Requires your {PIN}
// /wow/v2/?api_key={API_KEY}&a=withdraw_from_user&user_id={USER_ID}&pin={PIN}&amount_doge={AMOUNT_DOGE}&payment_address={PAYMENT_ADDRESS}
 
    public function withdraw_from_user($args = array())
    {
        return $this->_request('GET', '&a=withdraw_from_user', $args);
    } 


// move_to_user
// Moves {AMOUNT_DOGE} to user with ID {TO_USER_ID} from user with ID {FROM_USER_ID}. There is no network fee for this transaction, just the DogeAPI fee.
// /wow/v2/?api_key={API_KEY}&a=move_to_user&to_user_id={TO_USER_ID}&from_user_id={FROM_USER_ID}&amount_doge={AMOUNT_DOGE}

    public function move_to_user($args = array())
    {
        return $this->_request('GET', '&a=move_to_user', $args);
    } 


//get_users
//Returns a list of users asssociated with your account with their balances.
// /wow/v2/?api_key={API_KEY}&a=get_users
    public function get_users($args = array())
    {
        return $this->_request('GET', '&a=get_users', $args);
    } 

//get_transactions
// Returns a list of the {NUMBER} most recent transactions matching the options. {USER_ID}, {PAYMENT_ADDRESS}, {LABEL}, and {TYPE} are all optional. The types are receive, send, move, and fee.
// /wow/v2/?api_key={API_KEY}&a=get_transactions&num={NUMBER}&type={TYPE}
    public function get_transactions($args = array())
    {
        return $this->_request('GET', '&a=get_transactions', $args);
    } 

//get_network_hashrate
//Returns the current network hashrate. This doesn't require an API key.
///wow/v2/?a=get_network_hashrate
    public function get_network_hashrate($api_key=false)
    {
        return $this->_request('GET', '&a=get_network_hashrate');
    } 

//get_info
//Returns current information, including price in USD/BTC, block count, difficulty, 5 minute price change, network hashrate, and API version. This doesn't require an API key.
///wow/v2/?a=get_info 
    public function get_info($api_key=false)
    {
        return $this->_request('GET', '&a=get_info');
    }

}
