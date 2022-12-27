<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Leave;
class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        
        $status= 'NULL';
        if($this->in_status == 1 && $this->out_status == 1){
            $status = '<span class="text-warning">Late In</span> / <span class="text-danger">Early Out</span>';
        }
        if($this->in_status == 2 && $this->out_status == 2){
            $status = '<span class="text-success">In Time</span> / <span class="text-info">On Time</span>';
        }
        if($this->in_status == 2 && $this->out_status == 1){
            $status = '<span class="text-success">In Time</span> / <span class="text-danger">Early Out</span>';
        }
        if($this->in_status == 1 && $this->out_status == 2){
            $status = '<span class="text-warning">Late In</span> / <span class="text-info">On Time</span>';
        }
        if($this->in_status == 1 && $this->out_status == 0){
            $status = '<span class="text-warning">Late In</span>';
        }
        if($this->in_status == 2 && $this->out_status == 0){
            $status = '<span class="text-success">In Time</span>';
        }
        
        
        
        $totalHour = '0 hr 0 mins';
        $leaveHour = '0 hr 0 mins';
        $workHour = '0 hr 0 mins';
        
        if($this->clock_in && $this->clock_out){
            $start = Carbon::parse($this->clock_in);
            $end = Carbon::parse($this->clock_out);
            $diff = $end->diff($start);
            $hours = $diff->h;
            $hours = $hours + ($diff->days*24);
            $totalHour = $hours.' hr '. $diff->i .' mins';
        }
        
        
        $leaves = Leave::where('attendance_id', $this->id)->where('status', 1)->get();
        $hours = 0;
        $minutes = 0;
        if(count($leaves)){
            foreach($leaves  as $leave){
                
                $startTime = Carbon::parse($leave->start_time);
                $endTime = Carbon::parse($leave->end_time);
                $diff = $endTime->diff($startTime);
                $minutes += $diff->i;
                $hours += $diff->h + ($diff->days*24);
                
            }
            $remainder = $minutes % 60;
            $hours += ($minutes - $remainder) / 60;
            
            $leaveHour = $hours.' hr '. $remainder .' mins';
        }
        
        
        $user  = User::find($this->user_id);
        
        return [
                'id' => $this->id,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'clock_in' => date("h:i A", strtotime($this->clock_in)),
                'clock_out' => $this->clock_out?date("h:i A", strtotime($this->clock_out)):'00:00',
                'total_hour' => $totalHour,
                'leave_hour' => $leaveHour,
                'work_hour' => $workHour,
                'status' => $status,
                'date' => date('d, M Y', strtotime($this->work_date)),
                'work_date' => $this->work_date,
            ];
        
    }
}
