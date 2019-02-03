<?php

namespace MichalOravec\PaginateRoute\Test;

use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * @var string
     */
    protected $hostName;

    /**
     * @var string
     */
    protected $locale = 'en';

    /**
     * @var string
     */
    protected $mode = 'normal';

    public function setUp()
    {
        parent::setUp();

        $this->setUpDatabase($this->app);

        $this->app['paginateroute']->registerMacros();

        $this->hostName = $this->app['config']->get('app.url');
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            'MichalOravec\PaginateRoute\PaginateRouteServiceProvider',
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('paginateroute.mode', $this->mode);

        $app['config']->set('app.locale', $this->locale);

        $app['config']->set('database.default', 'sqlite');

        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => __DIR__.'/database.sqlite',
            'prefix' => '',
        ]);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        file_put_contents(__DIR__.'/database.sqlite', null);

        $app['db']->connection()->getSchemaBuilder()->create('dummies', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
        });

        for ($i = 1; $i <= 20; $i++) {
            Dummy::create(['name' => "Dummy {$i}"]);
        }
    }

    protected function registerDefaultRoute()
    {
        $this->app['router']->paginate('dummies', function () {
            $dummies = Dummy::paginate(5);

            $paginateRoute = $this->app['paginateroute'];

            return [
                'nextPageUrl' => $this->app['paginateroute']->nextPageUrl($dummies),
                'hasPrevious' => $this->app['paginateroute']->hasPreviousPage(),
                'previousPageUrl' => $this->app['paginateroute']->previousPageUrl(),
                'models' => $dummies->toArray(),
                'hasNext' => $this->app['paginateroute']->hasNextPage($dummies),
            ];
        });
    }

    /**
     * @param string $route
     * @param array $parameters
     *
     * @return array
     */
    protected function callRoute($route, array $parameters = [])
    {
        return json_decode($this->call('GET', 'dummies'.$route, $parameters)->getContent(), true);
    }
}
