<?php

namespace Payavel\Checkout\Models;

use Illuminate\Database\Eloquent\Model;
use Payavel\Orchestration\Support\ServiceConfig;
use Payavel\Orchestration\Traits\HasFactory;

class PaymentType extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = ['id'];

    /**
     * Custom factory namespace fallback.
     *
     * @return string
     */
    protected static function getFactoryNamespace()
    {
        return 'Payavel\\Checkout\\Database\\Factories';
    }

    /**
     * Get the payment methods that inherit this type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paymentMethods()
    {
        return $this->hasMany(ServiceConfig::get('checkout', 'models.' . PaymentMethod::class, PaymentMethod::class), 'type_id');
    }

    /**
     * Generate a slug based off a string that follows a set of rules to make it valid.
     *
     * @param string $name
     * @return string
     */
    public static function slugify($name)
    {
        return preg_replace('/[^a-z0-9]+/i', '_', trim(strtolower($name)));
    }
}
