<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
require __DIR__.'/../../../vendor/authorizenet/authorizenet/autoload.php';
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

define("AUTHORIZENET_LOG_FILE", "phplog");
define('MERCHANT_LOGIN_ID','2xXz3hH7nBP');
define('MERCHANT_TRANSACTION_KEY','3TD5DxSa85j22KnA');
//define('MERCHANT_LOGIN_ID', '8p4Rj8peK6');
//define('MERCHANT_TRANSACTION_KEY', '2qnS89Kht66V66Zy');
define('RESPONSE_OK','OK');


class AuthorizeComponent extends Component
{
    
    public function charge_card($card = [] , $payment = [] , $customer = [])
    {
        /* Create a merchantAuthenticationType object with authentication details
           retrieved from the constants file */
        // echo MERCHANT_LOGIN_ID;exit;
        $return = [];
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(MERCHANT_LOGIN_ID);
        $merchantAuthentication->setTransactionKey(MERCHANT_TRANSACTION_KEY);

        // Set the transaction's refId
        $refId = 'ref' . time();
        $amount = $payment['amount'];
        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($card['number']);
        $creditCard->setExpirationDate($card['exp_date']);
        $creditCard->setCardCode($card['cvv']);

        // Add the payment data to a paymentType object
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        // Create order information
        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber($payment['invoice_no']);
        $order->setDescription($payment['description']);

        // Set the customer's Bill To address
        $customerAddress = new AnetAPI\CustomerAddressType();
        $customerAddress->setFirstName($customer['first_name']);
        $customerAddress->setLastName($customer['last_name']);
        $customerAddress->setCompany($customer['company']);
        $customerAddress->setAddress($customer['address']);
        $customerAddress->setCity(@$customer['city']);
        $customerAddress->setState(@$customer['state']);
        $customerAddress->setZip(@$customer['zip']);
        $customerAddress->setCountry(@$customer['country']);

        // Set the customer's identifying information
        $customerData = new AnetAPI\CustomerDataType();
        $customerData->setType("individual");
        $customerData->setId($customer['id']);
        $customerData->setEmail($customer['email']);

        // Add values for transaction settings
        $duplicateWindowSetting = new AnetAPI\SettingType();
        $duplicateWindowSetting->setSettingName("duplicateWindow");
        $duplicateWindowSetting->setSettingValue("1");

        // Add some merchant defined fields. These fields won't be stored with the transaction,
        // but will be echoed back in the response.
        // $merchantDefinedField1 = new AnetAPI\UserFieldType();
        // $merchantDefinedField1->setName("customerLoyaltyNum");
        // $merchantDefinedField1->setValue("1128836273");

        // $merchantDefinedField2 = new AnetAPI\UserFieldType();
        // $merchantDefinedField2->setName("favoriteColor");
        // $merchantDefinedField2->setValue("blue");

        // Create a TransactionRequestType object and add the previous objects to it
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($amount);
        $transactionRequestType->setOrder($order);
        $transactionRequestType->setPayment($paymentOne);
        $transactionRequestType->setBillTo($customerAddress);
        $transactionRequestType->setCustomer($customerData);
        $transactionRequestType->addToTransactionSettings($duplicateWindowSetting);
        //$transactionRequestType->addToUserFields($merchantDefinedField1);
        //$transactionRequestType->addToUserFields($merchantDefinedField2);

        // Assemble the complete transaction request
        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setTransactionRequest($transactionRequestType);

        // Create the controller and get the response
        $controller = new AnetController\CreateTransactionController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
        // echo '<prE>'; print_r($response); die;

        if ($response != null) {
            // Check to see if the API request was successfully received and acted upon
            if ($response->getMessages()->getResultCode() == RESPONSE_OK) {
                // Since the API request was successful, look for a transaction response
                // and parse it to display the results of authorizing the card
                $tresponse = $response->getTransactionResponse();
                
                if ($tresponse != null && $tresponse->getMessages() != null) 
                {
                    $return['status'] = 200;
                    $return['transaction_id'] =  $tresponse->getTransId() ;
                    $return['reponse_code'] =  $tresponse->getResponseCode() ;
                    $return['message_code'] =  $tresponse->getMessages()[0]->getCode() ;
                    $return['auth_code'] =   $tresponse->getAuthCode() ;
                    $return['description'] =   $tresponse->getMessages()[0]->getDescription() ;
                } 
                else 
                {
                    $return['status'] = 400;
                    if ($tresponse->getErrors() != null) 
                    {
                        $return['error_code'] = $tresponse->getErrors()[0]->getErrorCode() ;
                        $return['error_message'] = $tresponse->getErrors()[0]->getErrorText();
                    }
                }
                // Or, print errors if the API request wasn't successful
                } 
                else 
                {
                   
                    $tresponse = $response->getTransactionResponse();
                    //print "<pre>";print_r($tresponse);exit;
                    if ($tresponse != null && $tresponse->getErrors() != null) {
                        $return['status'] = 400;
                        $return['error_code'] = $tresponse->getErrors()[0]->getErrorCode() ;
                        $return['error_message'] = $tresponse->getErrors()[0]->getErrorText() ;
                    } else {
                        //$return['status'] = 200;
                        $return['message_code'] = $response->getMessages()->getMessage()[0]->getCode() ;
                        $return['message'] = $response->getMessages()->getMessage()[0]->getText() ;
                        $return['transaction_id'] =  $tresponse->getTransId() ;
                    }
                }
            } 
            else 
            {
                $return['status'] = 400;
                $return['error_code'] = 000;
                $return['error_message'] = 'Empty Response.';
            }
        // echo '<prE>'; print_r($return); die;

        return $return;
}

function authorizeCreditCard($amount)
{
    /* Create a merchantAuthenticationType object with authentication details
       retrieved from the constants file */
    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
    $merchantAuthentication->setName(\SampleCode\Constants::MERCHANT_LOGIN_ID);
    $merchantAuthentication->setTransactionKey(\SampleCode\Constants::MERCHANT_TRANSACTION_KEY);
    
    // Set the transaction's refId
    $refId = 'ref' . time();

    // Create the payment data for a credit card
    $creditCard = new AnetAPI\CreditCardType();
    $creditCard->setCardNumber("4111111111111111");
    $creditCard->setExpirationDate("2038-12");
    $creditCard->setCardCode("123");

    // Add the payment data to a paymentType object
    $paymentOne = new AnetAPI\PaymentType();
    $paymentOne->setCreditCard($creditCard);

    // Create order information
    $order = new AnetAPI\OrderType();
    $order->setInvoiceNumber("10101");
    $order->setDescription("Golf Shirts");

    // Set the customer's Bill To address
    $customerAddress = new AnetAPI\CustomerAddressType();
    $customerAddress->setFirstName("Ellen");
    $customerAddress->setLastName("Johnson");
    $customerAddress->setCompany("Souveniropolis");
    $customerAddress->setAddress("14 Main Street");
    $customerAddress->setCity("Pecan Springs");
    $customerAddress->setState("TX");
    $customerAddress->setZip("44628");
    $customerAddress->setCountry("USA");

    // Set the customer's identifying information
    $customerData = new AnetAPI\CustomerDataType();
    $customerData->setType("individual");
    $customerData->setId("99999456654");
    $customerData->setEmail("EllenJohnson@example.com");

    // Add values for transaction settings
    $duplicateWindowSetting = new AnetAPI\SettingType();
    $duplicateWindowSetting->setSettingName("duplicateWindow");
    $duplicateWindowSetting->setSettingValue("60");

    // Add some merchant defined fields. These fields won't be stored with the transaction,
    // but will be echoed back in the response.
    $merchantDefinedField1 = new AnetAPI\UserFieldType();
    $merchantDefinedField1->setName("customerLoyaltyNum");
    $merchantDefinedField1->setValue("1128836273");

    $merchantDefinedField2 = new AnetAPI\UserFieldType();
    $merchantDefinedField2->setName("favoriteColor");
    $merchantDefinedField2->setValue("blue");

    // Create a TransactionRequestType object and add the previous objects to it
    $transactionRequestType = new AnetAPI\TransactionRequestType();
    $transactionRequestType->setTransactionType("authOnlyTransaction"); 
    $transactionRequestType->setAmount($amount);
    $transactionRequestType->setOrder($order);
    $transactionRequestType->setPayment($paymentOne);
    $transactionRequestType->setBillTo($customerAddress);
    $transactionRequestType->setCustomer($customerData);
    $transactionRequestType->addToTransactionSettings($duplicateWindowSetting);
    $transactionRequestType->addToUserFields($merchantDefinedField1);
    $transactionRequestType->addToUserFields($merchantDefinedField2);

    // Assemble the complete transaction request
    $request = new AnetAPI\CreateTransactionRequest();
    $request->setMerchantAuthentication($merchantAuthentication);
    $request->setRefId($refId);
    $request->setTransactionRequest($transactionRequestType);

    // Create the controller and get the response
    $controller = new AnetController\CreateTransactionController($request);
    $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);


