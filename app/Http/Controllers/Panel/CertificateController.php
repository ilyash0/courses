<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\View\View;

class CertificateController extends Controller
{
    /**
     * Display a listing of the certificates.
     */
    public function index(): View
    {
        $certificates = Certificate::with(['user', 'course'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('certificates.index', compact('certificates'));
    }
}
