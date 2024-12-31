<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use GpsLab\Bundle\GeoIP2Bundle\Reader\ReaderFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use GeoIp2\Exception\AddressNotFoundException;


class GeoIPController extends AbstractController
{   
    #[Route('/geoip', name: 'app_geo_i_p')]
    public function index(Request $request, ReaderFactory $factory): Response
    {
        $client_locale = $request->getLocale();
        $client_ip = $request->getClientIp();
        $database_name = 'default';
        $fallback_locale = 'de';
    
        $reader = $factory->create($database_name, [$client_locale, $fallback_locale]);
        $record = $reader->city($client_ip);
    
        return new Response(sprintf('You are from %s?', $record->country->name));
    }
}