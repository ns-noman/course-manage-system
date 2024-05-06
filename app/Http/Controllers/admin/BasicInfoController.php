<?php

namespace App\Http\Controllers\admin;

use App\Models\BasicInfo;
use App\Models\CurrencySymbol;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;

use Auth;
class BasicInfoController extends Controller
{
    public function index()
    {
        $basicInfo = BasicInfo::first();
        return view('admin.basic-infos.index', compact('basicInfo'));
    }

    public function edit(BasicInfo $basicInfo)
    {
        $currencys = CurrencySymbol::get();
        return view('admin.basic-infos.edit', compact('basicInfo','currencys'));
    }

    public function update(Request $request, BasicInfo $basicInfo)
    {
        $data = $request->all();
        $currency = CurrencySymbol::find($data['currency_symbol_id']);
        $data['currency_code'] = $currency->code;
        $data['currency_symbol'] = $currency->symbol;

        if(isset($data['logo'])){
            $fileName = 'logo-'. time().'.'. $data['logo']->getClientOriginalExtension();
            $data['logo']->move(public_path('uploads/basic-info'), $fileName);
            $data['logo'] = $fileName;

            $imagePath = public_path('uploads/basic-info/'.$basicInfo->logo);
            if($basicInfo->logo) unlink($imagePath);

        }else unset($data['logo']);

        if(isset($data['favIcon'])){
            $fileName = 'favIcon-'. time().'.'. $data['favIcon']->getClientOriginalExtension();
            $data['favIcon']->move(public_path('uploads/basic-info/'), $fileName);
            $data['favIcon'] = $fileName;

            $imagePath = public_path('uploads/basic-info/'.$basicInfo->favIcon);
            if($basicInfo->favIcon) unlink($imagePath);

        }else unset($data['favIcon']);

        if(isset($data['acceptPaymentType'])){
            $fileName = 'apt-'. time().'.'. $data['acceptPaymentType']->getClientOriginalExtension();
            $data['acceptPaymentType']->move(public_path('uploads/basic-info'), $fileName);
            $data['acceptPaymentType'] = $fileName;

            $imagePath = public_path('uploads/basic-info/'.$basicInfo->acceptPaymentType);
            if($basicInfo->acceptPaymentType) unlink($imagePath);

        }else unset($data['acceptPaymentType']);

        $basicInfo->update($data);
        return redirect('admin/basic-infos')->with('alert',['messageType'=>'warning','message'=>'Data Updated Successfully!']);

    }
    public function localization(Request $request, $id, $locale)
    {
        if($request->isMethod('post'))
        {
            BasicInfo::find($id)->update([$locale=>$request->all(),]);
            return redirect('admin/basic-infos')->with('alert',['messageType'=>'warning','message'=>'Data Updated Successfully!']);
        }else{
            $data = BasicInfo::find($id)->translate($locale);
            return view('admin.basic-infos.localization', compact('data','id','locale'));
        }
    }

}