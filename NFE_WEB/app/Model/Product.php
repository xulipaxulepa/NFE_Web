<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function getNcmSTR()
    {
        $ncm = Ncm::find($this->ncm);
        $ncmEnterprise = NcmEnterprise::where('ncm', $ncm->id)->where('enterprise', $this->enterprise)->first();
        if(is_null($ncmEnterprise)) {
            return $ncm->code . (!is_null($ncm->description) ? " - " . $ncm->description : "");
        } else {
            return $ncmEnterprise->code . (!is_null($ncmEnterprise->description) ? " - " . $ncmEnterprise->description : "");
        }
    }
}
