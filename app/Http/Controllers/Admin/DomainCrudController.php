<?php

namespace App\Http\Controllers\Admin;

use App\Models\Domain;
use App\Models\Product;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DomainCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DomainCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Domain::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/domain');
        CRUD::setEntityNameStrings('domain', 'domains');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('url');
        CRUD::column('status');
        CRUD::column('code');
        CRUD::column('created_at');
        CRUD::column('updated_at');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        Crud::setValidation([
            'product_id' => 'required',
            'url' => 'required|unique:domains,url',
            'status' => 'required',
            'user_nickname' => 'required',
        ]);

        CRUD::addField([
            'name'        => 'product_id',
            'label'       => "Plugin",
            'type'        => 'select_from_array',
            'options'     => [Domain::PRO_PLUGIN_PRODUCT_ID => 'Telegram Pro Plugin'],
            'allows_null' => false,
            'default'     => 'one',
        ]);

        CRUD::field('url')->attributes(['required' => 'required']);
        CRUD::field('user_nickname')->attributes(['required' => 'required']);

        CRUD::addField([
            'name' => "status",
            'label' => "Status",
            'type' => 'select_from_array',
            'options' => ['activated' => 'Activated', 'unactivated' => 'Unactivated'],
            'allows_null' => false,
            'default' => 'unactivated',
            'required' => 'required'
        ]);

        CRUD::addField([
            'name' => 'fake-code',
            'label'=> 'Code',
            'default'=> 'fake-code (manually activated)',
            'attributes' => [
                'disabled' => 'disabled',
            ]
        ]);

        CRUD::addField([
            'name' => 'code',
            'value'=> 'fake-code (manually activated)',
            'type' => 'hidden',
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see http/os://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
