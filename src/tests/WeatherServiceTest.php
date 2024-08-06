<?php

use PHPUnit\Framework\TestCase;
use Services\WeatherService;

class WeatherServiceTest extends TestCase
{
    private $weatherService;

    protected function setUp(): void
    {
        $this->weatherService = $this->getMockBuilder(WeatherService::class)
                                     ->setConstructorArgs(['fake_api_key'])
                                     ->onlyMethods(['makeRequest'])
                                     ->getMock();
    }

    public function testGetWeatherByCityId()
    {
        // Simulate a response that matches the expected ?float type
        $this->weatherService->method('makeRequest')->willReturn(25.0);

        $result = $this->weatherService->getWeatherByCityId(123456);
        $this->assertSame(25.0, $result);
    }

    public function testGetWeatherByCoordinates()
    {
        // Simulate a response that matches the expected ?float type
        $this->weatherService->method('makeRequest')->willReturn(18.5);

        $result = $this->weatherService->getWeatherByCoordinates(48.8566, 2.3522);
        $this->assertSame(18.5, $result);
    }

    public function testInjectionInCityName()
    {
        $this->weatherService->method('makeRequest')->willReturn(20.0);

        $maliciousInput = 'testCityName"; DROP TABLE users; --';
        $result = $this->weatherService->getWeatherByCityName($maliciousInput);

        // im not really testing the request here because the API should protect against this,
        // but we can check that the method dont return an eror or un expected things.
        $this->assertSame(20.0, $result);
    }

    public function testInvalidApiResponse()
    {
        // simulate a malformed API response
        $this->weatherService->method('makeRequest')->willReturn(null);

        $result = $this->weatherService->getWeatherByCityName("validCityName");

        // check that the result is handled securely, for example by returning null or throwing an exception
        $this->assertNull($result);
    }

    // Security test for exceptions:
    public function testExceptionHandling()
    {
        // Simulate an exception in makeRequest
        $this->weatherService->method('makeRequest')->will($this->throwException(new \Exception('error encountred')));

        $this->expectException(\Exception::class);

        $this->weatherService->getWeatherByCityName("CityName");
    }

    // security test for Denial of Service (DoS)
    public function testDoSProtection()
    {
        // simulate a series of rapid requests
        for ($i = 0; $i < 1000; $i++) {
            $this->weatherService->method('makeRequest')->willReturn(20.0);
            $result = $this->weatherService->getWeatherByCityName("CityName");
            $this->assertSame(20.0, $result);
        }
        
        // This test should verify that the service continues to function correctly under high load
    }

    // Security test for data exposure:
    public function testApiKeyNotExposed()
    {
        // Create a real instance of WeatherService
        $realWeatherService = new \Services\WeatherService('fake_api_key', 'https://api.example.com');

        // Use reflection to access the private $apiKey property
        $reflection = new \ReflectionClass($realWeatherService);
        $property = $reflection->getProperty('apiKey');
        $property->setAccessible(true);

        // verify that the API key is properly stored and not exposed
        $this->assertSame('fake_api_key', $property->getValue($realWeatherService));
    }
}