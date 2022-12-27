<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
use Carbon\Carbon;

class ScheduleResource extends JsonResource
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
        
        $totalHour = '0 hr 0 mins';
        if($this->start_time && $this->end_time){
            $start = Carbon::parse($this->start_time);
            $end = Carbon::parse($this->end_time);
            $diff = $end->diff($start);
            $hours = $diff->h;
            $hours = $hours + ($diff->days*24);
            $totalHour = $hours.' hr '. $diff->i .' mins';
        }
        $user  = User::find($this->user_id);
        
        return [
                'id' => $this->id,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'time' => date('h:i A', strtotime($this->start_time)). ' - ' .date('h:i A', strtotime($this->end_time)),
                'rest_days' => $this->rest_days,
                'from_date' => date('d, M Y', strtotime($this->from_date)),
                'until_date' => date('d, M Y', strtotime($this->until_date)),
                'total_hour' => $totalHour,
                'status' => $this->status,
                'date' => date('d, M Y', strtotime($this->work_date)),
            ];
        
        
    }
}
