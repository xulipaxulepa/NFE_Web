<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    public function getUser()
    {
        return User::find($this->user);
    }

    public function getAmount()
    {
        $note = EnterpriseNote::where('enterprise', $this->id)->first();
        return !is_null($note) ? $note->amount : 0;
    }

    public function getTaxRegimeSTR()
    {
        return $this->tax_regime == 1 ? __("fields.enterprise_tax_regime_simple_national") : ($this->tax_regime == 2 ? __("fields.enterprise_tax_regime_simple_national_exception_grouss") : ($this->tax_regime == 3 ? __("fields.enterprise_tax_regime_normal_regime") : ''));
    }
}
