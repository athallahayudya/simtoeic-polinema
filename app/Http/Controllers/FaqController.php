<?php

namespace App\Http\Controllers;

use App\Models\FaqModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    public function list(Request $request)
    {
        $faqs = FaqModel::select('faq_id', 'question', 'answer');

        if ($request->faq_id) {
            $faqs->where('faq_id', $request->faq_id);
        }

        return DataTables::of($faqs)
            ->addIndexColumn()
            ->addColumn('action', function ($faqs) {
                $btn = '<button onclick="modalAction(\'' . url('faqs/' . $faqs->faq_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('faqs/' . $faqs->faq_id . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('faqs/' . $faqs->faq_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Delete</button> ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $faqs = FaqModel::find($id);
        return view('users-admin.faq.show', ['faqs' => $faqs]);
    }

    public function confirm_ajax(string $id)
    {
        $faqs = FaqModel::find($id);
        return view('users-admin.faq.delete', ['faqs' => $faqs]);
    }

    public function delete_ajax(string $id)
    {
        $faqs = FaqModel::find($id);
        if ($faqs) {
            $faqs->delete();
            return redirect('faqs/');

            return response()->json([
                'status' => true,
                'message' => 'FAQ data has been successfully deleted.'
            ]);
        } else {
            return redirect('faqs/');

            return response()->json([
                'status' => false,
                'message' => 'Data not found.'
            ]);
        }
        return redirect('faqs/');
    }

    public function edit(string $id)
    {
        $faqs = FaqModel::find($id);
        return view('users-admin.faq.edit', ['faqs' => $faqs]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:255',
        ]);

        FaqModel::find($id)->update([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);
        return redirect('faqs/')->with('success', 'FAQ updated successfully.');
    }

    public function create()
    {
        return view('users-admin.faq.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:255',
        ]);

        FaqModel::create([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        return redirect('/faqs/')->with('success', 'FAQ created successfully.');
    }

    public function publicFaqList()
    {
        $faqs = FaqModel::select('faq_id', 'question', 'answer')->get();
        return view('users-public.faq.list', compact('faqs'));
    }
}
