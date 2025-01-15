<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-18 14:13:59
 * @ Description: Controller pour les erreurs
 */
namespace App\Core;

class Error
{
    static public function api(int $code, mixed $data) {
        return ['code' => $code, 'error' =>  $data];
    }

    static public function header($code) {
        switch ($code) {
            case 100:
                header("HTTP/1.1 100 Continue");
                break;
            case 101:
                header("HTTP/1.1 101 Switching Protocols");
                break;
            case 200:
                header("HTTP/1.1 200 OK");
                break;
            case 201:
                header("HTTP/1.1 201 Created");
                break;
            case 202:
                header("HTTP/1.1 202 Accepted");
                break;
            case 203:
                header("HTTP/1.1 203 Non-Authoritative Information");
                break;
            case 204:
                header("HTTP/1.1 204 No Content");
                break;
            case 205:
                header("HTTP/1.1 205 Reset Content");
                break;
            case 206:
                header("HTTP/1.1 206 Partial Content");
                break;
            case 300:
                header("HTTP/1.1 300 Multiple Choices");
                break;
            case 301:
                header("HTTP/1.1 301 Moved Permanently");
                break;
            case 302:
                header("HTTP/1.1 302 Found");
                break;
            case 303:
                header("HTTP/1.1 303 See Other");
                break;
            case 304:
                header("HTTP/1.1 304 Not Modified");
                break;
            case 305:
                header("HTTP/1.1 305 Use Proxy");
                break;
            case 307:
                header("HTTP/1.1 307 Temporary Redirect");
                break;
            case 400:
                header("HTTP/1.1 400 Bad Request");
                break;
            case 401:
                header("HTTP/1.1 401 Unauthorized");
                break;
            case 402:
                header("HTTP/1.1 402 Payment Required");
                break;
            case 403:
                header("HTTP/1.1 403 Forbidden");
                break;
            case 404:
                header("HTTP/1.1 404 Not Found");
                break;
            case 405:
                header("HTTP/1.1 405 Method Not Allowed");
                break;
            case 406:
                header("HTTP/1.1 406 Not Acceptable");
                break;
            case 407:
                header("HTTP/1.1 407 Proxy Authentication Required");
                break;
            case 408:
                header("HTTP/1.1 408 Request Timeout");
                break;
            case 409:
                header("HTTP/1.1 409 Conflict");
                break;
            case 410:
                header("HTTP/1.1 410 Gone");
                break;
            case 411:
                header("HTTP/1.1 411 Length Required");
                break;
            case 412:
                header("HTTP/1.1 412 Precondition Failed");
                break;
            case 413:
                header("HTTP/1.1 413 Payload Too Large");
                break;
            case 414:
                header("HTTP/1.1 414 URI Too Long");
                break;
            case 415:
                header("HTTP/1.1 415 Unsupported Media Type");
                break;
            case 416:
                header("HTTP/1.1 416 Range Not Satisfiable");
                break;
            case 417:
                header("HTTP/1.1 417 Expectation Failed");
                break;
            case 500:
                header("HTTP/1.1 500 Internal Server Error");
                break;
            case 501:
                header("HTTP/1.1 501 Not Implemented");
                break;
            case 502:
                header("HTTP/1.1 502 Bad Gateway");
                break;
            case 503:
                header("HTTP/1.1 503 Service Unavailable");
                break;
            case 504:
                header("HTTP/1.1 504 Gateway Timeout");
                break;
            case 505:
                header("HTTP/1.1 505 HTTP Version Not Supported");
                break;
            default:
                header("HTTP/1.1 200 OK");
                break;
        }
    }
    
}
