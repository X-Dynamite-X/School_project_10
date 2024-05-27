<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Subject;
use App\Models\SubjectUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        $subjectUsers = SubjectUser::all();
        $users = User::all();
        return view("admin.subject", ['subjects' => $subjects, "subjectUsers" => $subjectUsers, "users" => $users]);
    }


    public function getSubjectData($id)
    {
        $subject = Subject::find($id);
        if ($subject) {
            return response()->json($subject);
        } else {
            return response()->json(['error' => 'Subject not found'], 404);
        }
    }


    public function getsubject()
    {
        $subjects = Subject::query();
        return DataTables::of($subjects)
            ->setRowId('trSubject_{{$id}}')
            ->rawColumns(["Action", "subjectInUser"])
            ->addColumn("Action", "admin.dataTables.subject.actionSubjectTable",)
            ->addColumn("subjectInUser", function ($subject) {
                return $subject->users->count();
            })
            ->toJson();
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                "subject_code" => "required|min:3|max:6|unique:subjects",
                'success_mark' => 'required|numeric|min:0',
                'full_mark' => 'required|numeric|min:0|gte:success_mark',
            ],
            [
                'subject_input.required' => 'The subject field is required',
                'subject_code.required' => 'The code field is required',
                'subject_code.unique' => 'This code is already in use and cannot be duplicated.',

                'success_mark.required' => 'The minimum mark field is required',
                'full_mark.required' => 'The full mark field is required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['error' => 'Validation failed', 'message' => $validator->errors()], 422);
        }
        $subject = Subject::create([
            'name' => $request->input('name'),
            'subject_code' => $request->input('subject_code'),
            'success_mark' => $request->input('success_mark'),
            'full_mark' => $request->input('full_mark'),
        ]);
        $users = User::all();
        return response()->json([$subject, $users]);
    }
    public function update(Request $request, string $id)
    {
        $subject = Subject::find($id);

        if (!$subject) {
            return response()->json(['error' => 'Subject not found'], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'subject_code' => "required|min:3|max:6|unique:subjects,subject_code,$id",
                'success_mark' => 'required|numeric|min:0',
                'full_mark' => 'required|numeric|min:0|gte:success_mark',
            ],
            [
                'name.required' => 'The name field is required',
                'subject_code.required' => 'The subject code field is required',
                'subject_code.unique' => 'This code is already in use and cannot be duplicated.',
                'success_mark.required' => 'The minimum mark field is required',
                'full_mark.required' => 'The full mark field is required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => 'Validation failed', 'message' => $validator->errors()], 422);
        }

        $subject->name = $request->input('name');
        $subject->subject_code = $request->input('subject_code');
        $subject->success_mark = $request->input('success_mark');
        $subject->full_mark = $request->input('full_mark');
        $subject->save();

        return response()->json($subject);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = Subject::find($id);

        if (!$subject) {
            return response()->json([], 404);
        }

        $subject->delete();
        return response()->json(["message" => "Delete Successfuly"]);
    }
}
