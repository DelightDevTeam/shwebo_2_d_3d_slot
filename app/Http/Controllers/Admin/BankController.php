<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankRequest;
use App\Models\Admin\Bank;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banks = Bank::where('agent_id', Auth::id())->get();
        
        return view('admin.bank.index', compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.bank.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BankRequest $request)
    {
        $image = $request->file('image');
        $ext = $image->getClientOriginalExtension();
        $filename = uniqid('bank').'.'.$ext;
        $image->move(public_path('assets/img/bank/'), $filename);
        $param = array_merge($request->validated(),['image' => $filename ,'agent_id' => Auth::id()]);

        Bank::create($param);

        return redirect(route('admin.bank.index'))->with('success', 'New Bank Added.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Bank $bank)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bank $bank)
    {
        return view('admin.bank.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BankRequest $request, Bank $bank)
    {
        if (!$bank) {
            return redirect()->back()->with('error', 'Bank Not Found');
        }
        if($request->file('image'))
        {
            File::delete(public_path('assets/img/banks/'.$bank->image));

            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $filename = uniqid('bank').'.'.$ext; // Generate a unique filename
            $image->move(public_path('assets/img/banks/'), $filename); // Save the file
           
            $param = array_merge($request->validated(),['image' => $filename]);
        }else{
            $param = $request->validated();
        }

        $bank->update($param);

        return redirect(route('admin.bank.index'))->with('success', 'Bank Image Updated.');
 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bank $bank)
    {
        if (!$bank) {
            return redirect()->back()->with('error', 'Bank Not Found');
        }
        //remove banner from localstorage
        File::delete(public_path('assets/img/banks/'.$bank->image));
        $bank->delete();

        return redirect()->back()->with('success', 'Bank Deleted.');
    }
}