    if ($response != null) {
        // Check to see if the API request was successfully received and acted upon
        if ($response->getMessages()->getResultCode() == \SampleCode\Constants::RESPONSE_OK) {
            // Since the API request was successful, look for a transaction response
            // and parse it to display the results of authorizing the card
            $tresponse = $response->getTransactionResponse();
        
            if ($tresponse != null && $tresponse->getMessages() != null) {
                echo " Successfully created transaction with Transaction ID: " . $tresponse->getTransId() . "\n";
                echo " Transaction Response Code: " . $tresponse->getResponseCode() . "\n";
                echo " Message Code: " . $tresponse->getMessages()[0]->getCode() . "\n";
                echo " Auth Code: " . $tresponse->getAuthCode() . "\n";
                echo " Description: " . $tresponse->getMessages()[0]->getDescription() . "\n";
            } else {
                echo "Transaction Failed \n";
                if ($tresponse->getErrors() != null) {
                    echo " Error Code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
                    echo " Error Message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";
                }
            }
            // Or, print errors if the API request wasn't successful
        } else {
            echo "Transaction Failed \n";
            $tresponse = $response->getTransactionResponse();
        
            if ($tresponse != null && $tresponse->getErrors() != null) {
                echo " Error Code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
                echo " Error Message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";
            } else {
                echo " Error Code  : " . $response->getMessages()->getMessage()[0]->getCode() . "\n";
                echo " Error Message : " . $response->getMessages()->getMessage()[0]->getText() . "\n";
            }
        }      
    } else {
        echo  "No response returned \n";
    }

