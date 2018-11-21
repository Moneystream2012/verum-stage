<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

/**
 * Class BladeDirectiveServiceProvider.
 */
class BladeDirectiveServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // function modify the number to bitcoin format ex. 0.00120000
        Blade::directive('format_vmc', function ($expression) {
            return "<?php echo formatVMC($expression);?> <small>VMC</small>";
        });

        Blade::directive('format_btc', function ($expression) {
            return "<?php echo formatVMC($expression);?> <small>BTC</small>";
        });

        Blade::directive('format_usd', function ($expression) {
            return "<?php echo formatUSD($expression);?> <small>USD</small>";
        });

        Blade::directive('usd_to_vmc', function ($amount) {
            return "<?php echo formatVMC(USDtoVMC($amount));?> <strong class=\"text-primary\">VMC</strong>";
        });

        Blade::directive('vmc_to_usd', function ($amount) {
            return "<?php echo formatUSD(VMCtoUSD($amount));?> <strong class=\"text-primary\">USD</strong>";
        });

        Blade::directive('format_date', function ($expression) {
            return "<?php if({$expression}) { ?><a href=\"javascript:;\" 
                    data-toggle=\"tooltip\"
                    data-placement=\"top\"
                    data-original-title=\"<?php echo {$expression}->format('d/m/Y H:i:s'); ?>\">
                        <?php echo {$expression}->format('d/m/Y'); ?>
                    </a><?php } else { echo '-';}?>";
        });
        Blade::directive('input_disabled', function ($checkup) {
            return "<?php if($checkup) echo 'disabled';?>";
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
