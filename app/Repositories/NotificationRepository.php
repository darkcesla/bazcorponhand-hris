<?php

namespace App\Repositories;

use App\Models\Notification;

class NotificationRepository {

    public function getList($params)
    {
        $query = Notification::query();
        if (isset($params['user_id'])) {
            $query->where('user_id', $params['user_id'])
                ->orderBy('created_at', 'desc');
        } 
        $data = $query->get();
        return $data;
    }

    
    public function show(int $id)
    {
        $data = Notification::find($id);
        return $data;
    }

    public function create(array $data)
    {
        return Notification::create($data);
    }

    public function read(int $id)
    {
        $notification = Notification::findOrFail($id);
        $notification->read_at = now();
        
        return $notification->save();
    }
    
    public function delete($id)
    {
        $data = Notification::findOrFail($id);
        $data->delete();
        return true;
    }
}