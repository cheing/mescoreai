<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    private $limits = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'username');
        $direction = $request->input('direction', 'asc');

        $members = User::where('role', 'member')
        ->orderBy($sort, $direction)->paginate($this->limits);

        return view('admin.members.index', [
            'members' => $members,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = \Config::get('custom')['statuses'];

        return view('admin.members.create', ['statuses' => $status]); // 传递到视图
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMemberRequest $request)
    {
        $data = $request->validated();
        $data['role'] = 'member';
        $data['password'] = Hash::make($data['password']);

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        return new UserResource(User::create($data));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Member $member
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $member)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Member $member
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $member)
    {
        $status = \Config::get('custom')['statuses'];

        return view('admin.members.edit', ['member' => $member, 'statuses' => $status]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Models\Member $member
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMemberRequest $request, User $member)
    {
        //     $validatedData = $request->validate([
        //         'email' => 'sometimes|required|max:25',
        //         'phone' => 'sometimes|nullable|max:50',
        //         'status' => 'sometimes|required',
        //         'subscribe' => 'sometimes|boolean',
        //         'me88username' => 'sometimes|nullable',
        //     ]);

        // \Log::info($request->all());  // Log all request data to the Laravel log

        // return response()->json($member);
        $validatedData = $request->validated();

        if (empty($validatedData)) {
            \Log::error('Validation failed', [
                'errors' => $request->errors(), // This will log any validation errors
                'all_data' => $request->all(),   // This will re-log all data for correlation
            ]);

            return response()->json(['error' => 'Validation failed', 'details' => $request->errors()]);
        }

        $member->update($validatedData);

        return new UserResource($member);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Member $member
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $member)
    {
        $member->delete();

        return response()->json(['message' => 'Member deleted successfully']);
    }
}
