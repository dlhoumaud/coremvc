<?php

namespace Tests;

use App\Core\TestCase;
use App\Helpers\Session;
use App\Controllers\HomeController;
use App\Services\HomeService;

class HomeControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        chdir('public');
        Session::clear();
    }

    public function testIndexSetsCorrectSessionTitle()
    {
        $homeController = new HomeController();

        buffer(function () use ($homeController) {
            $homeController->index();
        });
        
        self::assertEquals(l('welcome'), Session::get('title'));
    }

    public function testIndexReturnsCorrectData()
    {
        $expectedComponents = ['component1', 'component2'];
        
        $homeServiceMock = self::createMock(HomeService::class);
        $homeServiceMock->method('getVueComponents')
                        ->willReturn($expectedComponents);
            
        $homeController = new HomeController();
        
        $data = [
            'head_title' => l('welcome'),
            'vue_components' => $expectedComponents
        ];
        
        self::assertIsString(
            buffer(function () use ($homeController) {
                $homeController->index();
            })
        );
        self::assertIsArray($data);
    }

    public function testAboutSetsCorrectSessionTitle()
    {
        $homeController = new HomeController();
        buffer(function () use ($homeController) {
            $homeController->about();
        });
        
        $this->assertEquals(l('about'), Session::get('title'));
    }

    public function testAboutReturnsCorrectData()
    {
        $homeController = new HomeController();
        
        $data = [
            'head_title' => l('about')
        ];
        
        self::assertIsString(
            buffer(function () use ($homeController) {
                $homeController->about();
            })
        );
        self::assertIsArray($data);
    }

    public function tearDown(): void
    {
        Session::clear();
        parent::tearDown();
    }
}
