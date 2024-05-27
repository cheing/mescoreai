<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReceiptRequest;
use App\Http\Requests\UpdateReceiptRequest;
use App\Http\Resources\V1\ReceiptResource;
use App\Models\Package;
use App\Models\Receipt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReceiptController extends Controller
{
    private $limits = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'submitted_at');
        $direction = $request->input('direction', 'asc');

        $receipts = Receipt::orderBy($sort, $direction)
        ->paginate($this->limits);

        return view('admin.receipts.index', [
            'receipts' => $receipts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('role', 'member')->where('status', 1)->get();

        return view('admin.receipts.create', ['users' => $users]); // 传递到视图
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReceiptRequest $request)
    {
        $data = $request->validated();

        $data['submitted_at'] = NOW();
        $receipt = Receipt::create($data);

        return new ReceiptResource($receipt);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Receipt $receipt)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Receipt $receipt)
    {
        $users = User::where('role', 'member')->get();
        $packages = Package::where('status', 1)->get();

        return view('admin.receipts.edit', ['receipt' => $receipt, 'users' => $users, 'packages' => $packages]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReceiptRequest $request, Receipt $receipt)
    {
        $data = $request->validated();

        $receipt->update($data);

        return new ReceiptResource($receipt);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receipt $receipt)
    {
        if ($receipt->file_path && !Storage::delete('public/'.$receipt->file_path)) {
            return response()->json(['message' => 'File could not be deleted'], 500);
        }
        $receipt->delete();

        return response()->json(['message' => 'Receipt deleted successfully']);
    }
}
