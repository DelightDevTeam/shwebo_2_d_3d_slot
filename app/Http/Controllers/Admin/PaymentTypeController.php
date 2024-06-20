<?php

namespace App\Http\Controllers\Admin;

use App\Models\PaymentType;
use App\Models\PaymentImage;
use Illuminate\Http\Request;
use App\Models\Admin\UserPayment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class PaymentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentTypes = UserPayment::with('paymentType')->get();
        Log::info($paymentTypes);
        return view('admin.paymentType.index', compact('paymentTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $paymentType = PaymentType::where('id', $id)->first();

        return view('admin.paymentType.edit', compact('paymentType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $paymentType = PaymentType::findOrFail($id);

        $this->updatePaymentTypeImages($paymentType, $request->image);

        return redirect()->route('admin.paymentType.index');
    }

    private function updatePaymentTypeImages(PaymentType $paymentType, $images)
    {
        if (! $images) {
            return;
        }

        $paymentType->paymentImages()->delete();

        foreach ($images as $image) {
            $imageName = $this->generateUniqueImageName($image);
            $image->move('assets/img/paymentType/banners', $imageName);
            $paymentImages[] = [
                'payment_type_id' => $paymentType->id,
                'image' => $imageName,
            ];
        }

        $paymentType->paymentImages()->createMany($paymentImages);
    }

    private function generateUniqueImageName(UploadedFile $image)
    {
        return time().'-'.uniqid().'.'.$image->getClientOriginalExtension();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
