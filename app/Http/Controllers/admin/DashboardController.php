<?php
namespace App\Http\Controllers\admin;

use App\Models\Trainer;
use App\Models\Trainee;
use App\Models\Batch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $data['total_trainer'] = Trainer::count('id');
        $data['total_trainee'] = Trainee::count('id');
        $data['total_batch'] = Batch::count('id');
        $data['total_running_batch'] = Batch::join('schedules', 'batches.id', '=', 'schedules.batch_id')
                                        ->where('schedules.end_date','>=', Carbon::now())->count();
        return view('admin.index', compact('data'));
    }
}

