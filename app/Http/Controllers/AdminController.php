<?php

namespace App\Http\Controllers;

use App\Export\ExportMatches;
use App\Export\ExportParticipants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    private $limits = 15;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['ForgotPassword', 'ForgotPasswordPost', 'ResetPassword', 'ResetPasswordPost']]);
    }

    public function ForgotPassword()
    {
        return view('admin.passwords.email');
    }

    public function ForgotPasswordPost(\App\Http\Requests\Admin\ForgotRequest $request)
    {
        $data = $request->validated();
        if (\App\Lib\Queries\Admin\IsAccountExistsByEmail::Result($data['email'])) {
            dispatch(new \App\Lib\Commands\Admin\RequestPasswordReset($data));

            return $this->JsonOk();
        }

        return $this->JsonError();
    }

    public function ResetPassword($token)
    {
        return view('admin.passwords.reset', ['vm' => $token]);
    }

    public function ResetPasswordPost(\App\Http\Requests\Admin\ResetPasswordRequest $request)
    {
        $data = $request->validated();

        if (\App\Lib\Queries\Admin\IsTokenExists::Result($data['token'])) {
            dispatch(new \App\Lib\Commands\Admin\ResetPassword($data));

            return $this->JsonOk();
        }

        return $this->JsonError('Token expired, please reset again.');
    }

    public function SignOut()
    {
        Auth::logout();

        return redirect('admin');
    }

    public function ChangePassword()
    {
        return view('admin/password');
    }

    public function ChangePasswordPost(\App\Http\Requests\Admin\PasswordRequest $request)
    {
        $data = $request->validated();
        $data['id'] = Auth::id();
        dispatch(new \App\Lib\Commands\Admin\UpdatePassword($data));

        return $this->JsonOk();
    }

    public function Profile()
    {
        $dto = \App\Lib\Queries\Admin\GetProfile::Result(Auth::id());

        return view('admin/profile', ['data' => $dto]);
    }

    public function ProfilePost(\App\Http\Requests\Admin\ProfileRequest $request)
    {
        $data = $request->validated();
        $data['id'] = Auth::id();
        dispatch(new \App\Lib\Commands\Admin\UpdateProfile($data));

        return $this->JsonOk();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dashboard
        return view('admin.dashboard');
    }

    // User
    public function Users(Request $request)
    {
        if (null !== $request->input('sort')) {
            $sort = $request->input('sort');
        } else {
            $sort = 'name';
        }

        if (null !== $request->input('direction')) {
            $direction = $request->input('direction');
            $inputs['direction'] = $request->input('direction');
        } else {
            $direction = 'asc';
        }

        $params[] = [
          'limits' => $this->limits,
          'sort' => $sort,
          'direction' => $direction,
        ];

        $dto = \App\Lib\Queries\Admin\GetUsers::Result($params);
        $paging = \App\Lib\Queries\Admin\GetUsers::Paging($params);
        $vm = new \App\Http\ViewModels\Admin\UsersViewModel($dto, $paging);

        return view('admin/user/list', ['vm' => $vm]);
    }

    public function AddUser()
    {
        $vm = new \App\Http\ViewModels\Admin\UserViewModel();

        return view('admin/user/add', ['vm' => $vm]);
    }

    public function AddUserPost(\App\Http\Requests\Admin\UserRequest $request)
    {
        $data = $request->validated();

        $data['role'] = 'admin';
        dispatch(new \App\Lib\Commands\Admin\CreateUser($data));

        return $this->JsonOk();
    }

    public function EditUser($id)
    {
        $dto = \App\Lib\Queries\Admin\GetUser::Result($id);
        $vm = new \App\Http\ViewModels\Admin\UserEditViewModel($dto);

        return view('admin/user/edit', ['vm' => $vm]);
    }

    public function EditUserPost(\App\Http\Requests\Admin\UserInfoRequest $request)
    {
        $data = $request->validated();
        dispatch(new \App\Lib\Commands\Admin\UpdateUser($data));

        return $this->JsonOk();
    }

    public function DeleteUserPost(Request $request)
    {
        $data['id'] = $request->input('id');
        if ($this->ValidateDeleteUser($request->input('id'))) {
            dispatch(new \App\Lib\Commands\Admin\DeleteUser($data));

            return $this->JsonOk();
        } else {
            return $this->JsonError('User are unable to delete.');
        }
    }

    private function ValidateDeleteUser($id)
    {
        $result = \App\Lib\Queries\Admin\GetUser::ValidateDelete($id);

        return $result;
    }

    public function ResetUserPasswordPost(\App\Http\Requests\Admin\ResetUserPasswordRequest $request)
    {
        $data = $request->validated();
        dispatch(new \App\Lib\Commands\Admin\ResetUserPassword($data));

        return $this->JsonOk();
    }

    // Prediction
    public function Predictions(Request $request)
    {
        if (null !== $request->input('sort')) {
            $sort = $request->input('sort');
        } else {
            $sort = 'prediction_id';
        }

        if (null !== $request->input('direction')) {
            $direction = $request->input('direction');
            $inputs['direction'] = $request->input('direction');
        } else {
            $direction = 'desc';
        }

        $params[] = [
          'limits' => $this->limits,
          'sort' => $sort,
          'direction' => $direction,
        ];

        $dto = \App\Lib\Queries\Admin\GetPredictions::Result($params);
        $paging = \App\Lib\Queries\Admin\GetPredictions::Paging($params);
        $vm = new \App\Http\ViewModels\Admin\PredictionsViewModel($dto, $paging);

        return view('admin/prediction/list', ['vm' => $vm]);
    }

    public function AddPrediction()
    {
        $vm = new \App\Http\ViewModels\Admin\PredictionViewModel();

        return view('admin/prediction/add', ['vm' => $vm]);
    }

    public function AddPredictionPost(\App\Http\Requests\Admin\PredictionRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::user()->name;
        dispatch(new \App\Lib\Commands\Admin\CreatePrediction($data));

        return $this->JsonOk();
    }

    public function EditPrediction($id)
    {
        $dto = \App\Lib\Queries\Admin\GetPrediction::Result($id);
        $vm = new \App\Http\ViewModels\Admin\PredictionEditViewModel($dto);

        return view('admin/prediction/edit', ['vm' => $vm]);
    }

    public function EditPredictionPost(\App\Http\Requests\Admin\PredictionInfoRequest $request)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::user()->name;
        dispatch(new \App\Lib\Commands\Admin\UpdatePrediction($data));

        return $this->JsonOk();
    }

    public function CopyPredictionPost(Request $request)
    {
        $id = $request->input('id');

        $dto = \App\Lib\Queries\Admin\GetPrediction::Result($id);

        if (!empty($dto)) {
            $data['date_start'] = $dto->date_start;
            $data['date_end'] = $dto->date_end;
            $data['status_id'] = 0;

            if (!empty($dto->questions)) {
                $questions = [];
                foreach ($dto->questions as $q) {
                    $options = [];

                    if (!empty($q->options)) {
                        foreach ($q->options as $o) {
                            $options[] = [
                              'code' => $o->code,
                              'title' => $o->title,
                              'title_zh' => $o->title_zh,
                            ];
                        }
                    }
                    $questions[] = [
                      'title' => $q->title,
                      'title_zh' => $q->title_zh,
                      'seq' => $q->seq,
                      'options' => $options,
                    ];
                }// endforeach
            }

            $data['questions'] = $questions;
        }

        $data['created_by'] = Auth::user()->name;
        $data['updated_by'] = Auth::user()->name;
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        dispatch(new \App\Lib\Commands\Admin\CopyPrediction($data));

        return $this->JsonOk();
    }

    public function DeletePredictionPost(Request $request)
    {
        $data['id'] = $request->input('id');

        dispatch(new \App\Lib\Commands\Admin\DeletePrediction($data));

        return $this->JsonOk();
    }

    // Question
    public function GetQuestions($prediction_id)
    {
        $dto = \App\Lib\Queries\Admin\GetPrediction::GetQuestions($prediction_id);

        return view('admin/prediction/questions', ['data' => $dto]);
    }

    public function GetQuestion($id)
    {
        $dto = \App\Lib\Queries\Admin\GetPrediction::GetQuestion($id);

        return response()->json(['json' => $dto], 200);
    }

    public function AddQuestionPost(\App\Http\Requests\Admin\PredictionQuestionRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::user()->name;
        $data['updated_by'] = Auth::user()->name;

        dispatch(new \App\Lib\Commands\Admin\CreateQuestion($data));

        return $this->JsonOk();
    }

    public function EditQuestionPost(\App\Http\Requests\Admin\PredictionQuestionRequest $request)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::user()->name;

        dispatch(new \App\Lib\Commands\Admin\UpdateQuestion($data));

        return $this->JsonOk();
    }

    public function CopyQuestionPost(Request $request)
    {
        $id = $request->input('id');
        $data['prediction_id'] = $request->input('prediction_id');
        $dto = \App\Lib\Queries\Admin\GetPrediction::GetQuestion($id);

        // echo "<pre>";
        // print_r($dto);
        // echo "</pre>";
        if (!empty($dto)) {
            $data['title'] = $dto->title;
            $data['title_zh'] = $dto->title_zh;
            $data['seq'] = $dto->seq;
            $data['title'] = $dto->title;

            $options = [];

            if (!empty($dto->options)) {
                foreach ($dto->options as $o) {
                    $options[] = [
                      'code' => $o->code,
                      'title' => $o->title,
                      'title_zh' => $o->title_zh,
                    ];
                }
            }

            $data['options'] = $options;
        }

        $data['created_by'] = Auth::user()->name;
        $data['updated_by'] = Auth::user()->name;
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        dispatch(new \App\Lib\Commands\Admin\CopyQuestion($data));

        return $this->JsonOk();
    }

    public function DeleteQuestionPost(Request $request)
    {
        $data['id'] = $request->input('id');
        dispatch(new \App\Lib\Commands\Admin\DeleteQuestion($data));

        return $this->JsonOk();
    }

    // Option
    public function GetOption($id)
    {
        $dto = \App\Lib\Queries\Admin\GetPrediction::GetOption($id);

        return response()->json(['json' => $dto], 200);
    }

    public function AddOptionPost(\App\Http\Requests\Admin\PredictionOptionRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::user()->name;
        $data['updated_by'] = Auth::user()->name;

        dispatch(new \App\Lib\Commands\Admin\CreateOption($data));

        return $this->JsonOk();
    }

    public function EditOptionPost(\App\Http\Requests\Admin\PredictionOptionRequest $request)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::user()->name;

        dispatch(new \App\Lib\Commands\Admin\UpdateOption($data));

        return $this->JsonOk();
    }

    public function DeleteOptionPost(Request $request)
    {
        $data['id'] = $request->input('id');
        dispatch(new \App\Lib\Commands\Admin\DeleteOption($data));

        return $this->JsonOk();
    }

    // Participants
    public function GetParticipants(Request $request)
    {
        if (null !== $request->input('id')) {
            $id = $request->input('id');
        } else {
            $id = '';
        }

        if (null !== $request->input('sort')) {
            $sort = $request->input('sort');
        } else {
            $sort = 'created_at';
        }

        if (null !== $request->input('direction')) {
            $direction = $request->input('direction');
            $inputs['direction'] = $request->input('direction');
        } else {
            $direction = 'desc';
        }

        $params[] = [
          'sort' => $sort,
          'direction' => $direction,
          'id' => $id,
        ];

        $dto1 = \App\Lib\Queries\Admin\GetPrediction::GetParticipants($params);
        $dto2 = \App\Lib\Queries\Admin\GetPrediction::GetQuestions($id);
        $vm = new \App\Http\ViewModels\Admin\ParticipantsViewModel($id, $dto1, $dto2);

        return view('admin/prediction/participants', ['vm' => $vm]);
    }

    public function GetMatches(Request $request)
    {
        if (null !== $request->input('id')) {
            $id = $request->input('id');
        } else {
            $id = '';
        }

        if (null !== $request->input('matches')) {
            $matches = $request->input('matches');
        } else {
            $matches = '';
        }

        if (null !== $request->input('sort')) {
            $sort = $request->input('sort');
        } else {
            $sort = 'created_at';
        }

        if (null !== $request->input('direction')) {
            $direction = $request->input('direction');
            $inputs['direction'] = $request->input('direction');
        } else {
            $direction = 'desc';
        }

        $params[] = [
          'sort' => $sort,
          'direction' => $direction,
          'id' => $id,
          'matches' => $matches,
        ];

        $dto1 = \App\Lib\Queries\Admin\GetPrediction::GetMatches($params);

        $dto2 = \App\Lib\Queries\Admin\GetPrediction::GetQuestions($id);
        $vm = new \App\Http\ViewModels\Admin\ParticipantsViewModel($id, $dto1, $dto2);

        return view('admin/prediction/match', ['vm' => $vm]);
    }

    // Export
    public function ExportParticipants(Request $request)
    {
        if (null !== $request->input('id')) {
            $id = $request->input('id');
        } else {
            $id = '';
        }

        if (null !== $request->input('sort')) {
            $sort = $request->input('sort');
        } else {
            $sort = 'created_at';
        }

        if (null !== $request->input('direction')) {
            $direction = $request->input('direction');
            $inputs['direction'] = $request->input('direction');
        } else {
            $direction = 'desc';
        }

        $params[] = [
          'sort' => $sort,
          'direction' => $direction,
          'id' => $id,
        ];

        $dto1 = \App\Lib\Queries\Admin\GetPrediction::GetParticipants($params);
        $dto2 = \App\Lib\Queries\Admin\GetPrediction::GetQuestions($id);
        // $vm =  new \App\Http\ViewModels\Admin\ParticipantsViewModel($id, $dto1, $dto2);
        // return view('admin/prediction/participants', ['vm' => $vm]);

        $data = [];
        $data['questions'] = [];
        $data['participants'] = [];

        if (count($dto1) > 0) {
            foreach ($dto1 as $k => $v) {
                // $answers = array();

                $data['participants'][] = [
                  'created_at' => $v->created_at,
                  'username' => $v->username,
                  'answers' => $v->answers,
                ];
            }// foreach
        }

        if (count($dto2) > 0) {
            foreach ($dto2 as $k => $v) {
                $data['questions'][] = [
                  'seq' => $v->seq,
                  'title' => $v->title,
                ];
            }// foreach
        }

        $filename = date('ymd').'-Participants-'.$id.'.xlsx';

        // return view('admin.prediction.export.participants', ['data' => $data]);
        return Excel::download(new ExportParticipants('admin.prediction.export.participants', $data), $filename);
    }

    public function ExportMatches(Request $request)
    {
        if (null !== $request->input('id')) {
            $id = $request->input('id');
        } else {
            $id = '';
        }

        if (null !== $request->input('sort')) {
            $sort = $request->input('sort');
        } else {
            $sort = 'created_at';
        }

        if (null !== $request->input('direction')) {
            $direction = $request->input('direction');
            $inputs['direction'] = $request->input('direction');
        } else {
            $direction = 'desc';
        }

        $params[] = [
          'sort' => $sort,
          'direction' => $direction,
          'id' => $id,
        ];

        $dto1 = \App\Lib\Queries\Admin\GetPrediction::GetMatches($params);
        $dto2 = \App\Lib\Queries\Admin\GetPrediction::GetQuestions($id);
        // $vm =  new \App\Http\ViewModels\Admin\ParticipantsViewModel($id, $dto1, $dto2);
        // return view('admin/prediction/participants', ['vm' => $vm]);

        $data = [];
        $data['questions'] = [];
        $data['participants'] = $dto1;

        if (count($dto2) > 0) {
            foreach ($dto2 as $k => $v) {
                $data['questions'][] = [
                  'seq' => $v->seq,
                  'title' => $v->title,
                  'answer' => $v->answer,
                ];
            }// foreach
        }

        $filename = date('ymd').'-Matches-'.$id.'.xlsx';

        // return view('admin.prediction.export.matches', ['data' => $data]);
        return Excel::download(new ExportMatches('admin.prediction.export.matches', $data), $filename);
    }
}
