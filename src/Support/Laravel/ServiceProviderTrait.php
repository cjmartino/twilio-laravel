<?php
namespace cjmartino\Twilio\Support\Laravel;

use cjmartin\Twilio\Commands\TwilioCallCommand;
use cjmartin\Twilio\Commands\TwilioSmsCommand;
use Twilio\Manager;
use Twilio\TwilioInterface;

trait ServiceProviderTrait
{
    /**
     *
     */
    public function register()
    {
        // Register manager for usage with the Facade.
        $this->app->singleton('twilio', function () {
            $config = $this->config();

            return new Manager($config['default'], $config['connections']);
        });

        // Define an alias.
        $this->app->alias('twilio', Manager::class);

        // Register Twilio Test SMS Command.
        $this->app->singleton('twilio.sms', TwilioSmsCommand::class);

        // Register Twilio Test Call Command.
        $this->app->singleton('twilio.call', TwilioCallCommand::class);

        // Register TwilioInterface concretion.
        $this->app->singleton(TwilioInterface::class, function () {
            return $this->app->make('twilio')->defaultConnection();
        });
    }
}
