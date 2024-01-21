<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $certificates = Certificate::all();
        return response()->json($certificates, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'companyAddress' => 'required|max:191',
            'manufacturer' => 'required|max:191',
            'manufacturerAddress' => 'required|max:191',
            'brandName' => 'required|max:191',
            'productName' => 'required|max:191',
            'standardsApplicable' => 'required|max:191',
            'productCategory' => 'required|max:191',
            'issueDate' => 'required|max:191',
            'validUntil' => 'required|max:191',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->getMessageBag(),
            ], 400);
        }
        $uniqueKey = (string) Str::uuid();


        $certificate = new Certificate;
        $certificate->key = $uniqueKey;
        $certificate->companyAddress = $request->input('companyAddress');
        $certificate->manufacturer = $request->input('manufacturer');
        $certificate->manufacturerAddress = $request->input('manufacturerAddress');
        $certificate->brandName = $request->input('brandName');
        $certificate->productName = $request->input('productName');
        $certificate->standardsApplicable = $request->input('standardsApplicable');
        $certificate->productCategory = $request->input('productCategory');
        $certificate->issueDate = $request->input('issueDate');
        $certificate->validUntil = $request->input('validUntil');
        $certificate->save();
        return response()->json([
            'message' => 'Certificate added successfully',
        ], 200);
    }

    public function checkCertificate($key)
    {
        // Query the database to find a certificate with the given key
        $certificate = Certificate::where('key', $key)->first();

        if ($certificate) {
            // Certificate found, return it
            return response()->json($certificate);
        } else {
            // Certificate not found, return a message
            return response()->json(['message' => 'No certificate with this key found.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function show(Certificate $certificate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function edit(Certificate $certificate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'companyAddress' => 'required|max:191',
            'manufacturer' => 'required|max:191',
            'manufacturerAddress' => 'required|max:191',
            'brandName' => 'required|max:191',
            'productName' => 'required|max:191',
            'standardsApplicable' => 'required|max:191',
            'productCategory' => 'required|max:191',
            'issueDate' => 'required|max:191',
            'validUntil' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->getMessageBag(),
            ], 422);
        } else {
            $certificate = Certificate::find($id);
            if ($certificate) {
                $certificate->companyAddress = $request->input('key');
                $certificate->companyAddress = $request->input('companyAddress');
                $certificate->manufacturer = $request->input('manufacturer');
                $certificate->manufacturerAddress = $request->input('manufacturerAddress');
                $certificate->brandName = $request->input('brandName');
                $certificate->productName = $request->input('productName');
                $certificate->standardsApplicable = $request->input('standardsApplicable');
                $certificate->productCategory = $request->input('productCategory');
                $certificate->issueDate = $request->input('issueDate');
                $certificate->validUntil = $request->input('validUntil');
                $certificate->save();
                return response()->json([
                    'message' => 'Certificate updated successfully',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Certificate not found !'
                ], 404);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $certificate = Certificate::find($id);
        if ($certificate) {
            $certificate->delete();
            return response()->json([
                'message' => 'Certificate deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Certificate not found !',
            ], 404);
        }
    }
}
