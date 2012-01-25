<?php defined('SYSPATH') or die('No direct script access.');
/**
 * PayPal ReferenceTransaction integration.
 *
 * @see  https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_api_ECGettingStarted
 *
 * @package    Paypal
 * @author     Thorsten Schau
 * @license    MIT
 */
class PayPal_ReferenceTransaction extends PayPal {

	// Default parameters
	protected $_default = array(
		'PAYMENTACTION' => 'Sale',
	);

	/**
	 * Run the Transaction
	 * @params array nvp params
	 **/
  public function DoReferenceTransaction(array $params)
  {
      $required = array('PAYMENTTYPE','CURRENCYCODE','AMT', 'DESC', 'REFERENCEID');
      
      $params += $this->_default;
      
      foreach ($required as $key) {
          if ( ! isset($params[$key])) {
              throw new Kohana_Exception('You must provide a :param parameter for :method',
                  array(':param' => $key, ':method' => __METHOD__));
          }
      }
      
      return $this->_post('DoReferenceTransaction', $params);
  }

		/**
		 * Create the actual BillingAgreement
		 * @params array params
		 **/
    public function CreateBillingAgreement(array $params)
    {
        $required = array('PAYERID','TOKEN');
        
        $params += $this->_default;
        
        foreach ($required as $key) {
            if ( ! isset($params[$key])) {
                throw new Kohana_Exception('You must provide a :param parameter for :method',
                    array(':param' => $key, ':method' => __METHOD__));
            }
        }
        
        return $this->_post('CreateBillingAgreement', $params);
    }
    
		/**
		 * Retrieve the BillingAgreementId from paypal
 		 * @params string token
 		 **/
    public function GetBillingAgreementCustomerDetails($token)
    {
	      if ( ! isset($token)) {
	          throw new Kohana_Exception('You must provide a token parameter for :method',
	              array(':method' => __METHOD__));
	      }	

        $params = array('TOKEN' => $token);
        $params += $this->_default;

        return $this->_post('GetBillingAgreementCustomerDetails', $params);
    }

	/**
	 * Set up the Billing Agreement.
	 * @param  array   NVP parameters
	 */
	public function SetCustomerBillingAgreement(array $params = NULL)
	{
		if ($params === NULL)
		{
			// Use the default parameters
			$params = $this->_default;
		}
		else
		{
			// Add the default parameters
			$params += $this->_default;
		}

		if ( ! isset($params['AMT']))
		{
			throw new Kohana_Exception('You must provide a :param parameter for :method',
				array(':param' => 'AMT', ':method' => __METHOD__));
		}

		return $this->_post('SetCustomerBillingAgreement', $params);
	}

} // End PayPal_ReferenceTransaction
