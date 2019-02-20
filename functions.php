<?php
/**
 * Created by PhpStorm.
 * User: Pashted
 * Date: 19.02.2019
 * Time: 14:38
 */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

function postFile()
{
    global $filename;
    //here is the file route, in this case is on same directory but you can set URL too like "http://examplewebsite.com/test.txt"

    $eol = "\r\n"; //default line-break for mime type
    $BOUNDARY = md5(time()); //random boundaryid, is a separator for each param on my post curl function
    $BODY = ""; //init my curl body
    $BODY .= '--' . $BOUNDARY . $eol; //start param header
    $BODY .= 'Content-Disposition: form-data; name="file"; filename="' . $filename . '"' . $eol; //first Content data for post file, remember you only put 1 when you are going to add more Contents, and 2 on the last, to close the Content Instance
    $BODY .= 'Content-Type: application/octet-stream' . $eol; //Same before row
    $BODY .= 'Content-Transfer-Encoding: base64' . $eol . $eol; // we put the last Content and 2 $eol,
    $BODY .= file_get_contents($filename) . $eol; // we write the Base64 File Content and the $eol to finish the data,
    $BODY .= '--' . $BOUNDARY . '--' . $eol . $eol; // we close the param and the post width "--" and 2 $eol at the end of our boundary header.


    $ch = curl_init(); //init curl
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $_REQUEST['token'],
        //custom header for my api validation you can get it from $_SERVER["HTTP_X_PARAM_TOKEN"] variable
        "Content-Type: multipart/form-data; boundary=" . $BOUNDARY
    ) //setting our mime type for make it work on $_FILE variable
    );
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/1.0 (Windows NT 6.1; WOW64; rv:28.0) Gecko/20100101 Firefox/28.0'); //setting our user agent
    curl_setopt($ch, CURLOPT_URL, "https://api-audience.yandex.ru/v1/management/segments/upload_file?"); //setting our api post url
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // call return content
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // navigate the endpoint
    curl_setopt($ch, CURLOPT_POST, true); //set as post
    curl_setopt($ch, CURLOPT_POSTFIELDS, $BODY); // set our $BODY


    $response = json_decode(curl_exec($ch), 1); // start curl navigation

    return $response;

}

function saveSegment()
{
    $BODY = json_encode(array(
        'segment' => array(
            'id'           => (int)$_REQUEST['segment-id'],
            'name'         => $_REQUEST['segment-name'],
            'hashed'       => false,
            'content_type' => 'mac'
        )
    ));
    $ch = curl_init(); //init curl
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $_REQUEST['token'],
            //custom header for my api validation you can get it from $_SERVER["HTTP_X_PARAM_TOKEN"] variable
            'Content-Type: application/json',
            'Content-Length: ' . strlen($BODY)
        )
    );
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/1.0 (Windows NT 6.1; WOW64; rv:28.0) Gecko/20100101 Firefox/28.0'); //setting our user agent
    curl_setopt($ch, CURLOPT_URL, "https://api-audience.yandex.ru/v1/management/segment/{$_REQUEST['segment-id']}/confirm?"); //setting our api post url
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // call return content
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // navigate the endpoint
    curl_setopt($ch, CURLOPT_POST, true); //set as post
    curl_setopt($ch, CURLOPT_POSTFIELDS, $BODY); // set our $BODY


    $response = json_decode(curl_exec($ch), 1); // start curl navigation

    return $response;


}