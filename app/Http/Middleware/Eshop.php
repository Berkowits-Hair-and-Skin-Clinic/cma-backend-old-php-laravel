<?php 
namespace App\Http\Middleware;
use Closure;
use Sentinel;
use App\Posts;
use Illuminate\Support\Facades\Http;

class Eshop{
    // Make request for getting blank Schema
    public static function create_vlc_products_checkout($productArray){
        $cartSchemaXML = Eshop::makeRequest(env('BERKOWITS_PRODUCT_API_URL')  . 'carts?schema=blank');
        $cartXML = simplexml_load_string($cartSchemaXML);
        $cartXML->cart->id_customer = 0;
        $cartXML->cart->id_currency = 2; // Replace with your currency ID
        $cartXML->cart->id_lang = 1; // Language ID
        if(!empty($request->id_product)){
        }
        // Convert to XML string and create cart
        $cartResponse = Eshop::makeRequest(env('BERKOWITS_PRODUCT_API_URL')  . 'carts', 'POST', $cartXML->asXML());
        $cartResponseXML = new \SimpleXMLElement($cartResponse);
        //var_dump($cartResponseXML);exit;
        $cart_id = (int)$cartResponseXML->cart->id;
        // ------------------------------------------------------

        // Retrieve the existing cart data
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, env('BERKOWITS_PRODUCT_API_URL') . "carts/$cart_id?output=XML");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . base64_encode(env('BERKOWITS_PRODUCT_API_KEY') . ':')
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        // Check if the response is valid
        if (!$response) {
            die("Error retrieving cart.");
        }
        // Load XML and modify the cart
        $xml = new \SimpleXMLElement($response);
        // ------------------------------------------------------

        /*$products = [
            ['id_product' => 20, 'id_product_attribute' => 0, 'quantity' => 1],
            ['id_product' => 21, 'id_product_attribute' => 0, 'quantity' => 1],
            ['id_product' => 22, 'id_product_attribute' => 0, 'quantity' => 1],
        ];*/
        $products=$productArray;
        foreach ($products as $product) {
            $new_product = $xml->cart->associations->cart_rows->addChild('cart_row');
            $new_product->addChild('id_product', $product['id_product'] ); // New Product ID
            $new_product->addChild('quantity', $product['quantity']); // Quantity
        }

         // ------------------------------------------------------

