<?php

namespace App\Http\Controllers;

use App\Models\PdfFile;
use App\Traits\UploadTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\PDFResource;
use App\Http\Controllers\Controller;

class PDFController extends Controller
{
    use UploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pdfFiles = PdfFile::all();
        return PDFResource::collection($pdfFiles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'file' => 'required|mimes:pdf'
        ]);

        $pdf = new PdfFile();
        $pdf->title = $request->input('title');

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = Str::random(25) . '.' . $file->getClientOriginalExtension();
            $folder = 'public/uploads/pdf_files';
            $url = $this->uploadFile($file, $folder, $fileName);
            $pdf->file = $url;
            $pdf->save();
        }

        $pdf->save();

        return new PDFResource($pdf);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PdfFile $pdfFile)
    {
        return new PDFResource($pdfFile);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PdfFile $pdfFile)
    {
        $this->validate($request, [
            'title' => 'filled|string',
            'file' => 'filled|mimes:pdf'
        ]);

        $title = $request->only('title');
        $pdfFile->update($title);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = Str::random(25) . '.' . $file->getClientOriginalExtension();
            $folder = 'public/uploads/pdf_files';
            $url = $this->uploadFile($file, $folder, $fileName);
            $pdfFile->file = $url;
            $pdfFile->save();
        }
        // return $title;
        return new PDFResource($pdfFile->fresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PdfFile $pdfFile)
    {
        $pdfFile->delete();
        return response()->noContent();
    }
}
