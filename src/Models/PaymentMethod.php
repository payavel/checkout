<?php

namespace rkujawa\LaravelPaymentGateway\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use rkujawa\LaravelPaymentGateway\Database\Factories\PaymentMethodFactory;

class PaymentMethod extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'payment_customer_id',
        'fallback_id',
        'token',
        'first_name',
        'last_name',
        'last_digits',
        'exp_month',
        'exp_year',
        'type',
        'created_at',
    ];

    protected $hidden = ['token'];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return PaymentMethodFactory::new();
    }

    public function getCardholderAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getExpirationDateAttribute()
    {
        return $this->getExpirationDate();
    }

    public function setFirstNameAttribute($value)
    {
        if (!is_null($value)) {
            $this->attributes['first_name'] = ucwords(strtolower(trim($value)));
        }
    }

    public function setLastNameAttribute($value)
    {
        if (!is_null($value)) {
            $this->attributes['last_name'] = ucwords(strtolower(trim($value)));
        }
    }

    public function getExpirationDate(string $seperator = '/')
    {
        return $this->exp_month . $seperator . $this->exp_year;
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function fallback()
    {
        return $this->belongsTo(self::class);
    }

    public static function findByToken(string $token)
    {
        return self::where('token', $token)->first();
    }

    public function getContactData(): array
    {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
        ];
    }
}
