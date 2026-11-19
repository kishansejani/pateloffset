<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Storage;

class InquiryController extends Controller
{
    public function index()
    {
        return view('admin.inquiries', ['inquiries' => Inquiry::latest()->paginate(20)]);
    }

    public function toggle(Inquiry $inquiry)
    {
        $inquiry->update(['is_read' => ! $inquiry->is_read]);

        return back();
    }

    public function destroy(Inquiry $inquiry)
    {
        if ($inquiry->attachment) {
            Storage::disk('public')->delete($inquiry->attachment);
        }
        $inquiry->delete();

        return back()->with('success', 'Inquiry deleted.');
    }
}
