DogeAPI PHP
===========

PHP wrapper for [DogeAPI.com](https://www.dogeapi.com/) for use with [Dogecoin](http://dogecoin.com/). API key validation on instantiation, simple abstraction layer on top of existing API interfaces, and automatic JSON decoding on response.

Pull requests accepted and encouraged. :)

### Usage

First, sign up for an account at [DogeAPI.com](https://www.dogeapi.com/) and take note of your API key under Account > Settings

Download and include the dogeapi.php class:

~~~
require_once 'path/to/dogeapi.php';
~~~

Instantiate the class, passing through your unique API key. Will return `true` if the key validates. 

~~~
$doge = new DogeAPI('YOUR-API-KEY-HERE');

// Test that your API key is valid
if ($doge) {
  echo "Yay, it's a valid API key";
}

else {
  echo "That's not a valid API key";
}
~~~

The wrapper abstracts all methods listed at https://www.dogeapi.com/api_documentation using the same interface names. For example, to get your current account balance:

~~~
$balance =  $doge->get_balance();
echo $balance;
~~~

To make requests that require parameters (eg. an address label or address to withdraw to), pass through each parameter in an associative array. For example, the request below will withdraw 50 DOGE to the wallet you specify in place of `WALLET-ADDRESS-HERE`:

~~~
$withdraw = $doge->withdraw(array('amount' => 50, 'payment_address' => 'WALLET-ADDRESS-HERE'));
~~~

**Note:** Error checking has not been fully implemented, please enforce your own checks on top of the wrapper. 

### Other examples

Print an array of wallet addresses associated with your account:

~~~
$addresses = $doge->get_my_addresses();
print_r($addresses);
~~~

Print the current block the blockchain has reached:

~~~
echo $doge->get_current_block();
~~~




