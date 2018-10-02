<?php

namespace Signifly\Travy;

use Illuminate\Contracts\Routing\Registrar as Router;

class RouteRegistrar
{
    /**
     * The router implementation.
     *
     * @var \Illuminate\Contracts\Routing\Registrar
     */
    protected $router;

    /**
     * Create a new route registrar instance.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Register routes for transient tokens, clients, and personal access tokens.
     *
     * @return void
     */
    public function all()
    {
        $this->forDefinitions();
        $this->forResources();
        $this->forRelations();
    }

    /**
     * Register the routes for definitions.
     *
     * @return void
     */
    public function forDefinitions()
    {
        $this->router->get('definitions/{type}/{resource}', 'DefinitionController@show')
            ->name('definitions.show');
    }

    /**
     * Register the routes for creating, reading, updating and deleting resources.
     *
     * @return void
     */
    public function forResources()
    {
        $this->router->get('{resource}', 'TravyController@index')
            ->name('travy.index');

        $this->router->post('{resource}', 'TravyController@store')
            ->name('travy.store');

        $this->router->get('{resource}/{resourceId}', 'TravyController@show')
            ->name('travy.show');

        $this->router->put('{resource}/{resourceId}', 'TravyController@update')
            ->name('travy.update');

        $this->router->delete('{resource}/{resourceId}', 'TravyController@destroy')
            ->name('travy.destroy');

        $this->router->post('{resource}/{resourceId}/restore', 'TravyController@restore')
            ->name('travy.restore');
    }

    /**
     * Register the routes for relations.
     *
     * @return void
     */
    public function forRelations()
    {
        $this->router->get('{resource}/{resourceId}/{relation}', 'RelationController@index')
            ->name('travy.relation.index');

        $this->router->get('{resource}/{resourceId}/{relation}/{relationId}', 'RelationController@show')
            ->name('travy.relation.show');
    }
}
