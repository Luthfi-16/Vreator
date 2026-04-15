<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SoftwareResource;
use App\Http\Resources\TemplateCategoryResource;
use App\Models\Software;
use App\Models\TemplateCategory;

class LookupController extends Controller
{
    public function softwares()
    {
        return response()->json([
            'message' => 'Daftar software berhasil diambil.',
            'data' => SoftwareResource::collection(Software::orderBy('name')->get()),
        ]);
    }

    public function categories()
    {
        return response()->json([
            'message' => 'Daftar kategori template berhasil diambil.',
            'data' => TemplateCategoryResource::collection(TemplateCategory::orderBy('name')->get()),
        ]);
    }
}