    return $response;
}

function capturePreviouslyAuthorizedAmount($transactionid)
{
    /* Create a merchantAuthenticationType object with authentication details
       retrieved from the constants file */
    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
    $merchantAuthentication->setName(\SampleCode\Constants::MERCHANT_LOGIN_ID);
    $merchantAuthentication->setTransactionKey(\SampleCode\Constants::MERCHANT_TRANSACTION_KEY);
    
    // Set the transaction's refId
    $refId = 'ref' . time();

    // Now capture the previously authorized  amount
    echo "Capturing the Authorization with transaction ID : " . $transactionid . "\n";
    $transactionRequestType = new AnetAPI\TransactionRequestType();
    $transactionRequestType->setTransactionType("priorAuthCaptureTransaction");
    $transactionRequestType->setRefTransId($transactionid);

    
    $request = new AnetAPI\CreateTransactionRequest();
    $request->setMerchantAuthentication($merchantAuthentication);
    $request->setTransactionRequest( $transactionRequestType);

    $controller = new AnetController\CreateTransactionController($request);
    $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
    
    if ($response != null)
    {
      if($response->getMessages()->getResultCode() == \SampleCode\Constants::RESPONSE_OK)
      {
        $tresponse = $response->getTransactionResponse();
        
          if ($tresponse != null && $tresponse->getMessages() != null)   
        {
            echo " Transaction Response code : " . $tresponse->getResponseCode() . "\n";
            echo "Successful." . "\n";
            echo "Capture Previously Authorized Amount, Trans ID : " . $tresponse->getRefTransId() . "\n";
            echo " Code : " . $tresponse->getMessages()[0]->getCode() . "\n"; 
              echo " Description : " . $tresponse->getMessages()[0]->getDescription() . "\n";
        }
        else
        {
          echo "Transaction Failed \n";
          if($tresponse->getErrors() != null)
          {
            echo " Error code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
            echo " Error message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";            
          }
        }
      }
      else
      {
        echo "Transaction Failed \n";
        $tresponse = $response->getTransactionResponse();
        if($tresponse != null && $tresponse->getErrors() != null)
        {
          echo " Error code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
          echo " Error message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";                      
        }
        else
        {
          echo " Error code  : " . $response->getMessages()->getMessage()[0]->getCode() . "\n";
          echo " Error message : " . $response->getMessages()->getMessage()[0]->getText() . "\n";
        }
      }      
    }
    else
    {
      echo  "No response returned \n";
    }

    return $response;
  }



}


?>