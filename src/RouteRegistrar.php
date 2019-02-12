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
     * @param \Illuminate\Contracts\Routing\Registrar $router
     *
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
        $this->router->get('{resource}', 'ResourceController@index')
            ->name('travy.index');

        $this->router->post('{resource}', 'ResourceController@store')
            ->name('travy.store');

        $this->router->get('{resource}/{resourceId}', 'ResourceController@show')
            ->name('travy.show');

        $this->router->put('{resource}/{resourceId}', 'ResourceController@update')
            ->name('travy.update');

        $this->router->delete('{resource}/{resourceId}', 'ResourceController@destroy')
            ->name('travy.destroy');

        $this->router->post('{resource}/{resourceId}/restore', 'ResourceController@restore')
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
