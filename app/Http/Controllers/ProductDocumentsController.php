<?php

namespace App\Http\Controllers;

use App\Models\ProductDocument;
use App\Models\Project;
use App\Models\ProjectDocument;
use Illuminate\Http\Request;

class ProductDocumentsController extends Controller
{
    public function index()
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['name' => "Product Documents"]
        ];

        return view('content.product-documents', ['breadcrumbs' => $breadcrumbs]);
    }

    public function addProductDocument()
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['link' => "admin/product-documents", 'name' => "Product Documents"], ['name' => "Add Product Document"]
        ];

        $document = [];

        return view('content.add-product-document', ['document' => $document, 'breadcrumbs' => $breadcrumbs]);
    }

    public function editProductDocument($id)
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['link' => "admin/product-documents", 'name' => "Product Documents"], ['name' => "Edit Product Document"]
        ];

        $document = ProductDocument::where('id', $id)->select('id', 'name', 'name_ar', 'pages')->with('types:id,name')->first();

        return view('content.add-product-document', ['document' => $document, 'breadcrumbs' => $breadcrumbs]);
    }

    public function addDocuments($id, $type)
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['link' => "admin/projects", 'name' => "Certification"], ['name' => ucfirst($type) . " Documents"]
        ];

        $project = Project::find($id);
        $documents = $project->load(['documents' => function ($query) use ($type) {
            $query->whereIn('type', ['add', 'amend']);
        }]);

        return view('content.add-documents', ['id' => $id, 'type' => $type, 'documents' => $documents, 'breadcrumbs' => $breadcrumbs]);
    }
}
