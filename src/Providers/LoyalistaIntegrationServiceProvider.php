<?php

namespace LoyalistaIntegration\Providers;

use Plenty\Plugin\Log\Loggable;
use Plenty\Plugin\ServiceProvider;
use Plenty\Modules\Cron\Services\CronContainer;
use Plenty\Log\Services\ReferenceContainer;

use LoyalistaIntegration\Contracts\ToDoRepositoryContract;
use LoyalistaIntegration\Repositories\ToDoRepository;

use LoyalistaIntegration\Contracts\OrderSyncedRepositoryContract;
use LoyalistaIntegration\Repositories\OrderSyncedRepository;

use Plenty\Modules\EventProcedures\Services\EventProceduresService;
use Plenty\Modules\EventProcedures\Services\Entries\ProcedureEntry;
use LoyalistaIntegration\EventProcedures\LoyalistaProcedures;

use LoyalistaIntegration\Cron\ConfigurationCron;


/**
 * Class LoyalistaIntegrationServiceProvider
 * @package LoyalistaIntegration\Providers
 */
class LoyalistaIntegrationServiceProvider extends ServiceProvider
{
    use Loggable;
    /**
    * Register the route service provider
    */
    public function register()
    {
        $this->getApplication()->register(LoyalistaIntegrationRouteServiceProvider::class);

        // bind() function to bind the ....RepositoryContract class to the ...Repository class.
        // This way, when using the ...RepositoryContract` class via dependency injection,
        // the functions defined in the repository will be implemented.

        $this->getApplication()->bind(ToDoRepositoryContract::class, ToDoRepository::class);
        $this->getApplication()->bind(OrderSyncedRepositoryContract::class, OrderSyncedRepository::class);
    }

    public function boot(EventProceduresService $eventProceduresService,
                         CronContainer $cronContainer)
    {

        $cronContainer->add(CronContainer::EVERY_FIVE_MINUTES, ConfigurationCron::class);

        $eventProceduresService->registerProcedure(
            'exportOrder',
            ProcedureEntry::EVENT_TYPE_ORDER,
            [
                'de' => 'Loyalista - Export/Send Orders',
                'en' => 'Loyalista - Export/Send Orders'
            ],
            LoyalistaProcedures::class . '@exportOrder'
        );

         $eventProceduresService->registerProcedure(
            'revertPoints',
            ProcedureEntry::EVENT_TYPE_ORDER,
            [
                'de' => 'Loyalista - Refund/Revert Points',
                'en' => 'Loyalista - Refund/Revert Points'
            ],
            LoyalistaProcedures::class . '@revertPoints'
        );


    }
}

/*
 *
 *  Logs are registered in a ServiceProvider. Once registered, they can be called on in a Controller.
 *  The ServiceProvider has to import and use the Plenty\Log\Services\ReferenceContainer service.
 *  You should also import and use Plenty\Log\Exceptions\ReferenceTypeException to catch exceptions on registration.
 * */