        // Convert XML back to string
        $updated_xml = $xml->asXML();
        // Send PUT request to update cart
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, env('BERKOWITS_PRODUCT_API_URL') . "carts/$cart_id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . base64_encode(env('BERKOWITS_PRODUCT_API_KEY') . ':'),
            'Content-Type: text/xml'
        ]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $updated_xml);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        //var_dump($cartId);exit;
        if ($httpCode == 200 || $httpCode == 201) {
            //echo "Cart updated successfully:\n$response";
            return $cart_id;
            //$response2['success'] = 1;
            //$response2['id_cart'] =$cart_id;
            //$response2['data'] =$response;
            //return json_encode($response2, JSON_NUMERIC_CHECK);
        } else{
            return false;
        }
        // ------------------------------------------------------
    }
    public static function makeRequest($url, $method = 'GET', $xml = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, env('BERKOWITS_PRODUCT_API_KEY').':');
    
        if ($xml) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: text/xml']);
        }
    
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    
        if ($httpCode >= 200 && $httpCode < 300) {
            return $response;
        } else {
            die("Error: HTTP Code " . $httpCode . "\nResponse: " . $response);
        }
    }
    // for any  post , put , patch on ecom webservice
    public static function arrayToXml($data, &$xmlData) {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                // If numeric key, set a generic name
                if (is_numeric($key)) {
                    $key = "item";
                }
                $subNode = $xmlData->addChild($key);
                self::arrayToXml($value, $subNode);
            } else {
                $xmlData->addChild($key, htmlspecialchars($value));
            }
        }
    }
    public static function addResource($resource,$method,$param){
        switch($resource){
            case 'order-payment-patch':
                $xml = simplexml_load_string('<prestashop/>');
                $orderPayment = $xml->addChild('order_payment');
                $orderPayment->addChild('id', $param['id']); 
                $orderPayment->addChild('transaction_id', $param['transaction_id']); 
                $xmlString = $xml->asXML();
                $response=self::curlEshopPost("order_payments","PATCH",$xmlString);
                return $response;
            break;
            case 'order-patch':
                $xml = simplexml_load_string('<prestashop/>');
                $order = $xml->addChild('order');
                $order->addChild('id', $param['id']); 
                $order->addChild('current_state', $param['current_state']); 
                $order->addChild('id_address_invoice', $param['id_address_invoice']); 
                $order->addChild('id_address_delivery', $param['id_address_delivery']); 
                $xmlString = $xml->asXML();
                $response=self::curlEshopPost("orders","PATCH",$xmlString);
                return $response;
            break;
            case 'orders':
                $xml = simplexml_load_string('<prestashop/>');
                //$address = $xml->children()->children();
                $address = $xml->addChild('order');
                $address->addChild('id_customer', $param['id_customer']); 
                $address->addChild('id_cart', $param['id_cart']);  // 109 for india in ecom
                $address->addChild('id_currency', 2); 
                $address->addChild('id_address_invoice', $param['id_address_invoice']); 
                $address->addChild('id_address_delivery', $param['id_address_delivery']); 
                $address->addChild('id_carrier', 10); 
                //$address->addChild('current_state', $param['current_state']); 
                $address->addChild('payment', $param['payment']); 
                $address->addChild('module', $param['module']); 
                $address->addChild('id_lang', 1); 
                $address->addChild('total_paid', $param['total_paid']); 
                $address->addChild('total_paid_real', $param['total_paid_real']); 
                $address->addChild('total_products', $param['total_products']); 
                $address->addChild('total_products_wt', $param['total_products_wt']); 
                $address->addChild('conversion_rate', $param['conversion_rate']); 
                $xmlString = $xml->asXML();
                $response=self::curlEshopPost($resource,"POST",$xmlString);
                return $response;
            break;

            case 'customers':
                if(empty($param['password'])){
                    $passwd=md5('Berkowith@123');
                }else{$passwd=md5($param['password']);}
                $xml = simplexml_load_string('<prestashop/>');
                $customer = $xml->addChild('customer');
                // Add customer details
                $customer->addChild('id_lang', '1');  // Language ID (1 = English)
                $customer->addChild('firstname', $param['firstname']);
                $customer->addChild('lastname', $param['lastname']);
                $customer->addChild('email', $param['email']);
                $customer->addChild('passwd', $passwd);  // PrestaShop requires MD5-hashed passwords
                $customer->addChild('active', '1');  // Set customer as active
                $customer->addChild('id_default_group', '3');  // Default group (e.g., Customer group)
                // Assign customer to the default group
                $associations = $customer->addChild('associations');
                $groups = $associations->addChild('groups');
                $group = $groups->addChild('group');
                $group->addChild('id', '3');  // Default group ID
                $xmlString = $xml->asXML();
                $response=self::curlEshopPost($resource,"POST",$xmlString);
                return $response;
            break;
            case 'addresses':
                $xml = simplexml_load_string('<prestashop/>');
                //$address = $xml->children()->children();
                $address = $xml->addChild('address');
                $address->addChild('id_customer', $param['id_customer']); 
                $address->addChild('id_country', 109);  // 109 for india in ecom
                $address->addChild('id_state', 0); 
                $address->addChild('alias', $param['alias']); 
                $address->addChild('lastname', $param['lastname']); 
                $address->addChild('firstname', $param['firstname']); 
                $address->addChild('address1', $param['address1']); 
                $address->addChild('address2', $param['address2']); 
                $address->addChild('postcode', $param['postcode']); 
                $address->addChild('city', $param['city']); 
                $address->addChild('phone', $param['phone']); 
                $address->addChild('phone_mobile', $param['phone_mobile']); 
                $xmlString = $xml->asXML();
                $response=self::curlEshopPost($resource,"POST",$xmlString);
                return $response;
            break;

        }
    }
    public static function curlEshopPost($resource,$method,$postfield){
        $apiurl=env('BERKOWITS_PRODUCT_API_URL').$resource;
        $authorizationKey = base64_encode(env('BERKOWITS_PRODUCT_API_KEY') . ':');
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL =>$apiurl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 100,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POSTFIELDS=>$postfield,
        CURLOPT_HTTPHEADER => [
            "Authorization: Basic $authorizationKey",
            "accept: application/json",
            "output_format: JSON"
        ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $data = json_decode($response, true); 
            return $data ;
        }
    }
    public static function curlEshop($apiurl,$method){
        $authorizationKey = base64_encode(env('BERKOWITS_PRODUCT_API_KEY') . ':');
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL =>$apiurl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 100,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => [
            "Authorization: Basic $authorizationKey",
            "accept: application/json",
            "output_format: JSON"
        ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $data = json_decode($response, true); 
            return $data ;
        }
    }

    public static function getEcomCustomerID($phone,$email){
        $apiurl=env('BERKOWITS_PRODUCT_API_URL')."customers/"."?display=[id]&filter[email]=[".$email."]";
        $custData=self::curlEshop($apiurl,"GET");
        if (isset($custData['customers']) && !empty($custData['customers'])) {
            $id_customer =  $custData['customers'][0]['id'];
            return $id_customer;
        }
        $apiurl=env('BERKOWITS_PRODUCT_API_URL')."addresses/"."?display=[id_customer]&filter[phone]=[".$phone."]";
        $custData=self::curlEshop($apiurl,"GET");
        if (isset($custData['addresses']) && !empty($custData['addresses'])) {
            $id_customer = $custData['addresses'][0]['id_customer'];
            return $id_customer;
        }
        return false;
    }
    public static function getLastOrderId($id_customer){
        $apiurl=env('BERKOWITS_PRODUCT_API_URL')."orders/"."?display=[id]&sort=[id_DESC]&limit=1&filter[id_customer]=[".$id_customer."]";
        $orderData=self::curlEshop($apiurl,"GET");
        if (isset($orderData['orders']) && !empty($orderData['orders'])) {
            $id_order =  $orderData['orders'][0]['id'];
            return $id_order;
        }else{
            return 0;
        }

    }

}
?>