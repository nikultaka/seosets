<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

$orderID = 5355020;
$orderDate = date("Y-m-d H:i:s");
$status = 'open';
$name = 'Oven Burner Tube 20.25" (#703201)';
$sku = '';  
$brand = 'BlueStar';
$quantity = 1;
$taxable = 'yes';
$pricePerUnit = '$83.00';
$retailer = 'BLUESTAR';
$licensee = 'BlueStar';
$customerID = 9999;

$firstName = 'Kevin';
$lastName = 'Seldon';
$companyName = 'testing';
$address1 = '6189 Bank St.';
$address2 = '6189 Bank St.';
$city = 'Greely';
$state = 'Ontario';
$postalCode = 'k4p1b4';
$country = 'Canada';

$countryCode = 1;
$number = 8787878;
$description = 'Mobile';

$email = 'kseldon@hotmail.com';
$emailOptin = 'yes';
$activity= '';

$option = 'Economy (4-7 Days)';
$method = 'UPS - Standard';

$subTotal = '$116.00';
$shippingAmount = '$116.00';
$handling = '$116.00';
$tax = '$116.00';
$total = '$116.00';

$xml = new SimpleXMLElement('<orders/>');
$track = $xml->addChild('order');
$track->addAttribute("id",$orderID);
$track->addChild('date',$orderDate);
$track->addChild('status',$status);

$orders = $xml->addChild('items');

for($n = 0;$n<2;$n++) {
	$item = $orders->addChild('item');
	$item->addChild('name',$name);
	$item->addChild('configuration');
	$item->addChild('sku',$sku);
	$item->addChild('sku_alt');
	$item->addChild('sku_alt2');
	$item->addChild('brand',$brand);
	$item->addChild('licensee',$licensee);
	$item->addChild('retailer',$retailer);
	$item->addChild('price_per_unit',$pricePerUnit);
	$item->addChild('taxable',$taxable);
	$item->addChild('quantity',$quantity);
	$item->addChild('shipping_method');
	$item->addChild('notes');	
}

$customer = $xml->addChild('customer');
$customer->addAttribute("id",$customerID);


$billingAddress = $customer->addChild('billing_address');	
$billingAddress->addChild('first_name',$firstName);
$billingAddress->addChild('last_name',$lastName);
$billingAddress->addChild('company_name',$companyName);
$billingAddress->addChild('address1',$address1);
$billingAddress->addChild('address2',$address2);
$billingAddress->addChild('city',$city);
$billingAddress->addChild('state',$state);
$billingAddress->addChild('postal_code',$postalCode);
$billingAddress->addChild('country',$country);

$shippingAddress = $customer->addChild('shipping_address');	
$shippingAddress->addChild('first_name',$firstName);
$shippingAddress->addChild('last_name',$lastName);
$shippingAddress->addChild('company_name',$companyName);
$shippingAddress->addChild('address1',$address1);
$shippingAddress->addChild('address2',$address2);
$shippingAddress->addChild('city',$city);
$shippingAddress->addChild('state',$state);
$shippingAddress->addChild('postal_code',$postalCode);
$shippingAddress->addChild('country',$country);

$phone = $customer->addChild('phone');	    
$phone->addChild('country_code',$countryCode);
$phone->addChild('number',$number);
$phone->addChild('description',$description);

$customer->addChild('email',$email);	
$customer->addChild('email_optin',$emailOptin);	

$shipping = $xml->addChild('shipping');
$shipping->addChild('option',$option);
$shipping->addChild('method',$method);
$shipping->addChild('activity',$activity);

$xml->addChild('distributor_code');
$xml->addChild('consumer_code');

$totals = $xml->addChild('totals');
$totals->addChild('subtotal',$subTotal);
$totals->addChild('shipping',$shippingAmount);
$totals->addChild('handling',$handling);
$totals->addChild('tax',$tax);
$totals->addChild('total',$total);


Header('Content-type: text/xml');
print($xml->asXML());

?>